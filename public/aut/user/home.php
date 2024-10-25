<?php
require 'config.php';

$sql = "SELECT * FROM event ORDER BY start_date";
$result = connectDB()->query($sql);
$events = $result->fetchAll(PDO::FETCH_ASSOC);

date_default_timezone_set('Asia/Jakarta');
$currentDate = date('Y-m-d');
$currentTime = date('H:i');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet">
    <title>Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
<nav class="bg-gradient-to-r from-purple-600 to-blue-600 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
    <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">
        <a href="" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="../assets/images/logo3.png" class="h-11 transform transition-transform duration-300 hover:scale-110" alt="harsa" />
            <span class="self-center text-3xl font-bold text-white">Harsa</span>
        </a>
        <div class="flex items-center space-x-4">
            <!-- Navigation Links -->
            <a href="#" class="py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200">Home</a>
            <a href="#" class="py-2 px-4 bg-gray-300 text-gray-900 font-semibold rounded-lg hover:bg-gray-400 transition duration-200">Registered event</a>
            <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full" src="../assets/uploads/users/<?php echo $_SESSION['profile_image']; ?>" alt="Profile Image" />
            </button>

            <!-- Dropdown Menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm font-semibold text-gray-900 dark:text-white"><?= $_SESSION['username'] ?></span>
                    <span class="block text-sm text-gray-500 truncate dark:text-gray-400"><?= $_SESSION['email'] ?></span>
                </div>
                <ul class="py-2">
                    <li>
                        <a href="../profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                    </li>
                    <li>
                        <a href="history.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">History</a>
                    </li>
                    <li>
                        <a href="../logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

    
    <div class="mt-32">
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
                    <div class="max-w-80 xs:max-w-sm bg-white border border-gray-200 rounded-lg shadow-lg transition-transform duration-300 hover:scale-105 dark:bg-gray-800 dark:border-gray-700">
                        <img class="rounded-t-lg" src="<?= '../../admin/gambar/' . $event['image'] ?>" />
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?= $event['event_name'] ?></h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400" style="word-wrap: break-word; word-break: break-word; max-width: 100%; white-space: normal;"><?= $event['description'] ?></p>
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
                    <div id="default-modal-<?= htmlspecialchars($event['event_id']) ?>" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                    <div>
                                        <img src="../../admin/gambar/<?= htmlspecialchars($event['image']) ?>" class="max-w-64 max-h-64 rounded-lg shadow-md">
                                        <h3 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white">
                                            <?= htmlspecialchars($event['event_name']) ?>
                                        </h3>
                                    </div>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="default-modal-<?= htmlspecialchars($event['event_id']) ?>">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l-6 6m6 0l6-6m-6 0L1 1m6 6l6-6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-6 space-y-6">
                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400"><?= htmlspecialchars($event['description']) ?></p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <p><strong>Start Date:</strong> <?= htmlspecialchars($start_date) ?>, <?= htmlspecialchars($start_time) ?></p>
                                        <p><strong>End Date:</strong> <?= htmlspecialchars($end_date) ?>, <?= htmlspecialchars($end_time) ?></p>
                                    </div>
                                    <div>
                                        <p><strong>Organizer:</strong> <?= htmlspecialchars($event['organizer']) ?></p>
                                    </div>
                                    <div>
                                        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button data-modal-hide="default-modal-<?= htmlspecialchars($event['event_id']) ?>" type="button" class="text-gray-500 bg-white rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Close</button>
                                    <button type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 transition-transform duration-300 hover:scale-105">Register</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <footer class="bg-gray-900 text-white text-center py-4 mt-8">
        <p>&copy; 2024 Harsa. All rights reserved.</p>
    </footer>


        
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

</body>

</html>
