<?php
    session_start();

    require '../assets/includes/auth_functions.php';
    require '../assets/includes/security_functions.php';
    
    generate_csrf_token();
    check_remember_me();
?>