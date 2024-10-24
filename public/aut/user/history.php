<?php
require 'config.php';

session_start();

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ../login/index.php');
    exit();
}

// Fetch past events that the user has registered for
$sql = "SELECT e.event_name, e.start_date, e.end_date, e.image, r.registration_date 
        FROM event e 
        JOIN registration r ON e.event_id = r.event_id 
        WHERE r.user_id = :user_id AND e.end_date < :current_date 
        ORDER BY e.end_date DESC";

$stmt = connectDB()->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->bindValue(':current_date', date('Y-m-d'), PDO::PARAM_STR);
$stmt->execute();

$past_events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet">
    <title>Event History</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
        <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">
            <a href="index.php" class="flex items-center space-x-3">
                <img src="../assets/images/logo3.png" class="h-11" alt="Logo" />
                <span class="self-center text-2xl font-semibold dark:text-white">Harsa</span>
            </a>
            <div class="flex items-center">
                <span class="text-gray-900 dark:text-white mr-4"><?= $_SESSION['username'] ?></span>
                <a href="logout.php" class="text-gray-900 dark:text-white">Log out</a>
            </div>
        </div>
    </nav>

    <div class="mt-32 container mx-auto">
        <h1 class="text-center text-2xl font-bold mb-9">Event History</h1>

        <div class="grid grid-cols-1 gap-9 md:grid-cols-2 lg:grid-cols-3">
            <?php if (count($past_events) > 0): ?>
                <?php foreach ($past_events as $event): ?>
                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <img class="rounded-t-lg" src="<?= '../../admin/gambar/' . htmlspecialchars($event['image']) ?>" alt="Event Image" />
                        <div class="p-5">
                            <h5 class="text-2xl font-bold text-gray-900 dark:text-white"><?= htmlspecialchars($event['event_name']) ?></h5>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Registered on: <?= htmlspecialchars($event['registration_date']) ?></p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Event Date: <?= htmlspecialchars($event['start_date']) ?> - <?= htmlspecialchars($event['end_date']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-600 dark:text-white">No past events found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
