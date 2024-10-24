<?php

if (isset($_SESSION['auth'])) {

    header("Location: ./user/home.php");
    exit();
}
else {

    header("Location: login");
    exit();
}
