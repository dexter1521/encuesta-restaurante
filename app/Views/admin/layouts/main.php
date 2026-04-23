<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Panel') ?> | Encuestas Restaurante</title>
    <link href="<?= base_url('assets/sb-admin/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="<?= base_url('assets/sb-admin/css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>
<body id="page-top">
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('/admin/dashboard') ?>">
            <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-poll"></i></div>
            <div class="sidebar-brand-text mx-3">Encuestas</div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item"><a class="nav-link" href="<?= site_url('/admin/dashboard') ?>"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a></li>
        <li class="nav-item"><a class="nav-link" href="<?= site_url('/admin/sucursales') ?>"><i class="fas fa-fw fa-store"></i><span>Sucursales</span></a></li>
        <li class="nav-item"><a class="nav-link" href="<?= site_url('/admin/preguntas') ?>"><i class="fas fa-fw fa-question-circle"></i><span>Preguntas</span></a></li>
        <li class="nav-item"><a class="nav-link" href="<?= site_url('/admin/reportes') ?>"><i class="fas fa-fw fa-file-alt"></i><span>Reportes</span></a></li>
        <hr class="sidebar-divider d-none d-md-block">
        <li class="nav-item"><a class="nav-link" href="<?= site_url('/encuesta') ?>" target="_blank"><i class="fas fa-fw fa-mobile-alt"></i><span>Ver encuesta</span></a></li>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mr-3 d-flex align-items-center text-gray-700">Hola, <?= esc((string) session('admin_name')) ?></li>
                    <li class="nav-item"><a class="btn btn-sm btn-outline-danger" href="<?= site_url('/admin/logout') ?>">Salir</a></li>
                </ul>
            </nav>
            <div class="container-fluid">
                <?php if (session('success')): ?>
                    <div class="alert alert-success js-auto-dismiss"><?= esc((string) session('success')) ?></div>
                <?php endif; ?>
                <?php if (session('error')): ?>
                    <div class="alert alert-danger js-auto-dismiss"><?= esc((string) session('error')) ?></div>
                <?php endif; ?>
                <?php if (isset($validation)): ?>
                    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                <?php endif; ?>
                <?= $this->renderSection('content') ?>
            </div>
        </div>
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto"><span>Encuestas Restaurante &copy; <?= date('Y') ?></span></div>
            </div>
        </footer>
    </div>
</div>
<script src="<?= base_url('assets/sb-admin/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/sb-admin/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
<script src="<?= base_url('assets/sb-admin/vendor/chart.js/Chart.min.js') ?>"></script>
<script src="<?= base_url('assets/sb-admin/js/sb-admin-2.min.js') ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alerts = document.querySelectorAll('.js-auto-dismiss');
        alerts.forEach(function (alert) {
            setTimeout(function () {
                alert.style.transition = 'opacity 0.4s ease';
                alert.style.opacity = '0';
                setTimeout(function () {
                    alert.remove();
                }, 450);
            }, 3200);
        });
    });
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
