<?php

namespace App\Services;

use App\Models\UserModel;

class AuthService
{
    private UserModel $userModel;
    private AuditLogService $auditLogService;

    public function __construct()
    {
        $this->userModel = model(UserModel::class);
        $this->auditLogService = new AuditLogService();
    }

    public function attemptLogin(string $username, string $password): bool
    {
        $user = $this->userModel->where('username', $username)->where('is_active', 1)->first();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        $session = session();
        $session->regenerate(true);
        $session->set([
            'admin_logged_in' => true,
            'admin_id'        => (int) $user['id'],
            'admin_name'      => $user['name'],
            'admin_username'  => $user['username'],
        ]);

        $this->userModel->update($user['id'], [
            'last_login_at' => date('Y-m-d H:i:s'),
        ]);

        $this->auditLogService->register('LOGIN_ADMIN', 'Inicio de sesion exitoso', (int) $user['id']);

        return true;
    }

    public function logout(): void
    {
        $userId = session('admin_id') ? (int) session('admin_id') : null;
        $this->auditLogService->register('LOGOUT_ADMIN', 'Cierre de sesion', $userId);
        session()->destroy();
    }
}
