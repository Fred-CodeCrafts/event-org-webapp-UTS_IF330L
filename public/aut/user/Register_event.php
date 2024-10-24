<?php
require_once('config.php');

$user_id = $_SESSION['id']; 
$event_id = $_GET['event_id'];

$data = "INSERT INTO event_participants (user_id, event_id) VALUES (:user_id, :event_id)";

$stmt = connectDB()->prepare($data);
$params = [
	":user_id" => $user_id,
	":event_id" => $event_id
];

$stmt->execute($params);
header("Location: home.php");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Event Registration</title>
</head>
<body>
    <a href="events.php">Back to Events</a>
</body>
</html>