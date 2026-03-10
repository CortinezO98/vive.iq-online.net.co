<?php
class reporte_clicsController extends Controller {

    function __construct() {
        // Asegurar que solo administradores puedan acceder
        if (!isset($_SESSION[APP_SESSION . 'usu_id'])) {
            Redirect::to('login');
            exit;
        }
        $perfil = strtoupper(trim((string)($_SESSION[APP_SESSION . 'usu_perfil'] ?? '')));
        $allow = ['ADMIN', 'ADMINISTRADOR', 'SUPERADMIN'];
        if (!in_array($perfil, $allow, true)) {
            Redirect::to('error');
            exit;
        }
    }

    function index() {
        $data = [
            'titulo_pagina' => 'REPORTES|CLICS EN ITEMS'
        ];
        View::render('index', $data);
    }

    function generar_json() {
        require_once MODELS . 'ItemClickModel.php';
        $clickModel = new ItemClickModel();

        $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
        $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

        $clics = $clickModel->obtenerReporte($fecha_inicio, $fecha_fin);

        $data = [
            'data' => is_array($clics) ? $clics : []
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}