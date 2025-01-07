<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Exception;

class AuthController extends ResourceController
{
    use ResponseTrait;
    
    protected $format = 'json';
    protected $model;

    public function __construct()
    {
        helper('jwt');
        $this->model = new UserModel();
    }

    public function register()
    {
        try {
            // Get JSON input
            $json = $this->request->getJSON();
            if (empty($json)) {
                return $this->failValidationError('No data received');
            }

            // Basic validation
            if (empty($json->name) || strlen($json->name) < 3) {
                return $this->fail('Name is required and must be at least 3 characters long');
            }
            if (empty($json->email) || !filter_var($json->email, FILTER_VALIDATE_EMAIL)) {
                return $this->fail('Valid email is required');
            }
            if (empty($json->password) || strlen($json->password) < 6) {
                return $this->fail('Password is required and must be at least 6 characters long');
            }

            // Check if email already exists
            $existingUser = $this->model->where('email', $json->email)->first();
            if ($existingUser) {
                return $this->fail('Email already exists');
            }

            // Prepare data
            $data = [
                'name' => $json->name,
                'email' => $json->email,
                'password' => password_hash($json->password, PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Insert user
            if ($this->model->insert($data)) {
                $userId = $this->model->getInsertID();
                $token = generateJWT($userId);
                
                return $this->respond([
                    'status' => 201,
                    'message' => 'User registered successfully',
                    'token' => $token,
                    'user' => [
                        'id' => $userId,
                        'name' => $data['name'],
                        'email' => $data['email']
                    ]
                ], 201);
            }

            return $this->failServerError('Failed to register user');
            
        } catch (Exception $e) {
            log_message('error', '[AuthController::register] Error: ' . $e->getMessage());
            log_message('error', '[AuthController::register] Stack trace: ' . $e->getTraceAsString());
            return $this->failServerError('An error occurred while processing your request: ' . $e->getMessage());
        }
    }

    public function login()
    {
        try {
            // Get JSON input
            $json = $this->request->getJSON();
            if (empty($json)) {
                return $this->failValidationError('No data received');
            }

            // Basic validation
            if (empty($json->email) || !filter_var($json->email, FILTER_VALIDATE_EMAIL)) {
                return $this->fail('Valid email is required');
            }
            if (empty($json->password)) {
                return $this->fail('Password is required');
            }

            $user = $this->model->where('email', $json->email)->first();

            if (!$user) {
                return $this->failNotFound('User not found');
            }

            if (!password_verify($json->password, $user['password'])) {
                return $this->fail('Invalid credentials');
            }

            $token = generateJWT($user['id']);
            
            return $this->respond([
                'status' => 200,
                'message' => 'Login successful',
                'token' => $token,
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email']
                ]
            ]);
            
        } catch (Exception $e) {
            log_message('error', '[AuthController::login] Error: ' . $e->getMessage());
            log_message('error', '[AuthController::login] Stack trace: ' . $e->getTraceAsString());
            return $this->failServerError('An error occurred while processing your request: ' . $e->getMessage());
        }
    }
}
