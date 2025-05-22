<?php

namespace App\Controllers;
use App\Models\User;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login', ['title' => 'Login']);
    }

    public function loginPost()
    {
        $session = session();
        $model = new User();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $session->set([
                    'isLoggedIn' => true,
                    'user' => $user,
                    'username' => $user['name']
                ]);
                return redirect()->to('/dashboard');
            } else {
                return redirect()->to('/login')->with('error', 'Incorrect password');
            }
        } else {
            return redirect()->to('/login')->with('error', 'User not found');
        }
    }

    public function signup()
    {
        return view('auth/signup', ['title' => 'Sign Up']);
    }

    public function signupPost()
    {
        $session = session();
        $model = new User();

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($name) || empty($email) || empty($password)) {
            return redirect()->to('/signup')->with('error', 'All fields are required.');
        }

        if ($model->where('email', $email)->first()) {
            return redirect()->to('/signup')->with('error', 'Email already exists.');
        }

        $model->save([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/login')->with('success', 'Account created. You can now log in.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
