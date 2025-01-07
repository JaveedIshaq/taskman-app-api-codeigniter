<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class TestController extends ResourceController
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
