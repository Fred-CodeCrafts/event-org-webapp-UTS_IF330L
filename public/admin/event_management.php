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
<body class="bg-gray-100 p-4">
    <div class="max-w-lg bg-white shadow-md rounded-lg p-6">
        <div class="btn bg-green-500"><a href="add_event.php">Tambah Event</a></div>
    </div>
    
    
</body>
</html>