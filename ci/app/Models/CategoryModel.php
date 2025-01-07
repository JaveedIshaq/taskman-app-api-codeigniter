<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['user_id', 'name', 'description', 'created_at', 'updated_at'];

    // Validation rules
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'description' => 'permit_empty|max_length[1000]'
    ];

    // Get categories for a specific user
    public function getUserCategories($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // Get single category with validation for user ownership
    public function getUserCategory($categoryId, $userId)
    {
        return $this->where('id', $categoryId)
                    ->where('user_id', $userId)
                    ->first();
    }
}
