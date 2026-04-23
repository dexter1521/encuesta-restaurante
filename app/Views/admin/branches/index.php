<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sucursales</h1>
    <button class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#createBranchForm">Nueva Sucursal</button>
</div>

<div class="collapse mb-4" id="createBranchForm">
    <div class="card shadow">
        <div class="card-body">
            <form method="post" action="<?= site_url('/admin/sucursales') ?>">
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Direccion</label>
                        <input type="text" name="direccion" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Telefono</label>
                        <input type="text" name="telefono" class="form-control">
                    </div>
                    <div class="col-md-1 mb-3 d-flex align-items-center">
                        <div class="custom-control custom-switch mt-4">
                            <input type="checkbox" class="custom-control-input" id="activa_new" name="activa" checked>
                            <label class="custom-control-label" for="activa_new">Activa</label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success">Guardar</button>
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
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Estado</th>
                        <th width="160">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($branches as $branch): ?>
                    <tr>
                        <td><?= esc($branch['nombre']) ?></td>
                        <td><?= esc($branch['direccion']) ?></td>
                        <td><?= esc($branch['telefono']) ?></td>
                        <td>
                            <?php if ((int) $branch['activa'] === 1): ?>
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
                                    <button class="dropdown-item" type="button" data-toggle="collapse" data-target="#edit-<?= $branch['id'] ?>">
                                        Editar
                                    </button>
                                    <form method="post" action="<?= site_url('/admin/sucursales/' . $branch['id'] . '/toggle') ?>">
                                        <?= csrf_field() ?>
                                        <button class="dropdown-item" type="submit">Activar/Desactivar</button>
                                    </form>
                                    <form method="post" action="<?= site_url('/admin/sucursales/' . $branch['id'] . '/eliminar') ?>" onsubmit="return confirm('Confirmar borrado logico?')">
                                        <?= csrf_field() ?>
                                        <button class="dropdown-item text-danger" type="submit">Borrar</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="collapse bg-light" id="edit-<?= $branch['id'] ?>">
                        <td colspan="5">
                            <form method="post" action="<?= site_url('/admin/sucursales/' . $branch['id'] . '/actualizar') ?>">
                                <?= csrf_field() ?>
                                <div class="form-row">
                                    <div class="col-md-4 mb-2">
                                        <input type="text" name="nombre" class="form-control" value="<?= esc($branch['nombre']) ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="text" name="direccion" class="form-control" value="<?= esc((string) $branch['direccion']) ?>">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <input type="text" name="telefono" class="form-control" value="<?= esc((string) $branch['telefono']) ?>">
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <input type="checkbox" name="activa" <?= (int) $branch['activa'] === 1 ? 'checked' : '' ?>>
                                    </div>
                                    <div class="col-md-1 mb-2">
                                        <button class="btn btn-primary btn-sm">Guardar</button>
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
