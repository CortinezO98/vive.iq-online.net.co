<?php
class usuarioSecurityModel extends Model {

    public $aus_usuario;
    public $aus_question_id;
    public $aus_answer_hash;
    public $aus_attempts;
    public $aus_locked_until;

    public function getByUser() {
        $sql = "SELECT aus_usuario, aus_question_id, aus_answer_hash, aus_attempts, aus_locked_until
                FROM app_usuario_security
                WHERE aus_usuario = :aus_usuario
                LIMIT 1";
        return parent::query($sql, ['aus_usuario' => $this->aus_usuario]);
    }

    public function getQuestionByUser() {
        $sql = "SELECT s.asq_id, s.asq_question,
                       u.aus_attempts, u.aus_locked_until
                FROM app_usuario_security u
                INNER JOIN app_security_questions s ON s.asq_id = u.aus_question_id
                WHERE u.aus_usuario = :aus_usuario
                LIMIT 1";
        return parent::query($sql, ['aus_usuario' => $this->aus_usuario]);
    }

    public function upsert() {
        $sql = "INSERT INTO app_usuario_security (aus_usuario, aus_question_id, aus_answer_hash, aus_attempts, aus_locked_until, aus_updated_at)
                VALUES (:aus_usuario, :aus_question_id, :aus_answer_hash, 0, NULL, NOW())
                ON DUPLICATE KEY UPDATE
                    aus_question_id = VALUES(aus_question_id),
                    aus_answer_hash = VALUES(aus_answer_hash),
                    aus_attempts = 0,
                    aus_locked_until = NULL,
                    aus_updated_at = NOW()";
        return parent::query($sql, [
            'aus_usuario' => $this->aus_usuario,
            'aus_question_id' => $this->aus_question_id,
            'aus_answer_hash' => $this->aus_answer_hash,
        ]) ? true : false;
    }

    public function setAttemptsAndLock($attempts, $lockedUntil = null) {
        $sql = "UPDATE app_usuario_security
                SET aus_attempts = :aus_attempts,
                    aus_locked_until = :aus_locked_until,
                    aus_updated_at = NOW()
                WHERE aus_usuario = :aus_usuario";
        return parent::query($sql, [
            'aus_usuario' => $this->aus_usuario,
            'aus_attempts' => $attempts,
            'aus_locked_until' => $lockedUntil,
        ]) ? true : false;
    }
}
