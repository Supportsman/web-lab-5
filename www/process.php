<?php
require_once "db.php";
require_once "GymRegistration.php";

$gym = new GymRegistration($pdo);

$name = htmlspecialchars(trim($_POST["name"]));
$birth_date = $_POST["birth_date"];
$tariff = htmlspecialchars(trim($_POST["tariff"]));
$personal_trainer = isset($_POST["personal_trainer"]) ? 1 : 0;
$visit_time = htmlspecialchars(trim($_POST["visit_time"]));

$gym->add($name, $birth_date, $tariff, $personal_trainer, $visit_time);

header("Location: index.php");
exit();
?>
