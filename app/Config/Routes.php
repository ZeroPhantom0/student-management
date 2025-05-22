<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->setDefaultController('Auth');
$routes->setDefaultMethod('login');

// AUTH ROUTES
$routes->get('/', 'Auth::login');                   // Login page
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginPost');

$routes->get('/signup', 'Auth::signup');
$routes->post('/signup', 'Auth::signupPost');

$routes->get('/logout', 'Auth::logout');

// DASHBOARD
$routes->get('/dashboard', 'Home::index', ['filter' => 'authGuard']);

// STUDENT ROUTES (with auth filter)
$routes->get('/students', 'Students::index', ['filter' => 'authGuard']);
$routes->get('/students/create', 'Students::create', ['filter' => 'authGuard']);
$routes->post('/students/store', 'Students::store', ['filter' => 'authGuard']);
$routes->get('/students/edit/(:num)', 'Students::edit/$1', ['filter' => 'authGuard']);
$routes->post('/students/update/(:num)', 'Students::update/$1', ['filter' => 'authGuard']);
$routes->get('/students/delete/(:num)', 'Students::delete/$1', ['filter' => 'authGuard']);

// COURSE ROUTES
$routes->get('/courses', 'Courses::index', ['filter' => 'authGuard']);
$routes->get('/courses/create', 'Courses::create', ['filter' => 'authGuard']);
$routes->post('/courses/store', 'Courses::store', ['filter' => 'authGuard']);
$routes->get('/courses/edit/(:num)', 'Courses::edit/$1', ['filter' => 'authGuard']);
$routes->post('/courses/update/(:num)', 'Courses::update/$1', ['filter' => 'authGuard']);
$routes->get('/courses/delete/(:num)', 'Courses::delete/$1', ['filter' => 'authGuard']);

// ENROLLMENT ROUTES
$routes->get('/enrollments', 'Enrollments::index', ['filter' => 'authGuard']);
$routes->get('/enrollments/create', 'Enrollments::create', ['filter' => 'authGuard']);
$routes->post('/enrollments/store', 'Enrollments::store', ['filter' => 'authGuard']);
$routes->get('/enrollments/edit/(:num)', 'Enrollments::edit/$1', ['filter' => 'authGuard']);
$routes->post('/enrollments/update/(:num)', 'Enrollments::update/$1', ['filter' => 'authGuard']);
$routes->get('/enrollments/delete/(:num)', 'Enrollments::delete/$1', ['filter' => 'authGuard']);

$routes->get('/create-admin', 'Auth::createAdmin');
$routes->get('/test-password', 'Test::password');

