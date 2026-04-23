<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador | Encuestas Restaurante</title>
    <link href="<?= base_url('assets/sb-admin/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="<?= base_url('assets/sb-admin/css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Panel de Administracion</h1>
                        </div>
                        <?php if (session('success')): ?>
                            <div class="alert alert-success"><?= esc((string) session('success')) ?></div>
                        <?php endif; ?>
                        <?php if (session('error')): ?>
                            <div class="alert alert-danger"><?= esc((string) session('error')) ?></div>
                        <?php endif; ?>
                        <form method="post" action="<?= site_url('/admin/login') ?>">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-user" placeholder="Usuario" value="<?= esc((string) old('username')) ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user" placeholder="Contrasena" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Ingresar</button>
                        </form>
                        <hr>
                        <p class="small text-muted mb-0">Credenciales iniciales: admin / Admin12345*</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/sb-admin/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/sb-admin/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
<script src="<?= base_url('assets/sb-admin/js/sb-admin-2.min.js') ?>"></script>
</body>
</html>
