<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Error Handling
$routes->set404Override('App\Controllers\Errors::show404');

// Default Controller
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');

// PUBLIC ROUTES (no authentication required)
$routes->group('', ['filter' => 'noauth'], function($routes) {
    // Authentication Routes
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::loginPost');
    $routes->get('signup', 'Auth::signup');
    $routes->post('signup', 'Auth::signupPost');
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('process-forgot-password', 'Auth::processForgotPassword');
});

// Special unfiltered routes
    $routes->match(['get', 'post'], 'logout', 'Auth::logout');


// AUTHENTICATED USER ROUTES
$routes->group('', ['filter' => 'authGuard'], function($routes) {
    // Dashboard
    $routes->get('/', 'Home::index');
    $routes->get('dashboard', 'Home::index');
    
    // Profile
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/update', 'Profile::update');
    
    // Files Module
    $routes->group('files', function($routes) {
        $routes->get('/', 'Files::index');
        $routes->match(['get', 'post'], 'upload', 'Files::upload');
        $routes->post('store', 'Files::store');
        $routes->get('view/(:num)', 'Files::view/$1');
        $routes->get('download/(:num)', 'Files::download/$1');
        $routes->get('delete/(:num)', 'Files::delete/$1');
    });
    
    // Students Module
    $routes->group('students', function($routes) {
        $routes->get('/', 'Students::index');
        $routes->match(['get', 'post'], 'create', 'Students::create');
        $routes->post('store', 'Students::store');
        $routes->match(['get', 'post'], 'edit/(:num)', 'Students::edit/$1');
        $routes->post('update/(:num)', 'Students::update/$1');
        $routes->get('delete/(:num)', 'Students::delete/$1');
    });
    
    // Courses Module
    $routes->group('courses', function($routes) {
        $routes->get('/', 'Courses::index');
        $routes->match(['get', 'post'], 'create', 'Courses::create');
        $routes->post('store', 'Courses::store');
        $routes->match(['get', 'post'], 'edit/(:num)', 'Courses::edit/$1');
        $routes->post('update/(:num)', 'Courses::update/$1');
        $routes->get('delete/(:num)', 'Courses::delete/$1');
    });
    
    // Enrollments Module
    $routes->group('enrollments', function($routes) {
        $routes->get('/', 'Enrollments::index');
        $routes->match(['get', 'post'], 'create', 'Enrollments::create');
        $routes->post('store', 'Enrollments::store');
        $routes->match(['get', 'post'], 'edit/(:num)', 'Enrollments::edit/$1');
        $routes->post('update/(:num)', 'Enrollments::update/$1');
        $routes->get('delete/(:num)', 'Enrollments::delete/$1');
    });
});

// ADMIN ROUTES (requires both authentication and admin privileges)
$routes->group('admin', ['filter' => ['authGuard', 'adminGuard'], 'namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('users', 'Users::index');
    $routes->match(['get', 'post'], 'users/create', 'Users::create');
    $routes->post('users/store', 'Users::store');
    $routes->get('users/edit/(:num)', 'Users::edit/$1');
    $routes->post('users/update/(:num)', 'Users::update/$1');
    $routes->get('users/delete/(:num)', 'Users::delete/$1');
    
    $routes->get('files', 'Files::index', ['as' => 'admin.files']);
    
    // System Administration
    $routes->get('settings', 'Settings::index');
    $routes->post('settings/update', 'Settings::update');
    
    // Temporary admin creation (remove in production)
    $routes->get('create-admin', 'Auth::createAdmin', ['filter' => null]);
});

// API ROUTES
$routes->group('api', ['filter' => 'apiAuth', 'namespace' => 'App\Controllers\Api'], function($routes) {
    
    $routes->group('courses', function($routes) {
        $routes->get('/', 'CoursesApi::index');
        $routes->get('(:num)', 'CoursesApi::show/$1');
        $routes->post('/', 'CoursesApi::create');
        $routes->put('(:num)', 'CoursesApi::update/$1');
        $routes->delete('(:num)', 'CoursesApi::delete/$1');
    });

    $routes->group('students', function($routes) {
        $routes->get('/', 'StudentsApi::index');
        $routes->get('(:num)', 'StudentsApi::show/$1');
        $routes->post('/', 'StudentsApi::create');
        $routes->put('(:num)', 'StudentsApi::update/$1');
        $routes->delete('(:num)', 'StudentsApi::delete/$1');
    });
   
    $routes->group('users', ['filter' => 'adminGuard'], function($routes) {
        $routes->get('/', 'UsersApi::index');
        $routes->get('(:num)', 'UsersApi::show/$1');
    });
});