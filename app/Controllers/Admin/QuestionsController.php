<?php

namespace App\Controllers\Admin;

use App\Models\QuestionModel;
use App\Services\AuditLogService;

class QuestionsController extends AdminBaseController
{
    private QuestionModel $questionModel;
    private AuditLogService $auditLogService;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->questionModel = model(QuestionModel::class);
        $this->auditLogService = new AuditLogService();
    }

    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $questions = $this->questionModel->where('is_deleted', 0)->orderBy('orden', 'ASC')->findAll();

        return view('admin/questions/index', [
            'title' => 'Preguntas',
            'questions' => $questions,
            'categories' => ['Servicio', 'Alimentos', 'Instalaciones', 'General'],
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $rules = [
            'pregunta' => 'required|min_length[5]|max_length[255]',
            'categoria' => 'required|in_list[Servicio,Alimentos,Instalaciones,General]',
            'orden' => 'required|integer|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Datos invalidos para registrar pregunta.');
        }

        $this->questionModel->insert([
            'pregunta' => strip_tags((string) $this->request->getPost('pregunta')),
            'categoria' => (string) $this->request->getPost('categoria'),
            'tipo' => 'escala_1_5',
            'orden' => (int) $this->request->getPost('orden'),
            'activa' => $this->request->getPost('activa') ? 1 : 0,
            'is_deleted' => 0,
        ]);

        $this->auditLogService->register('ALTA_PREGUNTA', 'Se creo una pregunta', (int) session('admin_id'));

        return redirect()->to('/admin/preguntas')->with('success', 'Pregunta creada.');
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $question = $this->questionModel->where('is_deleted', 0)->find($id);
        if (!$question) {
            return redirect()->to('/admin/preguntas')->with('error', 'Pregunta no encontrada.');
        }

        $rules = [
            'pregunta' => 'required|min_length[5]|max_length[255]',
            'categoria' => 'required|in_list[Servicio,Alimentos,Instalaciones,General]',
            'orden' => 'required|integer|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Datos invalidos para actualizar pregunta.');
        }

        $this->questionModel->update($id, [
            'pregunta' => strip_tags((string) $this->request->getPost('pregunta')),
            'categoria' => (string) $this->request->getPost('categoria'),
            'tipo' => 'escala_1_5',
            'orden' => (int) $this->request->getPost('orden'),
            'activa' => $this->request->getPost('activa') ? 1 : 0,
        ]);

        $this->auditLogService->register('EDITAR_PREGUNTA', 'Pregunta ID ' . $id, (int) session('admin_id'));

        return redirect()->to('/admin/preguntas')->with('success', 'Pregunta actualizada.');
    }

    public function toggle(int $id)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $question = $this->questionModel->where('is_deleted', 0)->find($id);
        if (!$question) {
            return redirect()->to('/admin/preguntas')->with('error', 'Pregunta no encontrada.');
        }

        $newStatus = (int) !$question['activa'];
        $this->questionModel->update($id, ['activa' => $newStatus]);

        $this->auditLogService->register('CAMBIO_ESTADO_PREGUNTA', 'Pregunta ID ' . $id . ' activa=' . $newStatus, (int) session('admin_id'));

        return redirect()->to('/admin/preguntas')->with('success', 'Estado de pregunta actualizado.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $question = $this->questionModel->where('is_deleted', 0)->find($id);
        if (!$question) {
            return redirect()->to('/admin/preguntas')->with('error', 'Pregunta no encontrada.');
        }

        $this->questionModel->update($id, [
            'is_deleted' => 1,
            'activa' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        $this->auditLogService->register('BORRADO_LOGICO_PREGUNTA', 'Pregunta ID ' . $id, (int) session('admin_id'));

        return redirect()->to('/admin/preguntas')->with('success', 'Pregunta eliminada logicamente.');
    }
}
