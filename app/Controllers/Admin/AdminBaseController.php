<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

abstract class AdminBaseController extends BaseController
{
    protected function requireAuth(): ?RedirectResponse
    {
        if (!session('admin_logged_in')) {
            return redirect()->to('/admin/login')->with('error', 'Debes iniciar sesion.');
        }

        return null;
    }
}
