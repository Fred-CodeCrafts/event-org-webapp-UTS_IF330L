<?php
    // $dsn = "mysql:host=localhost;dbname=uts";
    // $kunci = new PDO($dsn,"root","");
require_once('../DB.php');

$stmt = connectDB()->prepare("DELETE FROM event WHERE ID_event = ?");
$id = $_POST['id'];
$stmt->execute(array($id));

header("Location: event_management.php");