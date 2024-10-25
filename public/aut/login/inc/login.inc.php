<?php

session_start();

require '../../assets/includes/auth_functions.php';
require '../../assets/includes/datacheck.php';
require '../../assets/includes/security_functions.php';

check_logged_out();

if (!isset($_POST['loginsubmit'])) {
    header("Location: ../");
    exit();
} else {

    foreach($_POST as $key => $value) {
        $_POST[$key] = _cleaninjections(trim($value));
    }

    if (!verify_csrf_token()) {
        $_SESSION['STATUS']['loginstatus'] = 'Request could not be validated';
        header("Location: ../");
        exit();
    }

    require '../../assets/setup/db.inc.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['STATUS']['loginstatus'] = 'Fields cannot be empty';
        header("Location: ../");
        exit();
    } else {
        $sql = "UPDATE user SET last_login_at=NOW() WHERE username=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
            header("Location: ../");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
        }

        $sql = "SELECT * FROM user WHERE username=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
            header("Location: ../");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($password, $row['password']);

                if ($pwdCheck == false) {
                    $_SESSION['ERRORS']['wrongpassword'] = 'Wrong password';
                    header("Location: ../");
                    exit();
                } else if ($pwdCheck == true) {
                    $_SESSION['auth'] = 'loggedin';
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                    $_SESSION['gender'] = $row['gender'];
                    $_SESSION['headline'] = $row['headline'];
                    $_SESSION['bio'] = $row['bio'];
                    $_SESSION['profile_image'] = $row['profile_image'];
                    $_SESSION['created_at'] = $row['created_at'];
                    $_SESSION['last_login_at'] = $row['last_login_at'];
                    $_SESSION['remember_me_selector'] = $row['remember_me_selector'];
                    $_SESSION['remember_me_token'] = $row['remember_me_token'];
                    $_SESSION['password_reset_token'] = $row['password_reset_token'];
                    $_SESSION['password_reset_expires_at'] = $row['password_reset_expires_at'];

    
                    if (isset($_POST['rememberme'])) {
                        $selector = bin2hex(random_bytes(8));
                        $token = random_bytes(32);
                        $sql = "UPDATE user SET remember_me_selector=?, remember_me_token=?, last_login_at=? WHERE email=?;";
                        $stmt = mysqli_stmt_init($conn);

                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
                            header("Location: ../");
                            exit();
                        } else {
                            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ssss", $selector, $hashedToken, date('Y-m-d H:i:s'), $_SESSION['email']);
                            mysqli_stmt_execute($stmt);
                        }
                        setcookie(
                            'rememberme',
                            $selector . ':' . bin2hex($token),
                            time() + 864000, // 10 days
                            '/',
                            NULL,
                            false,
                            true
                        );
                    }

                   
                    header("Location: /utslec/public/aut/user/home.php");
                    exit();
                }
            } else {
                
                $_SESSION['ERRORS']['nouser'] = 'Username does not exist';
                header("Location: ../");
                exit();
            }
        }
    }
}
