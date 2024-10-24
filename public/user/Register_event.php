<?php
include 'ConnectDB.php';

$user_id = 1; 
$event_id = $_POST['event_id'];

$sql = "INSERT INTO registrations (user_id, event_id) VALUES ($user_id, $event_id)";
if ($conn->query($sql) === TRUE) {
    echo "Registered successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
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