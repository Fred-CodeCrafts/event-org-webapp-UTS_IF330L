<?php
require 'config.php';

$sql = "SELECT * FROM event ORDER BY start_date";
$result = connectDB()->query($sql);
$events = $result->fetchAll(PDO::FETCH_ASSOC);

date_default_timezone_set('Asia/Jakarta');
$currentDate = date('Y-m-d');
$currentTime = date('H:i');

$user_id = $_SESSION['user_id']; 

$registeredEventIds = [];
$sql = "SELECT event_id FROM event_participants WHERE user_id = :user_id";
$stmt = connectDB()->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$registeredEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($registeredEvents as $event) {
    $registeredEventIds[] = $event['event_id'];
}

function ongoingEvents() {
    global $events, $currentDate, $currentTime;
    $isOngoing = false;

    foreach ($events as $event) {
        $start_date = $event['start_date'];
        $start_time = $event['start_time'];
        $end_date = $event['end_date'];
        $end_time = $event['end_time'];

        $currentTimestamp = strtotime("$currentDate $currentTime");
        $startTimestamp = strtotime("$start_date $start_time");
        $endTimestamp = strtotime("$end_date $end_time");

        if (($currentTimestamp >= $startTimestamp && $currentTimestamp <= $endTimestamp) && $event['status_toogle'] == 1) {
            $isOngoing = true;
        }
    }
    return $isOngoing;
}

function registered($event_id) {
    global $registeredEventIds;
    return in_array($event_id, $registeredEventIds);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../styles.css" rel="stylesheet">
    <title>Harsa - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <?php require 'user_navbar.php'; ?>
    
    <div class="mt-28">
    <!-- Search Bar -->
    <div class="flex justify-center mb-6">
            <input type="text" id="searchInput" placeholder="Search events..." 
                   class="px-4 py-2 border rounded-lg w-3/4 max-w-md" 
                   oninput="filterEvents()">
    </div>
        <?php if(ongoingEvents()) { ?>
        <h1 class="text-center text-4xl font-extrabold mb-9 text-purple-600">Upcoming Events</h1>
        <div class="flex mx-11 justify-center">
            <div class="grid grid-cols-1 gap-9 md:gap-24 lg:gap-32 md:grid-cols-2 lg:grid-cols-3">
                <?php 
                    foreach ($events as $event) { 
                    $start_date = $event['start_date'];
                    $start_time = $event['start_time'];
                    $end_date = $event['end_date'];
                    $end_time = $event['end_time'];

                    $currentTimestamp = strtotime("$currentDate $currentTime");
                    $startTimestamp = strtotime("$start_date $start_time");
                    $endTimestamp = strtotime("$end_date $end_time");

                    if(($currentTimestamp >= $startTimestamp && $currentTimestamp <= $endTimestamp) && $event['status_toogle'] == 1) { ?>
                    <div class="max-w-80 xs:max-w-sm bg-white border border-gray-200 rounded-lg shadow-lg transition-transform duration-300 hover:scale-105 dark:bg-gray-800 dark:border-gray-700 event-card"
                        data-event-name="<?= htmlspecialchars($event['event_name']) ?>">
                        <img class="rounded-t-lg" src="<?= '../../admin/gambar/' . $event['image'] ?>" />
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?= $event['event_name'] ?></h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?= $event['description'] ?></p>
                            <button type="button"
                                data-modal-target="default-modal-<?= htmlspecialchars($event['event_id']) ?>"
                                data-modal-toggle="default-modal-<?= htmlspecialchars($event['event_id']) ?>"
                                class="view-event-btn p-2 mr-3 items-center flex flex-row text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 transition-transform duration-300 hover:scale-105">
                                Details
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <?php } ?>
                    <div id="default-modal-<?= htmlspecialchars($event['event_id']) ?>" 
                        tabindex="-1" 
                        aria-hidden="true" 
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                    <div>
                                        <img src="../../admin/gambar/<?= htmlspecialchars($event['image']) ?>" class="max-w-64 max-h-64 rounded-lg">
                                        <h3 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white">
                                            <?= htmlspecialchars($event['event_name']) ?>
                                        </h3>
                                    </div>
                                    <button type="button" 
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="default-modal-<?= htmlspecialchars($event['event_id']) ?>">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4">
                                    <div class="flex flex-row">
                                        <p class="text-base text-gray-800 leading-relaxed" style="word-wrap: break-word; word-break: break-word; max-width: 100%; white-space: normal;">
                                            <?= $event['description'] ?>
                                        </p>
                                    </div>
                                    <div class="flex flex-row">
                                        <svg class="mr-2 w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                                        </svg>
                                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                            <strong>Capacity:</strong> <?= $event['capacity'] ?> 
                                        </p>
                                    </div>
                                    <div class="flex flex-row">
                                        <svg class="mr-2 w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
                                        </svg>
                                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                            <strong>Event starts:</strong> <?= $event['start_date'] ?> <?= $event['start_time'] ?>
                                        </p>
                                    </div>
                                    <div class="flex flex-row">
                                    <svg class="w-6 h-6 mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" clip-rule="evenodd"/>
                                    </svg>
                                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                            <strong>Event ends:</strong> <?= $event['end_date'] ?> <?= $event['end_time'] ?>
                                        </p>
                                    </div>
                                    <div class="flex flex-row">
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
                                    <!-- Modal footer -->
                                    <div class="flex flex-row-reverse">
                                        <a href="register_event.php?event_id=<?= htmlspecialchars($event['event_id']) ?>"
                                            class="<?= registered($event['event_id']) ? 'pointer-events-none opacity-50' : '' ?> ml-3 flex flex-row p-2 mr-1 items-center text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5">
                                            <?= registered($event['event_id']) ? 'Registered' : 'Register' ?>
                                            <svg class="w-6 h-6 ml-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M18 5.05h1a2 2 0 0 1 2 2v2H3v-2a2 2 0 0 1 2-2h1v-1a1 1 0 1 1 2 0v1h3v-1a1 1 0 1 1 2 0v1h3v-1a1 1 0 1 1 2 0v1Zm-15 6v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-8H3ZM11 18a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1a1 1 0 1 0-2 0v1h-1a1 1 0 1 0 0 2h1v1Z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } else { ?>
        <h1 class="text-center text-4xl font-extrabold mb-9 text-purple-600">There's no upcoming events</h1>
    <?php } ?>
    <footer class="bg-gray-900 text-white text-center py-4 mt-8">
      hp 2024 Harsa. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<!-- <script src="../../../node_modules/flowbite/dist/flowbite.min.js"></script> -->
        
        <script>

        function filterEvents() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const events = Array.from(document.querySelectorAll('.event-card'));

            events.forEach(event => event.style.display = 'none'); 
            
            const filteredEvents = events.filter(event => 
                event.getAttribute('data-event-name').toLowerCase().includes(searchInput)
            );

            filteredEvents.slice(0, 5).forEach(event => event.style.display = 'block'); 
        }

    </script>

</body>

</html>