<?php
    require_once('../DB.php');

    $sql = "SELECT COALESCE(CONCAT(first_name, ' ', last_name), first_name) as name, email, username FROM user";
    
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User management</title>
</head>
<body>
    
</body>
</html>