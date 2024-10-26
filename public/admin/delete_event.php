<?php
session_start();
if(!isset($_SESSION["admin"]) || $_SESSION["admin"] != "true") {
	header("Location: ../aut/login/admin.php");
}

require_once('../DB.php');

if(isset($_POST['id'])){
    $id = $_POST['id'];
    var_dump($id);
    $stmt = connectDB()->prepare("DELETE FROM event_participants WHERE event_id = :event_id");
    $stmt->bindValue(':event_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $stmt = connectDB()->prepare("DELETE FROM event WHERE event_id = :event_id");
    $stmt->bindValue(':event_id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

header("Location: admin_dashboard.php");