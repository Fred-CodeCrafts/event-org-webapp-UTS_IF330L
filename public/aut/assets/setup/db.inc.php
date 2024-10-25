<?php

require 'env.php';
function connectDB() {
    define('DB_NAME', 'hary8495_utslec');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'hary8495_alenkeren');
    define('DB_PASS', 'alenkeren');
    
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}

$conn = connectDB();

