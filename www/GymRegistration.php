<?php
class GymRegistration {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function add($name, $birth_date, $tariff, $personal_trainer, $visit_time) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO gym_registrations (name, birth_date, tariff, personal_trainer, visit_time) 
             VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$name, $birth_date, $tariff, $personal_trainer, $visit_time]);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM gym_registrations ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM gym_registrations WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
