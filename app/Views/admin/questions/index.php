<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Preguntas</h1>
    <button class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#createQuestionForm">Nueva Pregunta</button>
</div>

<div class="collapse mb-4" id="createQuestionForm">
    <div class="card shadow">
        <div class="card-body">
            <form method="post" action="<?= site_url('/admin/preguntas') ?>">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col-md-5 mb-3">
                        <label>Pregunta</label>
                        <input type="text" name="pregunta" class="form-control" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Categoria</label>
                        <select name="categoria" class="form-control" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= esc($category) ?>"><?= esc($category) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>Tipo</label>
                        <input type="text" class="form-control" value="Escala 1 a 5" readonly>
                    </div>
                    <div class="col-md-1 mb-3">
                        <label>Orden</label>
                        <input type="number" name="orden" class="form-control" min="1" required>
                    </div>
                    <div class="col-md-1 mb-3 d-flex align-items-center">
                        <div class="custom-control custom-switch mt-4">
                            <input type="checkbox" class="custom-control-input" id="activa_q_new" name="activa" checked>
                            <label class="custom-control-label" for="activa_q_new">Activa</label>
                        </div>
                    </div>
                    <div class="col-md-1 mb-3 d-flex align-items-end">
                        <button class="btn btn-success btn-block">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Pregunta</th>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th width="160">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($questions as $question): ?>
                    <tr>
                        <td><?= esc((string) $question['orden']) ?></td>
                        <td><?= esc($question['pregunta']) ?></td>
                        <td><?= esc($question['categoria']) ?></td>
                        <td>Escala 1 a 5</td>
                        <td>
                            <?php if ((int) $question['activa'] === 1): ?>
                                <span class="badge badge-success">Activa</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Inactiva</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                    Acciones
                                </button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item" type="button" data-toggle="collapse" data-target="#editq-<?= $question['id'] ?>">
                                        Editar
                                    </button>
                                    <form method="post" action="<?= site_url('/admin/preguntas/' . $question['id'] . '/toggle') ?>">
                                        <?= csrf_field() ?>
                                        <button class="dropdown-item" type="submit">Activar/Desactivar</button>
                                    </form>
                                    <form method="post" action="<?= site_url('/admin/preguntas/' . $question['id'] . '/eliminar') ?>" onsubmit="return confirm('Confirmar borrado logico?')">
                                        <?= csrf_field() ?>
                                        <button class="dropdown-item text-danger" type="submit">Borrar</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse bg-light" id="editq-<?= $question['id'] ?>">
                        <td colspan="6">
                            <form method="post" action="<?= site_url('/admin/preguntas/' . $question['id'] . '/actualizar') ?>">
                                <?= csrf_field() ?>
                                <div class="form-row">
                                    <div class="col-md-5 mb-2">
                                        <input type="text" name="pregunta" class="form-control" value="<?= esc($question['pregunta']) ?>" required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <select name="categoria" class="form-control" required>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= esc($category) ?>" <?= $question['categoria'] === $category ? 'selected' : '' ?>><?= esc($category) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <input type="number" name="orden" class="form-control" value="<?= esc((string) $question['orden']) ?>" min="1" required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <input type="checkbox" name="activa" <?= (int) $question['activa'] === 1 ? 'checked' : '' ?>> Activa
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <button class="btn btn-primary btn-sm">Guardar cambios</button>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
