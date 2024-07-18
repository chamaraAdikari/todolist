<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
   
    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validate input
        $validated = $this->validate([
            'email' => 'required|valid_email',
            'password' => 'required',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput()->with('error', 'Invalid credentials.');
        }

        // Check user credentials
        $userModel = new User();
        $user = $userModel->where('email', $email)->first();

        if (!$user || $user['password'] !==  $password) {
            return redirect()->back()->withInput()->with('error', 'Invalid credentials.');
        }

        // Set user session
        $userData = [
            'user_id' => $user['user_id'],
            'email' => $user['email'],
            'username' => $user['username'],
            'role' => $user['role'],
                    'isLoggedIn' => true,
            // Add any other data you need in session
        ];

        session()->set($userData);

        // Redirect to dashboard or any desired page after successful login
        return redirect()->to('admin')->with('success', 'Logged in successfully.');
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
