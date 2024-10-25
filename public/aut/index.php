<?php

if (isset($_SESSION['auth'])) {
    echo "index utama";
    header("Location: user/home.php");
    exit();
} else {
    header("Location: login");
    exit();
}
