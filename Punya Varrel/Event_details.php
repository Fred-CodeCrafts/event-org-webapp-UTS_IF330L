<?php
include 'ConnectDB.php';

$event_id = $_GET['id'];
$sql = "SELECT * FROM events WHERE id = $event_id";
$result = $conn->query($sql);
$event = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $event['name']; ?></title>
</head>
<body>
    <h1><?php echo $event['name']; ?></h1>
    <p><?php echo $event['description']; ?></p>
    <p>Schedule: <?php echo $event['schedule']; ?></p>
    <p>Location: <?php echo $event['location']; ?></p>
    <form method="post" action="register_event.php">
        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
        <button type="submit">Register</button>
    </form>
</body>
</html>
