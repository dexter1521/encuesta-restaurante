<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<h1 class="h3 mb-4 text-gray-800">Reportes</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="get" action="<?= site_url('/admin/reportes') ?>" class="form-row">
            <div class="col-md-3 mb-2">
                <label>Desde</label>
                <input type="date" name="from" class="form-control" value="<?= esc($report['filters']['from']) ?>">
            </div>
            <div class="col-md-3 mb-2">
                <label>Hasta</label>
                <input type="date" name="to" class="form-control" value="<?= esc($report['filters']['to']) ?>">
            </div>
            <div class="col-md-4 mb-2">
                <label>Sucursal</label>
                <select name="sucursal_id" class="form-control">
                    <option value="">Todas</option>
                    <?php foreach ($branches as $branch): ?>
                        <option value="<?= esc((string) $branch['id']) ?>" <?= (string) $report['filters']['sucursal_id'] === (string) $branch['id'] ? 'selected' : '' ?>>
                            <?= esc($branch['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end">
                <button class="btn btn-primary btn-block">Filtrar</button>
            </div>
        </form>
        <a href="<?= site_url('/admin/reportes/exportar-csv?from=' . urlencode((string) $report['filters']['from']) . '&to=' . urlencode((string) $report['filters']['to']) . '&sucursal_id=' . urlencode((string) $report['filters']['sucursal_id'])) ?>" class="btn btn-success btn-sm mt-2">Exportar CSV (Excel)</a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs text-primary text-uppercase mb-1">Promedio General</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format((float) $report['totals']['promedio_general'], 2) ?>/5</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs text-success text-uppercase mb-1">Total Encuestas</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc((string) $report['totals']['total_encuestas']) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs text-info text-uppercase mb-1">Total Respuestas</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc((string) $report['totals']['total_respuestas']) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Promedio por Pregunta</h6></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead><tr><th>Pregunta</th><th>Categoria</th><th>Promedio</th><th>Total</th></tr></thead>
                        <tbody>
                        <?php foreach ($report['per_question'] as $row): ?>
                            <tr>
                                <td><?= esc($row['pregunta']) ?></td>
                                <td><?= esc($row['categoria']) ?></td>
                                <td><?= number_format((float) $row['promedio'], 2) ?></td>
                                <td><?= esc((string) $row['total']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Tendencia Semanal</h6></div>
            <div class="card-body"><canvas id="weeklyTrend" height="180"></canvas></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const trendLabels = <?= json_encode(array_map(static fn($row) => 'Sem ' . substr((string) $row['semana'], -2), $report['weekly_trend'])) ?>;
const trendValues = <?= json_encode(array_map(static fn($row) => round((float) $row['promedio'], 2), $report['weekly_trend'])) ?>;

const trendCtx = document.getElementById('weeklyTrend');
if (trendCtx) {
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Promedio semanal',
                data: trendValues,
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.15)',
                fill: true
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: { min: 0, max: 5 }
                }]
            }
        }
    });
}
</script>
<?= $this->endSection() ?>
