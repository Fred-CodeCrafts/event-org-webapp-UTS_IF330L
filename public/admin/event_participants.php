<?php
require_once('../DB.php');

$sql = "SELECT e.nama as eventName,u.nama as nama, u.username as user,u.email as email
        FROM event_participants ep
        JOIN event e
        USING (event_id)
        JOIN user u
        USING (user_id)
        WHERE e.event_id = :id";

$stmt = connectDB()->prepare($sql);
$id = $_GET["event_id"];
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($participants)) {
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    $eventName = $name['eventName'];
}else{
    $sql = "SELECT nama as eventName FROM event ep WHERE event_id = :id";
    $stmt = connectDB()->prepare($sql);
    $id = $_GET["event_id"];
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $name = $stmt->fetch(PDO::FETCH_ASSOC);
    $eventName = $name['eventName'];
}


if (isset($_GET['csv'])) {
    ob_end_clean();
    
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment;filename='.htmlspecialchars($eventName).'registrations.csv');
    $output = fopen('php://output', 'w');

    fputcsv($output, ['Username', 'Email', 'Event Title']);

    foreach($participants as $participant){
        fputcsv($output, [
            $participant['nama'],   
            $participant['email'], 
            $participant['eventName'] 
        ]);
    }

    fclose($output);

    exit();
}

if(isset($_GET['xlxs'])){
    require_once('xlsxwriter.php');

    header('Content-disposition: attachment; filename="' . htmlspecialchars($eventName) . 'Participants.xlsx"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Cache-Control: max-age=0');

    $writer = new XLSXWriter();
    $writer->writeSheetHeader('Sheet1', ['Name' => 'string', 'Username' => 'string', 'Email' => 'string']);

    foreach($participants as $participant) {
        $writer->writeSheetRow('Sheet1', [$participant['nama'], $participant['user'], $participant['email']]);
    }

    $writer->writeToStdOut();
    exit();
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <title><?= htmlspecialchars($eventName) ?> Participants</title>
</head>

<body>
    <h1 class="text-4xl text-center"><?= htmlspecialchars($eventName) ?> Participants</h1>
    <div class="mt-10 p-3 relative overflow-x-auto shadow-md rounded-lg dark:bg-gray-900">
        <div class="flex flex-row p-3">
            <a href="admin_dashboard.php" class="flex flex-row mr-4 p-2 items-center text-white bg-gradient-to-r from-amber-500 via-amber-600 to-amber-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-amber-300 dark:focus:ring-amber-800 font-medium rounded-lg text-sm px-5 py-2.5">
                <svg class="w-6 h-6 mr-3 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                </svg>
                Back to dashboard
            </a>
            <?php if (!empty($participants)) { ?>
            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Download participants <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
            </button>
            <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <li>
                    <a href="event_participants.php?event_id=<?= $id ?>&csv" class="text-[21px] block p-2 mx-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">.csv</a>
                </li>
                <li>
                    <a href="event_participants.php?event_id=<?= $id ?>&xlxs" class="text-[21px] block p-2 mx-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">.xls</a>
                </li>
                </ul>
            </div>
        </div>
        <div class="relative overflow-x-auto p-6">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border dark:border-transparent">
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
                    </tr>
                </thead>
                <tbody>
                    <?php  foreach($participants as $participant):?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="ps-2">
                                    <div class="text-base font-semibold"><?= htmlspecialchars($participant['nama']) ?></div>
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                <?= htmlspecialchars($participant['user']) ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= htmlspecialchars($participant['email']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } else { ?>
        <p>No user registered</p>
    <?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>

</html>