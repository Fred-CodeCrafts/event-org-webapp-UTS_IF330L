<?php
require 'config.php';

// session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login/index.php');
    exit();
}

$sql = "SELECT e.event_name as event_name, e.start_date as start_date, e.end_date as end_date, e.image as image, ep.registration_date as registration_date
        FROM event e 
        JOIN event_participants ep ON e.event_id = ep.event_id 
        WHERE ep.user_id = :user_id 
        ORDER BY e.end_date DESC";

$stmt = connectDB()->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();

$past_events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet">
    <title>Harsa - Event History</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body>
    <?php require 'user_navbar.php'; ?>

    <div class="mt-32 container mx-auto">
        <h1 class="text-center text-2xl font-bold mb-9">Event History</h1>
        <div class="flex mx-11 justify-center">

            <div class="grid grid-cols-1 gap-9 md:grid-cols-2 lg:grid-cols-3">
                <?php if (count($past_events) > 0): ?>
                    <?php foreach ($past_events as $event): ?>
                        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <img class="rounded-t-lg" src="<?= '../../admin/gambar/' . htmlspecialchars($event['image']) ?>" alt="Event Image" />
                            <div class="p-5">
                                <h5 class="text-2xl font-bold text-gray-900 dark:text-white"><?= htmlspecialchars($event['event_name']) ?></h5>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Registered on: <?= htmlspecialchars($event['registration_date']) ?></p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">Event Date: <?= htmlspecialchars($event['start_date']) ?> ~ <?= htmlspecialchars($event['end_date']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-gray-600 dark:text-white">No past events found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    <footer class="bg-gray-900 text-white text-center py-4 mt-8">
      hp 2024 Harsa. All rights reserved.</p>
    </footer>
</body>
</html>
