<?php

namespace App\Controllers;

use App\Models\BranchModel;
use App\Models\QuestionModel;
use App\Services\SurveyService;
use RuntimeException;

class SurveyController extends BaseController
{
    private BranchModel $branchModel;
    private QuestionModel $questionModel;
    private SurveyService $surveyService;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->branchModel = model(BranchModel::class);
        $this->questionModel = model(QuestionModel::class);
        $this->surveyService = new SurveyService();
    }

    public function index()
    {
        return view('public/survey', [
            'title' => 'Encuesta de Satisfaccion',
            'branches' => $this->branchModel->activeOptions(),
            'questions' => $this->questionModel->activeQuestions(),
            'frequencies' => ['Primera vez', 'Semanal', 'Quincenal', 'Mensual', 'Ocasional'],
        ]);
    }

    public function submit()
    {
        $questions = $this->questionModel->activeQuestions();
        if (empty($questions)) {
            return redirect()->back()->withInput()->with('error', 'No hay preguntas activas disponibles.');
        }

        $rules = [
            'sucursal_id' => 'required|integer',
            'mesa_numero' => 'permit_empty|max_length[20]',
            'primera_visita' => 'required|in_list[0,1]',
            'frecuencia_visita' => 'required|in_list[Primera vez,Semanal,Quincenal,Mensual,Ocasional]',
            'comentario_final' => 'permit_empty|max_length[1000]',
        ];

        foreach ($questions as $question) {
            $rules['respuesta_' . $question['id']] = 'required|integer|in_list[1,2,3,4,5]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Completa la encuesta correctamente.');
        }

        $answers = [];
        foreach ($questions as $question) {
            $answers[$question['id']] = (int) $this->request->getPost('respuesta_' . $question['id']);
        }

        try {
            $this->surveyService->registerSurvey([
                'sucursal_id' => (int) $this->request->getPost('sucursal_id'),
                'mesa_numero' => trim((string) $this->request->getPost('mesa_numero')),
                'primera_visita' => (int) $this->request->getPost('primera_visita'),
                'frecuencia_visita' => (string) $this->request->getPost('frecuencia_visita'),
                'comentario_final' => trim((string) $this->request->getPost('comentario_final')),
            ], $answers);
        } catch (RuntimeException $exception) {
            return redirect()->back()->withInput()->with('error', 'Ocurrio un error al guardar la encuesta.');
        }

        return redirect()->to('/encuesta?thanks=1');
    }
}
