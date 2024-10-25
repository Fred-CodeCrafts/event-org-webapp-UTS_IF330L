<?php
require_once('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}


$user_id = $_SESSION['user_id']; 
$event_id = $_GET['event_id'];

if (!$event_id) {
    $_SESSION['error'] = 'Event ID is required.';
    header("Location: home.php");
    exit();
}

try {
    date_default_timezone_set('Asia/Jakarta');
    $currentDate = date('Y-m-d');

    $data = "INSERT INTO event_participants (user_id, event_id, registration_date) VALUES (:user_id, :event_id, :registration_date)";

    $stmt = connectDB()->prepare($data);
    $params = [
        ":user_id" => $user_id,
        ":event_id" => $event_id,
        ":registration_date" => $currentDate
    ];

    if ($stmt->execute($params)) {
        $_SESSION['registered'] = 1;
        echo "asdasd";
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
