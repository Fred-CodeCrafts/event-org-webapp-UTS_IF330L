<?php
include 'ConnectDB.php';

$sql = "SELECT * FROM events";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Events</title>
</head>
<body>
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