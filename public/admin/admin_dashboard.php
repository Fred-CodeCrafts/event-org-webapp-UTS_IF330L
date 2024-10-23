<?php
require_once('../DB.php');

$sql = "SELECT * FROM event";
$hasil = connectDB()->query($sql);

date_default_timezone_set('Asia/Jakarta');
$currentDate = date('Y-m-d');
$currentTime = date('H:i');

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <title>Admin Dashboard</title>
</head>

<body class="bg-gray-100 px-10">
    <div class="flex justify-items-center items-center">
        <div class="max-w-lg bg-white shadow-md rounded-lg p-6">
            <div class="btn bg-green-500"><a href="create_event.html">Create Event</a></div>
        </div>
    </div>

    <div class="mt-3 relative overflow-x-auto shadow-md rounded-lg dark:bg-gray-900">
        <div class="flex items-center space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900 p-6">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-50 md:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for events">
            </div>
        </div>
        <?php if ($hasil->rowCount() > 0): ?>
            <div class="relative overflow-x-auto p-6">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Checkbox
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Participants
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status  
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $hasil->fetch(PDO::FETCH_ASSOC)): 
                            $tgl_mulai = $row['tgl_mulai'];
                            $waktu_mulai = $row['waktu_mulai'];
                            $tgl_akhir = $row['tgl_akhir'];
                            $waktu_akhir = $row['waktu_akhir'];

                            $currentTimestamp = strtotime("$currentDate $currentTime");
                            $startTimestamp = strtotime("$tgl_mulai $waktu_mulai");
                            $endTimestamp = strtotime("$tgl_akhir $waktu_akhir");
                        ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-<?= urlencode($row['event_id']) ?>" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-<?= urlencode($row['event_id']) ?>" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="ps-2">
                                        <div class="text-base font-semibold"><?= htmlspecialchars($row['nama']) ?></div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    <?= htmlspecialchars($row['event_id']) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if (($currentTimestamp >= $startTimestamp && $currentTimestamp <= $endTimestamp) && $row['status_toogle'] == 1) { ?>
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> Open
                                        </div>
                                    <?php } else if($row['status_toogle'] == 2) { ?>
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div> Canceled
                                        </div>
                                    <?php } else { ?>
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div> Close
                                        </div>
                                    <?php } ?>
                                </td>
                                <td class="px-6 py-6 flex flex-row">
                                    <button data-modal-target="default-modal-<?= urlencode($row['event_id']) ?>" 
                                            data-modal-toggle="default-modal-<?= urlencode($row['event_id']) ?>" 
                                            class="p-2 mr-3 items-center flex flex-row text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                                        <svg class="w-10 xl:w-6 h-10 xl:h-6  mr-2 responsive-svg text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H4m0 0v4m0-4 5 5m7-5h4m0 0v4m0-4-5 5M8 20H4m0 0v-4m0 4 5-5m7 5h4m0 0v-4m0 4-5-5"/>
                                        </svg>
                                        View event
                                    </button>
                                    <a href="edit_event.php?event_id=<?= urlencode($row['event_id']) ?>" class="flex flex-row p-2 mr-3  items-center text-white bg-gradient-to-r from-amber-500 via-amber-600 to-amber-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-amber-300 dark:focus:ring-amber-800 font-medium rounded-lg text-sm px-5 py-2.5">
                                        <svg class="w-10 xl:w-6 h-10 xl:h-6 text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                        </svg>
                                        Edit event
                                    </a>
                                    <button data-modal-target="popup-modal-<?= urlencode($row['event_id']) ?>" data-modal-toggle="popup-modal-<?= urlencode($row['event_id']) ?>" class="items-center flex flex-row text-white bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5">
                                        <svg class="w-10 xl:w-6 h-10 xl:h-6 mr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                        </svg>
                                        Delete event
                                    </button>
                                    <a href="event_participants.php?event_id=<?= urlencode($row['event_id']) ?>" class="ml-3 flex flex-row p-2 mr-3  items-center text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5">
                                        <svg class="w-10 xl:w-6 h-10 xl:h-6 text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                        </svg>
                                        View users
                                    </a>
                                </td>
                            </tr>
                            <div id="default-modal-<?= urlencode($row['event_id']) ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <div>
                                                <img src="gambar/<?= $row['gambar']?>" class="max-w-64 max-h-64 rounded-lg">
                                                <h3 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white" style="word-wrap: break-word; word-break: break-word; max-width: 100%; white-space: normal;">
                                                    <?= htmlspecialchars($row['nama']) ?>
                                                </h3>
                                            </div>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal-<?= urlencode($row['event_id']) ?>">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <div class="p-4 md:p-5 space-y-4">
                                            <div class="flex flex-row">
                                                <p class="text-base leading-relaxed text-white" style="word-wrap: break-word; word-break: break-word; max-width: 100%; white-space: normal;">
                                                    <?= $row['deskripsi'] ?>
                                                </p>
                                            </div>
                                            <div class="flex flex-row">
                                                <svg class="mr-2 w-6 h-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                                                </svg>
                                                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                                    Capacity: <?= $row['kapasitas'] ?> 
                                                </p>
                                            </div>
                                            <div class="flex flex-row">
                                                <svg class="mr-2 w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
                                                </svg>
                                                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                                    Event started: <?= $row['tgl_mulai'] ?> <?= $row['waktu_mulai'] ?>
                                                </p>
                                            </div>
                                            <div class="flex flex-row">
                                            <svg class="w-6 h-6 mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" clip-rule="evenodd"/>
                                            </svg>
                                                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                                    Event ended: <?= $row['tgl_akhir'] ?> <?= $row['waktu_akhir'] ?>
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
                                                        Location: <?= $row['lokasi'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="popup-modal-<?= urlencode($row['event_id']) ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-<?= urlencode($row['event_id']) ?>">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this event?</h3>
                                            <form action="delete_event.php" method="post">
                                                <input type="hidden" value="<?= urlencode($row['event_id']) ?>" name="id">
                                                <button data-modal-hide="popup-modal-<?= urlencode($row['event_id']) ?>" type="submit" id="confirm-redirect" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Yes, I'm sure
                                                </button>
                                            </form>
                                            <button data-modal-hide="popup-modal-<?= urlencode($row['event_id']) ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No event found</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <!-- <script src="../../node_modules/flowbite/dist/flowbite.min.js"></script> -->
    <script>
        function submitForm() {
            document.getElementById('hiddenForm').submit();
        }
    </script>
</body>

</html>