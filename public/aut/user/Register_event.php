<?php
require_once('config.php');
session_start();  // Make sure to start the session

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to login page if user is not logged in
    header("Location: ../login/index.php");
    exit();
}

// Debugging - View session data
var_dump($_SESSION);

$user_id = $_SESSION['id'];  // User ID from the session
$event_id = $_GET['event_id'] ?? null; // Get event ID from the URL; ensure it exists

// Check if event_id is set and valid
if (!$event_id) {
    // Handle case where event_id is not provided
    $_SESSION['error'] = 'Event ID is required.';
    header("Location: home.php");
    exit();
}

try {
    // Prepare SQL statement
    $data = "INSERT INTO event_participants (user_id, event_id) VALUES (:user_id, :event_id)";

    // Prepare the statement using PDO
    $stmt = connectDB()->prepare($data);
    $params = [
        ":user_id" => $user_id,
        ":event_id" => $event_id
    ];

    // Execute the statement
    if ($stmt->execute($params)) {
        $_SESSION['registered'] = 1; // Set registration success
        header("Location: home.php"); // Redirect to home
        exit();
    } else {
        // Handle failure in execution
        $_SESSION['error'] = 'Failed to register for the event.';
        header("Location: home.php");
        exit();
    }
} catch (PDOException $e) {
    // Handle exceptions
    $_SESSION['error'] = 'Database error: ' . $e->getMessage();
    header("Location: home.php");
    exit();
}
?>
