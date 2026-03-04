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
    public function listBetween($startDate, $endDate) {
        $sql = "SELECT e.*, u.usu_nombres_apellidos as creator_name 
                FROM comm_events e
                LEFT JOIN app_usuario u ON e.created_by = u.usu_id
                WHERE e.event_date BETWEEN :start_date AND :end_date 
                ORDER BY e.event_date ASC, e.start_time ASC";
        
        return parent::query($sql, [
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    /**
     * Obtener evento por ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM comm_events WHERE id = :id LIMIT 1";
        $result = parent::query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }

    /**
     * Crear nuevo evento
     */
    public function add() {
        $sql = "INSERT INTO comm_events 
                (title, description, event_date, start_time, end_time, meet_url, location, is_all_day, color, created_by) 
                VALUES 
                (:title, :description, :event_date, :start_time, :end_time, :meet_url, :location, :is_all_day, :color, :created_by)";
        
        return parent::query($sql, [
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'meet_url' => $this->meet_url,
            'location' => $this->location,
            'is_all_day' => $this->is_all_day,
            'color' => $this->color ?? '#1C2262',
            'created_by' => $this->created_by
        ]);
    }

    /**
     * Actualizar evento
     */
    public function update() {
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
        
        return parent::query($sql, [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'meet_url' => $this->meet_url,
            'location' => $this->location,
            'is_all_day' => $this->is_all_day,
            'color' => $this->color ?? '#1C2262'
        ]);
    }

    /**
     * Eliminar evento
     */
    public function delete() {
        $sql = "DELETE FROM comm_events WHERE id = :id";
        return parent::query($sql, ['id' => $this->id]);
    }

    /**
     * Obtener eventos del mes para calendario
     */
    public function getMonthEvents($year, $month) {
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        return $this->listBetween($startDate, $endDate);
    }
}