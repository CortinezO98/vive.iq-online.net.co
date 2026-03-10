<?php
class analyticsController extends Controller {

    function __construct() {
        if (!isset($_SESSION[APP_SESSION . 'usu_id']) && !isset($_SESSION[APP_SESSION . 'usu_id'])) {
            // Permitir registro de clics incluso sin sesión? (para visitantes)
            // Si quieres restringir solo a usuarios logueados, descomenta:
            // Redirect::to('login');
            // exit;
        }
    }

    /**
     * Endpoint para registrar clics generales
     */
    public function registrar_click() {
        $response = [
            'success' => false,
            'message' => 'Solicitud inválida'
        ];

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $click_tipo   = isset($_POST['click_tipo']) ? trim($_POST['click_tipo']) : '';
            $click_clave  = isset($_POST['click_clave']) ? trim($_POST['click_clave']) : '';
            $click_label  = isset($_POST['click_label']) ? trim($_POST['click_label']) : '';
            $click_modulo = isset($_POST['click_modulo']) ? trim($_POST['click_modulo']) : '';
            $click_url_destino = isset($_POST['click_url_destino']) ? trim($_POST['click_url_destino']) : '';
            $entidad_id   = isset($_POST['entidad_id']) && $_POST['entidad_id'] !== '' ? (int)$_POST['entidad_id'] : null;
            $entidad_tipo = isset($_POST['entidad_tipo']) ? trim($_POST['entidad_tipo']) : null;

            if ($click_tipo === '' || $click_clave === '' || $click_label === '') {
                throw new Exception('Faltan datos obligatorios del evento');
            }

            require_once MODELS . 'ClickEventModel.php';
            $model = new ClickEventModel();

            // Validar click duplicado (opcional)
            $session_id = session_id() ?: '';
            if ($model->existeClickReciente($click_clave, $click_tipo, $session_id, 2)) {
                $response = [
                    'success' => true,
                    'message' => 'Click ya registrado recientemente'
                ];
            } else {
                $model->click_tipo = $click_tipo;
                $model->click_clave = $click_clave;
                $model->click_label = $click_label;
                $model->click_modulo = $click_modulo;
                $model->click_url_destino = $click_url_destino;
                $model->click_url_origen = $_SERVER['HTTP_REFERER'] ?? '';
                $model->entidad_id = $entidad_id;
                $model->entidad_tipo = $entidad_tipo;
                $model->user_id = isset($_SESSION[APP_SESSION . 'usu_id']) ? (int)$_SESSION[APP_SESSION . 'usu_id'] : null;
                $model->click_ip = $_SERVER['REMOTE_ADDR'] ?? '';
                $model->click_user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
                $model->click_session_id = $session_id;

                if ($model->registrarClick()) {
                    $response = [
                        'success' => true,
                        'message' => 'Click registrado correctamente'
                    ];
                } else {
                    throw new Exception('No fue posible registrar el click');
                }
            }
        } catch (Exception $e) {
            error_log('Error registrar_click: ' . $e->getMessage());
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
        exit;
    }

    /**
     * Vista del dashboard de analytics
     */
    public function index() {
        $this->requireAdmin();

        $data = [
            'titulo_pagina' => 'ANALYTICS|DASHBOARD'
        ];
        View::render('index', $data);
    }

    /**
     * Endpoint para obtener datos JSON del dashboard
     */
    public function datos_json() {
        $this->requireAdmin();

        require_once MODELS . 'ClickEventModel.php';
        $model = new ClickEventModel();

        $fecha_inicio = isset($_GET['fecha_inicio']) && $_GET['fecha_inicio'] !== ''
            ? trim($_GET['fecha_inicio'])
            : null;

        $fecha_fin = isset($_GET['fecha_fin']) && $_GET['fecha_fin'] !== ''
            ? trim($_GET['fecha_fin'])
            : null;

        $click_tipo = isset($_GET['click_tipo']) && $_GET['click_tipo'] !== ''
            ? trim($_GET['click_tipo'])
            : null;

        $click_modulo = isset($_GET['click_modulo']) && $_GET['click_modulo'] !== ''
            ? trim($_GET['click_modulo'])
            : null;

        $detalle       = $model->obtenerReporte($fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);
        $resumen       = $model->obtenerResumenGeneral($fecha_inicio, $fecha_fin);
        $top_elementos = $model->obtenerTopElementos($fecha_inicio, $fecha_fin, 10);
        $por_tipo      = $model->obtenerPorTipo($fecha_inicio, $fecha_fin);
        $por_modulo    = $model->obtenerPorModulo($fecha_inicio, $fecha_fin);
        $serie_diaria  = $model->obtenerSerieDiaria($fecha_inicio, $fecha_fin);
        $top_usuarios  = $model->obtenerTopUsuarios($fecha_inicio, $fecha_fin, 10);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'data' => is_array($detalle) ? $detalle : [],
            'resumen' => $resumen ?: [
                'total_clics' => 0,
                'elementos_unicos' => 0,
                'usuarios_unicos' => 0,
                'sesiones_unicas' => 0
            ],
            'top_elementos' => is_array($top_elementos) ? $top_elementos : [],
            'por_tipo' => is_array($por_tipo) ? $por_tipo : [],
            'por_modulo' => is_array($por_modulo) ? $por_modulo : [],
            'serie_diaria' => is_array($serie_diaria) ? $serie_diaria : [],
            'top_usuarios' => is_array($top_usuarios) ? $top_usuarios : []
        ]);
        exit;
    }

    /**
     * Exportar a Excel
     */
    public function exportar_excel() {
        $this->requireAdmin();

        require_once MODELS . 'ClickEventModel.php';
        require_once PLUGINS . 'PhpSpreadsheet/vendor/autoload.php';

        $model = new ClickEventModel();

        $fecha_inicio = isset($_GET['fecha_inicio']) && $_GET['fecha_inicio'] !== ''
            ? trim($_GET['fecha_inicio'])
            : null;

        $fecha_fin = isset($_GET['fecha_fin']) && $_GET['fecha_fin'] !== ''
            ? trim($_GET['fecha_fin'])
            : null;

        $datos = $model->obtenerReporte($fecha_inicio, $fecha_fin);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Títulos
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Fecha y Hora');
        $sheet->setCellValue('C1', 'Tipo');
        $sheet->setCellValue('D1', 'Clave');
        $sheet->setCellValue('E1', 'Etiqueta');
        $sheet->setCellValue('F1', 'Módulo');
        $sheet->setCellValue('G1', 'URL Destino');
        $sheet->setCellValue('H1', 'URL Origen');
        $sheet->setCellValue('I1', 'Usuario');
        $sheet->setCellValue('J1', 'IP');
        $sheet->setCellValue('K1', 'Session ID');

        // Datos
        $row = 2;
        foreach ($datos as $d) {
            $sheet->setCellValue('A' . $row, $d['click_id']);
            $sheet->setCellValue('B' . $row, $d['click_fecha']);
            $sheet->setCellValue('C' . $row, $d['click_tipo']);
            $sheet->setCellValue('D' . $row, $d['click_clave']);
            $sheet->setCellValue('E' . $row, $d['click_label']);
            $sheet->setCellValue('F' . $row, $d['click_modulo']);
            $sheet->setCellValue('G' . $row, $d['click_url_destino']);
            $sheet->setCellValue('H' . $row, $d['click_url_origen']);
            $sheet->setCellValue('I' . $row, $d['usuario_nombre'] ?? 'Anónimo');
            $sheet->setCellValue('J' . $row, $d['click_ip']);
            $sheet->setCellValue('K' . $row, $d['click_session_id']);
            $row++;
        }

        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte_clics_' . date('Y-m-d') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    private function requireAdmin() {
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
}