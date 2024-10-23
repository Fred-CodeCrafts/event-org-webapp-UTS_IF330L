<?php
require_once('../DB.php');

$sql = "SELECT user_id,username,email,nama FROM user";
$hasil = connectDB()->query($sql);

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <title>Registered Users</title>
</head>

<body class="bg-gray-100 px-10">
    <a href="admin_dashboard.php" class="flex flex-row mr-4 p-2 items-center text-white bg-gradient-to-r from-amber-500 via-amber-600 to-amber-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-amber-300 dark:focus:ring-amber-800 font-medium rounded-lg text-sm px-5 py-2.5">
        <svg class="w-6 h-6 mr-3 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
        </svg>
        Back to dashboard
    </a>
    <div class="mt-3 relative overflow-x-auto shadow-md rounded-lg dark:bg-gray-900">
        <div class="flex items-center space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900 p-6">
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-50 md:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for user">
            </div>
        </div>
        <?php if ($hasil->rowCount() > 0): ?>
            <div class="relative overflow-x-auto p-6">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Username
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $hasil->fetch(PDO::FETCH_ASSOC)):?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="ps-2">
                                        <div class="text-base font-semibold"><?= htmlspecialchars($row['nama']) ?></div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    <?= htmlspecialchars($row['username']) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?= htmlspecialchars($row['email']) ?>
                                </td>
                                <td class="px-6 py-6 flex flex-row">
                                    <button data-modal-target="default-modal-<?= urlencode($row['user_id']) ?>" 
                                            data-modal-toggle="default-modal-<?= urlencode($row['user_id']) ?>" 
                                            class="p-2 mr-3 items-center flex flex-row text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                                        <svg class="w-10 xl:w-6 h-10 xl:h-6  mr-2 responsive-svg text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H4m0 0v4m0-4 5 5m7-5h4m0 0v4m0-4-5 5M8 20H4m0 0v-4m0 4 5-5m7 5h4m0 0v-4m0 4-5-5"/>
                                        </svg>
                                        View user's registered event
                                    </button>
                                    <button data-modal-target="popup-modal-<?= urlencode($row['user_id']) ?>" data-modal-toggle="popup-modal-<?= urlencode($row['user_id']) ?>" class="items-center flex flex-row text-white bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5">
                                        <svg class="w-10 xl:w-6 h-10 xl:h-6 mr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                        </svg>
                                        Delete user
                                    </button>
                                </td>
                            </tr>
                            <div id="default-modal-<?= urlencode($row['user_id']) ?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <div>
                                                <h3 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white" style="word-wrap: break-word; word-break: break-word; max-width: 100%; white-space: normal;">
                                                    <?= htmlspecialchars($row['nama']) ?>'s registered event
                                                </h3>
                                            </div>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal-<?= urlencode($row['user_id']) ?>">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <div class="p-4 md:p-5 space-y-4">
                                            <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                                <?php 
                                                    $sql = "SELECT e.nama as eventName
                                                    FROM event e
                                                    JOIN event_participants ep
                                                    ON ep.event_id = e.event_id 
                                                    JOIN user u
                                                    ON ep.user_id = u.user_id
                                                    WHERE ep.user_id = :id";
                                            
                                                    $stmt = connectDB()->prepare($sql);
                                                    $id = $row["user_id"];
                                                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                                                    $stmt->execute();
                                                    $event = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                    if(!empty($event)){
                                                        foreach ($event as $name):?>
                                                        <li>
                                                            <?= $name['eventName'] ?>
                                                        </li>
                                                <?php endforeach;} else { ?>
                                                        They've been busy lately
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="popup-modal-<?= urlencode($row['user_id']) ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-<?= urlencode($row['user_id']) ?>">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this user?</h3>
                                            <form action="delete_user.php" method="post">
                                                <input type="hidden" value="<?= urlencode($row['user_id']) ?>" name="id">
                                                <button data-modal-hide="popup-modal-<?= urlencode($row['user_id']) ?>" type="submit" id="confirm-redirect" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Yes, I'm sure
                                                </button>
                                            </form>
                                            <button data-modal-hide="popup-modal-<?= urlencode($row['user_id']) ?>" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No user found</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>