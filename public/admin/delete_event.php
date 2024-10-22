<?php
require_once('../DB.php');

$stmt = connectDB()->prepare("DELETE FROM event WHERE event_id = ?");
$id = $_POST['id'];
$stmt->execute(array($id));

header("Location: event_management.php");