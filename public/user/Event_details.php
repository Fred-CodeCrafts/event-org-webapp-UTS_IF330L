<?php
require_once('../DB.php');

if (isset($_GET["id"])) {
	$id = $_GET["id"];
	$sql = "SELECT * FROM event WHERE event_id = :id";
	$stmt = connectDB()->prepare($sql);
	$stmt->bindParam(":event_id", $id, PDO::PARAM_INT);
	$stmt->execute();
	$event = $stmt->fetch(PDO::FETCH_ASSOC);

	if (!$event) {
		echo "Event not found.";
		exit();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $event['event_name']; ?></title>
</head>
<body>
    <h1><?php echo $event['event_name']; ?></h1>
    <p><?php echo $event['description']; ?></p>
    <p>Schedule: <?php echo $event['schedule']; ?></p>
    <p>Location: <?php echo $event['location']; ?></p>
    <form method="post" action="register_event.php">
        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
        <button type="submit">Register</button>
    </form>

	<!-- numpang -->
	<h1>Upcoming Events</h1>
    <ul>
        <?php while($row = $result->fetch_assoc()): ?>
            <li>
                <a href="Event_details.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
