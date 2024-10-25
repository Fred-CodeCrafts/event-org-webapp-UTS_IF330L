<?php
require_once('config.php');
var_dump($_SESSION);
if (!isset($_SESSION['user_id'])) {
    die("User ID tidak ditemukan dalam sesi.");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT e.event_id, e.event_name, e.description, e.start_date, e.end_date, e.start_time, e.end_time, e.location 
        FROM event e
        JOIN event_participants ep ON e.event_id = ep.event_id 
        WHERE ep.user_id = :user_id";

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
                <p>
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" clip-rule="evenodd"/>
                    </svg>
                    = event starts : <?php echo htmlspecialchars($event['start_date']).' '. $event['start_time'] ; ?>
                    event ended  : <?php echo htmlspecialchars($event['start_date']).' '. $event['end_time']; ?></p>
                <p>
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z"/>
                    </svg>
                    Location: <?php echo htmlspecialchars($event['location']); ?></p>
                <form method="post" action="Cancel_registration.php">
                    <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['id']); ?>">
                    <button type="submit">Cancel</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>