<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Test and Debug routes
$routes->get('test', 'TestController::index');
$routes->get('logs', 'LogController::index');

// Authentication Routes
$routes->post('auth/register', 'AuthController::register');
$routes->post('auth/login', 'AuthController::login');

// Protected Routes (require JWT authentication)
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Task Routes
    $routes->get('tasks', 'TaskController::index');
    $routes->get('tasks/(:num)', 'TaskController::show/$1');
    $routes->post('tasks', 'TaskController::create');
    $routes->put('tasks/(:num)', 'TaskController::update/$1');
    $routes->delete('tasks/(:num)', 'TaskController::delete/$1');

    // Category Routes
    $routes->get('categories', 'CategoryController::index');
    $routes->get('categories/(:num)', 'CategoryController::show/$1');
    $routes->post('categories', 'CategoryController::create');
    $routes->put('categories/(:num)', 'CategoryController::update/$1');
    $routes->delete('categories/(:num)', 'CategoryController::delete/$1');
});
