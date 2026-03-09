<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
    use ResponseTrait;

    public function register()
    {
        if ($this->request->getMethod() !== 'post') {
            return view('auth/register');
        }

        $userModel = new UserModel();
        $validation = \Config\Services::validation();

        $rules = [
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|strong_password',
            'password_confirm' => 'required|matches[password]',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ];

        if (!$this->validate($rules)) {
            return view('auth/register', ['errors' => $this->validator->getErrors()]);
        }

        $data = [
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'organization' => $this->request->getPost('organization', ''),
            'is_active' => true,
        ];

        $userModel->insert($data);
        session()->setFlashdata('success', 'Registration successful! Please log in.');

        return redirect()->to('/auth/login');
    }

    public function login()
    {
        if ($this->request->getMethod() !== 'post') {
            return view('auth/login');
        }

        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return view('auth/login', ['error' => 'Invalid email or password']);
        }

        session()->set([
            'user_id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['first_name'] . ' ' . $user['last_name'],
        ]);

        session()->setFlashdata('success', 'Login successful!');
        return redirect()->to('/');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
