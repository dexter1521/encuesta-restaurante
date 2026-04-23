<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Encuestas Hoy</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc((string) $dashboard['totalToday']) ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Encuestas Semana</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc((string) $dashboard['totalWeek']) ?></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Promedio General</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format((float) $dashboard['overallAvg'], 2) ?>/5</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Graficas por Sucursal</h6></div>
            <div class="card-body"><canvas id="branchChart" height="140"></canvas></div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-danger">Preguntas Peor Calificadas</h6></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead><tr><th>Pregunta</th><th>Promedio</th><th>Total</th></tr></thead>
                        <tbody>
                        <?php foreach ($dashboard['worstQuestions'] as $row): ?>
                            <tr>
                                <td><?= esc($row['pregunta']) ?></td>
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
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Ultimas Respuestas</h6></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead><tr><th>Fecha</th><th>Sucursal</th><th>Pregunta</th><th>Calif.</th></tr></thead>
                        <tbody>
                        <?php foreach ($dashboard['latestAnswers'] as $row): ?>
                            <tr>
                                <td><?= esc(date('d/m/Y H:i', strtotime((string) $row['created_at']))) ?></td>
                                <td><?= esc($row['sucursal']) ?></td>
                                <td><?= esc($row['pregunta']) ?></td>
                                <td><?= esc((string) $row['calificacion']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Comentarios Recientes</h6></div>
            <div class="card-body">
                <?php if (empty($dashboard['recentComments'])): ?>
                    <p class="text-muted mb-0">Sin comentarios recientes.</p>
                <?php else: ?>
                    <?php foreach ($dashboard['recentComments'] as $comment): ?>
                        <blockquote class="blockquote mb-3 border-left-primary pl-3">
                            <p class="mb-1"><?= esc($comment['comentario_final']) ?></p>
                            <footer class="blockquote-footer"><?= esc(date('d/m/Y H:i', strtotime((string) $comment['created_at']))) ?></footer>
                        </blockquote>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const branchLabels = <?= json_encode(array_column($dashboard['branchAverages'], 'nombre'), JSON_UNESCAPED_UNICODE) ?>;
const branchValues = <?= json_encode(array_map(static fn($row) => round((float) $row['promedio'], 2), $dashboard['branchAverages'])) ?>;

const ctx = document.getElementById('branchChart');
if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: branchLabels,
            datasets: [{
                label: 'Promedio',
                backgroundColor: '#4e73df',
                borderColor: '#4e73df',
                data: branchValues
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 5
                    }
                }]
            }
        }
    });
}
</script>
<?= $this->endSection() ?>
