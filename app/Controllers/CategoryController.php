<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;

class CategoryController extends ResourceController
{
    use ResponseTrait;
    
    protected $format = 'json';
    protected $model;

    public function __construct()
    {
        helper('jwt');
        $this->model = new CategoryModel();
    }

    // GET /categories - Get all categories for the authenticated user
    public function index()
    {
        $userId = $this->request->user->user_id;
        $categories = $this->model->getUserCategories($userId);

        return $this->respond([
            'status' => 200,
            'data' => $categories
        ]);
    }

    // GET /categories/{id} - Get a specific category
    public function show($id = null)
    {
        $userId = $this->request->user->user_id;
        $category = $this->model->getUserCategory($id, $userId);

        if (!$category) {
            return $this->failNotFound('Category not found or access denied');
        }

        return $this->respond([
            'status' => 200,
            'data' => $category
        ]);
    }

    // POST /categories - Create a new category
    public function create()
    {
        $data = [
            'user_id' => $this->request->user->user_id,
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (!$this->model->validate($data)) {
            return $this->fail($this->model->errors());
        }

        $categoryId = $this->model->insert($data);

        if ($categoryId) {
            $category = $this->model->find($categoryId);
            return $this->respondCreated([
                'status' => 201,
                'message' => 'Category created successfully',
                'data' => $category
            ]);
        }

        return $this->fail('Failed to create category');
    }

    // PUT /categories/{id} - Update a category
    public function update($id = null)
    {
        $userId = $this->request->user->user_id;
        $category = $this->model->getUserCategory($id, $userId);

        if (!$category) {
            return $this->failNotFound('Category not found or access denied');
        }

        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Remove null values
        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        if (!$this->model->validate($data)) {
            return $this->fail($this->model->errors());
        }

        if ($this->model->update($id, $data)) {
            $updatedCategory = $this->model->find($id);
            return $this->respond([
                'status' => 200,
                'message' => 'Category updated successfully',
                'data' => $updatedCategory
            ]);
        }

        return $this->fail('Failed to update category');
    }

    // DELETE /categories/{id} - Delete a category
    public function delete($id = null)
    {
        $userId = $this->request->user->user_id;
        $category = $this->model->getUserCategory($id, $userId);

        if (!$category) {
            return $this->failNotFound('Category not found or access denied');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted([
                'status' => 200,
                'message' => 'Category deleted successfully'
            ]);
        }

        return $this->fail('Failed to delete category');
    }
}
