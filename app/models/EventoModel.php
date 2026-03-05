<?php
class eventoModel extends Model {
    public $id;
    public $title;
    public $description;
    public $event_date;
    public $start_time;
    public $end_time;
    public $meet_url;
    public $location;
    public $is_all_day;
    public $color;
    public $created_by;

    /**
     * Listar eventos entre dos fechas
     */
/**
 * Listar eventos entre dos fechas
 */
    public function listBetween($startDate, $endDate) {
        error_log("EventoModel::listBetween($startDate, $endDate)");
        
        $sql = "SELECT e.*, u.usu_nombres_apellidos as creator_name
                FROM comm_events e
                LEFT JOIN app_usuario u ON e.created_by = u.usu_id
                WHERE e.event_date BETWEEN :start_date AND :end_date
                ORDER BY e.event_date ASC, e.start_time ASC";

        try {
            $res = parent::query($sql, [
                'start_date' => $startDate,
                'end_date'   => $endDate
            ]);
            
            error_log("Resultado de query: " . (is_array($res) ? count($res) . ' registros' : 'NO ES ARRAY'));
            
            return is_array($res) ? $res : [];
        } catch (Exception $e) {
            error_log("ERROR en EventoModel::listBetween: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener evento por ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM comm_events WHERE id = :id LIMIT 1";
        $result = parent::query($sql, ['id' => (int)$id]);

        return (is_array($result) && isset($result[0])) ? $result[0] : null;
    }

    /**
     * Crear nuevo evento
     */
    public function add(): bool {
        $sql = "INSERT INTO comm_events
                (title, description, event_date, start_time, end_time, meet_url, location, is_all_day, color, created_by)
                VALUES
                (:title, :description, :event_date, :start_time, :end_time, :meet_url, :location, :is_all_day, :color, :created_by)";

        $res = parent::query($sql, [
            'title'       => (string)$this->title,
            'description' => (string)$this->description,
            'event_date'  => (string)$this->event_date,
            'start_time'  => $this->start_time !== null && $this->start_time !== '' ? (string)$this->start_time : null,
            'end_time'    => $this->end_time !== null && $this->end_time !== '' ? (string)$this->end_time : null,
            'meet_url'    => (string)$this->meet_url,
            'location'    => (string)$this->location,
            'is_all_day'  => (int)$this->is_all_day,
            'color'       => $this->color ?: '#1C2262',
            'created_by'  => (int)$this->created_by
        ]);

        return $res !== false;
    }

    /**
     * Actualizar evento
     */
    public function update(): bool {
        $sql = "UPDATE comm_events SET
                title = :title,
                description = :description,
                event_date = :event_date,
                start_time = :start_time,
                end_time = :end_time,
                meet_url = :meet_url,
                location = :location,
                is_all_day = :is_all_day,
                color = :color
                WHERE id = :id";

        $res = parent::query($sql, [
            'id'          => (int)$this->id,
            'title'       => (string)$this->title,
            'description' => (string)$this->description,
            'event_date'  => (string)$this->event_date,
            'start_time'  => $this->start_time !== null && $this->start_time !== '' ? (string)$this->start_time : null,
            'end_time'    => $this->end_time !== null && $this->end_time !== '' ? (string)$this->end_time : null,
            'meet_url'    => (string)$this->meet_url,
            'location'    => (string)$this->location,
            'is_all_day'  => (int)$this->is_all_day,
            'color'       => $this->color ?: '#1C2262'
        ]);

        return $res !== false;
    }

    /**
     * Eliminar evento
     */
    public function delete(): bool {
        $sql = "DELETE FROM comm_events WHERE id = :id";
        $res = parent::query($sql, ['id' => (int)$this->id]);

        return $res !== false;
    }

    /**
     * Obtener eventos del mes para calendario
     */
    public function getMonthEvents($year, $month) {
        $startDate = sprintf('%04d-%02d-01', (int)$year, (int)$month);
        $endDate = date('Y-m-t', strtotime($startDate));

        return $this->listBetween($startDate, $endDate);
    }
}