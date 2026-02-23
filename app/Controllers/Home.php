<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\SettingModel;
use App\Models\LogModel;
use App\Models\UserModel;
use App\Models\ActivityLogModel;

class Home extends BaseController
{
	protected $barang, $log, $user, $setting, $activityLog;

	public function __construct()
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->barang = new BarangModel();
		$this->log = new LogModel();
		$this->user = new UserModel();
		$this->setting = new SettingModel(); // <-- PASTIKAN BARIS INI ADA
		$this->activityLog = new ActivityLogModel();
	}

	/* ===================== GUARD & HELPERS ====================== */

	private function authCheck()
	{
		if (!session()->get('logged')) {
			redirect()->to('home/login')->send();
			exit;
		}
	}

	private function adminOnly()
	{
		if (session()->get('role') !== 'admin') {
			$this->recordActivity('AKSES ILEGAL: Mencoba fitur administrator');
			return redirect()->to('home/dashboard')->with('error', 'Akses ditolak!')->send();
			exit;
		}
	}

	private function recordActivity($action)
	{
		if (session()->get('logged')) {
			$this->activityLog->insert([
				'user_id' => session()->get('user_id'),
				'action' => $action,
				'url' => (string) current_url(),
				'ip_address' => $this->request->getIPAddress(),
			]);
		}
	}

	/* ===================== AUTH SECTION ====================== */

	public function login()
	{
		// Generate Math CAPTCHA sederhana
		$num1 = rand(1, 9);
		$num2 = rand(1, 9);
		session()->set('captcha_res', $num1 + $num2);
		
		$data = ['captcha_text' => "$num1 + $num2 = ?"];
		return view('login', $data);
	}

	public function loginProcess()
	{
		// 1. Cek Human Verification (Anti-Bot)
		$inputCaptcha = $this->request->getPost('captcha');
		if ($inputCaptcha != session()->get('captcha_res')) {
			return redirect()->back()->with('error', 'Verifikasi gagal! Jawaban hitungan salah.');
		}

		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');
		$user = $this->user->where('email', $email)->first();

		if (!$user || !password_verify($password, $user['password'])) {
			return redirect()->back()->with('error', 'Email atau Password salah!');
		}

		session()->set([
			'user_id' => $user['id'],
			'nama' => $user['nama'],
			'role' => $user['role'],
			'logged' => true
		]);

		$this->recordActivity('Login ke Sistem');
		return redirect()->to('home/dashboard');
	}

	public function logout()
	{
		$this->recordActivity('Logout dari Sistem');
		session()->destroy();
		return redirect()->to('home/login');
	}

	/* ===================== DASHBOARD ====================== */

	public function dashboard()
	{
		$this->authCheck();
		$this->recordActivity('Melihat Dashboard');

		$data = [
			'title' => 'Dashboard',
			'active' => 'dashboard',
			'setting' => $this->setting->find(1),
			'totalBarang' => $this->barang->countAll(),
			'barangDipakai' => $this->barang->where('status', 'dipakai')->countAllResults(),
			'totalUser' => $this->user->countAll()
		];
		echo view('header', $data);
		echo view('sidebar', $data);
		echo view('dashboard', $data);
		echo view('footer');
	}

	/* ===================== MANAJEMEN BARANG ====================== */

	public function barang()
	{
		$this->authCheck();
		$filter = $this->request->getGet('filter') ?? 'all';
		$keyword = $this->request->getGet('keyword');
		$this->recordActivity('Melihat Data Barang');

		$builder = $this->barang->select('barang.*, users.nama AS user_nama')
			->join('users', 'users.id = barang.dipakai_oleh', 'left');

		if ($filter === 'dipakai')
			$builder->where('barang.status', 'dipakai');
		if ($filter === 'tersedia')
			$builder->where('barang.status', 'tersedia');

		if ($keyword) {
			$builder->like('barang.nama_barang', $keyword);
		}

		$data = [
			'title' => 'Data Barang',
			'active' => 'barang',
			'filter' => $filter,
			'keyword' => $keyword,
			'setting' => $this->setting->find(1),
			'barang' => $builder->findAll()
		];
		echo view('header', $data);
		echo view('sidebar', $data);
		echo view('barang', $data);
		echo view('footer');
	}

	public function createBarang()
	{
		$this->authCheck();
		$this->adminOnly();
		$nama = $this->request->getPost('nama_barang');
		$file = $this->request->getFile('foto');
		$foto = null;

		if ($file && $file->isValid()) {
			$foto = $file->getRandomName();
			$file->move('uploads/barang', $foto);
		}

		$this->barang->insert(['nama_barang' => $nama, 'foto' => $foto, 'status' => 'tersedia']);
		$this->recordActivity('Menambah Barang: ' . $nama);
		return redirect()->to('home/barang')->with('success', 'Barang ditambah!');
	}

	public function updateBarang()
	{
		$this->authCheck();
		$this->adminOnly();
		$id = $this->request->getPost('id');
		$data = ['nama_barang' => $this->request->getPost('nama_barang')];
		$file = $this->request->getFile('foto');
		if ($file && $file->isValid()) {
			$foto = $file->getRandomName();
			$file->move('uploads/barang', $foto);
			$data['foto'] = $foto;
		}
		$this->barang->update($id, $data);
		$this->recordActivity('Mengubah Barang ID: ' . $id);
		return redirect()->to('home/barang')->with('success', 'Barang diperbarui!');
	}

	public function deleteBarang($id)
	{
		$this->authCheck();
		$this->adminOnly();
		$this->recordActivity('Menghapus Barang ID: ' . $id);
		$this->barang->delete($id);
		return redirect()->to('home/barang');
	}

	/* ===================== WORKFLOW PEMINJAMAN ====================== */

	public function log()
	{
		$this->authCheck();
		$role = session()->get('role');
		$uid = session()->get('user_id');
		$statusFilter = $this->request->getGet('status') ?? 'dipinjam';
		// Ambil Parameter Search
		$keyword = $this->request->getGet('keyword');
		$startDate = $this->request->getGet('start_date');
		$endDate = $this->request->getGet('end_date');
		$targetUser = $this->request->getGet('target_user'); // Khusus Admin

		$builder = $this->log->select('log_peminjaman.*, users.nama AS user_nama, GROUP_CONCAT(barang.nama_barang SEPARATOR ", ") AS barang_nama')
			->join('users', 'users.id = log_peminjaman.user_id', 'left')
			->join('barang', 'barang.id = log_peminjaman.barang_id', 'left');

		// 1. Filter Keyword (Nama Barang)
		if ($keyword) {
			$builder->like('barang.nama_barang', $keyword);
		}

		// 2. Filter Tanggal
		if ($startDate) {
			$builder->where('DATE(log_peminjaman.jam_mulai) >=', $startDate);
		}
		if ($endDate) {
			$builder->where('DATE(log_peminjaman.jam_mulai) <=', $endDate);
		}

		// 3. Logika Privasi Data (Admin/Assistant lihat semua by default)
		if ($role === 'admin' || $role === 'asistant') {
			if (!empty($targetUser) && $targetUser !== 'all') {
				$builder->where('log_peminjaman.user_id', $targetUser);
			}
		} else {
			$builder->where('log_peminjaman.user_id', $uid);
		}

		// 4. Filter Status Tab
		if ($statusFilter !== 'all')
			$builder->where('log_peminjaman.status', $statusFilter);

		$data = [
			'title' => 'Log Peminjaman',
			'active' => 'log',
			'setting' => $this->setting->find(1),
			'logs' => $builder->groupBy('log_peminjaman.user_id, log_peminjaman.jam_mulai')->orderBy('log_peminjaman.jam_mulai', 'DESC')->findAll(),
			'users' => $this->user->findAll(),
			'barang' => $this->barang->where('status', 'tersedia')->findAll(),
			'filter' => [
				'status' => $statusFilter,
				'keyword' => $keyword,
				'start_date' => $startDate,
				'end_date' => $endDate,
				'target_user' => $targetUser
			]
		];

		$this->recordActivity('Melihat Log Peminjaman');
		echo view('header', $data);
		echo view('sidebar', $data);
		echo view('log', $data);
		echo view('footer');
	}

	public function pinjamLog()
	{
		$this->authCheck();
		$uid = (session()->get('role') === 'admin') ? $this->request->getPost('user_id') : session()->get('user_id');
		$bids = $this->request->getPost('barang_id');
		$now = date('Y-m-d H:i:s');
		
		// Jika Admin yang input, langsung ACC. Jika User/Assistant, butuh persetujuan.
		$isAdmin = session()->get('role') === 'admin';
		$statusLog = $isAdmin ? 'dipinjam' : 'menunggu_persetujuan';
		$statusBarang = $isAdmin ? 'dipakai' : 'menunggu_persetujuan';

		foreach ($bids as $id) {
			$this->barang->update($id, ['status' => $statusBarang, 'dipakai_oleh' => $uid, 'jam_mulai' => $now]);
			$this->log->insert(['user_id' => $uid, 'barang_id' => $id, 'jam_mulai' => $now, 'status' => $statusLog]);
		}
		
		$this->recordActivity($isAdmin ? 'Memulai Peminjaman Barang' : 'Request Peminjaman Barang');
		$redirectTab = $isAdmin ? 'dipinjam' : 'menunggu_persetujuan';
		return redirect()->to('home/log?status=' . $redirectTab)->with('success', $isAdmin ? 'Barang berhasil dipinjam!' : 'Permintaan terkirim, menunggu persetujuan.');
	}

	// Step 1: User mengembalikan barang
	public function selesai($uid, $jam)
	{
		$this->authCheck();
		$jam = urldecode($jam);

		// Proteksi kepemilikan
		if (session()->get('role') !== 'admin' && $uid != session()->get('user_id'))
			return redirect()->back();

		$this->log->where(['user_id' => $uid, 'jam_mulai' => $jam])->set(['status' => 'menunggu_konfirmasi'])->update();

		$logs = $this->log->where(['user_id' => $uid, 'jam_mulai' => $jam])->findAll();
		foreach ($logs as $l) {
			$this->barang->update($l['barang_id'], ['status' => 'menunggu_konfirmasi']);
		}

		$this->recordActivity('Mengembalikan barang (Menunggu Verifikasi)');
		return redirect()->back()->with('success', 'Barang dikembalikan. Menunggu cek fisik.');
	}

	// Step 2: Admin/Assistant verifikasi
	public function konfirmasi($uid, $jam)
	{
		$this->authCheck();
		if (!in_array(session()->get('role'), ['admin', 'asistant']))
			return redirect()->back();

		$jam = urldecode($jam);
		$this->log->where(['user_id' => $uid, 'jam_mulai' => $jam])
			->set(['status' => 'selesai', 'jam_selesai' => date('Y-m-d H:i:s'), 'dikonfirmasi_oleh' => session()->get('user_id')])
			->update();

		$logs = $this->log->where(['user_id' => $uid, 'jam_mulai' => $jam])->findAll();
		foreach ($logs as $l) {
			$this->barang->update($l['barang_id'], ['status' => 'tersedia', 'dipakai_oleh' => null, 'jam_mulai' => null]);
		}

		$this->recordActivity('Verifikasi Peminjaman Selesai');
		return redirect()->back()->with('success', 'Verifikasi berhasil!');
	}

	// Step Baru: Admin/Assistant menyetujui peminjaman awal
	public function approvePinjam($uid, $jam)
	{
		$this->authCheck();
		if (!in_array(session()->get('role'), ['admin', 'asistant']))
			return redirect()->back();

		$jam = urldecode($jam);
		
		// Update Log menjadi dipinjam
		$this->log->where(['user_id' => $uid, 'jam_mulai' => $jam])
			->set(['status' => 'dipinjam'])
			->update();

		// Update Barang menjadi dipakai
		$logs = $this->log->where(['user_id' => $uid, 'jam_mulai' => $jam])->findAll();
		foreach ($logs as $l) {
			$this->barang->update($l['barang_id'], ['status' => 'dipakai']);
		}

		$this->recordActivity('Menyetujui Peminjaman Barang');
		return redirect()->back()->with('success', 'Peminjaman disetujui, barang boleh diambil.');
	}

	public function tolakPinjam($uid, $jam)
	{
		$this->authCheck();
		$jam = urldecode($jam);
		
		// Ambil barang ID dulu sebelum hapus log untuk reset status barang
		$logs = $this->log->where(['user_id' => $uid, 'jam_mulai' => $jam])->findAll();
		foreach ($logs as $l) {
			$this->barang->update($l['barang_id'], ['status' => 'tersedia', 'dipakai_oleh' => null, 'jam_mulai' => null]);
		}

		// Hapus Log Permintaan
		$this->log->where(['user_id' => $uid, 'jam_mulai' => $jam])->delete();

		$this->recordActivity('Menolak/Membatalkan Peminjaman');
		return redirect()->back()->with('success', 'Permintaan peminjaman dibatalkan.');
	}

	/* ===================== MANAJEMEN USER ====================== */

	/* ===================== MANAJEMEN USER (UPDATED) ====================== */

	public function user()
	{
		$this->authCheck();
		$this->adminOnly(); // Hanya admin yang bisa kelola user

		$data = [
			'title' => 'Manajemen User',
			'active' => 'user',
			'setting' => $this->setting->find(1),
			'users' => $this->user->orderBy('nama', 'ASC')->findAll()
		];

		echo view('header', $data);
		echo view('sidebar', $data);
		echo view('user', $data);
		echo view('footer');
	}

	public function createUser()
	{
		$this->authCheck();
		$this->adminOnly();

		$data = [
			'nama' => $this->request->getPost('nama'),
			'email' => $this->request->getPost('email'),
			'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
			'role' => $this->request->getPost('role') // Akan menerima 'admin', 'user', atau 'asistant'
		];

		$this->user->insert($data);
		$this->recordActivity('Mendaftarkan User Baru: ' . $data['nama']);
		return redirect()->to('home/user')->with('success', 'User berhasil didaftarkan.');
	}

	public function updateUser()
	{
		$this->authCheck();
		$this->adminOnly();
		$id = $this->request->getPost('id');

		$data = [
			'nama' => $this->request->getPost('nama'),
			'email' => $this->request->getPost('email'),
			'role' => $this->request->getPost('role')
		];

		// Update password hanya jika diisi
		$password = $this->request->getPost('password');
		if (!empty($password)) {
			$data['password'] = password_hash($password, PASSWORD_DEFAULT);
		}

		$this->user->update($id, $data);
		$this->recordActivity('Memperbarui Profil User ID: ' . $id);
		return redirect()->to('home/user')->with('success', 'Data user berhasil diperbarui.');
	}

	public function deleteUser($id)
	{
		$this->authCheck();
		$this->adminOnly();

		// Proteksi: Admin tidak bisa menghapus dirinya sendiri
		if ($id == session()->get('user_id')) {
			return redirect()->to('home/user')->with('error', 'Anda tidak bisa menghapus akun sendiri!');
		}

		$this->user->delete($id);
		$this->recordActivity('Menghapus User ID: ' . $id);
		return redirect()->to('home/user')->with('success', 'User telah dihapus.');
	}

	/* ===================== AUDIT & ERROR ====================== */

	public function activity()
	{
		$this->authCheck();
		$this->adminOnly();
		$builder = $this->activityLog->select('activity_logs.*, users.nama AS user_nama')->join('users', 'users.id = activity_logs.user_id', 'left');

		$data = [
			'title' => 'Audit Trail',
			'active' => 'activity',
			'setting' => $this->setting->find(1),
			'activities' => $builder->orderBy('created_at', 'DESC')->findAll(),
			'users' => $this->user->findAll()
		];
		echo view('header', $data);
		echo view('sidebar', $data);
		echo view('activity', $data);
		echo view('footer');
	}

	public function notFound()
	{
		$data = ['setting' => $this->setting->find(1), 'logged' => session()->get('logged')];
		return view('custom_404', $data); //
	}

	/* ===================== PENGATURAN SISTEM (SETTINGS) ====================== */

	public function setting()
	{
		$this->authCheck();
		$this->adminOnly(); // Hanya admin yang boleh masuk sini
		$this->recordActivity('Membuka Pengaturan Sistem');

		$data = [
			'title' => 'Pengaturan Sistem',
			'active' => 'setting',
			'setting' => $this->setting->find(1), // Mengambil data id 1
		];

		// Pastikan dipanggil lengkap agar header/sidebar muncul
		echo view('header', $data);
		echo view('sidebar', $data);
		echo view('settings', $data);
		echo view('footer');
	}

	public function updateSetting()
	{
		$this->authCheck();
		$this->adminOnly();

		$id = 1; // ID default setting
		$data = [
			'app_name' => $this->request->getPost('app_name'),
			'sidebar_type' => $this->request->getPost('sidebar_type'),
		];

		// LOGIKA UPLOAD LOGO
		$logoFile = $this->request->getFile('logo');
		if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
			$newLogoName = $logoFile->getRandomName();
			$logoFile->move('uploads/settings', $newLogoName);
			$data['logo'] = $newLogoName;
		}

		// LOGIKA UPLOAD FAVICON
		$faviconFile = $this->request->getFile('favicon');
		if ($faviconFile && $faviconFile->isValid() && !$faviconFile->hasMoved()) {
			$newFavName = $faviconFile->getRandomName();
			$faviconFile->move('uploads/settings', $newFavName);
			$data['favicon'] = $newFavName;
		}

		$this->setting->update($id, $data);
		$this->recordActivity('Memperbarui Pengaturan Sistem');

		return redirect()->to('home/setting')->with('success', 'Pengaturan berhasil diperbarui!');
	}

}