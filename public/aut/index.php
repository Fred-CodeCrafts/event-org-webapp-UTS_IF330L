<?php

if (isset($_SESSION['auth'])) {

    header("Location: /utslec/public/aut/user/home.php");
    exit();
}
else {

    header("Location: login");
    exit();
}
