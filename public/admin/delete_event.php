<?php
require_once('../DB.php');

if(isset($_POST['checkbox_delete'])){
    $delete = $_POST['checkbox_delete'];
    foreach ($delete as $eventId) {
        $stmt = connectDB()->prepare("DELETE FROM event_participants WHERE event_id = :user_id");
        $stmt->bindValue(':user_id', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        
        $stmt = connectDB()->prepare("DELETE FROM event WHERE event_id = :user_id");
        $stmt->bindValue(':user_id', $eventId, PDO::PARAM_INT);
        $stmt->execute();
    }
}else{
    $id = $_POST['id'];
    $stmt = connectDB()->prepare("DELETE FROM event_participants WHERE event_id = :user_id");
    $stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $stmt = connectDB()->prepare("DELETE FROM event WHERE event_id = :user_id");
    $stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

header("Location: admin_dashboard.php");