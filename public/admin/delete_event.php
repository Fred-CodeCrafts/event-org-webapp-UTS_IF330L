<?php
require_once('../DB.php');

if(isset($_POST['checkbox_delete'])){
    $delete = $_POST['checkbox_delete'];
    foreach ($delete as $eventId) {
        $stmt = connectDB()->prepare("DELETE FROM event_participants WHERE event_id = ?");
        $stmt->execute(array($eventId));

        $stmt = connectDB()->prepare("DELETE FROM event WHERE event_id = ?");
        $stmt->execute(array($eventId));
    }
}else{
    $id = $_POST['id'];
    $stmt = connectDB()->prepare("DELETE FROM event_participants WHERE event_id = ?");
    $stmt->execute(array($id));

    $stmt = connectDB()->prepare("DELETE FROM event WHERE event_id = ?");
    $stmt->execute(array($id));
}

header("Location: admin_dashboard.php");