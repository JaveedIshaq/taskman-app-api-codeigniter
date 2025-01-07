<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TaskModel;

class TaskController extends ResourceController
{
    protected $format = 'json';
    protected $model;

    public function __construct()
    {
        helper('jwt');
        $this->model = new TaskModel();
    }

    // GET /tasks
    public function index()
    {
        $userId = $this->request->user->user_id;
        
        $tasks = $this->model->getUserTasks($userId);
        return $this->respond([
            'status' => 200,
            'data' => $tasks
        ]);
    }

    // GET /tasks/{id}
    public function show($id = null)
    {
        $task = $this->model->getTaskWithCategory($id);
        
        if (!$task) {
            return $this->failNotFound('Task not found');
        }

        // Check if the task belongs to the authenticated user
        if ($task['user_id'] !== $this->request->user->user_id) {
            return $this->failForbidden('You do not have permission to view this task');
        }

        return $this->respond([
            'status' => 200,
            'data' => $task
        ]);
    }

    // POST /tasks
    public function create()
    {
        $data = [
            'user_id' => $this->request->user->user_id,
            'title' => $this->request->getVar('title'),
            'description' => $this->request->getVar('description'),
            'due_date' => $this->request->getVar('due_date'),
            'priority' => $this->request->getVar('priority') ?? 'medium',
            'status' => $this->request->getVar('status') ?? 'pending',
            'category_id' => $this->request->getVar('category_id')
        ];

        if (!$this->model->validate($data)) {
            return $this->fail($this->model->errors());
        }

        $taskId = $this->model->insert($data);

        if ($taskId) {
            $task = $this->model->getTaskWithCategory($taskId);
            return $this->respondCreated([
                'status' => 201,
                'message' => 'Task created successfully',
                'data' => $task
            ]);
        }

        return $this->fail('Failed to create task');
    }

    // PUT /tasks/{id}
    public function update($id = null)
    {
        $task = $this->model->find($id);
        if (!$task) {
            return $this->failNotFound('Task not found');
        }

        // Check if the task belongs to the authenticated user
        if ($task['user_id'] !== $this->request->user->user_id) {
            return $this->failForbidden('You do not have permission to update this task');
        }

        $data = [
            'title' => $this->request->getVar('title'),
            'date' => $this->request->getVar('date'),
            'start_time' => $this->request->getVar('start_time'),
            'end_time' => $this->request->getVar('end_time'),
            'category_id' => $this->request->getVar('category_id'),
            'description' => $this->request->getVar('description')
        ];

        // Remove null values from data
        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        if ($this->model->update($id, $data)) {
            $updatedTask = $this->model->getTaskWithCategory($id);
            return $this->respond([
                'status' => 200,
                'message' => 'Task updated successfully',
                'data' => $updatedTask
            ]);
        }

        return $this->fail('Failed to update task');
    }

    // DELETE /tasks/{id}
    public function delete($id = null)
    {
        $task = $this->model->find($id);
        if (!$task) {
            return $this->failNotFound('Task not found');
        }

        // Check if the task belongs to the authenticated user
        if ($task['user_id'] !== $this->request->user->user_id) {
            return $this->failForbidden('You do not have permission to delete this task');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted([
                'status' => 200,
                'message' => 'Task deleted successfully'
            ]);
        }

        return $this->fail('Failed to delete task');
    }
}
