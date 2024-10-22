<?php
include 'ConnectDB.php';

$user_id = 1; // Assume user is logged in and has user_id 1
$event_id = $_POST['event_id'];

$sql = "DELETE FROM registrations WHERE user_id = $user_id AND event_id = $event_id";
if ($conn->query($sql) === TRUE) {
    echo "Cancelled registration successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cancel Registration</title>
</head>
<body>
    <a href="Registered_events.php">Back to Registered Events</a>
</body>
</html>