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
    public $created_by;

    public function listBetween($startDate, $endDate) {
        $sql = "SELECT * FROM comm_events 
                WHERE event_date BETWEEN :start_date AND :end_date 
                ORDER BY event_date ASC, start_time ASC";
        return parent::query($sql, [
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    public function add() {
        $sql = "INSERT INTO comm_events 
                (title, description, event_date, start_time, end_time, meet_url, location, is_all_day, created_by) 
                VALUES 
                (:title, :description, :event_date, :start_time, :end_time, :meet_url, :location, :is_all_day, :created_by)";
        
        return parent::query($sql, [
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'meet_url' => $this->meet_url,
            'location' => $this->location,
            'is_all_day' => $this->is_all_day,
            'created_by' => $this->created_by
        ]);
    }
}