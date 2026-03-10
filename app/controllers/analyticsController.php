<?php
class analyticsController extends Controller
{
    public function __construct()
    {
        // Se permite registrar clics incluso sin sesión.
        // Si en el futuro quieres restringirlo, aquí puedes validar login.
    }

    /**
     * Endpoint para registrar clics generales
     */
    public function registrar_click()
    {
        $response = [
            'success' => false,
            'message' => 'Solicitud inválida'
        ];

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            require_once MODELS . 'ClickEventModel.php';
            $model = new ClickEventModel();

            $click_tipo        = isset($_POST['click_tipo']) ? trim((string)$_POST['click_tipo']) : '';
            $click_clave       = isset($_POST['click_clave']) ? trim((string)$_POST['click_clave']) : '';
            $click_label       = isset($_POST['click_label']) ? trim((string)$_POST['click_label']) : '';
            $click_modulo      = isset($_POST['click_modulo']) ? trim((string)$_POST['click_modulo']) : '';
            $click_url_destino = isset($_POST['click_url_destino']) ? trim((string)$_POST['click_url_destino']) : '';
            $entidad_id        = isset($_POST['entidad_id']) && $_POST['entidad_id'] !== '' ? (int)$_POST['entidad_id'] : null;
            $entidad_tipo      = isset($_POST['entidad_tipo']) ? trim((string)$_POST['entidad_tipo']) : null;

            // Nuevos campos enriquecidos
            $click_dom_path      = isset($_POST['click_dom_path']) ? trim((string)$_POST['click_dom_path']) : null;
            $click_texto_visible = isset($_POST['click_texto_visible']) ? trim((string)$_POST['click_texto_visible']) : null;
            $click_x             = isset($_POST['click_x']) && $_POST['click_x'] !== '' ? (int)$_POST['click_x'] : null;
            $click_y             = isset($_POST['click_y']) && $_POST['click_y'] !== '' ? (int)$_POST['click_y'] : null;
            $viewport_w          = isset($_POST['viewport_w']) && $_POST['viewport_w'] !== '' ? (int)$_POST['viewport_w'] : null;
            $viewport_h          = isset($_POST['viewport_h']) && $_POST['viewport_h'] !== '' ? (int)$_POST['viewport_h'] : null;
            $page_url            = isset($_POST['page_url']) ? trim((string)$_POST['page_url']) : null;
            $page_slug           = isset($_POST['page_slug']) ? trim((string)$_POST['page_slug']) : null;
            $seccion_nombre      = isset($_POST['seccion_nombre']) ? trim((string)$_POST['seccion_nombre']) : null;
            $click_contexto      = isset($_POST['click_contexto']) ? trim((string)$_POST['click_contexto']) : null;
            $click_posicion      = isset($_POST['click_posicion']) && $_POST['click_posicion'] !== '' ? (int)$_POST['click_posicion'] : null;

            if ($click_tipo === '' || $click_clave === '' || $click_label === '') {
                throw new Exception('Faltan datos obligatorios del evento');
            }

            $session_id = session_id();
            if (!$session_id) {
                $session_id = '';
            }

            // Evitar doble clic inmediato
            if ($session_id !== '' && $model->existeClickReciente($click_clave, $click_tipo, $session_id, 2)) {
                $response = [
                    'success' => true,
                    'message' => 'Click ya registrado recientemente'
                ];
            } else {
                $model->click_tipo = $click_tipo;
                $model->click_clave = $click_clave;
                $model->click_label = $click_label;
                $model->click_modulo = $click_modulo !== '' ? $click_modulo : null;
                $model->click_url_destino = $click_url_destino !== '' ? $click_url_destino : null;
                $model->click_url_origen = isset($_SERVER['HTTP_REFERER']) && trim((string)$_SERVER['HTTP_REFERER']) !== ''
                    ? trim((string)$_SERVER['HTTP_REFERER'])
                    : null;
                $model->entidad_id = $entidad_id;
                $model->entidad_tipo = ($entidad_tipo !== null && $entidad_tipo !== '') ? $entidad_tipo : null;
                $model->user_id = isset($_SESSION[APP_SESSION . 'usu_id']) ? (int)$_SESSION[APP_SESSION . 'usu_id'] : null;
                $model->click_ip = isset($_SERVER['REMOTE_ADDR']) && trim((string)$_SERVER['REMOTE_ADDR']) !== ''
                    ? trim((string)$_SERVER['REMOTE_ADDR'])
                    : null;
                $model->click_user_agent = isset($_SERVER['HTTP_USER_AGENT']) && trim((string)$_SERVER['HTTP_USER_AGENT']) !== ''
                    ? trim((string)$_SERVER['HTTP_USER_AGENT'])
                    : null;
                $model->click_session_id = $session_id !== '' ? $session_id : null;

                // Asignación de nuevos campos enriquecidos
                $model->click_dom_path = ($click_dom_path !== null && $click_dom_path !== '') ? $click_dom_path : null;
                $model->click_texto_visible = ($click_texto_visible !== null && $click_texto_visible !== '') ? $click_texto_visible : null;
                $model->click_x = $click_x;
                $model->click_y = $click_y;
                $model->viewport_w = $viewport_w;
                $model->viewport_h = $viewport_h;
                $model->page_url = ($page_url !== null && $page_url !== '') ? $page_url : null;
                $model->page_slug = ($page_slug !== null && $page_slug !== '') ? $page_slug : null;
                $model->seccion_nombre = ($seccion_nombre !== null && $seccion_nombre !== '') ? $seccion_nombre : null;
                $model->click_contexto = ($click_contexto !== null && $click_contexto !== '') ? $click_contexto : null;
                $model->click_posicion = $click_posicion;

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
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Vista del dashboard de analytics
     */
    public function index()
    {
        $this->requireAdmin();

        $data = [
            'titulo_pagina' => 'ANALYTICS|DASHBOARD'
        ];

        View::render('index', $data);
    }

    /**
     * Endpoint para obtener datos JSON del dashboard
     */
    public function datos_json()
    {
        $this->requireAdmin();

        require_once MODELS . 'ClickEventModel.php';
        $model = new ClickEventModel();

        $fecha_inicio = isset($_GET['fecha_inicio']) && trim((string)$_GET['fecha_inicio']) !== ''
            ? trim((string)$_GET['fecha_inicio'])
            : null;

        $fecha_fin = isset($_GET['fecha_fin']) && trim((string)$_GET['fecha_fin']) !== ''
            ? trim((string)$_GET['fecha_fin'])
            : null;

        $click_tipo = isset($_GET['click_tipo']) && trim((string)$_GET['click_tipo']) !== ''
            ? trim((string)$_GET['click_tipo'])
            : null;

        $click_modulo = isset($_GET['click_modulo']) && trim((string)$_GET['click_modulo']) !== ''
            ? trim((string)$_GET['click_modulo'])
            : null;

        try {
            $detalle       = $model->obtenerReporte($fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);
            $resumen       = $model->obtenerResumenGeneral($fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);
            $top_elementos = $model->obtenerTopElementos($fecha_inicio, $fecha_fin, $click_tipo, $click_modulo, 10);
            $por_tipo      = $model->obtenerPorTipo($fecha_inicio, $fecha_fin, $click_modulo);
            $por_modulo    = $model->obtenerPorModulo($fecha_inicio, $fecha_fin, $click_tipo);
            $serie_diaria  = $model->obtenerSerieDiaria($fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);
            $top_usuarios  = $model->obtenerTopUsuarios($fecha_inicio, $fecha_fin, $click_tipo, $click_modulo, 10);

            $response = [
                'data' => is_array($detalle) ? $detalle : [],
                'resumen' => is_array($resumen) ? $resumen : [
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
            ];
        } catch (Exception $e) {
            error_log('Error datos_json analytics: ' . $e->getMessage());

            $response = [
                'data' => [],
                'resumen' => [
                    'total_clics' => 0,
                    'elementos_unicos' => 0,
                    'usuarios_unicos' => 0,
                    'sesiones_unicas' => 0
                ],
                'top_elementos' => [],
                'por_tipo' => [],
                'por_modulo' => [],
                'serie_diaria' => [],
                'top_usuarios' => []
            ];
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Exportar a Excel
     */
    public function exportar_excel()
    {
        $this->requireAdmin();

        require_once MODELS . 'ClickEventModel.php';
        require_once PLUGINS . 'PhpSpreadsheet/vendor/autoload.php';

        $model = new ClickEventModel();

        $fecha_inicio = isset($_GET['fecha_inicio']) && trim((string)$_GET['fecha_inicio']) !== ''
            ? trim((string)$_GET['fecha_inicio'])
            : null;

        $fecha_fin = isset($_GET['fecha_fin']) && trim((string)$_GET['fecha_fin']) !== ''
            ? trim((string)$_GET['fecha_fin'])
            : null;

        $click_tipo = isset($_GET['click_tipo']) && trim((string)$_GET['click_tipo']) !== ''
            ? trim((string)$_GET['click_tipo'])
            : null;

        $click_modulo = isset($_GET['click_modulo']) && trim((string)$_GET['click_modulo']) !== ''
            ? trim((string)$_GET['click_modulo'])
            : null;

        try {
            $datos = $model->obtenerReporte($fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Reporte Clics');

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

            $row = 2;
            foreach ($datos as $d) {
                $sheet->setCellValue('A' . $row, $d['click_id'] ?? '');
                $sheet->setCellValue('B' . $row, $d['click_fecha'] ?? '');
                $sheet->setCellValue('C' . $row, $d['click_tipo'] ?? '');
                $sheet->setCellValue('D' . $row, $d['click_clave'] ?? '');
                $sheet->setCellValue('E' . $row, $d['click_label'] ?? '');
                $sheet->setCellValue('F' . $row, $d['click_modulo'] ?? '');
                $sheet->setCellValue('G' . $row, $d['click_url_destino'] ?? '');
                $sheet->setCellValue('H' . $row, $d['click_url_origen'] ?? '');
                $sheet->setCellValue('I' . $row, $d['usuario_nombre'] ?? 'Anónimo');
                $sheet->setCellValue('J' . $row, $d['click_ip'] ?? '');
                $sheet->setCellValue('K' . $row, $d['click_session_id'] ?? '');
                $row++;
            }

            foreach (range('A', 'K') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="reporte_clics_' . date('Y-m-d_H-i-s') . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        } catch (Exception $e) {
            error_log('Error exportar_excel analytics: ' . $e->getMessage());
            Redirect::to('error');
            exit;
        }
    }

    /**
     * Validar acceso administrador
     */
    private function requireAdmin()
    {
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