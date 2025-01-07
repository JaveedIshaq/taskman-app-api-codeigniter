<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'title', 'date', 'start_time', 'end_time', 'category_id', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;

    protected $validationRules = [
        'user_id' => 'required|integer',
        'title' => 'required|min_length[3]|max_length[255]',
        'date' => 'required|valid_date',
        'start_time' => 'required',
        'end_time' => 'required',
        'category_id' => 'required|integer'
    ];

    // Get tasks with category information
    public function getTaskWithCategory($id = null)
    {
        $builder = $this->db->table('tasks');
        $builder->select('tasks.*, categories.name as category_name');
        $builder->join('categories', 'categories.id = tasks.category_id');
        
        if ($id !== null) {
            return $builder->where('tasks.id', $id)->get()->getRowArray();
        }
        
        return $builder->get()->getResultArray();
    }

    // Get tasks for a specific user
    public function getUserTasks($userId)
    {
        $builder = $this->db->table('tasks');
        $builder->select('tasks.*, categories.name as category_name');
        $builder->join('categories', 'categories.id = tasks.category_id');
        $builder->where('tasks.user_id', $userId);
        return $builder->get()->getResultArray();
    }
}
