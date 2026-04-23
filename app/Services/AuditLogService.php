<?php

namespace App\Services;

use App\Models\LogModel;

class AuditLogService
{
    private LogModel $logModel;

    public function __construct()
    {
        $this->logModel = model(LogModel::class);
    }

    public function register(string $action, ?string $detail = null, ?int $userId = null): void
    {
        $this->logModel->insert([
            'usuario_id'  => $userId,
            'accion'      => $action,
            'detalle'     => $detail,
            'ip_address'  => service('request')->getIPAddress(),
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
    }
}
