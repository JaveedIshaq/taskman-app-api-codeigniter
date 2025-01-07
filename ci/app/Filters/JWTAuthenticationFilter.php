<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class JWTAuthenticationFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('jwt');
        
        $response = Services::response();
        
        $userData = validateJWTFromHeader();
        if ($userData === null) {
            return $response->setJSON([
                'status' => 401,
                'message' => 'Access denied. Invalid or missing token.'
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        // Add user data to request for controllers to use
        $request->user = $userData;
        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing after the request
    }
}
