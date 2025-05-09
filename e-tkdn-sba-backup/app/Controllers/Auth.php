<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends Controller
{
    public function index()
    {
        return redirect()->to('login');
    }

    public function login()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('dashboard');
        }

        // Load the login view
        return view('auth/login');
    }

    public function authenticate()
    {
        $session = session();
        $userModel = new \App\Models\UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user) {
            $pass = $user['password'];
            $authenticatePassword = password_verify($password, $pass);

            if ($authenticatePassword) {
                $ses_data = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);

                // Update last login
                $userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

                return redirect()->to('dashboard');
            }
        }

        $session->setFlashdata('error', 'Username atau Password Salah');
        return redirect()->back();
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('login');
    }
}
