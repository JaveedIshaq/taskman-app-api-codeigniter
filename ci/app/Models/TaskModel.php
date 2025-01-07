<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'title', 'description', 'due_date', 'priority', 'status', 'category_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'user_id' => 'required|integer',
        'title' => 'required|min_length[3]|max_length[255]',
        'due_date' => 'required|valid_date',
        'priority' => 'permit_empty|in_list[low,medium,high]',
        'status' => 'permit_empty|in_list[pending,in_progress,completed]',
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
