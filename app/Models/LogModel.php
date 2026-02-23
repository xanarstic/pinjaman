<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table = 'log_peminjaman';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'barang_id',
        'jam_mulai',
        'jam_selesai',
        'status',            // TAMBAHKAN INI
        'dikonfirmasi_oleh'  // TAMBAHKAN INI
    ];

    protected $useTimestamps = false;
    protected $returnType = 'array';
}