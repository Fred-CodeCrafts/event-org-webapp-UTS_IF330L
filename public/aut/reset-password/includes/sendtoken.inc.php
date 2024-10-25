<?php
session_start();

require '../../assets/includes/security_functions.php';
require '../../assets/includes/auth_functions.php';
check_logged_out();

require '../../assets/setup/env.php';
require '../../assets/setup/db.inc.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../assets/vendor/PHPMailer/src/Exception.php';
require '../../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../../assets/vendor/PHPMailer/src/SMTP.php';

if (isset($_POST['resentsend'])) {

    // Clean input
    foreach($_POST as $key => $value) {
        $_POST[$key] = _cleaninjections(trim($value));
    }

    // Generate selector, token, and URL for reset
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = "http://localhost/utslec/public/aut/reset-password/?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));

    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['ERRORS']['emailerror'] = 'Invalid email address';
        header("Location: ../");
        exit();
    }

    $sql = "SELECT user_id FROM user WHERE email=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
        header("Location: ../");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 0) {
            $_SESSION['ERRORS']['emailerror'] = 'Given email does not exist in our records';
            header("Location: ../");
            exit();
        }
    }
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    $sql = "UPDATE user SET password_reset_token=?, password_reset_expires_at=? WHERE email=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
        header("Location: ../");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "sss", $hashedToken, $expires, $email);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    $to = $email;
    $subject = 'Reset Your Password';

    $mail_variables = array(
        'APP_NAME' => APP_NAME,
        'email' => $email,
        'url' => $url
    );

    $message = file_get_contents("./template_passwordresetemail.php");
    foreach ($mail_variables as $key => $value) {
        $message = str_replace('{{ '.$key.' }}', $value, $message);
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = MAIL_ENCRYPTION;
        $mail->Port = MAIL_PORT;

        $mail->setFrom(MAIL_USERNAME, APP_NAME);
        $mail->addAddress($to, APP_NAME);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
    } catch (Exception $e) {
        $_SESSION['STATUS']['mailstatus'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        header("Location: ../");
        exit();
    }

    $_SESSION['STATUS']['resentsend'] = 'Verification email sent';
    header("Location: ../");
    exit();
} else {
    header("Location: ../");
    exit();
}
