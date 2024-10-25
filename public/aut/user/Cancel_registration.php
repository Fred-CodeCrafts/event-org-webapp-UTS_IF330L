<?php
require_once('../DB.php');

$user_id = $_POST['user_id'];
$event_id = $_POST['event_id'];

$sql = "DELETE FROM event_participant WHERE user_id = $user_id AND event_id = $event_id";
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