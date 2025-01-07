<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class LogController extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';

    public function index()
    {
        $logPath = WRITEPATH . 'logs/log-' . date('Y-m-d') . '.log';
        if (file_exists($logPath)) {
            $logs = file_get_contents($logPath);
            return $this->respond([
                'status' => 200,
                'logs' => $logs
            ]);
        }
        return $this->respond([
            'status' => 200,
            'logs' => 'No logs found'
        ]);
    }
}
