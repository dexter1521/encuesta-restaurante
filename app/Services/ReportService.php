<?php

namespace App\Services;

use CodeIgniter\Database\BaseConnection;

class ReportService
{
    private BaseConnection $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    /**
     * @return array<string, mixed>
     */
    public function build(array $filters): array
    {
        $from = $filters['from'] ?? date('Y-m-01');
        $to = $filters['to'] ?? date('Y-m-d');
        $branchId = isset($filters['sucursal_id']) && $filters['sucursal_id'] !== '' ? (int) $filters['sucursal_id'] : null;

        $base = $this->db->table('respuestas r')
            ->join('encuestas e', 'e.id = r.encuesta_id');

        $this->applyFilters($base, $from, $to, $branchId);

        $totalAnswers = $base->countAllResults(false);
        $overallRow = $base->selectAvg('r.calificacion', 'promedio')->get()->getRowArray();
        $overall = $overallRow['promedio'] ? round((float) $overallRow['promedio'], 2) : 0;

        $perQuestion = $this->db->table('respuestas r')
            ->select('p.pregunta, p.categoria, AVG(r.calificacion) AS promedio, COUNT(*) AS total')
            ->join('encuestas e', 'e.id = r.encuesta_id')
            ->join('preguntas p', 'p.id = r.pregunta_id');
        $this->applyFilters($perQuestion, $from, $to, $branchId);
        $perQuestion = $perQuestion
            ->groupBy('r.pregunta_id')
            ->orderBy('promedio', 'DESC')
            ->get()
            ->getResultArray();

        $weeklyTrend = $this->db->table('respuestas r')
            ->select("YEARWEEK(e.created_at, 1) AS semana, AVG(r.calificacion) AS promedio, COUNT(*) AS total", false)
            ->join('encuestas e', 'e.id = r.encuesta_id');
        $this->applyFilters($weeklyTrend, $from, $to, $branchId);
        $weeklyTrend = $weeklyTrend
            ->groupBy('semana')
            ->orderBy('semana', 'ASC')
            ->get()
            ->getResultArray();

        $surveysCount = $this->db->table('encuestas e');
        $surveysCount->where('DATE(e.created_at) >=', $from)->where('DATE(e.created_at) <=', $to);
        if ($branchId !== null) {
            $surveysCount->where('e.sucursal_id', $branchId);
        }

        return [
            'filters' => ['from' => $from, 'to' => $to, 'sucursal_id' => $branchId],
            'totals' => [
                'total_respuestas' => $totalAnswers,
                'promedio_general' => $overall,
                'total_encuestas' => $surveysCount->countAllResults(),
            ],
            'per_question' => $perQuestion,
            'weekly_trend' => $weeklyTrend,
        ];
    }

    private function applyFilters(\CodeIgniter\Database\BaseBuilder $builder, string $from, string $to, ?int $branchId): void
    {
        $builder->where('DATE(e.created_at) >=', $from)
            ->where('DATE(e.created_at) <=', $to);

        if ($branchId !== null) {
            $builder->where('e.sucursal_id', $branchId);
        }
    }
}
