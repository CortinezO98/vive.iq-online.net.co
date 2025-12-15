<?php
class comunicacionesModel extends Model {

    /* ======================================================
     * CONEXIÓN
     * ====================================================== */
    private function db(): Db {
        // Base de datos PRINCIPAL: iCubive / iqvive
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

    /**
     * Ejecuta una query y SIEMPRE devuelve un array.
     * Nunca retorna false (evita errores 500).
     */
    private function queryAll(string $sql, array $params = []): array {
        try {
            $result = $this->db()->query($sql, $params);
            return is_array($result) ? $result : [];
        } catch (\Throwable $e) {
            // En producción puedes loguear:
            // error_log('[comunicacionesModel] '.$e->getMessage());
            return [];
        }
    }

    /**
     * Ejecuta una query y devuelve una sola fila o null.
     */
    private function queryOne(string $sql, array $params = []): ?array {
        $rows = $this->queryAll($sql, $params);
        return $rows[0] ?? null;
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

    /**
     * Obtiene una página por slug.
     * Retorna array o null.
     */
    public function obtenerPaginaPorSlug(string $slug): ?array {
        $sql = "
            SELECT p.*
            FROM com_pagina p
            WHERE p.pag_slug = :slug
              AND p.pag_estado = 'ACTIVO'
              AND {$this->wherePerfilPagina('p')}
            LIMIT 1
        ";

        return $this->queryOne($sql, [
            'slug'   => $slug,
            'perfil' => $this->perfilActual()
        ]);
    }

    /**
     * Lista secciones de una página.
     * SIEMPRE retorna array (puede ser vacío).
     */
    public function obtenerSeccionesPagina(int $pagId): array {
        if ($pagId <= 0) {
            return [];
        }

        $sql = "
            SELECT s.*
            FROM com_seccion s
            WHERE s.pag_id = :pag_id
              AND s.sec_estado = 'ACTIVO'
              AND {$this->wherePerfilSeccion('s')}
            ORDER BY s.sec_orden ASC, s.sec_id ASC
        ";

        return $this->queryAll($sql, [
            'pag_id' => $pagId,
            'perfil' => $this->perfilActual()
        ]);
    }

    /**
     * Lista items de una sección.
     */
    public function obtenerItemsSeccion(int $secId): array {
        if ($secId <= 0) {
            return [];
        }

        $sql = "
            SELECT i.*
            FROM com_item i
            WHERE i.sec_id = :sec_id
              AND i.itm_estado = 'ACTIVO'
              AND {$this->wherePerfilItem('i')}
            ORDER BY i.itm_orden ASC, i.itm_id ASC
        ";

        return $this->queryAll($sql, [
            'sec_id' => $secId,
            'perfil' => $this->perfilActual()
        ]);
    }

    /* ======================================================
     * ADMIN – CRUD
     * ====================================================== */

    public function listarPaginasAdmin(): array {
        return $this->queryAll(
            "SELECT * FROM com_pagina ORDER BY pag_orden ASC, pag_id ASC"
        );
    }

    public function getPagina(int $id): ?array {
        return $this->queryOne(
            "SELECT * FROM com_pagina WHERE pag_id = :id LIMIT 1",
            ['id' => $id]
        );
    }

    public function listarSeccionesAdmin(int $pagId): array {
        return $this->queryAll(
            "SELECT * FROM com_seccion WHERE pag_id = :pag ORDER BY sec_orden ASC, sec_id ASC",
            ['pag' => $pagId]
        );
    }

    public function getSeccion(int $id): ?array {
        return $this->queryOne(
            "SELECT * FROM com_seccion WHERE sec_id = :id LIMIT 1",
            ['id' => $id]
        );
    }

    public function listarItemsAdmin(int $secId): array {
        return $this->queryAll(
            "SELECT * FROM com_item WHERE sec_id = :sec ORDER BY itm_orden ASC, itm_id ASC",
            ['sec' => $secId]
        );
    }

    public function getItem(int $id): ?array {
        return $this->queryOne(
            "SELECT * FROM com_item WHERE itm_id = :id LIMIT 1",
            ['id' => $id]
        );
    }

}
