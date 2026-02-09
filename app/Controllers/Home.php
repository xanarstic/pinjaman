<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\SettingModel;
use App\Models\LogModel;
use App\Models\UserModel;

class Home extends BaseController
{
	protected $barang, $log, $user, $setting;

	public function __construct()
	{
		// Inisialisasi semua model di awal agar tidak error
		$this->barang = new BarangModel();
		$this->log = new LogModel();
		$this->user = new UserModel();
		$this->setting = new SettingModel();
	}

	/* ===================== GUARD (KEAMANAN) ====================== */

	private function authCheck()
	{
		// Cek apakah user sudah login
		if (!session()->get('logged')) {
			redirect()->to('home/login')->send();
			exit;
		}
	}

	private function adminOnly()
	{
		// Proteksi fitur agar tidak diakses User biasa
		if (session()->get('role') !== 'admin') {
			return redirect()->to('home/dashboard')->with('error', 'Akses ditolak! Anda bukan Administrator.')->send();
			exit;
		}
	}

	/* ===================== AUTH (MASUK/KELUAR) ====================== */

	public function login()
	{
		return view('login');
	}

	public function loginProcess()
	{
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
		return redirect()->to('home/dashboard');
	}

	public function logout()
	{
		session()->destroy();
		return redirect()->to('home/login');
	}

	/* ===================== DASHBOARD ====================== */

	public function dashboard()
	{
		$this->authCheck();
		$data = [
			'title' => 'Dashboard',
			'active' => 'dashboard',
			'setting' => $this->setting->find(1), // Fix Undefined Variable
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
		$data = [
			'title' => 'Data Barang',
			'active' => 'barang',
			'setting' => $this->setting->find(1),
			'barang' => $this->barang
				->select('barang.*, users.nama AS user_nama')
				->join('users', 'users.id = barang.dipakai_oleh', 'left')
				->findAll()
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
		$file = $this->request->getFile('foto');
		$nama = null;
		if ($file && $file->isValid()) {
			$nama = $file->getRandomName();
			$file->move('uploads/barang', $nama);
		}
		$this->barang->insert(['nama_barang' => $this->request->getPost('nama_barang'), 'foto' => $nama, 'status' => 'tersedia']);
		return redirect()->to('home/barang')->with('success', 'Barang berhasil ditambah!');
	}

	public function updateBarang()
	{
		$this->authCheck();
		$this->adminOnly();
		$id = $this->request->getPost('id');
		$data = ['nama_barang' => $this->request->getPost('nama_barang')];
		$file = $this->request->getFile('foto');
		if ($file && $file->isValid()) {
			$nama = $file->getRandomName();
			$file->move('uploads/barang', $nama);
			$data['foto'] = $nama;
		}
		$this->barang->update($id, $data);
		return redirect()->to('home/barang')->with('success', 'Barang diperbarui!');
	}

	public function deleteBarang($id)
	{
		$this->authCheck();
		$this->adminOnly();
		$this->barang->delete($id);
		return redirect()->to('home/barang');
	}

	/* ===================== LOG AKTIVITAS (PEMINJAMAN) ====================== */

	public function log()
	{
		$this->authCheck();
		$data = [
			'title' => 'Log Aktivitas',
			'active' => 'log',
			'setting' => $this->setting->find(1),
			'logs' => $this->log
				->select('log_peminjaman.user_id, log_peminjaman.jam_mulai, log_peminjaman.jam_selesai, users.nama AS user_nama, GROUP_CONCAT(barang.nama_barang SEPARATOR ", ") AS barang_nama')
				->join('users', 'users.id = log_peminjaman.user_id', 'left')
				->join('barang', 'barang.id = log_peminjaman.barang_id', 'left')
				->groupBy('log_peminjaman.user_id, log_peminjaman.jam_mulai')->orderBy('log_peminjaman.jam_mulai', 'DESC')->findAll(),
			'users' => $this->user->findAll(),
			'barang' => $this->barang->where('status', 'tersedia')->findAll()
		];
		echo view('header', $data);
		echo view('sidebar', $data);
		echo view('log', $data);
		echo view('footer');
	}

	public function pinjamLog()
	{
		$this->authCheck();
		$uid = $this->request->getPost('user_id');
		$bids = $this->request->getPost('barang_id');
		$now = date('Y-m-d H:i:s');
		foreach ($bids as $id) {
			$this->barang->update($id, ['status' => 'dipakai', 'dipakai_oleh' => $uid, 'jam_mulai' => $now]);
			$this->log->insert(['user_id' => $uid, 'barang_id' => $id, 'jam_mulai' => $now]);
		}
		return redirect()->to('home/log')->with('success', 'Peminjaman dicatat!');
	}

	public function selesai($uid, $jam)
	{
		$this->authCheck();
		$this->adminOnly();
		$jam = urldecode($jam);
		$logs = $this->log->where(['user_id' => $uid, 'jam_mulai' => $jam])->findAll();
		foreach ($logs as $l) {
			$this->barang->update($l['barang_id'], ['status' => 'tersedia', 'dipakai_oleh' => null, 'jam_mulai' => null]);
		}
		$this->log->where(['user_id' => $uid, 'jam_mulai' => $jam])->set(['jam_selesai' => date('Y-m-d H:i:s')])->update();
		return redirect()->back()->with('success', 'Barang dikembalikan!');
	}

	public function deleteLogBatch($uid, $jam)
	{
		$this->authCheck();
		$this->adminOnly();
		$jam = urldecode($jam);
		$this->log->where(['user_id' => $uid, 'jam_mulai' => $jam])->delete();
		return redirect()->back();
	}

	/* ===================== MANAJEMEN USER ====================== */

	public function user()
	{
		$this->authCheck();
		$this->adminOnly();
		$data = ['title' => 'Users', 'active' => 'users', 'setting' => $this->setting->find(1), 'users' => $this->user->findAll()];
		echo view('header', $data);
		echo view('sidebar', $data);
		echo view('user', $data);
		echo view('footer');
	}

	public function createUser()
	{
		$this->authCheck();
		$this->adminOnly();
		$this->user->insert(['nama' => $this->request->getPost('nama'), 'email' => $this->request->getPost('email'), 'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), 'role' => $this->request->getPost('role')]);
		return redirect()->to('home/user');
	}

	public function updateUser()
	{
		$this->authCheck();
		$this->adminOnly();
		$id = $this->request->getPost('id');
		$data = ['nama' => $this->request->getPost('nama'), 'email' => $this->request->getPost('email'), 'role' => $this->request->getPost('role')];
		if ($this->request->getPost('password')) {
			$data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
		}
		$this->user->update($id, $data);
		return redirect()->to('home/user');
	}

	public function deleteUser($id)
	{
		$this->authCheck();
		$this->adminOnly();
		if ($id == session()->get('user_id'))
			return redirect()->back()->with('error', 'Jangan hapus diri sendiri!');
		$this->user->delete($id);
		return redirect()->to('home/user');
	}

	/* ===================== SETTINGS ====================== */

	public function settings()
	{
		$this->authCheck();
		$this->adminOnly();
		$data = ['title' => 'Settings', 'active' => 'settings', 'setting' => $this->setting->find(1)];
		echo view('header', $data);
		echo view('sidebar', $data);
		echo view('settings', $data);
		echo view('footer');
	}

	public function updateSettings()
	{
		$this->authCheck();
		$this->adminOnly();
		$data = ['app_name' => $this->request->getPost('app_name'), 'sidebar_type' => $this->request->getPost('sidebar_type')];
		$l = $this->request->getFile('logo');
		if ($l && $l->isValid()) {
			$n = $l->getRandomName();
			$l->move('uploads/settings', $n);
			$data['logo'] = $n;
		}
		$f = $this->request->getFile('favicon');
		if ($f && $f->isValid()) {
			$n = $f->getRandomName();
			$f->move('uploads/settings', $n);
			$data['favicon'] = $n;
		}
		$this->setting->update(1, $data);
		return redirect()->back()->with('success', 'Pengaturan diperbarui!');
	}
}