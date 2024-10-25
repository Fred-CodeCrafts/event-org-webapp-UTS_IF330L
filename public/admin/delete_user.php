<?php
require_once('../DB.php');

$id = $_POST['id'];

$stmt = connectDB()->prepare("DELETE FROM event_participants WHERE user_id = ?");
$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
$stmt->execute();

$stmt = connectDB()->prepare("DELETE FROM user WHERE user_id = ?");
$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
$stmt->execute();

header("Location: registered_user.php");