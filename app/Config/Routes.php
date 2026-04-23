<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/encuesta', 'SurveyController::index');
$routes->post('/encuesta/enviar', 'SurveyController::submit', ['filter' => 'csrf']);

$routes->get('/admin/login', 'AuthController::login');
$routes->post('/admin/login', 'AuthController::attemptLogin', ['filter' => 'csrf']);
$routes->get('/admin/logout', 'AuthController::logout');

$routes->group('admin', static function ($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');

    $routes->get('sucursales', 'Admin\BranchesController::index');
    $routes->post('sucursales', 'Admin\BranchesController::store', ['filter' => 'csrf']);
    $routes->post('sucursales/(:num)/actualizar', 'Admin\BranchesController::update/$1', ['filter' => 'csrf']);
    $routes->post('sucursales/(:num)/toggle', 'Admin\BranchesController::toggle/$1', ['filter' => 'csrf']);
    $routes->post('sucursales/(:num)/eliminar', 'Admin\BranchesController::delete/$1', ['filter' => 'csrf']);

    $routes->get('preguntas', 'Admin\QuestionsController::index');
    $routes->post('preguntas', 'Admin\QuestionsController::store', ['filter' => 'csrf']);
    $routes->post('preguntas/(:num)/actualizar', 'Admin\QuestionsController::update/$1', ['filter' => 'csrf']);
    $routes->post('preguntas/(:num)/toggle', 'Admin\QuestionsController::toggle/$1', ['filter' => 'csrf']);
    $routes->post('preguntas/(:num)/eliminar', 'Admin\QuestionsController::delete/$1', ['filter' => 'csrf']);

    $routes->get('reportes', 'Admin\ReportsController::index');
    $routes->get('reportes/exportar-csv', 'Admin\ReportsController::exportCsv');
});
