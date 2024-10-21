<?php
include 'ConnectDB.php';

$user_id = 1; // Assume user is logged in and has user_id 1

$sql = "SELECT e.id, e.name, e.description, e.schedule, e.location 
        FROM events e 
        JOIN registrations r ON e.id = r.event_id 
        WHERE r.user_id = $user_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registered Events</title>
</head>
<body>
    <h1>My Registered Events</h1>
    <ul>
        <?php while($row = $result->fetch_assoc()): ?>
            <li>
                <h2><?php echo $row['name']; ?></h2>
                <p><?php echo $row['description']; ?></p>
                <p>Schedule: <?php echo $row['schedule']; ?></p>
                <p>Location: <?php echo $row['location']; ?></p>
                <form method="post" action="Cancel_registration.php">
                    <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Cancel</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>