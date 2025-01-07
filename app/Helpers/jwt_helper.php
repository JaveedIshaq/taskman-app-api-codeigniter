<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWTFromHeader(): ?string
{
    $header = service('request')->getHeaderLine('Authorization');
    if (empty($header)) {
        return null;
    }
    return explode(' ', $header)[1] ?? null;
}

function validateJWTFromHeader(): ?object
{
    $key = getenv('JWT_SECRET_KEY') ?: 'your-secret-key-here';
    $jwt = getJWTFromHeader();

    if ($jwt === null) {
        return null;
    }

    try {
        return JWT::decode($jwt, new Key($key, 'HS256'));
    } catch (\Exception $e) {
        return null;
    }
}

function generateJWT($userId): string
{
    $key = getenv('JWT_SECRET_KEY') ?: 'your-secret-key-here';
    $payload = [
        'iss' => 'your-app-name',
        'aud' => 'your-app-audience',
        'iat' => time(),
        'exp' => time() + (60 * 60 * 24), // Token expires in 24 hours
        'user_id' => $userId
    ];

    return JWT::encode($payload, $key, 'HS256');
}
