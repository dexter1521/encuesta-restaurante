<?php

namespace App\Controllers\Admin;

use App\Services\DashboardService;

class DashboardController extends AdminBaseController
{
    private DashboardService $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        return view('admin/dashboard', [
            'title' => 'Dashboard',
            'dashboard' => $this->dashboardService->getData(),
        ]);
    }
}
