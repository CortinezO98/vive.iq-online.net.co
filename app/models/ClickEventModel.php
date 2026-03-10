<?php
class ClickEventModel extends Model
{
    public $click_tipo;
    public $click_clave;
    public $click_label;
    public $click_modulo;
    public $click_url_destino;
    public $click_url_origen;
    public $entidad_id;
    public $entidad_tipo;
    public $user_id;
    public $click_ip;
    public $click_user_agent;
    public $click_session_id;

    public $click_dom_path;
    public $click_texto_visible;
    public $click_x;
    public $click_y;
    public $viewport_w;
    public $viewport_h;
    public $page_url;
    public $page_slug;
    public $seccion_nombre;
    public $click_contexto;
    public $click_posicion;

    /**
     * Registrar un click genérico
     */
    public function registrarClick()
    {
        $sql = "INSERT INTO app_click_event
                (
                    click_tipo,
                    click_clave,
                    click_label,
                    click_modulo,
                    click_url_destino,
                    click_url_origen,
                    entidad_id,
                    entidad_tipo,
                    user_id,
                    click_ip,
                    click_user_agent,
                    click_session_id,
                    click_dom_path,
                    click_texto_visible,
                    click_x,
                    click_y,
                    viewport_w,
                    viewport_h,
                    page_url,
                    page_slug,
                    seccion_nombre,
                    click_contexto,
                    click_posicion,
                    click_fecha
                )
                VALUES
                (
                    :click_tipo,
                    :click_clave,
                    :click_label,
                    :click_modulo,
                    :click_url_destino,
                    :click_url_origen,
                    :entidad_id,
                    :entidad_tipo,
                    :user_id,
                    :click_ip,
                    :click_user_agent,
                    :click_session_id,
                    :click_dom_path,
                    :click_texto_visible,
                    :click_x,
                    :click_y,
                    :viewport_w,
                    :viewport_h,
                    :page_url,
                    :page_slug,
                    :seccion_nombre,
                    :click_contexto,
                    :click_posicion,
                    NOW()
                )";

        $params = [
            'click_tipo'          => $this->normalizarTexto($this->click_tipo, 50),
            'click_clave'         => $this->normalizarTexto($this->click_clave, 150),
            'click_label'         => $this->normalizarTexto($this->click_label, 255),
            'click_modulo'        => $this->normalizarNullableTexto($this->click_modulo, 100),
            'click_url_destino'   => $this->normalizarNullableTextoLargo($this->click_url_destino),
            'click_url_origen'    => $this->normalizarNullableTextoLargo($this->click_url_origen),
            'entidad_id'          => $this->normalizarNullableEntero($this->entidad_id),
            'entidad_tipo'        => $this->normalizarNullableTexto($this->entidad_tipo, 50),
            'user_id'             => $this->normalizarNullableEntero($this->user_id),
            'click_ip'            => $this->normalizarNullableTexto($this->click_ip, 45),
            'click_user_agent'    => $this->normalizarNullableTextoLargo($this->click_user_agent),
            'click_session_id'    => $this->normalizarNullableTexto($this->click_session_id, 255),

            'click_dom_path'      => $this->normalizarNullableTexto($this->click_dom_path, 1000),
            'click_texto_visible' => $this->normalizarNullableTexto($this->click_texto_visible, 500),
            'click_x'             => $this->normalizarNullableEntero($this->click_x),
            'click_y'             => $this->normalizarNullableEntero($this->click_y),
            'viewport_w'          => $this->normalizarNullableEntero($this->viewport_w),
            'viewport_h'          => $this->normalizarNullableEntero($this->viewport_h),
            'page_url'            => $this->normalizarNullableTexto($this->page_url, 1000),
            'page_slug'           => $this->normalizarNullableTexto($this->page_slug, 255),
            'seccion_nombre'      => $this->normalizarNullableTexto($this->seccion_nombre, 255),
            'click_contexto'      => $this->normalizarNullableTexto($this->click_contexto, 255),
            'click_posicion'      => $this->normalizarNullableEntero($this->click_posicion),
        ];

        try {
            $res = parent::query($sql, $params);
            return $res !== false;
        } catch (Exception $e) {
            error_log('Error al registrar click general: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Dedupe en 1 segundo
     */
    public function existeClickReciente($click_clave, $click_tipo, $session_id, $segundos = 1)
    {
        $click_clave = trim((string)$click_clave);
        $click_tipo = trim((string)$click_tipo);
        $session_id = trim((string)$session_id);
        $segundos = (int)$segundos;

        if ($click_clave === '' || $click_tipo === '' || $session_id === '') {
            return false;
        }

        if ($segundos < 1) {
            $segundos = 1;
        }

        $sql = "SELECT click_id
                FROM app_click_event
                WHERE click_clave = :click_clave
                  AND click_tipo = :click_tipo
                  AND click_session_id = :click_session_id
                  AND click_fecha >= DATE_SUB(NOW(), INTERVAL {$segundos} SECOND)
                ORDER BY click_id DESC
                LIMIT 1";

        $params = [
            'click_clave'      => $click_clave,
            'click_tipo'       => $click_tipo,
            'click_session_id' => $session_id
        ];

        try {
            $res = parent::query($sql, $params);
            return !empty($res);
        } catch (Exception $e) {
            error_log('Error al validar click reciente: ' . $e->getMessage());
            return false;
        }
    }

    private function aplicarFiltros(&$sql, &$params, $alias, $fecha_inicio = null, $fecha_fin = null, $click_tipo = null, $click_modulo = null)
    {
        $prefijo = $alias !== '' ? $alias . '.' : '';

        if (!empty($fecha_inicio)) {
            $sql .= " AND DATE({$prefijo}click_fecha) >= :fecha_inicio";
            $params['fecha_inicio'] = $fecha_inicio;
        }

        if (!empty($fecha_fin)) {
            $sql .= " AND DATE({$prefijo}click_fecha) <= :fecha_fin";
            $params['fecha_fin'] = $fecha_fin;
        }

        if (!empty($click_tipo)) {
            $sql .= " AND {$prefijo}click_tipo = :click_tipo";
            $params['click_tipo'] = $click_tipo;
        }

        if (!empty($click_modulo)) {
            $sql .= " AND {$prefijo}click_modulo = :click_modulo";
            $params['click_modulo'] = $click_modulo;
        }
    }

    public function obtenerReporte($fecha_inicio = null, $fecha_fin = null, $click_tipo = null, $click_modulo = null)
    {
        $sql = "SELECT
                    c.*,
                    u.usu_nombres_apellidos AS usuario_nombre
                FROM app_click_event c
                LEFT JOIN app_usuario u ON c.user_id = u.usu_id
                WHERE 1=1";

        $params = [];
        $this->aplicarFiltros($sql, $params, 'c', $fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);

        $sql .= " ORDER BY c.click_fecha DESC, c.click_id DESC";

        try {
            $res = parent::query($sql, $params);
            return is_array($res) ? $res : [];
        } catch (Exception $e) {
            error_log('Error al obtener reporte general de clics: ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerResumenGeneral($fecha_inicio = null, $fecha_fin = null, $click_tipo = null, $click_modulo = null)
    {
        $sql = "SELECT
                    COUNT(*) AS total_clics,
                    COUNT(DISTINCT click_clave) AS elementos_unicos,
                    COUNT(DISTINCT user_id) AS usuarios_unicos,
                    COUNT(DISTINCT click_session_id) AS sesiones_unicas
                FROM app_click_event
                WHERE 1=1";

        $params = [];
        $this->aplicarFiltros($sql, $params, '', $fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);

        try {
            $res = parent::query($sql, $params);
            return isset($res[0]) ? $res[0] : [
                'total_clics' => 0,
                'elementos_unicos' => 0,
                'usuarios_unicos' => 0,
                'sesiones_unicas' => 0
            ];
        } catch (Exception $e) {
            error_log('Error al obtener resumen general: ' . $e->getMessage());
            return [
                'total_clics' => 0,
                'elementos_unicos' => 0,
                'usuarios_unicos' => 0,
                'sesiones_unicas' => 0
            ];
        }
    }

    public function obtenerTopElementos($fecha_inicio = null, $fecha_fin = null, $click_tipo = null, $click_modulo = null, $limite = 10)
    {
        $limite = (int)$limite;
        if ($limite < 1) {
            $limite = 10;
        }

        $sql = "SELECT
                    click_clave,
                    click_label,
                    click_tipo,
                    click_modulo,
                    COUNT(*) AS total_clics
                FROM app_click_event
                WHERE 1=1";

        $params = [];
        $this->aplicarFiltros($sql, $params, '', $fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);

        $sql .= " GROUP BY click_clave, click_label, click_tipo, click_modulo
                  ORDER BY total_clics DESC, click_label ASC
                  LIMIT {$limite}";

        try {
            $res = parent::query($sql, $params);
            return is_array($res) ? $res : [];
        } catch (Exception $e) {
            error_log('Error al obtener top elementos: ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorTipo($fecha_inicio = null, $fecha_fin = null, $click_modulo = null)
    {
        $sql = "SELECT
                    click_tipo,
                    COUNT(*) AS total_clics
                FROM app_click_event
                WHERE 1=1";

        $params = [];

        if (!empty($fecha_inicio)) {
            $sql .= " AND DATE(click_fecha) >= :fecha_inicio";
            $params['fecha_inicio'] = $fecha_inicio;
        }

        if (!empty($fecha_fin)) {
            $sql .= " AND DATE(click_fecha) <= :fecha_fin";
            $params['fecha_fin'] = $fecha_fin;
        }

        if (!empty($click_modulo)) {
            $sql .= " AND click_modulo = :click_modulo";
            $params['click_modulo'] = $click_modulo;
        }

        $sql .= " GROUP BY click_tipo
                  ORDER BY total_clics DESC, click_tipo ASC";

        try {
            $res = parent::query($sql, $params);
            return is_array($res) ? $res : [];
        } catch (Exception $e) {
            error_log('Error al obtener estadísticas por tipo: ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorModulo($fecha_inicio = null, $fecha_fin = null, $click_tipo = null)
    {
        $sql = "SELECT
                    COALESCE(NULLIF(click_modulo, ''), 'Sin módulo') AS click_modulo,
                    COUNT(*) AS total_clics
                FROM app_click_event
                WHERE 1=1";

        $params = [];

        if (!empty($fecha_inicio)) {
            $sql .= " AND DATE(click_fecha) >= :fecha_inicio";
            $params['fecha_inicio'] = $fecha_inicio;
        }

        if (!empty($fecha_fin)) {
            $sql .= " AND DATE(click_fecha) <= :fecha_fin";
            $params['fecha_fin'] = $fecha_fin;
        }

        if (!empty($click_tipo)) {
            $sql .= " AND click_tipo = :click_tipo";
            $params['click_tipo'] = $click_tipo;
        }

        $sql .= " GROUP BY COALESCE(NULLIF(click_modulo, ''), 'Sin módulo')
                  ORDER BY total_clics DESC, click_modulo ASC";

        try {
            $res = parent::query($sql, $params);
            return is_array($res) ? $res : [];
        } catch (Exception $e) {
            error_log('Error al obtener estadísticas por módulo: ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerSerieDiaria($fecha_inicio = null, $fecha_fin = null, $click_tipo = null, $click_modulo = null)
    {
        $sql = "SELECT
                    DATE(click_fecha) AS fecha,
                    COUNT(*) AS total_clics
                FROM app_click_event
                WHERE 1=1";

        $params = [];
        $this->aplicarFiltros($sql, $params, '', $fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);

        $sql .= " GROUP BY DATE(click_fecha)
                  ORDER BY DATE(click_fecha) ASC";

        try {
            $res = parent::query($sql, $params);
            return is_array($res) ? $res : [];
        } catch (Exception $e) {
            error_log('Error al obtener serie diaria: ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerTopUsuarios($fecha_inicio = null, $fecha_fin = null, $click_tipo = null, $click_modulo = null, $limite = 10)
    {
        $limite = (int)$limite;
        if ($limite < 1) {
            $limite = 10;
        }

        $sql = "SELECT
                    c.user_id,
                    COALESCE(NULLIF(u.usu_nombres_apellidos, ''), 'Anónimo') AS usuario_nombre,
                    COUNT(*) AS total_clics
                FROM app_click_event c
                LEFT JOIN app_usuario u ON c.user_id = u.usu_id
                WHERE 1=1";

        $params = [];
        $this->aplicarFiltros($sql, $params, 'c', $fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);

        $sql .= " GROUP BY c.user_id, u.usu_nombres_apellidos
                  ORDER BY total_clics DESC, usuario_nombre ASC
                  LIMIT {$limite}";

        try {
            $res = parent::query($sql, $params);
            return is_array($res) ? $res : [];
        } catch (Exception $e) {
            error_log('Error al obtener top usuarios: ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorPagina($fecha_inicio = null, $fecha_fin = null, $click_tipo = null, $click_modulo = null)
    {
        $sql = "SELECT
                    COALESCE(NULLIF(page_slug, ''), 'Sin página') AS page_slug,
                    COUNT(*) AS total_clics
                FROM app_click_event
                WHERE 1=1";

        $params = [];
        $this->aplicarFiltros($sql, $params, '', $fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);

        $sql .= " GROUP BY COALESCE(NULLIF(page_slug, ''), 'Sin página')
                  ORDER BY total_clics DESC, page_slug ASC";

        try {
            $res = parent::query($sql, $params);
            return is_array($res) ? $res : [];
        } catch (Exception $e) {
            error_log('Error al obtener clics por página: ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorSeccion($fecha_inicio = null, $fecha_fin = null, $click_tipo = null, $click_modulo = null)
    {
        $sql = "SELECT
                    COALESCE(NULLIF(seccion_nombre, ''), 'Sin sección') AS seccion_nombre,
                    COUNT(*) AS total_clics
                FROM app_click_event
                WHERE 1=1";

        $params = [];
        $this->aplicarFiltros($sql, $params, '', $fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);

        $sql .= " GROUP BY COALESCE(NULLIF(seccion_nombre, ''), 'Sin sección')
                  ORDER BY total_clics DESC, seccion_nombre ASC";

        try {
            $res = parent::query($sql, $params);
            return is_array($res) ? $res : [];
        } catch (Exception $e) {
            error_log('Error al obtener clics por sección: ' . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorContexto($fecha_inicio = null, $fecha_fin = null, $click_tipo = null, $click_modulo = null)
    {
        $sql = "SELECT
                    COALESCE(NULLIF(click_contexto, ''), 'Sin contexto') AS click_contexto,
                    COUNT(*) AS total_clics
                FROM app_click_event
                WHERE 1=1";

        $params = [];
        $this->aplicarFiltros($sql, $params, '', $fecha_inicio, $fecha_fin, $click_tipo, $click_modulo);

        $sql .= " GROUP BY COALESCE(NULLIF(click_contexto, ''), 'Sin contexto')
                  ORDER BY total_clics DESC, click_contexto ASC";

        try {
            $res = parent::query($sql, $params);
            return is_array($res) ? $res : [];
        } catch (Exception $e) {
            error_log('Error al obtener clics por contexto: ' . $e->getMessage());
            return [];
        }
    }

    private function normalizarTexto($valor, $max = 255)
    {
        $valor = trim((string)$valor);
        if ($valor === '') {
            return '';
        }

        return mb_substr($valor, 0, (int)$max);
    }

    private function normalizarNullableTexto($valor, $max = 255)
    {
        $valor = trim((string)$valor);
        if ($valor === '') {
            return null;
        }

        return mb_substr($valor, 0, (int)$max);
    }

    private function normalizarNullableTextoLargo($valor)
    {
        $valor = trim((string)$valor);
        return $valor === '' ? null : $valor;
    }

    private function normalizarNullableEntero($valor)
    {
        if ($valor === null || $valor === '') {
            return null;
        }

        return (int)$valor;
    }
}