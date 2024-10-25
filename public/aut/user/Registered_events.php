<?php
require_once('config.php');

if (!isset($_SESSION['user_id'])) {
    die("User ID tidak ditemukan dalam sesi.");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT e.id, e.name, e.description, e.schedule, e.location 
        FROM event e
        JOIN registrations r ON e.id = r.event_id 
        WHERE r.user_id = :user_id";

$stmt = connectDB()->prepare($sql);
$stmt->execute([':user_id' => $user_id]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registered Events</title>
</head>
<body>
    <h1>My Registered Events</h1>
    <ul>
        <?php foreach($events as $event): ?>
            <li>
                <h2><?php echo htmlspecialchars($event['name']); ?></h2>
                <p><?php echo htmlspecialchars($event['description']); ?></p>
                <p>Schedule: <?php echo htmlspecialchars($event['start_date']); ?></p>
                <p>Location: <?php echo htmlspecialchars($event['location']); ?></p>
                <form method="post" action="Cancel_registration.php">
                    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['id']); ?>">
                    <button type="submit">Cancel</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>