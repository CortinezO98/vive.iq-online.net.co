<?php
class reporte_clicsController extends Controller {

    function __construct() {
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

        $fecha_inicio = isset($_GET['fecha_inicio']) && $_GET['fecha_inicio'] !== ''
            ? trim($_GET['fecha_inicio'])
            : null;

        $fecha_fin = isset($_GET['fecha_fin']) && $_GET['fecha_fin'] !== ''
            ? trim($_GET['fecha_fin'])
            : null;

        $detalle       = $clickModel->obtenerReporte($fecha_inicio, $fecha_fin);
        $resumen       = $clickModel->obtenerResumenGeneral($fecha_inicio, $fecha_fin);
        $topItems      = $clickModel->obtenerTopItems($fecha_inicio, $fecha_fin, 10);
        $topSecciones  = $clickModel->obtenerTopSecciones($fecha_inicio, $fecha_fin);
        $topPaginas    = $clickModel->obtenerTopPaginas($fecha_inicio, $fecha_fin);
        $serieDiaria   = $clickModel->obtenerClicsPorDia($fecha_inicio, $fecha_fin);
        $topUsuarios   = $clickModel->obtenerTopUsuarios($fecha_inicio, $fecha_fin, 10);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'data' => is_array($detalle) ? $detalle : [],
            'resumen' => $resumen ?: [
                'total_clics' => 0,
                'items_clicados' => 0,
                'usuarios_unicos' => 0,
                'sesiones_unicas' => 0
            ],
            'top_items' => is_array($topItems) ? $topItems : [],
            'top_secciones' => is_array($topSecciones) ? $topSecciones : [],
            'top_paginas' => is_array($topPaginas) ? $topPaginas : [],
            'serie_diaria' => is_array($serieDiaria) ? $serieDiaria : [],
            'top_usuarios' => is_array($topUsuarios) ? $topUsuarios : []
        ]);
        exit;
    }
}