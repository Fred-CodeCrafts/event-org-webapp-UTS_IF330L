<?php 

define('DB_HOST', 'localhost');
define('DB_NAME', 'utslec');
define('DB_USER', 'root');
define('DB_PASS', '');

require '../assets/includes/auth_functions.php';
require '../assets/includes/security_functions.php';

generate_csrf_token();
check_remember_me();

// kalau mau pake ini tinggal connectDB()->....
function connectDB() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        return $pdo;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}