<?php
session_start();

require '../../assets/includes/security_functions.php';
require '../../assets/includes/auth_functions.php';
check_logged_out();

require '../../assets/setup/env.php';
require '../../assets/setup/db.inc.php';

if (isset($_POST['resetsubmit'])) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = _cleaninjections(trim($value));
    }

    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = $_POST['newpassword'];
    $passwordRepeat = $_POST['confirmpassword'];
    if (strlen($selector) !== 16 || strlen($validator) !== 64) {
        $_SESSION['STATUS']['resentsend'] = 'Invalid token format, Please use a new reset email';
        header("Location: ../");
        exit();
    }
    error_log("Selector: " . $selector);
    error_log("Validator: " . $validator);
    if (empty($selector) || empty($validator)) {
        $_SESSION['STATUS']['resentsend'] = 'Invalid token, Please use new reset email';
        header("Location: ../");
        exit();
    }
    if (empty($password) || empty($passwordRepeat)) {
        $_SESSION['ERRORS']['passworderror'] = 'Passwords cannot be empty';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else if ($password != $passwordRepeat) {
        $_SESSION['ERRORS']['passworderror'] = 'Passwords do not match';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
    $sql = "SELECT * FROM user WHERE password_reset_token = ? OR password_reset_expires_at > NOW();";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $selector);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);

        if (!($row = mysqli_fetch_assoc($results))) {
            $_SESSION['STATUS']['resentsend'] = 'Non-existent or expired token, Please use new reset email';
            header("Location: ../");
            exit();
        } else {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row['password_reset_token']);

            if ($tokenCheck === false) {
                $_SESSION['STATUS']['resentsend'] = 'Invalid token, Please use new reset email';
                header("Location: ../");
                exit();
            } else if ($tokenCheck === true) {
                $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                $tokenEmail = $row['email'];

                $sql = 'UPDATE users SET password=?, password_reset_token=NULL, password_reset_expires_at=NULL WHERE email=?;';
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                    mysqli_stmt_execute($stmt);

                    $_SESSION['STATUS']['loginstatus'] = 'Password updated, Please log in';
                    header("Location: ../../login/");
                    exit();
                }
            }
        }
    }
} else {
    header("Location: ../");
    exit();
}
