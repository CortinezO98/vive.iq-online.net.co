<?php

class comunicacionesController extends Controller {

    private comunicacionesModel $model;

    public function __construct() {
        $this->model = new comunicacionesModel();
    }

    private function requireLogin(): void {
        if (!isset($_SESSION[APP_SESSION . 'usu_id'])) {
            Redirect::to('?uri=login');
            exit;
        }
    }

    private function requireAdminComunicaciones(): void {
        $perfil = strtoupper(trim((string)($_SESSION[APP_SESSION . 'usu_perfil'] ?? '')));
        $allow = ['ADMIN', 'ADMINISTRADOR', 'SUPERADMIN'];

        if (!in_array($perfil, $allow, true)) {
            Redirect::to('?uri=error');
            exit;
        }
    }

    private function ensureCsrfToken(): void {
        if (empty($_SESSION['iqvive_token'])) {
            $_SESSION['iqvive_token'] = bin2hex(random_bytes(32));
        }
    }

    private function normalizeDate(?string $date): ?string {
        $date = trim((string)$date);
        if ($date === '') {
            return null;
        }

        $ts = strtotime($date);
        if ($ts === false) {
            return null;
        }

        return date('Y-m-d', $ts);
    }

    private function normalizeTime(?string $time): ?string {
        $time = trim((string)$time);
        if ($time === '') {
            return null;
        }

        // Acepta HH:MM o HH:MM:SS y guarda HH:MM
        if (preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $time)) {
            return substr($time, 0, 5);
        }

        return null;
    }

    private function getAgendaMonthYear(): array {
        $mes = (int)($_GET['m'] ?? date('n'));
        $anio = (int)($_GET['y'] ?? date('Y'));

        $mes = max(1, min(12, $mes));
        $anio = max(2020, min(2100, $anio));

        return [$mes, $anio];
    }

    private function buildEventosPorDia(array $eventos): array {
        $eventosPorDia = [];

        foreach ($eventos as $ev) {
            if (!is_array($ev)) {
                continue;
            }

            $fecha = $this->normalizeDate($ev['event_date'] ?? '');
            if (!$fecha) {
                continue;
            }

            $ev['event_date'] = $fecha;

            if (!isset($eventosPorDia[$fecha])) {
                $eventosPorDia[$fecha] = [];
            }

            $eventosPorDia[$fecha][] = $ev;
        }

        ksort($eventosPorDia);
        return $eventosPorDia;
    }

    private function loadEventosMes(int $anio, int $mes): array {
        $eventos = [];
        $eventosPorDia = [];

        $modelPath = MODELS . 'EventoModel.php';
        $fechaInicio = sprintf('%04d-%02d-01', $anio, $mes);
        $fechaFin = date('Y-m-t', strtotime($fechaInicio));

        error_log("=== loadEventosMes ===");
        error_log("MODELS path: " . MODELS);
        error_log("Model path completo: " . $modelPath);
        error_log("¿Existe archivo?: " . (file_exists($modelPath) ? 'SI' : 'NO'));
        error_log("Mes consultado: " . $mes);
        error_log("Año consultado: " . $anio);
        error_log("Fecha inicio: " . $fechaInicio);
        error_log("Fecha fin: " . $fechaFin);

        if (!file_exists($modelPath)) {
            error_log("ERROR: No existe EventoModel.php en la ruta esperada.");
            return [$eventos, $eventosPorDia];
        }

        require_once $modelPath;
        $eventoModel = new eventoModel();

        try {
            if (method_exists($eventoModel, 'listBetween')) {
                $rows = $eventoModel->listBetween($fechaInicio, $fechaFin);
            } elseif (method_exists($eventoModel, 'getMonthEvents')) {
                $rows = $eventoModel->getMonthEvents($anio, $mes);
            } else {
                $rows = [];
            }
        } catch (Exception $e) {
            error_log("ERROR llamando al modelo de eventos: " . $e->getMessage());
            $rows = [];
        }

        error_log("Rows obtenidos desde modelo: " . (is_array($rows) ? count($rows) : 'NO ARRAY'));
        if (is_array($rows) && !empty($rows)) {
            error_log("Primer row: " . print_r($rows[0], true));
        }

        if (!is_array($rows)) {
            $rows = [];
        }

        $eventos = $rows;
        $eventosPorDia = $this->buildEventosPorDia($rows);

        error_log("eventosPorDia armados: " . count($eventosPorDia));
        error_log("Fechas encontradas: " . (!empty($eventosPorDia) ? implode(', ', array_keys($eventosPorDia)) : 'NINGUNA'));

        return [$eventos, $eventosPorDia];
    }


    public function debug_eventos() {
        $this->requireLogin();

        header('Content-Type: application/json; charset=UTF-8');

        $anio = (int)($_GET['y'] ?? 2026);
        $mes  = (int)($_GET['m'] ?? 3);

        $fechaInicio = sprintf('%04d-%02d-01', $anio, $mes);
        $fechaFin = date('Y-m-t', strtotime($fechaInicio));

        $modelPath = MODELS . 'EventoModel.php';

        $out = [
            'MODELS' => MODELS,
            'modelPath' => $modelPath,
            'file_exists' => file_exists($modelPath),
            'anio' => $anio,
            'mes' => $mes,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'rows' => [],
            'eventosPorDia' => [],
        ];

        if (!file_exists($modelPath)) {
            echo json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            exit;
        }

        require_once $modelPath;
        $eventoModel = new eventoModel();

        try {
            $rows = $eventoModel->listBetween($fechaInicio, $fechaFin);
            if (!is_array($rows)) {
                $rows = [];
            }

            $eventosPorDia = $this->buildEventosPorDia($rows);

            $out['rows_count'] = count($rows);
            $out['rows'] = $rows;
            $out['eventosPorDia'] = $eventosPorDia;
            $out['eventosPorDia_count'] = count($eventosPorDia);
            $out['eventosPorDia_keys'] = array_keys($eventosPorDia);
        } catch (Exception $e) {
            $out['error'] = $e->getMessage();
        }

        echo json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }



    // =========================
    // PÚBLICO (logueados)
    // =========================

    public function index() {
        $this->requireLogin();
        Redirect::to('?uri=comunicaciones/ver/inicio');
        exit;
    }

    public function ver($slug = 'inicio') {
        $this->requireLogin();
        $this->ensureCsrfToken();

        $slug = trim((string)$slug);
        if ($slug === '') {
            $slug = 'inicio';
        }

        $pagina = $this->model->obtenerPaginaPorSlug($slug);
        if (!$pagina) {
            Redirect::to('?uri=error');
            exit;
        }

        $secciones = $this->model->obtenerSeccionesPagina((int)$pagina->pag_id);

        $itemsBySeccion = [];
        if (is_array($secciones) || is_object($secciones)) {
            foreach ($secciones as $sec) {
                $itemsBySeccion[$sec->sec_id] = $this->model->obtenerItemsSeccion((int)$sec->sec_id);
            }
        }

        [$mes, $anio] = $this->getAgendaMonthYear();
        [$eventos, $eventosPorDia] = $this->loadEventosMes($anio, $mes);

        View::render($slug, [
            'pagina'         => $pagina,
            'secciones'      => $secciones,
            'itemsBySeccion' => $itemsBySeccion,
            'slug'           => $slug,
            'mes_agenda'     => $mes,
            'anio_agenda'    => $anio,
            'eventos'        => $eventos,
            'eventosPorDia'  => $eventosPorDia
        ]);
    }

    // =========================
    // GESTIÓN DE EVENTOS DE AGENDA
    // =========================

    public function eventos_obtener() {
        $this->requireLogin();

        header('Content-Type: application/json; charset=UTF-8');

        if (!file_exists(MODELS . 'EventoModel.php')) {
            echo json_encode(['eventos' => []]);
            exit;
        }

        $fechaInicio = $this->normalizeDate($_GET['inicio'] ?? date('Y-m-01')) ?? date('Y-m-01');
        $fechaFin = $this->normalizeDate($_GET['fin'] ?? date('Y-m-t')) ?? date('Y-m-t');

        require_once MODELS . 'EventoModel.php';
        $eventoModel = new eventoModel();

        $rows = $eventoModel->listBetween($fechaInicio, $fechaFin);
        if (!is_array($rows)) {
            $rows = [];
        }

        $eventos = [];
        foreach ($rows as $r) {
            $date = $this->normalizeDate($r['event_date'] ?? '');
            if (!$date) {
                continue;
            }

            $startTime = $this->normalizeTime($r['start_time'] ?? '');
            $endTime = $this->normalizeTime($r['end_time'] ?? '');

            $start = $date . ' ' . ($startTime ?: '00:00') . ':00';
            $end   = $date . ' ' . ($endTime ?: '23:59') . ':59';

            $eventos[] = [
                'id'          => (int)($r['id'] ?? 0),
                'title'       => (string)($r['title'] ?? ''),
                'start'       => $start,
                'end'         => $end,
                'allDay'      => (bool)($r['is_all_day'] ?? 0),
                'color'       => $r['color'] ?? '#1C2262',
                'description' => $r['description'] ?? '',
                'location'    => $r['location'] ?? '',
                'meet_url'    => $r['meet_url'] ?? '',
            ];
        }

        echo json_encode(['eventos' => $eventos]);
        exit;
    }

    public function eventos_guardar() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('?uri=comunicaciones/ver/' . ($_POST['slug'] ?? 'inicio'));
            exit;
        }

        $token = $_POST['form_token'] ?? ($_POST['token'] ?? null);
        if (!$token || !hash_equals($_SESSION['iqvive_token'] ?? '', (string)$token)) {
            Flasher::new('Error de validación de token', 'danger');
            Redirect::to('?uri=comunicaciones/ver/' . ($_POST['slug'] ?? 'inicio'));
            exit;
        }

        if (!file_exists(MODELS . 'EventoModel.php')) {
            Flasher::new('No existe el modelo de eventos', 'danger');
            Redirect::to('?uri=comunicaciones/ver/' . ($_POST['slug'] ?? 'inicio'));
            exit;
        }

        require_once MODELS . 'EventoModel.php';
        $evento = new eventoModel();

        $slug = trim((string)($_POST['slug'] ?? 'inicio'));
        if ($slug === '') {
            $slug = 'inicio';
        }

        $evento->title       = checkInput($_POST['title'] ?? '');
        $evento->description = checkInput($_POST['description'] ?? '');
        $evento->event_date  = $this->normalizeDate(checkInput($_POST['event_date'] ?? ''));
        $evento->start_time  = $this->normalizeTime($_POST['start_time'] ?? '');
        $evento->end_time    = $this->normalizeTime($_POST['end_time'] ?? '');
        $evento->meet_url    = checkInput($_POST['meet_url'] ?? '');
        $evento->location    = checkInput($_POST['location'] ?? '');
        $evento->color       = checkInput($_POST['color'] ?? '#1C2262');
        $evento->created_by  = (int)($_SESSION[APP_SESSION . 'usu_id'] ?? 0);
        $evento->is_all_day  = (!empty($_POST['is_all_day']) || empty($evento->start_time)) ? 1 : 0;

        if (empty($evento->title) || empty($evento->event_date)) {
            Flasher::new('El título y la fecha son obligatorios', 'danger');

            $fechaRef = $evento->event_date ?: date('Y-m-d');
            Redirect::to(
                '?uri=comunicaciones/ver/' . $slug .
                '&m=' . date('n', strtotime($fechaRef)) .
                '&y=' . date('Y', strtotime($fechaRef))
            );
            exit;
        }

        if (!empty($evento->meet_url) && !filter_var($evento->meet_url, FILTER_VALIDATE_URL)) {
            Flasher::new('La URL de la reunión no es válida', 'danger');
            Redirect::to(
                '?uri=comunicaciones/ver/' . $slug .
                '&m=' . date('n', strtotime($evento->event_date)) .
                '&y=' . date('Y', strtotime($evento->event_date))
            );
            exit;
        }

        if ($evento->add()) {
            Flasher::new('Evento creado exitosamente', 'success');
        } else {
            Flasher::new('Error al crear el evento', 'danger');
        }

        $mes = date('n', strtotime($evento->event_date));
        $anio = date('Y', strtotime($evento->event_date));

        Redirect::to('?uri=comunicaciones/ver/' . $slug . '&m=' . $mes . '&y=' . $anio);
        exit;
    }

    public function eventos_eliminar($id) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $decoded = base64_decode((string)$id, true);
        $id = (int)($decoded !== false ? $decoded : 0);

        if ($id <= 0) {
            Redirect::to('?uri=comunicaciones/ver/inicio');
            exit;
        }

        if (!file_exists(MODELS . 'EventoModel.php')) {
            Flasher::new('No existe el modelo de eventos', 'danger');
            Redirect::to('?uri=comunicaciones/ver/inicio');
            exit;
        }

        require_once MODELS . 'EventoModel.php';
        $evento = new eventoModel();
        $evento->id = $id;

        if ($evento->delete()) {
            Flasher::new('Evento eliminado exitosamente', 'success');
        } else {
            Flasher::new('Error al eliminar el evento', 'danger');
        }

        $slug = trim((string)($_GET['slug'] ?? 'inicio'));
        if ($slug === '') {
            $slug = 'inicio';
        }

        Redirect::to('?uri=comunicaciones/ver/' . $slug);
        exit;
    }

    // =========================
    // CALENDARIO / AJAX
    // =========================

    public function calendario($secId = 0) {
        $this->requireLogin();
        $this->ensureCsrfToken();

        $secId = (int)$secId;
        if ($secId <= 0) {
            Flasher::new('ID de sección inválido', 'danger');
            Redirect::to('?uri=comunicaciones/ver/inicio');
            exit;
        }

        $year = (int)($_GET['year'] ?? date('Y'));
        $month = (int)($_GET['month'] ?? date('n'));

        $year = max(2020, min(2100, $year));
        $month = max(1, min(12, $month));

        [$eventos, $eventosPorDia] = $this->loadEventosMes($year, $month);

        $seccion = $this->model->getSeccion($secId);
        if (!$seccion) {
            Flasher::new('La sección no existe', 'danger');
            Redirect::to('?uri=comunicaciones/ver/inicio');
            exit;
        }

        $pagina = $this->model->getPagina((int)$seccion->pag_id);

        View::render('calendario', [
            'year'          => $year,
            'month'         => $month,
            'eventos'       => $eventos,
            'eventosPorDia' => $eventosPorDia,
            'seccion'       => $seccion,
            'pagina'        => $pagina,
            'secId'         => $secId,
        ]);
    }

    public function calendario_ajax($secId = 0) {
        $this->requireLogin();

        $secId = (int)$secId;
        $year = (int)($_GET['year'] ?? date('Y'));
        $month = (int)($_GET['month'] ?? date('n'));

        $year = max(2020, min(2100, $year));
        $month = max(1, min(12, $month));

        [$eventos, $eventosPorDia] = $this->loadEventosMes($year, $month);

        $perfil = strtoupper(trim((string)($_SESSION[APP_SESSION . 'usu_perfil'] ?? '')));
        $puedeEditar = in_array($perfil, ['ADMIN', 'ADMINISTRADOR', 'SUPERADMIN'], true);

        header('Content-Type: text/html; charset=UTF-8');

        include VIEWS . 'comunicaciones/calendario_grid.php';
        exit;
    }

    public function evento_guardar_ajax() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        header('Content-Type: application/json; charset=UTF-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $token = $_POST['token'] ?? ($_POST['form_token'] ?? null);
        $sessToken = $_SESSION['iqvive_token'] ?? '';

        if (!$token || !$sessToken || !hash_equals($sessToken, (string)$token)) {
            echo json_encode([
                'success' => false,
                'message' => 'Token inválido o expirado. Recarga la página.'
            ]);
            exit;
        }

        if (!file_exists(MODELS . 'EventoModel.php')) {
            echo json_encode(['success' => false, 'message' => 'No existe el modelo de eventos']);
            exit;
        }

        require_once MODELS . 'EventoModel.php';
        $evento = new eventoModel();

        $evento->id          = (int)($_POST['id'] ?? 0);
        $evento->title       = trim((string)($_POST['title'] ?? ''));
        $evento->description = trim((string)($_POST['description'] ?? ''));
        $evento->event_date  = $this->normalizeDate($_POST['event_date'] ?? '');
        $evento->start_time  = $this->normalizeTime($_POST['start_time'] ?? '');
        $evento->end_time    = $this->normalizeTime($_POST['end_time'] ?? '');
        $evento->meet_url    = trim((string)($_POST['meet_url'] ?? ''));
        $evento->location    = trim((string)($_POST['location'] ?? ''));
        $evento->color       = trim((string)($_POST['color'] ?? '#1C2262'));
        $evento->is_all_day  = !empty($_POST['is_all_day']) || empty($evento->start_time) ? 1 : 0;
        $evento->created_by  = (int)($_SESSION[APP_SESSION . 'usu_id'] ?? 0);

        if ($evento->title === '') {
            echo json_encode(['success' => false, 'message' => 'El título es obligatorio']);
            exit;
        }

        if (empty($evento->event_date)) {
            echo json_encode(['success' => false, 'message' => 'La fecha es obligatoria']);
            exit;
        }

        if (!empty($evento->meet_url) && !filter_var($evento->meet_url, FILTER_VALIDATE_URL)) {
            echo json_encode(['success' => false, 'message' => 'La URL no es válida']);
            exit;
        }

        try {
            if ($evento->id > 0) {
                $result = $evento->update();
                $message = 'Evento actualizado correctamente';
            } else {
                $result = $evento->add();
                $message = 'Evento creado correctamente';
            }

            echo json_encode([
                'success' => (bool)$result,
                'message' => $result ? $message : 'Error al guardar el evento'
            ]);
            exit;
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    public function evento_eliminar_ajax() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        header('Content-Type: application/json; charset=UTF-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        if (!file_exists(MODELS . 'EventoModel.php')) {
            echo json_encode(['success' => false, 'message' => 'No existe el modelo de eventos']);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID inválido']);
            exit;
        }

        require_once MODELS . 'EventoModel.php';
        $evento = new eventoModel();
        $evento->id = $id;

        if ($evento->delete()) {
            echo json_encode(['success' => true, 'message' => 'Evento eliminado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar']);
        }

        exit;
    }

    public function eventos_por_fecha() {
        $this->requireLogin();

        header('Content-Type: application/json; charset=UTF-8');

        if (!file_exists(MODELS . 'EventoModel.php')) {
            echo json_encode(['eventos' => []]);
            exit;
        }

        $fecha = $this->normalizeDate($_GET['fecha'] ?? date('Y-m-d')) ?? date('Y-m-d');

        require_once MODELS . 'EventoModel.php';
        $eventoModel = new eventoModel();

        $rows = $eventoModel->listBetween($fecha, $fecha);
        if (!is_array($rows)) {
            $rows = [];
        }

        $eventos = [];
        foreach ($rows as $r) {
            $date = $this->normalizeDate($r['event_date'] ?? '');
            if (!$date) {
                continue;
            }

            $startTime = $this->normalizeTime($r['start_time'] ?? '');
            $endTime = $this->normalizeTime($r['end_time'] ?? '');

            $start = $date . ' ' . ($startTime ?: '00:00') . ':00';
            $end   = $date . ' ' . ($endTime ?: '23:59') . ':59';

            $eventos[] = [
                'id'          => (int)($r['id'] ?? 0),
                'title'       => (string)($r['title'] ?? ''),
                'start'       => $start,
                'end'         => $end,
                'allDay'      => (bool)($r['is_all_day'] ?? 0),
                'color'       => $r['color'] ?? '#1C2262',
                'description' => $r['description'] ?? '',
                'location'    => $r['location'] ?? '',
                'meet_url'    => $r['meet_url'] ?? '',
            ];
        }

        echo json_encode(['eventos' => $eventos]);
        exit;
    }

    // =========================
    // ADMIN CMS
    // =========================

    public function admin_paginas() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $paginas = $this->model->listarPaginasAdmin();
        View::render('admin/adminPaginas', ['paginas' => $paginas]);
    }

    public function admin_pagina_form($id = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $pagina = null;
        if ((int)$id > 0) {
            $pagina = $this->model->getPagina((int)$id);
        }

        View::render('admin/adminPaginaForm', ['pagina' => $pagina]);
    }

    private function subirHeroImagen(?array $file, $pagId): ?string {
        if (!$file || empty($file['name'])) return null;
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) return null;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (!in_array($ext, $allow, true)) {
            Flasher::new('Tipo de archivo no permitido. Solo JPG, PNG, WEBP o GIF.', 'danger');
            return null;
        }

        if (($file['size'] ?? 0) > 5 * 1024 * 1024) {
            Flasher::new('La imagen no puede superar los 5MB.', 'danger');
            return null;
        }

        $dir = UPLOADS_ROOT_ASSETS . 'comunicaciones' . DS . 'hero' . DS;
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $name = 'pagina_' . $pagId . '_' . time() . '.' . $ext;
        $dest = $dir . $name;

        if (move_uploaded_file($file['tmp_name'], $dest)) {
            return 'comunicaciones/hero/' . $name;
        }

        Flasher::new('Error al subir la imagen', 'danger');
        return null;
    }

    public function admin_pagina_guardar() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }

        $pagId = (int)($_POST['pag_id'] ?? 0);
        $slug = trim((string)($_POST['pag_slug'] ?? ''));
        $titulo = trim((string)($_POST['pag_titulo'] ?? ''));

        if ($slug === '' || $titulo === '') {
            Flasher::new('El slug y el título son obligatorios', 'danger');
            Redirect::to('?uri=comunicaciones/admin_pagina_form/' . ($pagId ?: 0));
            exit;
        }

        $heroBg = trim((string)($_POST['pag_hero_bg'] ?? ''));

        if (isset($_FILES['pag_hero_imagen']) && ($_FILES['pag_hero_imagen']['error'] ?? null) === UPLOAD_ERR_OK) {
            if ($pagId > 0) {
                $uploaded = $this->subirHeroImagen($_FILES['pag_hero_imagen'], $pagId);
                if ($uploaded) {
                    $heroBg = $uploaded;
                }
            }
        }

        $d = [
            'pag_id'              => $pagId,
            'pag_slug'            => $slug,
            'pag_titulo'          => $titulo,
            'pag_subtitulo'       => trim((string)($_POST['pag_subtitulo'] ?? '')),
            'pag_hero_bg'         => $heroBg,
            'pag_hero_overlay'    => (int)($_POST['pag_hero_overlay'] ?? 1),
            'pag_hero_alineacion' => $_POST['pag_hero_alineacion'] ?? 'center',
            'pag_descripcion'     => trim((string)($_POST['pag_descripcion'] ?? '')),
            'pag_estado'          => $_POST['pag_estado'] ?? 'ACTIVO',
            'pag_orden'           => (int)($_POST['pag_orden'] ?? 0),
        ];

        $nuevoId = $this->model->guardarPagina($d);

        if ($pagId === 0 && isset($_FILES['pag_hero_imagen']) && ($_FILES['pag_hero_imagen']['error'] ?? null) === UPLOAD_ERR_OK) {
            $uploaded = $this->subirHeroImagen($_FILES['pag_hero_imagen'], $nuevoId);
            if ($uploaded) {
                $this->model->actualizarHeroBg($nuevoId, $uploaded);
            }
        }

        Flasher::new('Página guardada exitosamente', 'success');
        Redirect::to('?uri=comunicaciones/admin_secciones/' . ($pagId ?: $nuevoId));
        exit;
    }

    public function admin_secciones($pagId = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $pagId = (int)$pagId;

        $pagina = $this->model->getPagina($pagId);
        if (!$pagina) {
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }

        $secciones = $this->model->listarSeccionesAdmin($pagId);

        View::render('admin/adminSecciones', [
            'pagina'    => $pagina,
            'secciones' => $secciones
        ]);
    }

    public function admin_seccion_form($pagId = 0, $secId = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $pagId = (int)$pagId;
        $secId = (int)$secId;

        $pagina = $this->model->getPagina($pagId);
        if (!$pagina) {
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }

        $seccion = null;
        if ($secId > 0) {
            $seccion = $this->model->getSeccion($secId);
        }

        View::render('admin/adminSeccionForm', [
            'pagina'  => $pagina,
            'seccion' => $seccion
        ]);
    }




    public function admin_seccion_guardar() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }

        $d = [
            'sec_id'          => (int)($_POST['sec_id'] ?? 0),
            'pag_id'          => (int)($_POST['pag_id'] ?? 0),
            'sec_slug'        => trim((string)($_POST['sec_slug'] ?? '')),
            'sec_tipo'        => $_POST['sec_tipo'] ?? 'CAROUSEL',
            'sec_titulo'      => trim((string)($_POST['sec_titulo'] ?? '')),
            'sec_descripcion' => trim((string)($_POST['sec_descripcion'] ?? '')),
            'sec_layout'      => $_POST['sec_layout'] ?? 'CONTAINER',
            'sec_cols'        => (int)($_POST['sec_cols'] ?? 3),
            'sec_iframe_src'  => trim((string)($_POST['sec_iframe_src'] ?? '')),
            'sec_video_url'   => trim((string)($_POST['sec_video_url'] ?? '')),
            'sec_boton_texto' => trim((string)($_POST['sec_boton_texto'] ?? '')),
            'sec_boton_url'   => trim((string)($_POST['sec_boton_url'] ?? '')),
            'sec_estado'      => $_POST['sec_estado'] ?? 'ACTIVO',
            'sec_orden'       => (int)($_POST['sec_orden'] ?? 0),
            'sec_config_json' => null,
        ];

        $cfgRaw = trim((string)($_POST['sec_config_json_raw'] ?? ''));
        if ($cfgRaw !== '') {
            $decoded = json_decode($cfgRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $d['sec_config_json'] = $decoded;
            }
        }

        $this->model->guardarSeccion($d);

        Redirect::to('?uri=comunicaciones/admin_secciones/' . $d['pag_id']);
        exit;
    }

    public function admin_seccion_eliminar($id) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();
        
        $id = (int)$id;
        if ($id <= 0) {
            Flasher::new('ID de sección inválido', 'danger');
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }
        
        // Obtener la sección para conocer el ID de la página
        $seccion = $this->model->getSeccion($id);
        if (!$seccion) {
            Flasher::new('La sección no existe', 'danger');
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }
        
        $pagId = (int)$seccion->pag_id;
        
        // Ejecutar la eliminación
        if ($this->model->eliminarSeccion($id)) {
            Flasher::new('Sección eliminada exitosamente', 'success');
        } else {
            Flasher::new('Error al eliminar la sección', 'danger');
        }
        
        Redirect::to('?uri=comunicaciones/admin_secciones/' . $pagId);
        exit;
    }

    public function admin_items($secId = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $secId = (int)$secId;

        $sec = $this->model->getSeccion($secId);
        if (!$sec) {
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }

        $pagina = $this->model->getPagina((int)$sec->pag_id);
        $items  = $this->model->listarItemsAdmin($secId);

        View::render('admin/adminItems', [
            'pagina'  => $pagina,
            'seccion' => $sec,
            'items'   => $items
        ]);
    }

    public function admin_item_form($secId = 0, $itmId = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $secId = (int)$secId;
        $itmId = (int)$itmId;

        $sec = $this->model->getSeccion($secId);
        if (!$sec) {
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }

        $pagina = $this->model->getPagina((int)$sec->pag_id);

        $item = null;
        if ($itmId > 0) {
            $item = $this->model->getItem($itmId);
        }

        View::render('admin/adminItemForm', [
            'pagina'  => $pagina,
            'seccion' => $sec,
            'item'    => $item
        ]);
    }

    private function subirImagen(?array $file): ?string {
        if (!$file || empty($file['name'])) return null;
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) return null;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (!in_array($ext, $allow, true)) return null;

        $dir = UPLOADS_ROOT_ASSETS . 'comunicaciones' . DS;
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $name = 'com_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
        $dest = $dir . $name;

        if (move_uploaded_file($file['tmp_name'], $dest)) {
            return 'comunicaciones/' . $name;
        }

        return null;
    }

    public function admin_item_guardar() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }

        $secId = (int)($_POST['sec_id'] ?? 0);
        $itmId = (int)($_POST['itm_id'] ?? 0);

        $img = $this->subirImagen($_FILES['itm_imagen_file'] ?? null);
        $imgExistente = trim((string)($_POST['itm_imagen'] ?? ''));

        $d = [
            'itm_id'          => $itmId,
            'sec_id'          => $secId,
            'itm_titulo'      => trim((string)($_POST['itm_titulo'] ?? '')),
            'itm_descripcion' => trim((string)($_POST['itm_descripcion'] ?? '')),
            'itm_imagen'      => $img ?: ($imgExistente ?: null),
            'itm_url'         => trim((string)($_POST['itm_url'] ?? '')),
            'itm_target'      => $_POST['itm_target'] ?? '_blank',
            'itm_badge'       => trim((string)($_POST['itm_badge'] ?? '')),
            'itm_embed'       => trim((string)($_POST['itm_embed'] ?? '')),
            'itm_estado'      => $_POST['itm_estado'] ?? 'ACTIVO',
            'itm_orden'       => (int)($_POST['itm_orden'] ?? 0),
            'itm_extra_json'  => null,
        ];

        $extraRaw = trim((string)($_POST['itm_extra_json_raw'] ?? ''));
        if ($extraRaw !== '') {
            $decoded = json_decode($extraRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $d['itm_extra_json'] = $decoded;
            }
        }

        $this->model->guardarItem($d);

        Redirect::to('?uri=comunicaciones/admin_items/' . $secId);
        exit;
    }

    /**
     * Registra un clic en un item (llamada AJAX)
     */
    public function registrar_click_item() {
        // Respuesta por defecto
        $response = ['success' => false, 'message' => 'Error al procesar la solicitud'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['itm_id'])) {
            $itm_id = (int)$_POST['itm_id'];
            $user_id = isset($_SESSION[APP_SESSION . 'usu_id']) ? (int)$_SESSION[APP_SESSION . 'usu_id'] : null;
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
            $referer = $_SERVER['HTTP_REFERER'] ?? '';
            $session_id = session_id() ?: '';

            if ($itm_id > 0) {
                require_once MODELS . 'ItemClickModel.php';
                $clickModel = new ItemClickModel();
                $clickModel->itm_id = $itm_id;
                $clickModel->user_id = $user_id;
                $clickModel->click_ip = $ip;
                $clickModel->click_user_agent = $user_agent;
                $clickModel->click_referer = $referer;
                $clickModel->click_session_id = $session_id;

                if ($clickModel->registrarClick()) {
                    $response = ['success' => true, 'message' => 'Click registrado'];
                } else {
                    $response = ['success' => false, 'message' => 'Error al guardar en BD'];
                }
            } else {
                $response = ['success' => false, 'message' => 'ID de item inválido'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }


}