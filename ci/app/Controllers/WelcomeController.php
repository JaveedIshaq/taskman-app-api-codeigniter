<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class WelcomeController extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        return $this->respond([
            'status' => 200,
            'message' => 'Test endpoint working'
        ]);
    }
}
