<?php

class comunicacionesController extends Controller {

    private comunicacionesModel $model;

    function __construct() {
        $this->model = new comunicacionesModel();
    }

    private function requireLogin(): void {
        if (!isset($_SESSION[APP_SESSION.'usu_id'])) {
            Redirect::to('?uri=login');
        }
    }

    private function requireAdminComunicaciones(): void {
        $perfil = $_SESSION[APP_SESSION.'usu_perfil'] ?? '';
        if (!in_array($perfil, ['ADMIN','Administrador','SUPERADMIN'], true)) {
            Redirect::to('?uri=error');
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

        // templates/comunicaciones/<slug>View.php
        View::render($slug, [
            'pagina'        => $pagina,
            'secciones'     => $secciones,
            'itemsBySeccion'=> $itemsBySeccion,
            'slug'          => $slug,
        ]);
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

    function admin_pagina_guardar() {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::to('?uri=comunicaciones/admin_paginas');
        }

        $d = [
            'pag_id'             => (int)($_POST['pag_id'] ?? 0),
            'pag_slug'           => trim($_POST['pag_slug'] ?? ''),
            'pag_titulo'         => trim($_POST['pag_titulo'] ?? ''),
            'pag_subtitulo'      => trim($_POST['pag_subtitulo'] ?? ''),
            'pag_hero_bg'        => trim($_POST['pag_hero_bg'] ?? ''),
            'pag_hero_overlay'   => (int)($_POST['pag_hero_overlay'] ?? 1),
            'pag_hero_alineacion'=> $_POST['pag_hero_alineacion'] ?? 'center',
            'pag_descripcion'    => trim($_POST['pag_descripcion'] ?? ''),
            'pag_estado'         => $_POST['pag_estado'] ?? 'ACTIVO',
            'pag_orden'          => (int)($_POST['pag_orden'] ?? 0),
        ];

        if ($d['pag_slug'] === '' || $d['pag_titulo'] === '') {
            Redirect::to('?uri=comunicaciones/admin_pagina_form/'.($d['pag_id'] ?: 0));
        }

        $pagId = $this->model->guardarPagina($d);
        Redirect::to('?uri=comunicaciones/admin_secciones/'.$pagId);
    }

    function admin_secciones($pagId = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $pagId = (int)$pagId;

        $pagina = $this->model->getPagina($pagId);
        if (!$pagina) {
            Redirect::to('?uri=comunicaciones/admin_paginas');
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
    }

    function admin_items($secId = 0) {
        $this->requireLogin();
        $this->requireAdminComunicaciones();

        $secId = (int)$secId;

        $sec = $this->model->getSeccion($secId);
        if (!$sec) {
            Redirect::to('?uri=comunicaciones/admin_paginas');
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
    }
}
