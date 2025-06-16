<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    protected $helpers = ['form'];

    public function login()
{
    // Check if already logged in with cache prevention
    if (session()->get('isLoggedIn')) {
        return redirect()->to('/login')
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
                'Pragma' => 'no-cache'
            ]);
    }

    $data = [
        'title' => 'Login',
        'config' => config('Auth')
    ];

    return response()
        ->setBody(view('auth/login', $data))
        ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate')
        ->setHeader('Pragma', 'no-cache');
}

    public function loginPost(): RedirectResponse
    {
        if (!$this->validate(['csrf_test_name' => 'required|string'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid CSRF token');
        }

        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ];

        $messages = [
            'email' => [
                'required' => 'Email is required',
                'valid_email' => 'Please enter a valid email address'
            ],
            'password' => [
                'required' => 'Password is required',
                'min_length' => 'Password must be at least 8 characters'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new User();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if (!$user) {
            return redirect()->to('/login')
                ->withInput()
                ->with('error', 'Invalid credentials');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->to('/login')
                ->withInput()
                ->with('error', 'Invalid credentials');
        }

        // Log login activity
        model('ActivityModel')->insert([
            'user_id' => $user['id'],
            'activity_type' => 'login',
            'details' => 'User logged in from ' . $this->request->getIPAddress(),
            'ip_address' => $this->request->getIPAddress()
        ]);

        // Update last activity
        $model->update($user['id'], ['last_activity' => date('Y-m-d H:i:s')]);

        $sessionData = [
            'isLoggedIn' => true,
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'] ?? 'user'
            ],
            'lastActivity' => time()
        ];

        session()->set($sessionData);
        session()->regenerate();

        return redirect()->to('/dashboard')
            ->with('success', 'Welcome back, ' . esc($user['name']));
    }

    public function signup()
{
    // Redirect if already logged in
    if (session()->get('isLoggedIn')) {
        return redirect()->to('/dashboard');
    }

    $data = [
        'title' => 'Sign Up',
        'config' => config('Auth')
    ];

    return view('auth/signup', $data);
}

public function signupPost(): RedirectResponse
{
    // Validate CSRF token first
    if (!$this->validate(['csrf_test_name' => 'required|string'])) {
        return redirect()->back()->withInput()->with('error', 'Invalid CSRF token');
    }

    $rules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]|strong_password'
    ];

    $messages = [
        'name' => [
            'required' => 'Full name is required',
            'min_length' => 'Name must be at least 3 characters',
            'max_length' => 'Name cannot exceed 100 characters'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'is_unique' => 'This email is already registered'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 8 characters',
            'strong_password' => 'Password must contain at least one number, one letter, and one uppercase or special character'
        ]
    ];

    if (!$this->validate($rules, $messages)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $model = new User();

    $userData = [
        'name' => esc($this->request->getPost('name')),
        'email' => esc($this->request->getPost('email')),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role' => 'user'
    ];

    try {
        if ($model->save($userData)) {
            // Log activity
            model('ActivityModel')->insert([
                'user_id' => $model->getInsertID(),
                'activity_type' => 'account_creation',
                'details' => 'New user registered from ' . $this->request->getIPAddress(),
                'ip_address' => $this->request->getIPAddress()
            ]);

            return redirect()->to('/login')
                ->with('success', 'Registration successful! Please login.');
        }
    } catch (\Exception $e) {
        log_message('error', 'Registration error: ' . $e->getMessage());
    }

    return redirect()->back()
        ->withInput()
        ->with('error', 'Registration failed. Please try again.');
}

   public function logout()
{
    $session = session();
    
    // Add these headers to prevent caching
    $response = service('response');
    $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
    $response->setHeader('Pragma', 'no-cache');
    $response->setHeader('Expires', '0');
    
    // Destroy the session completely
    $session->destroy();
    
    // Clear any existing cookies
    $response = $response->deleteCookie(session_name());
    
    // Redirect to login with no-cache headers
    return redirect()->to('/login')
        ->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
}


    /**
     * ADMIN-ONLY METHODS (protected by adminGuard)
     */
    
    public function createAdmin(): RedirectResponse
    {
        $model = new User();

        $data = [
            'name' => 'System Admin',
            'email' => 'admin@' . $_SERVER['HTTP_HOST'],
            'password' => bin2hex(random_bytes(8)), // Temporary password
            'role' => 'admin'
        ];

        if ($model->save($data)) {
            // In production, you would email the temp password
            return redirect()->to('/admin/users')
                ->with('message', 'Admin created. Temp password: ' . $data['password']);
        }

        return redirect()->back()
            ->with('error', 'Failed to create admin');
    }

    public function passwordReset()
    {
        return view('auth/password_reset', ['title' => 'Reset Password']);
    }

    public function processPasswordReset()
    {
        $rules = ['email' => 'required|valid_email'];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Implementation would:
        // 1. Generate token
        // 2. Send email
        // 3. Store token with expiration

        return redirect()->to('/login')
            ->with('success', 'If email exists, you will receive reset instructions');
    }
}