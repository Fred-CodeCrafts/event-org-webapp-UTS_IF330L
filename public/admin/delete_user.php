<?php
session_start();
if(!isset($_SESSION["admin"]) || $_SESSION["admin"] != "true") {
	header("Location: ../aut/login/admin.php");
}

require_once('../DB.php');

$id = $_POST['id'];

$stmt = connectDB()->prepare("DELETE FROM event_participants WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
$stmt->execute();

$stmt = connectDB()->prepare("DELETE FROM user WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
$stmt->execute();

header("Location: registered_user.php");