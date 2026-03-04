<?php

class comunicacionesController extends Controller {

    private comunicacionesModel $model;

    function __construct() {
        $this->model = new comunicacionesModel();
    }

    private function requireLogin(): void {
        if (!isset($_SESSION[APP_SESSION.'usu_id'])) {
            Redirect::to('?uri=login');
            exit;
        }
    }

    private function requireAdminComunicaciones(): void {
        $perfil = strtoupper(trim((string)($_SESSION[APP_SESSION.'usu_perfil'] ?? '')));
        $allow = ['ADMIN', 'ADMINISTRADOR', 'SUPERADMIN'];

        if (!in_array($perfil, $allow, true)) {
            Redirect::to('?uri=error');
            exit;
        }
    }

    // =========================
    // PÚBLICO (logueados)
    // =========================
    function index() {
        $this->requireLogin();
        Redirect::to('?uri=comunicaciones/ver/inicio');
    }

    function ver($slug = 'inicio') {
        $this->requireLogin();

        $slug = trim((string)$slug);
        if ($slug === '') $slug = 'inicio';

        $pagina = $this->model->obtenerPaginaPorSlug($slug);
        if (!$pagina) Redirect::to('?uri=error');

        $secciones = $this->model->obtenerSeccionesPagina((int)$pagina->pag_id);

        $itemsBySeccion = [];
        foreach ($secciones as $sec) {
            $itemsBySeccion[$sec->sec_id] = $this->model->obtenerItemsSeccion((int)$sec->sec_id);
        }

        // Obtener parámetros de mes y año para la agenda
        $mes = (int)($_GET['m'] ?? date('n'));
        $anio = (int)($_GET['y'] ?? date('Y'));

        // Validar rangos
        $mes = max(1, min(12, $mes));
        $anio = max(2020, min(2100, $anio));

        // --- NUEVO: Obtener eventos del mes ---
        $eventos = [];
        $eventosPorDia = [];

        // Verificar si el modelo de eventos existe antes de usarlo
        if (file_exists(MODELS . 'eventoModel.php')) {
            require_once MODELS . 'eventoModel.php';
            $eventoModel = new eventoModel();
            $fecha_inicio = sprintf('%04d-%02d-01', $anio, $mes);
            $fecha_fin = date('Y-m-t', strtotime($fecha_inicio));
            $eventos = $eventoModel->listBetween($fecha_inicio, $fecha_fin);

            // Organizar eventos por día
            if (is_array($eventos)) {
                foreach ($eventos as $ev) {
                    if (!isset($ev['event_date'])) continue;
                    $dia = (int)date('j', strtotime($ev['event_date']));
                    if (!isset($eventosPorDia[$dia])) {
                        $eventosPorDia[$dia] = [];
                    }
                    $eventosPorDia[$dia][] = $ev;
                }
            } else {
                $eventos = [];
            }
        }
        // ---------------------------------------

        // templates/comunicaciones/<slug>View.php
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

    /**
     * Obtener eventos para una fecha (formato JSON)
     */
    function eventos_obtener() {
        $this->requireLogin();

        header('Content-Type: application/json');

        $fecha_inicio = $_GET['inicio'] ?? date('Y-m-01');
        $fecha_fin = $_GET['fin'] ?? date('Y-m-t');

        require_once MODELS . 'eventoModel.php';
        $eventoModel = new eventoModel();

        $rows = $eventoModel->listBetween($fecha_inicio, $fecha_fin);
        if (!is_array($rows)) $rows = [];

        // Transformar al formato esperado por calendarios JS (start/end/allDay/color)
        $eventos = [];
        foreach ($rows as $r) {
            if (!isset($r['event_date'])) continue;

            $date  = $r['event_date'];
            $start = $date . (!empty($r['start_time']) ? (' ' . $r['start_time'] . ':00') : ' 00:00:00');
            $end   = $date . (!empty($r['end_time']) ? (' ' . $r['end_time'] . ':00') : ' 23:59:59');

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

    /**
     * Guardar un nuevo evento (POST tradicional)
     */
    function eventos_guardar() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('?uri=comunicaciones/ver/' . ($_POST['slug'] ?? 'inicio'));
            exit;
        }

        // Validar token CSRF (acepta token o form_token)
        $token = $_POST['form_token'] ?? ($_POST['token'] ?? null);
        if (!$token || $token !== ($_SESSION['iqvive_token'] ?? '')) {
            Flasher::new('Error de validación de token', 'danger');
            Redirect::to('?uri=comunicaciones/ver/' . ($_POST['slug'] ?? 'inicio'));
            exit;
        }

        require_once MODELS . 'eventoModel.php';
        $evento = new eventoModel();

        $evento->title = checkInput($_POST['title'] ?? '');
        $evento->description = checkInput($_POST['description'] ?? '');
        $evento->event_date = checkInput($_POST['event_date'] ?? '');
        $evento->start_time = !empty($_POST['start_time']) ? checkInput($_POST['start_time']) : null;
        $evento->end_time = !empty($_POST['end_time']) ? checkInput($_POST['end_time']) : null;
        $evento->meet_url = checkInput($_POST['meet_url'] ?? '');
        $evento->location = checkInput($_POST['location'] ?? '');
        $evento->is_all_day = empty($_POST['start_time']) ? 1 : 0;
        $evento->color = checkInput($_POST['color'] ?? '#1C2262');
        $evento->created_by = $_SESSION[APP_SESSION.'usu_id'] ?? 0;

        // Validaciones básicas
        if (empty($evento->title) || empty($evento->event_date)) {
            Flasher::new('El título y la fecha son obligatorios', 'danger');
            Redirect::to(
                '?uri=comunicaciones/ver/' . ($_POST['slug'] ?? 'inicio')
                . '?m=' . date('n', strtotime($evento->event_date ?: date('Y-m-d')))
                . '&y=' . date('Y', strtotime($evento->event_date ?: date('Y-m-d')))
            );
            exit;
        }

        // Validar URL si se proporcionó
        if (!empty($evento->meet_url) && !filter_var($evento->meet_url, FILTER_VALIDATE_URL)) {
            Flasher::new('La URL de la reunión no es válida', 'danger');
            Redirect::to(
                '?uri=comunicaciones/ver/' . ($_POST['slug'] ?? 'inicio')
                . '?m=' . date('n', strtotime($evento->event_date))
                . '&y=' . date('Y', strtotime($evento->event_date))
            );
            exit;
        }

        if ($evento->add()) {
            Flasher::new('Evento creado exitosamente', 'success');
        } else {
            Flasher::new('Error al crear el evento', 'danger');
        }

        // Redirigir al mes del evento creado
        $mes = date('n', strtotime($evento->event_date));
        $anio = date('Y', strtotime($evento->event_date));
        Redirect::to('?uri=comunicaciones/ver/' . ($_POST['slug'] ?? 'inicio') . '?m=' . $mes . '&y=' . $anio);
        exit;
    }

    /**
     * Eliminar un evento (solo admin)
     */
    function eventos_eliminar($id) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $id = (int)base64_decode($id);
        if ($id <= 0) {
            Redirect::to('?uri=comunicaciones/ver/inicio');
            exit;
        }

        require_once MODELS . 'eventoModel.php';
        $evento = new eventoModel();
        $evento->id = $id;

        if ($evento->delete()) {
            Flasher::new('Evento eliminado exitosamente', 'success');
        } else {
            Flasher::new('Error al eliminar el evento', 'danger');
        }

        $slug = $_GET['slug'] ?? 'inicio';
        Redirect::to('?uri=comunicaciones/ver/' . $slug);
        exit;
    }

    // =========================
    // NUEVAS FUNCIONES PARA GESTIÓN DE EVENTOS (AJAX para SCHEDULE)
    // =========================

    /**
     * Mostrar calendario de eventos completo
     */
    function calendario($secId = 0) {
        $this->requireLogin();
        if (empty($_SESSION['iqvive_token'])) {
            $_SESSION['iqvive_token'] = bin2hex(random_bytes(32));
        }


        $secId = (int)$secId;
        $year = (int)($_GET['year'] ?? date('Y'));
        $month = (int)($_GET['month'] ?? date('n'));

        // Validar rangos
        $year = max(2020, min(2100, $year));
        $month = max(1, min(12, $month));

        require_once MODELS . 'eventoModel.php';
        $eventoModel = new eventoModel();
        $eventos = $eventoModel->getMonthEvents($year, $month);
        if (!is_array($eventos)) $eventos = [];

        // Organizar eventos por día
        $eventosPorDia = [];
        foreach ($eventos as $ev) {
            if (!isset($ev['event_date'])) continue;
            $dia = (int)date('j', strtotime($ev['event_date']));
            if (!isset($eventosPorDia[$dia])) {
                $eventosPorDia[$dia] = [];
            }
            $eventosPorDia[$dia][] = $ev;
        }

        // Obtener información de la sección
        $seccion = $this->model->getSeccion($secId);
        $pagina = $seccion ? $this->model->getPagina((int)$seccion->pag_id) : null;

        View::render('calendario', [
            'year' => $year,
            'month' => $month,
            'eventosPorDia' => $eventosPorDia,
            'seccion' => $seccion,
            'pagina' => $pagina
        ]);
    }

    /**
     * Guardar evento (AJAX)
     */
    function evento_guardar_ajax() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        header('Content-Type: application/json; charset=UTF-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        // ✅ Validar token CSRF (acepta token o form_token) + mensaje más claro
        $token = $_POST['token'] ?? ($_POST['form_token'] ?? null);
        $sessToken = $_SESSION['iqvive_token'] ?? '';
        if (!$token || !$sessToken || !hash_equals($sessToken, (string)$token)) {
            echo json_encode(['success' => false, 'message' => 'Token inválido o expirado. Recarga la página.']);
            exit;
        }

        require_once MODELS . 'eventoModel.php';
        $evento = new eventoModel();

        $evento->id          = (int)($_POST['id'] ?? 0);
        $evento->title       = checkInput($_POST['title'] ?? '');
        $evento->description = checkInput($_POST['description'] ?? '');
        $evento->event_date  = checkInput($_POST['event_date'] ?? '');
        $evento->start_time  = !empty($_POST['start_time']) ? checkInput($_POST['start_time']) : null;
        $evento->end_time    = !empty($_POST['end_time']) ? checkInput($_POST['end_time']) : null;
        $evento->meet_url    = checkInput($_POST['meet_url'] ?? '');
        $evento->location    = checkInput($_POST['location'] ?? '');
        $evento->color       = checkInput($_POST['color'] ?? '#1C2262');
        $evento->is_all_day  = !empty($_POST['is_all_day']) ? 1 : 0;
        $evento->created_by  = (int)($_SESSION[APP_SESSION.'usu_id'] ?? 0);

        // ✅ Validaciones
        if ($evento->title === '') {
            echo json_encode(['success' => false, 'message' => 'El título es obligatorio']);
            exit;
        }

        if ($evento->event_date === '') {
            echo json_encode(['success' => false, 'message' => 'La fecha es obligatoria']);
            exit;
        }

        // ✅ Si es "todo el día", ignora horas (evita guardar horas sucias)
        if ((int)$evento->is_all_day === 1) {
            $evento->start_time = null;
            $evento->end_time = null;
        }

        // ✅ Validar URL si existe
        if ($evento->meet_url !== '' && !filter_var($evento->meet_url, FILTER_VALIDATE_URL)) {
            echo json_encode(['success' => false, 'message' => 'La URL no es válida']);
            exit;
        }

        // ✅ Validar coherencia de horas si vienen
        if ($evento->start_time && $evento->end_time) {
            // Comparación simple HH:MM
            if (strcmp($evento->end_time, $evento->start_time) < 0) {
                echo json_encode(['success' => false, 'message' => 'La hora fin no puede ser menor que la hora inicio']);
                exit;
            }
        }

        try {
            if ($evento->id > 0) {
                $result  = $evento->update(); // ✅ debe retornar bool (por el fix del modelo)
                $message = 'Evento actualizado correctamente';
            } else {
                $result  = $evento->add();    // ✅ debe retornar bool (por el fix del modelo)
                $message = 'Evento creado correctamente';
            }

            if ($result) {
                echo json_encode(['success' => true, 'message' => $message]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar el evento']);
            }
        } catch (\Throwable $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }

        exit;
    }

    /**
     * Eliminar evento (AJAX)
     */
    function evento_eliminar_ajax() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID inválido']);
            exit;
        }

        require_once MODELS . 'eventoModel.php';
        $evento = new eventoModel();
        $evento->id = $id;

        if ($evento->delete()) {
            echo json_encode(['success' => true, 'message' => 'Evento eliminado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar']);
        }

        exit;
    }

    /**
     * Obtener eventos para una fecha (JSON)
     */
    function eventos_por_fecha() {
        $this->requireLogin();

        header('Content-Type: application/json');

        $fecha = $_GET['fecha'] ?? date('Y-m-d');

        require_once MODELS . 'eventoModel.php';
        $eventoModel = new eventoModel();
        $rows = $eventoModel->listBetween($fecha, $fecha);
        if (!is_array($rows)) $rows = [];

        // Mantener compatibilidad: devuelve "eventos" como antes (sin romper),
        // pero normaliza por si el front espera start/end.
        $eventos = [];
        foreach ($rows as $r) {
            if (!isset($r['event_date'])) continue;

            $date  = $r['event_date'];
            $start = $date . (!empty($r['start_time']) ? (' ' . $r['start_time'] . ':00') : ' 00:00:00');
            $end   = $date . (!empty($r['end_time']) ? (' ' . $r['end_time'] . ':00') : ' 23:59:59');

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
    // ADMIN CMS (views en comunicaciones/admin/)
    // =========================

    function admin_paginas() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $paginas = $this->model->listarPaginasAdmin();

        // templates/comunicaciones/admin/adminPaginasView.php
        View::render('admin/adminPaginas', ['paginas' => $paginas]);
    }

    function admin_pagina_form($id = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $pagina = null;
        if ((int)$id > 0) {
            $pagina = $this->model->getPagina((int)$id);
        }

        // templates/comunicaciones/admin/adminPaginaFormView.php
        View::render('admin/adminPaginaForm', ['pagina' => $pagina]);
    }

    /**
     * Subir imagen del hero
     */
    private function subirHeroImagen(?array $file, $pagId): ?string {
        if (!$file || empty($file['name'])) return null;
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) return null;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array($ext, $allow, true)) {
            Flasher::new('Tipo de archivo no permitido. Solo JPG, PNG, WEBP o GIF.', 'danger');
            return null;
        }

        // Validar tamaño (5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            Flasher::new('La imagen no puede superar los 5MB.', 'danger');
            return null;
        }

        $dir = UPLOADS_ROOT_ASSETS . 'comunicaciones' . DS . 'hero' . DS;
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Nombre seguro: pagina_{id}_{timestamp}.ext
        $name = 'pagina_' . $pagId . '_' . time() . '.' . $ext;
        $dest = $dir . $name;

        if (move_uploaded_file($file['tmp_name'], $dest)) {
            return 'comunicaciones/hero/' . $name;
        }

        Flasher::new('Error al subir la imagen', 'danger');
        return null;
    }

    /**
     * Guardar página (modificado para manejar imagen)
     */
    function admin_pagina_guardar() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }

        $pagId = (int)($_POST['pag_id'] ?? 0);
        $slug = trim($_POST['pag_slug'] ?? '');
        $titulo = trim($_POST['pag_titulo'] ?? '');

        if ($slug === '' || $titulo === '') {
            Flasher::new('El slug y el título son obligatorios', 'danger');
            Redirect::to('?uri=comunicaciones/admin_pagina_form/' . ($pagId ?: 0));
            exit;
        }

        // Procesar imagen si se subió una nueva
        $heroBg = trim($_POST['pag_hero_bg'] ?? '');

        // Si hay un archivo nuevo y es válido
        if (isset($_FILES['pag_hero_imagen']) && $_FILES['pag_hero_imagen']['error'] === UPLOAD_ERR_OK) {
            // Si es una página existente, podemos subir la imagen inmediatamente
            if ($pagId > 0) {
                $uploaded = $this->subirHeroImagen($_FILES['pag_hero_imagen'], $pagId);
                if ($uploaded) {
                    $heroBg = $uploaded;
                }
            }
            // Si es nueva página, la imagen se procesará después de obtener el ID
        }

        $d = [
            'pag_id'              => $pagId,
            'pag_slug'            => $slug,
            'pag_titulo'          => $titulo,
            'pag_subtitulo'       => trim($_POST['pag_subtitulo'] ?? ''),
            'pag_hero_bg'         => $heroBg,
            'pag_hero_overlay'    => (int)($_POST['pag_hero_overlay'] ?? 1),
            'pag_hero_alineacion' => $_POST['pag_hero_alineacion'] ?? 'center',
            'pag_descripcion'     => trim($_POST['pag_descripcion'] ?? ''),
            'pag_estado'          => $_POST['pag_estado'] ?? 'ACTIVO',
            'pag_orden'           => (int)($_POST['pag_orden'] ?? 0),
        ];

        $nuevoId = $this->model->guardarPagina($d);

        // Si era nueva página y se subió imagen, actualizar con el ID
        if ($pagId === 0 && isset($_FILES['pag_hero_imagen']) && $_FILES['pag_hero_imagen']['error'] === UPLOAD_ERR_OK) {
            $uploaded = $this->subirHeroImagen($_FILES['pag_hero_imagen'], $nuevoId);
            if ($uploaded) {
                // Actualizar la página con la ruta de la imagen
                $this->model->actualizarHeroBg($nuevoId, $uploaded);
            }
        }

        Flasher::new('Página guardada exitosamente', 'success');
        Redirect::to('?uri=comunicaciones/admin_secciones/' . ($pagId ?: $nuevoId));
        exit;
    }

    function admin_secciones($pagId = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $pagId = (int)$pagId;

        $pagina = $this->model->getPagina($pagId);
        if (!$pagina) {
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }

        $secciones = $this->model->listarSeccionesAdmin($pagId);

        // templates/comunicaciones/admin/adminSeccionesView.php
        View::render('admin/adminSecciones', [
            'pagina'    => $pagina,
            'secciones' => $secciones
        ]);
    }

    function admin_seccion_form($pagId = 0, $secId = 0) {
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

        // templates/comunicaciones/admin/adminSeccionFormView.php
        View::render('admin/adminSeccionForm', [
            'pagina' => $pagina,
            'seccion'=> $seccion
        ]);
    }

    function admin_seccion_guardar() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }

        $d = [
            'sec_id'          => (int)($_POST['sec_id'] ?? 0),
            'pag_id'          => (int)($_POST['pag_id'] ?? 0),

            'sec_slug'        => trim($_POST['sec_slug'] ?? ''),
            'sec_tipo'        => $_POST['sec_tipo'] ?? 'CAROUSEL',
            'sec_titulo'      => trim($_POST['sec_titulo'] ?? ''),
            'sec_descripcion' => trim($_POST['sec_descripcion'] ?? ''),

            'sec_layout'      => $_POST['sec_layout'] ?? 'CONTAINER',
            'sec_cols'        => (int)($_POST['sec_cols'] ?? 3),

            'sec_iframe_src'  => trim($_POST['sec_iframe_src'] ?? ''),
            'sec_video_url'   => trim($_POST['sec_video_url'] ?? ''),

            'sec_boton_texto' => trim($_POST['sec_boton_texto'] ?? ''),
            'sec_boton_url'   => trim($_POST['sec_boton_url'] ?? ''),

            'sec_estado'      => $_POST['sec_estado'] ?? 'ACTIVO',
            'sec_orden'       => (int)($_POST['sec_orden'] ?? 0),

            'sec_config_json' => null,
        ];

        $cfgRaw = trim($_POST['sec_config_json_raw'] ?? '');
        if ($cfgRaw !== '') {
            $decoded = json_decode($cfgRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $d['sec_config_json'] = $decoded;
            }
        }

        $this->model->guardarSeccion($d);

        // vuelve a la lista de secciones de la página
        Redirect::to('?uri=comunicaciones/admin_secciones/'.$d['pag_id']);
        exit;
    }

    function admin_items($secId = 0) {
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

        // templates/comunicaciones/admin/adminItemsView.php
        View::render('admin/adminItems', [
            'pagina' => $pagina,
            'seccion'=> $sec,
            'items'  => $items
        ]);
    }

    function admin_item_form($secId = 0, $itmId = 0) {
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

        // templates/comunicaciones/admin/adminItemFormView.php
        View::render('admin/adminItemForm', [
            'pagina' => $pagina,
            'seccion'=> $sec,
            'item'   => $item
        ]);
    }

    private function subirImagen(?array $file): ?string {
        if (!$file || empty($file['name'])) return null;
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) return null;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allow = ['jpg','jpeg','png','webp','gif'];
        if (!in_array($ext, $allow, true)) return null;

        $dir = UPLOADS_ROOT_ASSETS.'comunicaciones'.DS;
        if (!is_dir($dir)) @mkdir($dir, 0755, true);

        $name = 'com_'.date('Ymd_His').'_'.bin2hex(random_bytes(6)).'.'.$ext;
        $dest = $dir.$name;

        if (move_uploaded_file($file['tmp_name'], $dest)) {
            return 'comunicaciones/'.$name;
        }
        return null;
    }

    function admin_item_guardar() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('?uri=comunicaciones/admin_paginas');
            exit;
        }

        $secId = (int)($_POST['sec_id'] ?? 0);
        $itmId = (int)($_POST['itm_id'] ?? 0);

        $img = $this->subirImagen($_FILES['itm_imagen_file'] ?? null);
        $imgExistente = trim($_POST['itm_imagen'] ?? '');

        $d = [
            'itm_id'          => $itmId,
            'sec_id'          => $secId,
            'itm_titulo'      => trim($_POST['itm_titulo'] ?? ''),
            'itm_descripcion' => trim($_POST['itm_descripcion'] ?? ''),
            'itm_imagen'      => $img ?: ($imgExistente ?: null),
            'itm_url'         => trim($_POST['itm_url'] ?? ''),
            'itm_target'      => $_POST['itm_target'] ?? '_blank',
            'itm_badge'       => trim($_POST['itm_badge'] ?? ''),
            'itm_embed'       => trim($_POST['itm_embed'] ?? ''),
            'itm_estado'      => $_POST['itm_estado'] ?? 'ACTIVO',
            'itm_orden'       => (int)($_POST['itm_orden'] ?? 0),
            'itm_extra_json'  => null,
        ];

        $extraRaw = trim($_POST['itm_extra_json_raw'] ?? '');
        if ($extraRaw !== '') {
            $decoded = json_decode($extraRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $d['itm_extra_json'] = $decoded;
            }
        }

        $this->model->guardarItem($d);

        Redirect::to('?uri=comunicaciones/admin_items/'.$secId);
        exit;
    }
}