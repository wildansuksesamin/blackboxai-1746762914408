<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Only admin can access user management
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'super_admin') {
            return redirect()->to('dashboard')
                ->with('error', 'Access denied. You do not have permission to manage users.');
        }

        $data = [
            'title' => 'User Management',
            'users' => $this->userModel->findAll()
        ];

        return view('users/index', $data);
    }

    public function create()
    {
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'super_admin') {
            return redirect()->to('dashboard');
        }

        $data = [
            'title' => 'Create New User'
        ];

        return view('users/create', $data);
    }

    public function store()
    {
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'super_admin') {
            return redirect()->to('dashboard');
        }

        // Validate input
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
            'full_name' => 'required|min_length[3]|max_length[255]',
            'role' => 'required|in_list[admin,staff,user]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Prepare data
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'full_name' => $this->request->getPost('full_name'),
            'role' => $this->request->getPost('role'),
            'is_active' => true
        ];

        // Save user
        if ($this->userModel->insert($data)) {
            return redirect()->to('users')
                ->with('success', 'User created successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create user. Please try again.');
    }

    public function edit($id)
    {
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'super_admin') {
            return redirect()->to('dashboard');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('users')
                ->with('error', 'User not found');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user
        ];

        return view('users/edit', $data);
    }

    public function update($id)
    {
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'super_admin') {
            return redirect()->to('dashboard');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('users')
                ->with('error', 'User not found');
        }

        // Validate input
        $rules = [
            'username' => "required|min_length[3]|max_length[100]|is_unique[users.username,id,$id]",
            'email' => "required|valid_email|is_unique[users.email,id,$id]",
            'full_name' => 'required|min_length[3]|max_length[255]',
            'role' => 'required|in_list[admin,staff,user]'
        ];

        // Only validate password if it's being changed
        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
            $rules['confirm_password'] = 'required|matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Prepare data
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'role' => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('is_active') ? true : false
        ];

        // Only update password if it's being changed
        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        }

        // Update user
        if ($this->userModel->update($id, $data)) {
            return redirect()->to('users')
                ->with('success', 'User updated successfully');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update user. Please try again.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'super_admin') {
            return redirect()->to('dashboard');
        }

        // Prevent self-deletion
        if ($id == session()->get('id')) {
            return redirect()->to('users')
                ->with('error', 'You cannot delete your own account');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('users')
                ->with('success', 'User deleted successfully');
        }

        return redirect()->to('users')
            ->with('error', 'Failed to delete user. Please try again.');
    }

    public function toggleStatus($id)
    {
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'super_admin') {
            return redirect()->to('dashboard');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('users')
                ->with('error', 'User not found');
        }

        // Prevent self-deactivation
        if ($id == session()->get('id')) {
            return redirect()->to('users')
                ->with('error', 'You cannot deactivate your own account');
        }

        $data = [
            'is_active' => !$user['is_active']
        ];

        if ($this->userModel->update($id, $data)) {
            $status = $data['is_active'] ? 'activated' : 'deactivated';
            return redirect()->to('users')
                ->with('success', "User {$status} successfully");
        }

        return redirect()->to('users')
            ->with('error', 'Failed to update user status. Please try again.');
    }
}
