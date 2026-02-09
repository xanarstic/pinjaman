<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama',
        'email',
        'password',
        'role'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $returnType = 'array';

    // =========================
    // AUTH
    // =========================
    public function getByEmail($email)
    {
        return $this->db
            ->table($this->table)
            ->where('email', $email)
            ->get()
            ->getRowArray();
    }


    // =========================
    // USER CRUD
    // =========================
    public function getAllUsers()
    {
        return $this->select('id, nama, email, role')
            ->orderBy('nama', 'ASC')
            ->findAll();
    }
}
