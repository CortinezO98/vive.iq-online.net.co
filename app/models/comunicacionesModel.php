<?php

class comunicacionesModel extends Model {

    /* ======================================================
     * CONEXIÓN
     * ====================================================== */
    private function db(): Db {
        return new Db(
            DB_ENGINE,
            DB_HOST,
            DB_NAME,
            DB_USER,
            DB_PASS,
            DB_CHARSET
        );
    }

    /* ======================================================
     * HELPERS INTERNOS
     * ====================================================== */

    private function toObjArray(array $rows): array {
        $out = [];
        foreach ($rows as $r) $out[] = (object)$r;
        return $out;
    }

    private function queryAllObj(string $sql, array $params = []): array {
        try {
            $result = $this->db()->query($sql, $params);
            if (!is_array($result)) return [];
            return $this->toObjArray($result);
        } catch (\Throwable $e) {
            return [];
        }
    }

    private function queryOneObj(string $sql, array $params = []): ?object {
        $rows = $this->queryAllObj($sql, $params);
        return $rows[0] ?? null;
    }

    private function exec(string $sql, array $params = []): bool {
        try {
            $ok = $this->db()->query($sql, $params);
            return $ok !== false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function lastId(): int {
        try {
            // Si tu clase Db expone lastInsertId() úsalo.
            if (method_exists($this->db(), 'lastInsertId')) {
                return (int)$this->db()->lastInsertId();
            }
        } catch (\Throwable $e) {}
        return 0;
    }

    private function perfilActual(): string {
        return $_SESSION[APP_SESSION.'usu_perfil'] ?? 'PUBLICO';
    }

    /* ======================================================
     * FILTROS DE PERFIL (VISIBILIDAD)
     * ====================================================== */
    private function wherePerfilPagina(string $alias = 'p'): string {
        return "
            (
                NOT EXISTS (
                    SELECT 1 FROM com_pagina_perfil x
                    WHERE x.pag_id = {$alias}.pag_id
                )
                OR EXISTS (
                    SELECT 1 FROM com_pagina_perfil y
                    WHERE y.pag_id = {$alias}.pag_id
                      AND y.ppf_perfil = :perfil
                )
            )
        ";
    }

    private function wherePerfilSeccion(string $alias = 's'): string {
        return "
            (
                NOT EXISTS (
                    SELECT 1 FROM com_seccion_perfil x
                    WHERE x.sec_id = {$alias}.sec_id
                )
                OR EXISTS (
                    SELECT 1 FROM com_seccion_perfil y
                    WHERE y.sec_id = {$alias}.sec_id
                      AND y.spf_perfil = :perfil
                )
            )
        ";
    }

    private function wherePerfilItem(string $alias = 'i'): string {
        return "
            (
                NOT EXISTS (
                    SELECT 1 FROM com_item_perfil x
                    WHERE x.itm_id = {$alias}.itm_id
                )
                OR EXISTS (
                    SELECT 1 FROM com_item_perfil y
                    WHERE y.itm_id = {$alias}.itm_id
                      AND y.ipf_perfil = :perfil
                )
            )
        ";
    }

    /* ======================================================
     * LECTURA PÚBLICA (RENDER)
     * ====================================================== */

    public function obtenerPaginaPorSlug(string $slug): ?object {
        $sql = "
            SELECT p.*
            FROM com_pagina p
            WHERE p.pag_slug = :slug
              AND p.pag_estado = 'ACTIVO'
              AND {$this->wherePerfilPagina('p')}
            LIMIT 1
        ";
        return $this->queryOneObj($sql, [
            'slug'   => $slug,
            'perfil' => $this->perfilActual()
        ]);
    }

    public function obtenerSeccionesPagina(int $pagId): array {
        if ($pagId <= 0) return [];

        $sql = "
            SELECT s.*
            FROM com_seccion s
            WHERE s.pag_id = :pag_id
              AND s.sec_estado = 'ACTIVO'
              AND {$this->wherePerfilSeccion('s')}
            ORDER BY s.sec_orden ASC, s.sec_id ASC
        ";
        return $this->queryAllObj($sql, [
            'pag_id' => $pagId,
            'perfil' => $this->perfilActual()
        ]);
    }

    public function obtenerItemsSeccion(int $secId): array {
        if ($secId <= 0) return [];

        $sql = "
            SELECT i.*
            FROM com_item i
            WHERE i.sec_id = :sec_id
              AND i.itm_estado = 'ACTIVO'
              AND {$this->wherePerfilItem('i')}
            ORDER BY i.itm_orden ASC, i.itm_id ASC
        ";
        return $this->queryAllObj($sql, [
            'sec_id' => $secId,
            'perfil' => $this->perfilActual()
        ]);
    }

    /* ======================================================
     * ADMIN – CRUD
     * ====================================================== */

    public function listarPaginasAdmin(): array {
        return $this->queryAllObj("SELECT * FROM com_pagina ORDER BY pag_orden ASC, pag_id ASC");
    }

    public function getPagina(int $id): ?object {
        return $this->queryOneObj("SELECT * FROM com_pagina WHERE pag_id = :id LIMIT 1", ['id' => $id]);
    }

    public function guardarPagina(array $d): int {
        $id = (int)($d['pag_id'] ?? 0);

        if ($id > 0) {
            $sql = "
                UPDATE com_pagina SET
                    pag_slug = :pag_slug,
                    pag_titulo = :pag_titulo,
                    pag_subtitulo = :pag_subtitulo,
                    pag_hero_bg = :pag_hero_bg,
                    pag_hero_overlay = :pag_hero_overlay,
                    pag_hero_alineacion = :pag_hero_alineacion,
                    pag_descripcion = :pag_descripcion,
                    pag_estado = :pag_estado,
                    pag_orden = :pag_orden
                WHERE pag_id = :pag_id
            ";
            $this->exec($sql, [
                'pag_id' => $id,
                'pag_slug' => $d['pag_slug'],
                'pag_titulo' => $d['pag_titulo'],
                'pag_subtitulo' => $d['pag_subtitulo'],
                'pag_hero_bg' => $d['pag_hero_bg'],
                'pag_hero_overlay' => (int)$d['pag_hero_overlay'],
                'pag_hero_alineacion' => $d['pag_hero_alineacion'],
                'pag_descripcion' => $d['pag_descripcion'],
                'pag_estado' => $d['pag_estado'],
                'pag_orden' => (int)$d['pag_orden'],
            ]);
            return $id;
        }

        $sql = "
            INSERT INTO com_pagina
                (pag_slug, pag_titulo, pag_subtitulo, pag_hero_bg, pag_hero_overlay, pag_hero_alineacion, pag_descripcion, pag_estado, pag_orden)
            VALUES
                (:pag_slug, :pag_titulo, :pag_subtitulo, :pag_hero_bg, :pag_hero_overlay, :pag_hero_alineacion, :pag_descripcion, :pag_estado, :pag_orden)
        ";
        $this->exec($sql, [
            'pag_slug' => $d['pag_slug'],
            'pag_titulo' => $d['pag_titulo'],
            'pag_subtitulo' => $d['pag_subtitulo'],
            'pag_hero_bg' => $d['pag_hero_bg'],
            'pag_hero_overlay' => (int)$d['pag_hero_overlay'],
            'pag_hero_alineacion' => $d['pag_hero_alineacion'],
            'pag_descripcion' => $d['pag_descripcion'],
            'pag_estado' => $d['pag_estado'],
            'pag_orden' => (int)$d['pag_orden'],
        ]);

        $newId = $this->lastId();
        return $newId > 0 ? $newId : (int)($this->queryOneObj("SELECT MAX(pag_id) AS id FROM com_pagina")?->id ?? 0);
    }

    public function listarSeccionesAdmin(int $pagId): array {
        return $this->queryAllObj(
            "SELECT * FROM com_seccion WHERE pag_id = :pag ORDER BY sec_orden ASC, sec_id ASC",
            ['pag' => $pagId]
        );
    }

    public function getSeccion(int $id): ?object {
        return $this->queryOneObj("SELECT * FROM com_seccion WHERE sec_id = :id LIMIT 1", ['id' => $id]);
    }

    public function guardarSeccion(array $d): int {
        $id = (int)($d['sec_id'] ?? 0);

        $cfg = $d['sec_config_json'] ?? null;
        if (is_array($cfg)) $cfg = json_encode($cfg, JSON_UNESCAPED_UNICODE);

        if ($id > 0) {
            $sql = "
                UPDATE com_seccion SET
                    pag_id = :pag_id,
                    sec_slug = :sec_slug,
                    sec_tipo = :sec_tipo,
                    sec_titulo = :sec_titulo,
                    sec_descripcion = :sec_descripcion,
                    sec_layout = :sec_layout,
                    sec_cols = :sec_cols,
                    sec_iframe_src = :sec_iframe_src,
                    sec_video_url = :sec_video_url,
                    sec_boton_texto = :sec_boton_texto,
                    sec_boton_url = :sec_boton_url,
                    sec_estado = :sec_estado,
                    sec_orden = :sec_orden,
                    sec_config_json = :sec_config_json
                WHERE sec_id = :sec_id
            ";
            $this->exec($sql, [
                'sec_id' => $id,
                'pag_id' => (int)$d['pag_id'],
                'sec_slug' => $d['sec_slug'],
                'sec_tipo' => $d['sec_tipo'],
                'sec_titulo' => $d['sec_titulo'],
                'sec_descripcion' => $d['sec_descripcion'],
                'sec_layout' => $d['sec_layout'],
                'sec_cols' => (int)$d['sec_cols'],
                'sec_iframe_src' => $d['sec_iframe_src'],
                'sec_video_url' => $d['sec_video_url'],
                'sec_boton_texto' => $d['sec_boton_texto'],
                'sec_boton_url' => $d['sec_boton_url'],
                'sec_estado' => $d['sec_estado'],
                'sec_orden' => (int)$d['sec_orden'],
                'sec_config_json' => $cfg,
            ]);
            return $id;
        }

        $sql = "
            INSERT INTO com_seccion
                (pag_id, sec_slug, sec_tipo, sec_titulo, sec_descripcion, sec_layout, sec_cols,
                 sec_iframe_src, sec_video_url, sec_boton_texto, sec_boton_url, sec_estado, sec_orden, sec_config_json)
            VALUES
                (:pag_id, :sec_slug, :sec_tipo, :sec_titulo, :sec_descripcion, :sec_layout, :sec_cols,
                 :sec_iframe_src, :sec_video_url, :sec_boton_texto, :sec_boton_url, :sec_estado, :sec_orden, :sec_config_json)
        ";
        $this->exec($sql, [
            'pag_id' => (int)$d['pag_id'],
            'sec_slug' => $d['sec_slug'],
            'sec_tipo' => $d['sec_tipo'],
            'sec_titulo' => $d['sec_titulo'],
            'sec_descripcion' => $d['sec_descripcion'],
            'sec_layout' => $d['sec_layout'],
            'sec_cols' => (int)$d['sec_cols'],
            'sec_iframe_src' => $d['sec_iframe_src'],
            'sec_video_url' => $d['sec_video_url'],
            'sec_boton_texto' => $d['sec_boton_texto'],
            'sec_boton_url' => $d['sec_boton_url'],
            'sec_estado' => $d['sec_estado'],
            'sec_orden' => (int)$d['sec_orden'],
            'sec_config_json' => $cfg,
        ]);

        $newId = $this->lastId();
        return $newId > 0 ? $newId : (int)($this->queryOneObj("SELECT MAX(sec_id) AS id FROM com_seccion")?->id ?? 0);
    }

    public function listarItemsAdmin(int $secId): array {
        return $this->queryAllObj(
            "SELECT * FROM com_item WHERE sec_id = :sec ORDER BY itm_orden ASC, itm_id ASC",
            ['sec' => $secId]
        );
    }

    public function getItem(int $id): ?object {
        return $this->queryOneObj("SELECT * FROM com_item WHERE itm_id = :id LIMIT 1", ['id' => $id]);
    }

    public function guardarItem(array $d): int {
        $id = (int)($d['itm_id'] ?? 0);

        $extra = $d['itm_extra_json'] ?? null;
        if (is_array($extra)) $extra = json_encode($extra, JSON_UNESCAPED_UNICODE);

        if ($id > 0) {
            $sql = "
                UPDATE com_item SET
                    sec_id = :sec_id,
                    itm_titulo = :itm_titulo,
                    itm_descripcion = :itm_descripcion,
                    itm_imagen = :itm_imagen,
                    itm_url = :itm_url,
                    itm_target = :itm_target,
                    itm_badge = :itm_badge,
                    itm_embed = :itm_embed,
                    itm_estado = :itm_estado,
                    itm_orden = :itm_orden,
                    itm_extra_json = :itm_extra_json
                WHERE itm_id = :itm_id
            ";
            $this->exec($sql, [
                'itm_id' => $id,
                'sec_id' => (int)$d['sec_id'],
                'itm_titulo' => $d['itm_titulo'],
                'itm_descripcion' => $d['itm_descripcion'],
                'itm_imagen' => $d['itm_imagen'],
                'itm_url' => $d['itm_url'],
                'itm_target' => $d['itm_target'],
                'itm_badge' => $d['itm_badge'],
                'itm_embed' => $d['itm_embed'],
                'itm_estado' => $d['itm_estado'],
                'itm_orden' => (int)$d['itm_orden'],
                'itm_extra_json' => $extra,
            ]);
            return $id;
        }

        $sql = "
            INSERT INTO com_item
                (sec_id, itm_titulo, itm_descripcion, itm_imagen, itm_url, itm_target, itm_badge, itm_embed, itm_estado, itm_orden, itm_extra_json)
            VALUES
                (:sec_id, :itm_titulo, :itm_descripcion, :itm_imagen, :itm_url, :itm_target, :itm_badge, :itm_embed, :itm_estado, :itm_orden, :itm_extra_json)
        ";
        $this->exec($sql, [
            'sec_id' => (int)$d['sec_id'],
            'itm_titulo' => $d['itm_titulo'],
            'itm_descripcion' => $d['itm_descripcion'],
            'itm_imagen' => $d['itm_imagen'],
            'itm_url' => $d['itm_url'],
            'itm_target' => $d['itm_target'],
            'itm_badge' => $d['itm_badge'],
            'itm_embed' => $d['itm_embed'],
            'itm_estado' => $d['itm_estado'],
            'itm_orden' => (int)$d['itm_orden'],
            'itm_extra_json' => $extra,
        ]);

        $newId = $this->lastId();
        return $newId > 0 ? $newId : (int)($this->queryOneObj("SELECT MAX(itm_id) AS id FROM com_item")?->id ?? 0);
    }
}
