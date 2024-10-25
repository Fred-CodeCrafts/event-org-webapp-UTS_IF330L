<?php
require_once('config.php');
session_start();  

if (!isset($_SESSION['id'])) {
    header("Location: ../login/index.php");
    exit();
}


$user_id = $_SESSION['id']; 
$event_id = $_GET['event_id'] ?? null;

if (!$event_id) {
    $_SESSION['error'] = 'Event ID is required.';
    header("Location: home.php");
    exit();
}

try {
    $data = "INSERT INTO event_participants (user_id, event_id) VALUES (:user_id, :event_id)";

    $stmt = connectDB()->prepare($data);
    $params = [
        ":user_id" => $user_id,
        ":event_id" => $event_id
    ];

    if ($stmt->execute($params)) {
        $_SESSION['registered'] = 1;
        header("Location: home.php");
        exit();
    } else {
        $_SESSION['error'] = 'Failed to register for the event.';
        header("Location: home.php");
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = 'Database error: ' . $e->getMessage();
    header("Location: home.php");
    exit();
}
?>
