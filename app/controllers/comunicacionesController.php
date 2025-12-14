<?php
class comunicacionesController extends Controller {

    private comunicacionesModel $model;

    function __construct() {
        $this->model = new comunicacionesModel();
    }

    private function requireLogin(): void {
        if (!isset($_SESSION[APP_SESSION.'usu_id'])) {
            Redirect::to('login');
        }
    }

    private function requireAdminComunicaciones(): void {
        // Ajusta esto a tu lógica real:
        // - si manejas $_SESSION[APP_SESSION.'usu_modulos']['Administrador'] o perfiles.
        $perfil = $_SESSION[APP_SESSION.'usu_perfil'] ?? '';
        if (!in_array($perfil, ['ADMIN','Administrador','SUPERADMIN'])) {
            // si tu app usa un controlador de error:
            Redirect::to('error');
        }
    }

    // =========================
    // Público / interno (usuarios logueados)
    // =========================
    function index() {
        $this->ver('inicio');
    }

    function ver($slug = 'inicio') {
        $this->requireLogin();

        $slug = trim((string)$slug);
        if ($slug === '') $slug = 'inicio';

        $pagina = $this->model->obtenerPaginaPorSlug($slug);
        if (!$pagina) {
            Redirect::to('error');
        }

        $secciones = $this->model->obtenerSeccionesPagina((int)$pagina->pag_id);
        $mapItems = [];
        foreach ($secciones as $sec) {
            $mapItems[$sec->sec_id] = $this->model->obtenerItemsSeccion((int)$sec->sec_id);
        }

        View::render('ver', [
            'pagina' => $pagina,
            'secciones' => $secciones,
            'itemsPorSeccion' => $mapItems,
            'slug' => $slug,
        ]);
    }

    // =========================
    // Admin CMS
    // =========================
    function admin_paginas() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $paginas = $this->model->listarPaginasAdmin();
        View::render('adminPaginas', ['paginas'=>$paginas]);
    }

    function admin_pagina_form($id = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $pagina = null;
        if ((int)$id > 0) $pagina = $this->model->getPagina((int)$id);

        View::render('adminPaginaForm', ['pagina'=>$pagina]);
    }

    function admin_pagina_guardar() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') Redirect::to('comunicaciones/admin_paginas');

        $d = [
            'pag_id' => $_POST['pag_id'] ?? '',
            'pag_slug' => trim($_POST['pag_slug'] ?? ''),
            'pag_titulo' => trim($_POST['pag_titulo'] ?? ''),
            'pag_descripcion' => trim($_POST['pag_descripcion'] ?? ''),
            'pag_estado' => $_POST['pag_estado'] ?? 'ACTIVO',
            'pag_orden' => $_POST['pag_orden'] ?? 0,
        ];

        // Validación mínima
        if ($d['pag_slug'] === '' || $d['pag_titulo'] === '') {
            Redirect::to('comunicaciones/admin_pagina_form/'.($d['pag_id'] ?: 0));
        }

        $id = $this->model->guardarPagina($d);
        Redirect::to('comunicaciones/admin_secciones/'.$id);
    }

    function admin_secciones($pagId = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $pagId = (int)$pagId;
        $pagina = $this->model->getPagina($pagId);
        if (!$pagina) Redirect::to('comunicaciones/admin_paginas');

        $secciones = $this->model->listarSeccionesAdmin($pagId);
        View::render('adminSecciones', [
            'pagina'=>$pagina,
            'secciones'=>$secciones
        ]);
    }

    function admin_seccion_form($pagId = 0, $secId = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $pagina = $this->model->getPagina((int)$pagId);
        if (!$pagina) Redirect::to('comunicaciones/admin_paginas');

        $seccion = null;
        if ((int)$secId > 0) $seccion = $this->model->getSeccion((int)$secId);

        View::render('adminSeccionForm', [
            'pagina'=>$pagina,
            'seccion'=>$seccion
        ]);
    }

    function admin_seccion_guardar() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') Redirect::to('comunicaciones/admin_paginas');

        $d = [
            'sec_id' => $_POST['sec_id'] ?? '',
            'pag_id' => (int)($_POST['pag_id'] ?? 0),
            'sec_tipo' => $_POST['sec_tipo'] ?? 'CAROUSEL',
            'sec_titulo' => trim($_POST['sec_titulo'] ?? ''),
            'sec_descripcion' => trim($_POST['sec_descripcion'] ?? ''),
            'sec_estado' => $_POST['sec_estado'] ?? 'ACTIVO',
            'sec_orden' => $_POST['sec_orden'] ?? 0,
            // JSON simple editable (opcional)
            'sec_config_json' => null,
        ];

        // Si envías un textarea JSON:
        $cfgRaw = trim($_POST['sec_config_json_raw'] ?? '');
        if ($cfgRaw !== '') {
            $decoded = json_decode($cfgRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $d['sec_config_json'] = $decoded;
            }
        }

        $secId = $this->model->guardarSeccion($d);
        Redirect::to('comunicaciones/admin_items/'.$secId);
    }

    function admin_items($secId = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $sec = $this->model->getSeccion((int)$secId);
        if (!$sec) Redirect::to('comunicaciones/admin_paginas');

        $pagina = $this->model->getPagina((int)$sec->pag_id);
        $items = $this->model->listarItemsAdmin((int)$secId);

        View::render('adminItems', [
            'pagina'=>$pagina,
            'seccion'=>$sec,
            'items'=>$items
        ]);
    }

    function admin_item_form($secId = 0, $itmId = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $sec = $this->model->getSeccion((int)$secId);
        if (!$sec) Redirect::to('comunicaciones/admin_paginas');

        $pagina = $this->model->getPagina((int)$sec->pag_id);

        $item = null;
        if ((int)$itmId > 0) $item = $this->model->getItem((int)$itmId);

        View::render('adminItemForm', [
            'pagina'=>$pagina,
            'seccion'=>$sec,
            'item'=>$item
        ]);
    }

    private function subirImagen(?array $file): ?string {
        if (!$file || empty($file['name'])) return null;
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) return null;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allow = ['jpg','jpeg','png','webp','gif'];
        if (!in_array($ext, $allow)) return null;

        $dir = UPLOADS_ROOT_ASSETS.'comunicaciones'.DS;
        if (!is_dir($dir)) @mkdir($dir, 0755, true);

        $name = 'com_'.date('Ymd_His').'_'.bin2hex(random_bytes(6)).'.'.$ext;
        $dest = $dir.$name;

        if (move_uploaded_file($file['tmp_name'], $dest)) {
            // En DB guardamos ruta relativa dentro de assets/uploads
            return 'comunicaciones/'.$name;
        }
        return null;
    }

    function admin_item_guardar() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') Redirect::to('comunicaciones/admin_paginas');

        $secId = (int)($_POST['sec_id'] ?? 0);
        $itmId = $_POST['itm_id'] ?? '';

        $img = $this->subirImagen($_FILES['itm_imagen_file'] ?? null);
        $imgExistente = trim($_POST['itm_imagen'] ?? '');

        $d = [
            'itm_id' => $itmId,
            'sec_id' => $secId,
            'itm_titulo' => trim($_POST['itm_titulo'] ?? ''),
            'itm_descripcion' => trim($_POST['itm_descripcion'] ?? ''),
            'itm_imagen' => $img ?: ($imgExistente ?: null),
            'itm_url' => trim($_POST['itm_url'] ?? ''),
            'itm_embed' => trim($_POST['itm_embed'] ?? ''),
            'itm_estado' => $_POST['itm_estado'] ?? 'ACTIVO',
            'itm_orden' => $_POST['itm_orden'] ?? 0,
            'itm_extra_json' => null,
        ];

        $extraRaw = trim($_POST['itm_extra_json_raw'] ?? '');
        if ($extraRaw !== '') {
            $decoded = json_decode($extraRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $d['itm_extra_json'] = $decoded;
            }
        }

        $this->model->guardarItem($d);
        Redirect::to('comunicaciones/admin_items/'.$secId);
    }
}
