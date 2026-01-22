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

    public function getAdults($minAge = 18) {
        $dateLimit = date('Y-m-d', strtotime("-$minAge years"));
        $stmt = $this->pdo->prepare(
            "SELECT * FROM gym_registrations 
             WHERE birth_date <= ? 
             ORDER BY created_at DESC"
        );
        $stmt->execute([$dateLimit]);
        return $stmt->fetchAll();
    }

    // Метод для получения общего количества записей
    public function getTotalCount() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM gym_registrations");
        return $stmt->fetchColumn();
    }

    // Метод для количества совершеннолетних (старше 18)
    public function getAdultsCount($minAge = 18) {
        $dateLimit = date('Y-m-d', strtotime("-$minAge years"));
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) as adult_count FROM gym_registrations 
             WHERE birth_date <= ?"
        );
        $stmt->execute([$dateLimit]);
        return $stmt->fetchColumn();
    }
}
?>
