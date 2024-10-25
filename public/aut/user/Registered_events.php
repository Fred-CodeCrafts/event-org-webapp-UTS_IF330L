<?php
require_once('config.php');

if (!isset($_SESSION['user_id'])) {
    die("User ID tidak ditemukan dalam sesi.");
}


$user_id = $_SESSION['user_id'];

$sql = "SELECT *
        FROM event e
        JOIN event_participants ep ON ep.event_id = e.event_id 
        WHERE ep.user_id = :user_id";

$stmt = connectDB()->prepare($sql);
$stmt->execute([':user_id' => $user_id]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Harsa - Registered Events</title>
    <link href="../../styles.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body>
    <?php require 'user_navbar.php' ?>
    <h1>My Registered Events</h1>
    <div class="mt-32">
    <!-- Search Bar -->
        <div class="flex justify-center mb-6">
                <input type="text" id="searchInput" placeholder="Search events..." 
                    class="px-4 py-2 border rounded-lg w-3/4 max-w-md" 
                    oninput="filterEvents()">
        </div>
        <?php if(!empty($events)) { ?>
        <h1 class="text-center text-4xl font-extrabold mb-9 text-purple-600">Registered Events</h1>
        <div class="flex mx-11 justify-center">
            <div class="grid grid-cols-1 gap-9 md:gap-24 lg:gap-32 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($events as $event) { ?>
                    <div class="max-w-80 xs:max-w-sm bg-white border border-gray-200 rounded-lg shadow-lg transition-transform duration-300 hover:scale-105 dark:bg-gray-800 dark:border-gray-700 event-card"
                        data-event-name="<?= htmlspecialchars($event['event_name']) ?>">
                        <img class="rounded-t-lg" src="<?= '../../admin/gambar/' . $event['image'] ?>" />
                        <div class="p-5 mt-2">
                            <div class="flex flex-row">
                                <p class="text-base text-gray-800 leading-relaxed" style="word-wrap: break-word; word-break: break-word; max-width: 100%; white-space: normal;">
                                    <?= $event['description'] ?>
                                </p>
                            </div>
                            <div class="flex flex-row mt-2">
                                <svg class="mr-2 w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                                </svg>
                                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                    <strong>Capacity:</strong> <?= $event['capacity'] ?> 
                                </p>
                            </div>
                            <div class="flex flex-row mt-2">
                                <svg class="mr-2 w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
                                </svg>
                                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                    <strong>Event starts:</strong> <?= $event['start_date'] ?> <?= $event['start_time'] ?>
                                </p>
                            </div>
                            <div class="flex flex-row mt-2">
                            <svg class="w-6 h-6 mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" clip-rule="evenodd"/>
                            </svg>
                                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                    <strong>Event ends:</strong> <?= $event['end_date'] ?> <?= $event['end_time'] ?>
                                </p>
                            </div>
                            <div class="flex flex-row mt-2">
                                <div class="flex flex-row">
                                    <div class="flex-shrink-0 w-6 h-6 mr-2">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z"/>
                                        </svg>
                                    </div>
                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400" style="word-wrap: break-word; word-break: break-word; max-width: 100%; white-space: normal;">
                                        <strong>Location:</strong> <?= $event['location'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-row-reverse mt-2">
                                <a href="cancel_registration.php?event_id=<?= htmlspecialchars($event['event_id']) ?>"
                                    class="ml-3 flex flex-row p-2 mr-1 items-center text-white bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Cancel event
                                    <svg class="w-6 h-6 ml-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M18 5.05h1a2 2 0 0 1 2 2v2H3v-2a2 2 0 0 1 2-2h1v-1a1 1 0 1 1 2 0v1h3v-1a1 1 0 1 1 2 0v1h3v-1a1 1 0 1 1 2 0v1Zm-15 6v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-8H3ZM11 18a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1a1 1 0 1 0-2 0v1h-1a1 1 0 1 0 0 2h1v1Z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } else { ?>
        <h1 class="text-center text-4xl font-extrabold mb-9 text-purple-600">There's no registered events</h1>
    <?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>