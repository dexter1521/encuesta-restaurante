<?php

namespace App\Services;

use CodeIgniter\Database\BaseConnection;

class DashboardService
{
    private BaseConnection $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        $today = date('Y-m-d');
        $weekStart = date('Y-m-d', strtotime('monday this week'));
        $weekEnd = date('Y-m-d', strtotime('sunday this week'));

        $totalToday = $this->db->table('encuestas')
            ->where('DATE(created_at)', $today)
            ->countAllResults();

        $totalWeek = $this->db->table('encuestas')
            ->where('DATE(created_at) >=', $weekStart)
            ->where('DATE(created_at) <=', $weekEnd)
            ->countAllResults();

        $overallAvg = $this->db->table('respuestas')
            ->selectAvg('calificacion', 'promedio')
            ->get()
            ->getRowArray();

        $latestAnswers = $this->db->table('respuestas r')
            ->select('r.calificacion, r.created_at, p.pregunta, s.nombre AS sucursal')
            ->join('preguntas p', 'p.id = r.pregunta_id')
            ->join('encuestas e', 'e.id = r.encuesta_id')
            ->join('sucursales s', 's.id = e.sucursal_id')
            ->orderBy('r.id', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        $branchAverages = $this->db->table('respuestas r')
            ->select('s.nombre, AVG(r.calificacion) AS promedio')
            ->join('encuestas e', 'e.id = r.encuesta_id')
            ->join('sucursales s', 's.id = e.sucursal_id')
            ->groupBy('e.sucursal_id')
            ->orderBy('promedio', 'DESC')
            ->get()
            ->getResultArray();

        $worstQuestions = $this->db->table('respuestas r')
            ->select('p.pregunta, AVG(r.calificacion) AS promedio, COUNT(*) AS total')
            ->join('preguntas p', 'p.id = r.pregunta_id')
            ->groupBy('r.pregunta_id')
            ->having('COUNT(*) >', 0)
            ->orderBy('promedio', 'ASC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $recentComments = $this->db->table('encuestas')
            ->select('comentario_final, created_at')
            ->where('comentario_final IS NOT NULL')
            ->where('comentario_final !=', '')
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        return [
            'totalToday' => $totalToday,
            'totalWeek' => $totalWeek,
            'overallAvg' => $overallAvg['promedio'] ? round((float) $overallAvg['promedio'], 2) : 0,
            'latestAnswers' => $latestAnswers,
            'branchAverages' => $branchAverages,
            'worstQuestions' => $worstQuestions,
            'recentComments' => $recentComments,
        ];
    }
}
