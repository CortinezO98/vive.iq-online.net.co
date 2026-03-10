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
                    NOW()
                )";

        $params = [
            'click_tipo'        => $this->normalizarTexto($this->click_tipo, 50),
            'click_clave'       => $this->normalizarTexto($this->click_clave, 150),
            'click_label'       => $this->normalizarTexto($this->click_label, 255),
            'click_modulo'      => $this->normalizarNullableTexto($this->click_modulo, 100),
            'click_url_destino' => $this->normalizarNullableTextoLargo($this->click_url_destino),
            'click_url_origen'  => $this->normalizarNullableTextoLargo($this->click_url_origen),
            'entidad_id'        => $this->normalizarNullableEntero($this->entidad_id),
            'entidad_tipo'      => $this->normalizarNullableTexto($this->entidad_tipo, 50),
            'user_id'           => $this->normalizarNullableEntero($this->user_id),
            'click_ip'          => $this->normalizarNullableTexto($this->click_ip, 45),
            'click_user_agent'  => $this->normalizarNullableTextoLargo($this->click_user_agent),
            'click_session_id'  => $this->normalizarNullableTexto($this->click_session_id, 255),
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
     * Evitar doble click inmediato
     */
    public function existeClickReciente($click_clave, $click_tipo, $session_id, $segundos = 2)
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

    /**
     * Filtro base reutilizable
     */
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

    /**
     * Obtener reporte detallado
     */
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

    /**
     * Resumen general
     */
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

    /**
     * Top elementos más clicados
     */
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

    /**
     * Estadísticas por tipo
     */
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

    /**
     * Estadísticas por módulo
     */
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

    /**
     * Serie diaria
     */
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

    /**
     * Top usuarios
     */
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

    /**
     * Normaliza texto obligatorio
     */
    private function normalizarTexto($valor, $max = 255)
    {
        $valor = trim((string)$valor);
        if ($valor === '') {
            return '';
        }

        return mb_substr($valor, 0, (int)$max);
    }

    /**
     * Normaliza texto nullable
     */
    private function normalizarNullableTexto($valor, $max = 255)
    {
        $valor = trim((string)$valor);
        if ($valor === '') {
            return null;
        }

        return mb_substr($valor, 0, (int)$max);
    }

    /**
     * Normaliza texto largo nullable
     */
    private function normalizarNullableTextoLargo($valor)
    {
        $valor = trim((string)$valor);
        return $valor === '' ? null : $valor;
    }

    /**
     * Normaliza entero nullable
     */
    private function normalizarNullableEntero($valor)
    {
        if ($valor === null || $valor === '') {
            return null;
        }

        return (int)$valor;
    }
}