<?php

namespace App\Controllers\Admin;

use App\Models\BranchModel;
use App\Services\AuditLogService;

class BranchesController extends AdminBaseController
{
    private BranchModel $branchModel;
    private AuditLogService $auditLogService;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->branchModel = model(BranchModel::class);
        $this->auditLogService = new AuditLogService();
    }

    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $branches = $this->branchModel->where('is_deleted', 0)->orderBy('nombre', 'ASC')->findAll();

        return view('admin/branches/index', [
            'title' => 'Sucursales',
            'branches' => $branches,
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $rules = [
            'nombre' => 'required|min_length[3]|max_length[100]',
            'direccion' => 'permit_empty|max_length[255]',
            'telefono' => 'permit_empty|max_length[30]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Datos invalidos para registrar sucursal.');
        }

        $this->branchModel->insert([
            'nombre' => strip_tags((string) $this->request->getPost('nombre')),
            'direccion' => strip_tags((string) $this->request->getPost('direccion')),
            'telefono' => strip_tags((string) $this->request->getPost('telefono')),
            'activa' => $this->request->getPost('activa') ? 1 : 0,
            'is_deleted' => 0,
        ]);

        $this->auditLogService->register('ALTA_SUCURSAL', 'Se creo una sucursal', (int) session('admin_id'));

        return redirect()->to('/admin/sucursales')->with('success', 'Sucursal creada correctamente.');
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $branch = $this->branchModel->where('is_deleted', 0)->find($id);
        if (!$branch) {
            return redirect()->to('/admin/sucursales')->with('error', 'Sucursal no encontrada.');
        }

        $rules = [
            'nombre' => 'required|min_length[3]|max_length[100]',
            'direccion' => 'permit_empty|max_length[255]',
            'telefono' => 'permit_empty|max_length[30]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Datos invalidos para actualizar sucursal.');
        }

        $this->branchModel->update($id, [
            'nombre' => strip_tags((string) $this->request->getPost('nombre')),
            'direccion' => strip_tags((string) $this->request->getPost('direccion')),
            'telefono' => strip_tags((string) $this->request->getPost('telefono')),
            'activa' => $this->request->getPost('activa') ? 1 : 0,
        ]);

        $this->auditLogService->register('EDITAR_SUCURSAL', 'Se edito sucursal ID ' . $id, (int) session('admin_id'));

        return redirect()->to('/admin/sucursales')->with('success', 'Sucursal actualizada.');
    }

    public function toggle(int $id)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $branch = $this->branchModel->where('is_deleted', 0)->find($id);
        if (!$branch) {
            return redirect()->to('/admin/sucursales')->with('error', 'Sucursal no encontrada.');
        }

        $newStatus = (int) !$branch['activa'];
        $this->branchModel->update($id, ['activa' => $newStatus]);

        $this->auditLogService->register('CAMBIO_ESTADO_SUCURSAL', 'Sucursal ID ' . $id . ' activa=' . $newStatus, (int) session('admin_id'));

        return redirect()->to('/admin/sucursales')->with('success', 'Estado actualizado.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $branch = $this->branchModel->where('is_deleted', 0)->find($id);
        if (!$branch) {
            return redirect()->to('/admin/sucursales')->with('error', 'Sucursal no encontrada.');
        }

        $this->branchModel->update($id, [
            'is_deleted' => 1,
            'activa' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        $this->auditLogService->register('BORRADO_LOGICO_SUCURSAL', 'Sucursal ID ' . $id, (int) session('admin_id'));

        return redirect()->to('/admin/sucursales')->with('success', 'Sucursal eliminada logicamente.');
    }
}
