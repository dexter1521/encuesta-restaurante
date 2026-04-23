<?php

namespace App\Controllers\Admin;

use App\Models\BranchModel;
use App\Services\ReportService;

class ReportsController extends AdminBaseController
{
    private ReportService $reportService;
    private BranchModel $branchModel;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->reportService = new ReportService();
        $this->branchModel = model(BranchModel::class);
    }

    public function index()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $filters = [
            'from' => $this->request->getGet('from') ?: date('Y-m-01'),
            'to' => $this->request->getGet('to') ?: date('Y-m-d'),
            'sucursal_id' => $this->request->getGet('sucursal_id') ?? '',
        ];

        $report = $this->reportService->build($filters);

        return view('admin/reports/index', [
            'title' => 'Reportes',
            'report' => $report,
            'branches' => $this->branchModel->activeOptions(),
        ]);
    }

    public function exportCsv()
    {
        if ($redirect = $this->requireAuth()) {
            return $redirect;
        }

        $filters = [
            'from' => $this->request->getGet('from') ?: date('Y-m-01'),
            'to' => $this->request->getGet('to') ?: date('Y-m-d'),
            'sucursal_id' => $this->request->getGet('sucursal_id') ?? '',
        ];

        $report = $this->reportService->build($filters);

        $filename = 'reporte_encuestas_' . date('Ymd_His') . '.csv';
        $lines = [];
        $lines[] = 'Pregunta,Categoria,Promedio,Total Respuestas';

        foreach ($report['per_question'] as $row) {
            $lines[] = sprintf(
                '"%s","%s","%s","%s"',
                str_replace('"', '""', (string) $row['pregunta']),
                $row['categoria'],
                number_format((float) $row['promedio'], 2, '.', ''),
                $row['total']
            );
        }

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody("\xEF\xBB\xBF" . implode("\n", $lines));
    }
}
