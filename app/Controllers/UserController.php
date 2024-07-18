<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new User();
        $users = $userModel->findAll();

        return view('admin/users', ['users' => $users]);
    }

    public function insert()
    {
        helper(['form', 'url']);
        $validation = \Config\Services::validation();

        // Validate input data
        $validated = $this->validate([
            'email' => 'required|valid_email|min_length[5]|max_length[100]|is_unique[users.email]',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required',

        ], [
            'email' => [
                'required' => 'The email field is required.',
                'valid_email' => 'The email field must contain a valid email address.',
                'min_length' => 'The email must be at least 5 characters long.',
                'max_length' => 'The email cannot exceed 100 characters.',
                'is_unique' => 'The email address already exists.',
            ],

            'username' => [
                'required' => 'The username field is required.',
                'is_unique' => 'The username already exists.',
            ],
            'password' => [
                'required' => 'The password field is required.',
                'min_length' => 'The password must be at least 8 characters long.',
            ],

        ]);

        if (!$validated) {
            // If validation fails, display errors and redirect back
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Data is validated, proceed to insert into database
        $data = [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
        ];

        $UserModel = new User();

        // Insert data into the database
        if ($UserModel->insert($data)) {
            // Success message or redirect to success page
            return redirect()->to('users/view/')->with('success', 'User created successfully.');
        } else {
            // Error message or redirect to error page
            return redirect()->back()->withInput()->with('error', 'Failed to create user.');
        }
    }

    public function update($id)
    {
        $userModel = new User();
        $data = $this->request->getPost();

        // Check if password is provided and hash it
        if (!empty($data['password'])) {

        } else {
            unset($data['password']);
        }

        if ($userModel->update($id, $data)) {
            return redirect()->to('users/view/')->with('success', 'User updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }
    }

    public function delete($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);
        $userModel->delete($id);
        return redirect()->to('users/view/');
    }

    public function search()
{
    $keyword = $this->request->getGet('keyword');
    $userModel = new User();

    if ($keyword) {
        $users = $userModel->like('username', $keyword)->orLike('email', $keyword)->findAll();
    } else {
        $users = $userModel->findAll();
    }

    return view('admin/users', ['users' => $users]);
}

}
