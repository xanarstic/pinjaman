<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_barang',
        'foto',
        'status',
        'dipakai_oleh',
        'jam_mulai'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $returnType = 'array';
}
