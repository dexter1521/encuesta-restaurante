<?php

namespace App\Services;

use App\Models\AnswerModel;
use App\Models\QuestionModel;
use App\Models\SurveyModel;
use RuntimeException;

class SurveyService
{
    private SurveyModel $surveyModel;
    private AnswerModel $answerModel;
    private QuestionModel $questionModel;

    public function __construct()
    {
        $this->surveyModel = model(SurveyModel::class);
        $this->answerModel = model(AnswerModel::class);
        $this->questionModel = model(QuestionModel::class);
    }

    /**
     * @param array<int, string|int> $answers
     */
    public function registerSurvey(array $surveyData, array $answers): int
    {
        $db = db_connect();
        $db->transStart();

        $surveyId = (int) $this->surveyModel->insert([
            'sucursal_id'        => (int) $surveyData['sucursal_id'],
            'mesa_numero'        => $surveyData['mesa_numero'] ?: null,
            'primera_visita'     => (int) $surveyData['primera_visita'],
            'frecuencia_visita'  => $surveyData['frecuencia_visita'],
            'comentario_final'   => $surveyData['comentario_final'] ?: null,
            'ip_address'         => service('request')->getIPAddress(),
        ]);

        $activeQuestions = $this->questionModel->activeQuestions();
        $questionIds = array_column($activeQuestions, 'id');

        foreach ($questionIds as $questionId) {
            if (!isset($answers[$questionId])) {
                continue;
            }

            $this->answerModel->insert([
                'encuesta_id' => $surveyId,
                'pregunta_id' => (int) $questionId,
                'calificacion' => (int) $answers[$questionId],
            ]);
        }

        $db->transComplete();

        if (!$db->transStatus()) {
            throw new RuntimeException('No se pudo guardar la encuesta.');
        }

        return $surveyId;
    }
}
