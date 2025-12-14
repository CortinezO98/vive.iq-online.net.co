<?php
class comunicacionesModel extends Model {

    private function dbAux(): Db {
        return new Db(DB_ENGINE, DB_HOST, DB_NAME_AUX, DB_USER, DB_PASS, DB_CHARSET);
    }

    private function dbMain(): Db {
        return new Db(DB_ENGINE, DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHARSET);
    }

    // =========================
    // Helpers de visibilidad
    // =========================
    private function perfilActual(): string {
        return $_SESSION[APP_SESSION.'usu_perfil'] ?? 'PUBLICO';
    }

    private function wherePerfilPagina(string $aliasPag = 'p'): string {
        // Si NO hay filas en com_pagina_perfil => visible para todos
        // Si hay filas => visible solo si perfil coincide
        $perfil = $this->perfilActual();
        return "
          (
            NOT EXISTS (SELECT 1 FROM com_pagina_perfil x WHERE x.pag_id = {$aliasPag}.pag_id)
            OR EXISTS (SELECT 1 FROM com_pagina_perfil y WHERE y.pag_id = {$aliasPag}.pag_id AND y.ppf_perfil = :perfil)
          )
        ";
    }

    private function wherePerfilSeccion(string $aliasSec = 's'): string {
        $perfil = $this->perfilActual();
        return "
          (
            NOT EXISTS (SELECT 1 FROM com_seccion_perfil x WHERE x.sec_id = {$aliasSec}.sec_id)
            OR EXISTS (SELECT 1 FROM com_seccion_perfil y WHERE y.sec_id = {$aliasSec}.sec_id AND y.spf_perfil = :perfil)
          )
        ";
    }

    private function wherePerfilItem(string $aliasItm = 'i'): string {
        $perfil = $this->perfilActual();
        return "
          (
            NOT EXISTS (SELECT 1 FROM com_item_perfil x WHERE x.itm_id = {$aliasItm}.itm_id)
            OR EXISTS (SELECT 1 FROM com_item_perfil y WHERE y.itm_id = {$aliasItm}.itm_id AND y.ipf_perfil = :perfil)
          )
        ";
    }

    // =========================
    // Lectura pública (render)
    // =========================
    public function obtenerPaginaPorSlug(string $slug) {
        $db = $this->dbAux();
        $sql = "SELECT p.*
                FROM com_pagina p
                WHERE p.pag_slug = :slug
                  AND p.pag_estado = 'ACTIVO'
                  AND {$this->wherePerfilPagina('p')}
                LIMIT 1";
        return $db->query($sql, ['slug'=>$slug, 'perfil'=>$this->perfilActual()])->fetch();
    }

    public function obtenerSeccionesPagina(int $pagId): array {
        $db = $this->dbAux();
        $sql = "SELECT s.*
                FROM com_seccion s
                WHERE s.pag_id = :pag_id
                  AND s.sec_estado = 'ACTIVO'
                  AND {$this->wherePerfilSeccion('s')}
                ORDER BY s.sec_orden ASC, s.sec_id ASC";
        return $db->query($sql, ['pag_id'=>$pagId, 'perfil'=>$this->perfilActual()])->fetchAll();
    }

    public function obtenerItemsSeccion(int $secId): array {
        $db = $this->dbAux();
        $sql = "SELECT i.*
                FROM com_item i
                WHERE i.sec_id = :sec_id
                  AND i.itm_estado = 'ACTIVO'
                  AND {$this->wherePerfilItem('i')}
                ORDER BY i.itm_orden ASC, i.itm_id ASC";
        return $db->query($sql, ['sec_id'=>$secId, 'perfil'=>$this->perfilActual()])->fetchAll();
    }

    // =========================
    // Admin (CRUD básico)
    // =========================
    public function listarPaginasAdmin(): array {
        $db = $this->dbAux();
        return $db->query("SELECT * FROM com_pagina ORDER BY pag_orden ASC, pag_id ASC")->fetchAll();
    }

    public function getPagina(int $id) {
        $db = $this->dbAux();
        return $db->query("SELECT * FROM com_pagina WHERE pag_id = :id LIMIT 1", ['id'=>$id])->fetch();
    }

    public function guardarPagina(array $d): int {
        $db = $this->dbAux();

        if (!empty($d['pag_id'])) {
            $db->query("UPDATE com_pagina SET
                        pag_slug=:slug, pag_titulo=:titulo, pag_descripcion=:descripcion,
                        pag_estado=:estado, pag_orden=:orden
                        WHERE pag_id=:id", [
                'slug'=>$d['pag_slug'],
                'titulo'=>$d['pag_titulo'],
                'descripcion'=>$d['pag_descripcion'],
                'estado'=>$d['pag_estado'],
                'orden'=>(int)$d['pag_orden'],
                'id'=>(int)$d['pag_id'],
            ]);
            return (int)$d['pag_id'];
        }

        $db->query("INSERT INTO com_pagina
                   (pag_slug, pag_titulo, pag_descripcion, pag_estado, pag_orden)
                   VALUES (:slug,:titulo,:descripcion,:estado,:orden)", [
            'slug'=>$d['pag_slug'],
            'titulo'=>$d['pag_titulo'],
            'descripcion'=>$d['pag_descripcion'],
            'estado'=>$d['pag_estado'],
            'orden'=>(int)$d['pag_orden'],
        ]);
        return (int)$db->lastInsertId();
    }

    public function listarSeccionesAdmin(int $pagId): array {
        $db = $this->dbAux();
        return $db->query("SELECT * FROM com_seccion WHERE pag_id=:pag_id ORDER BY sec_orden ASC, sec_id ASC", ['pag_id'=>$pagId])->fetchAll();
    }

    public function getSeccion(int $id) {
        $db = $this->dbAux();
        return $db->query("SELECT * FROM com_seccion WHERE sec_id=:id LIMIT 1", ['id'=>$id])->fetch();
    }

    public function guardarSeccion(array $d): int {
        $db = $this->dbAux();

        $config = $d['sec_config_json'] ?? null;
        if (is_array($config)) $config = json_encode($config, JSON_UNESCAPED_UNICODE);

        if (!empty($d['sec_id'])) {
            $db->query("UPDATE com_seccion SET
                        sec_tipo=:tipo, sec_titulo=:titulo, sec_descripcion=:descripcion,
                        sec_config_json=:cfg, sec_estado=:estado, sec_orden=:orden
                        WHERE sec_id=:id", [
                'tipo'=>$d['sec_tipo'],
                'titulo'=>$d['sec_titulo'],
                'descripcion'=>$d['sec_descripcion'],
                'cfg'=>$config,
                'estado'=>$d['sec_estado'],
                'orden'=>(int)$d['sec_orden'],
                'id'=>(int)$d['sec_id'],
            ]);
            return (int)$d['sec_id'];
        }

        $db->query("INSERT INTO com_seccion
                   (pag_id, sec_tipo, sec_titulo, sec_descripcion, sec_config_json, sec_estado, sec_orden)
                   VALUES (:pag,:tipo,:titulo,:descripcion,:cfg,:estado,:orden)", [
            'pag'=>(int)$d['pag_id'],
            'tipo'=>$d['sec_tipo'],
            'titulo'=>$d['sec_titulo'],
            'descripcion'=>$d['sec_descripcion'],
            'cfg'=>$config,
            'estado'=>$d['sec_estado'],
            'orden'=>(int)$d['sec_orden'],
        ]);
        return (int)$db->lastInsertId();
    }

    public function listarItemsAdmin(int $secId): array {
        $db = $this->dbAux();
        return $db->query("SELECT * FROM com_item WHERE sec_id=:sec ORDER BY itm_orden ASC, itm_id ASC", ['sec'=>$secId])->fetchAll();
    }

    public function getItem(int $id) {
        $db = $this->dbAux();
        return $db->query("SELECT * FROM com_item WHERE itm_id=:id LIMIT 1", ['id'=>$id])->fetch();
    }

    public function guardarItem(array $d): int {
        $db = $this->dbAux();

        $extra = $d['itm_extra_json'] ?? null;
        if (is_array($extra)) $extra = json_encode($extra, JSON_UNESCAPED_UNICODE);

        if (!empty($d['itm_id'])) {
            $db->query("UPDATE com_item SET
                        itm_titulo=:titulo, itm_descripcion=:descripcion, itm_imagen=:imagen,
                        itm_url=:url, itm_embed=:embed, itm_extra_json=:extra,
                        itm_estado=:estado, itm_orden=:orden
                        WHERE itm_id=:id", [
                'titulo'=>$d['itm_titulo'],
                'descripcion'=>$d['itm_descripcion'],
                'imagen'=>$d['itm_imagen'],
                'url'=>$d['itm_url'],
                'embed'=>$d['itm_embed'],
                'extra'=>$extra,
                'estado'=>$d['itm_estado'],
                'orden'=>(int)$d['itm_orden'],
                'id'=>(int)$d['itm_id'],
            ]);
            return (int)$d['itm_id'];
        }

        $db->query("INSERT INTO com_item
                   (sec_id, itm_titulo, itm_descripcion, itm_imagen, itm_url, itm_embed, itm_extra_json, itm_estado, itm_orden)
                   VALUES (:sec,:titulo,:descripcion,:imagen,:url,:embed,:extra,:estado,:orden)", [
            'sec'=>(int)$d['sec_id'],
            'titulo'=>$d['itm_titulo'],
            'descripcion'=>$d['itm_descripcion'],
            'imagen'=>$d['itm_imagen'],
            'url'=>$d['itm_url'],
            'embed'=>$d['itm_embed'],
            'extra'=>$extra,
            'estado'=>$d['itm_estado'],
            'orden'=>(int)$d['itm_orden'],
        ]);
        return (int)$db->lastInsertId();
    }
}
