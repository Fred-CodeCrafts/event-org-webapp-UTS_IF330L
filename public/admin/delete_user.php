<?php
require_once('../DB.php');

$stmt = connectDB()->prepare("DELETE FROM event_participants WHERE user_id = ?");
$id = $_POST['id'];
$stmt->execute(array($id));

$stmt = connectDB()->prepare("DELETE FROM user WHERE user_id = ?");
$stmt->execute(array($id));

header("Location: registered_user.php");