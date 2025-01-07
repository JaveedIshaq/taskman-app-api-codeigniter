<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ErrorLogFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do nothing before the request
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Log any errors that occurred
        $error = error_get_last();
        if ($error !== null) {
            log_message('error', 'PHP Error: ' . json_encode($error));
        }

        // Log response status if it's an error
        if ($response->getStatusCode() >= 400) {
            log_message('error', 'Response Error: ' . json_encode([
                'status' => $response->getStatusCode(),
                'body' => $response->getBody(),
                'headers' => $response->getHeaders(),
                'uri' => $request->getUri()->getPath(),
                'method' => $request->getMethod(),
            ]));
        }
    }
}
