<?php
require_once "db.php";
require_once "GymRegistration.php";

$gym = new GymRegistration($pdo);

if (isset($_POST["id"]) && is_numeric($_POST["id"])) {
    $gym->delete($_POST["id"]);
}

header("Location: index.php");
exit();
?>
