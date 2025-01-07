<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password', 'created_at'];
    protected $returnType = 'array';

    protected $useTimestamps = false;
    protected $useSoftDeletes = false;

    protected $beforeInsert = ['addCreatedAt'];

    protected function addCreatedAt(array $data)
    {
        if (!isset($data['data']['created_at'])) {
            $data['data']['created_at'] = date('Y-m-d H:i:s');
        }
        return $data;
    }
}
