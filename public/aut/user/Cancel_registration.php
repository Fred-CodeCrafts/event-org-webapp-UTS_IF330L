<?php
require 'config.php';

$user_id = $_SESSION['user_id'];
$event_id = $_GET['event_id'];

$sql = "DELETE FROM event_participants WHERE user_id = $user_id AND event_id = $event_id";
if (connectDB()->query($sql) === TRUE) {
    echo "Cancelled registration successfully";
} else {
    echo "Failed to cancel the event";
}

header("Location: registered_events.php");
?>