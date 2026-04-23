<?php

namespace App\Controllers;

use App\Services\AuthService;

class AuthController extends BaseController
{
    private AuthService $authService;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->authService = new AuthService();
    }

    public function login()
    {
        if (session('admin_logged_in')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'password' => 'required|min_length[6]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Verifica los campos de acceso.');
        }

        $username = (string) $this->request->getPost('username');
        $password = (string) $this->request->getPost('password');

        if (!$this->authService->attemptLogin($username, $password)) {
            return redirect()->back()->withInput()->with('error', 'Usuario o contrasena invalidos.');
        }

        return redirect()->to('/admin/dashboard')->with('success', 'Bienvenido al panel de administracion.');
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->to('/admin/login')->with('success', 'Sesion cerrada correctamente.');
    }
}
