<?php
    $dsn = "mysql:host=localhost;dbname=uts";
    $kunci = new PDO($dsn,"root","");

    $sql = "SELECT * FROM event";
    $hasil = $kunci->query($sql);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet">
    <title>event</title>
</head>
<body class="bg-gray-100 p-4 ">
    <div class="flex justify-items-center items-center">
        <div class="max-w-lg bg-white shadow-md rounded-lg p-6">
            <div class="btn bg-green-500"><a href="create_event.html">Create Event</a></div>
        </div>
    </div>
    
    <?php if ($hasil->rowCount() > 0): ?>
        <div class="grid grid-cols-4 gap-4">
            <?php while($row = $hasil->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img class="rounded-t-lg" src=<?= "gambar/" . $row['gambar']?> />
                    </a>
                    <div class="p-5">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?= $row['nama'] ?></h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?= $row['tgl_mulai'] . ' ~ ' . $row['tgl_akhir']  ?></p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?= $row['waktu_mulai'] . ' - ' . $row['waktu_berakhir']  ?></p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?= $row['lokasi']  ?></p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?= $row['kapasitas']  ?></p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><?= $row['deskripsi']  ?></p>
                        <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No events found</p>
    <?php endif; ?>

    <script src="../../node_modules/flowbite/dist/flowbite.min.js"></script>
    
</body>
</html>