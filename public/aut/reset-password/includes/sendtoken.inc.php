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

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function generateRandomToken($length = 6) {
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= mt_rand(0, 9);
    }
    return $token; 
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';

    if (empty($email)) {
        $error = "Please fill in the email field.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            $error = "No account found with that email. Please check your details and try again.";
        } else {
            $newPassword = generateRandomToken(); 
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE user SET password = ? WHERE email = ?");
            $stmt->execute([$hashedPassword, $email]);
            
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->Username = "Fg.cygnus468@gmail.com"; 
                $mail->Password = "cgln mzwz wzfv tqzn"; 
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom("fg.cygnus468@gmail.com", "Event Website");
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = "Your Temporary Password";
                $mail->Body = "Your password has been reset. Here is your new password: <strong>$newPassword</strong><br>
                               Please log in using this password and change it manually through your profile page after logging in.";

                $mail->send();
                $success = "A new password has been sent to your email. Please log in and change it manually through your profile page.";
            } catch (Exception $e) {
                $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

<div class="container mx-auto max-w-md p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-center text-2xl font-semibold mb-6 text-gray-800">Password Reset Status</h2>
    <div class="text-center mt-4">
        <?php if ($error): ?>
            <div class="text-red-600"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="text-green-600"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <a href="http://localhost/kk/public/aut/login/index.php" class="text-sm text-blue-600 hover:underline">Back to Login</a>
        </div>
</div>

</body>
</html>
