<?php
class securityQuestionModel extends Model {

    public $asq_id;
    public $asq_question;
    public $asq_estado = 'Activo';

    public function listActive() {
        $sql = "SELECT asq_id, asq_question
                FROM app_security_questions
                WHERE asq_estado='Activo'
                ORDER BY asq_id ASC";
        return parent::query($sql, []);
    }
}
