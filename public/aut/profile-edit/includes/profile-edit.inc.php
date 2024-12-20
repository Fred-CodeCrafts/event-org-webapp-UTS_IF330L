<?php
session_start();

require '../../assets/includes/security_functions.php';
require '../../assets/includes/auth_functions.php';
require '../../assets/vendor/PHPMailer/src/Exception.php';
require '../../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../../assets/vendor/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['update-profile'])) {

    foreach($_POST as $key => $value){
        $_POST[$key] = _cleaninjections(trim($value));
    }

    if (!verify_csrf_token()){
        $_SESSION['STATUS']['editstatus'] = 'Request could not be validated';
        header("Location: ../");
        exit();
    }

    require '../../assets/setup/db.inc.php';
    require '../../assets/includes/datacheck.php';

    // Get the POST data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $headline = $_POST['headline'];
    $bio = $_POST['bio'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : NULL;
    $oldPassword = $_POST['password'];
    $newpassword = $_POST['newpassword'];
    $passwordrepeat  = $_POST['confirmpassword'];

    // Validate email and username
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['ERRORS']['emailerror'] = 'Invalid email, try again';
        header("Location: ../");
        exit();
    } 
    if ($_SESSION['email'] != $email && !availableEmail($conn, $email)) {
        $_SESSION['ERRORS']['emailerror'] = 'Email already taken';
        header("Location: ../");
        exit();
    }
    if ($_SESSION['username'] != $username && !availableUsername($conn, $username)) {
        $_SESSION['ERRORS']['usernameerror'] = 'Username already taken';
        header("Location: ../");
        exit();
    } else {
        $FileNameNew = $_SESSION['profile_image'];
        $file = $_FILES['avatar'];

        // Handle file upload
        if (!empty($_FILES['avatar']['name'])) {
            $fileName = $_FILES['avatar']['name'];
            $fileTmpName = $_FILES['avatar']['tmp_name'];
            $fileSize = $_FILES['avatar']['size'];
            $fileError = $_FILES['avatar']['error'];
            $fileType = $_FILES['avatar']['type']; 

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 10000000) {
                        $FileNameNew = uniqid('', true) . "." . $fileActualExt;
                        $fileDestination = '../../assets/uploads/users/' . $FileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                        if ($_SESSION['profile_image'] != "_defaultUser.png") {
                            if (!unlink('../../assets/uploads/users/' . $_SESSION['profile_image'])) {  
                                $_SESSION['ERRORS']['imageerror'] = 'Old image could not be deleted';
                                header("Location: ../");
                                exit();
                            } 
                        }
                    } else {
                        $_SESSION['ERRORS']['imageerror'] = 'Image size should be less than 10MB';
                        header("Location: ../");
                        exit(); 
                    }
                } else {
                    $_SESSION['ERRORS']['imageerror'] = 'Image upload failed, try again';
                    header("Location: ../");
                    exit();
                }
            } else {
                $_SESSION['ERRORS']['imageerror'] = 'Invalid image type, try again';
                header("Location: ../");
                exit();
            }
        }

        // Check for password update
        $passwordUpdated = false; // Initialize
        if (!empty($oldPassword) || !empty($newpassword) || !empty($passwordrepeat)) {
            include 'password-edit.inc.php';
            $passwordUpdated = true; // Set to true if password update is handled
        }
        
        // Prepare the SQL query
        $sql = "UPDATE user
            SET username=?, email=?, first_name=?, last_name=?, gender=?, headline=?, bio=?, profile_image=?";

        if ($passwordUpdated) {
            $sql .= ", password=? WHERE user_id=?;";
        } else {
            $sql .= " WHERE user_id=?;";
        }

        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
            header("Location: ../");
            exit();
        } else {
            if ($passwordUpdated) {
                $hashedPwd = password_hash($newpassword, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ssssssssss", 
                    $username,
                    $email,
                    $first_name,
                    $last_name,
                    $gender,
                    $headline,
                    $bio, 
                    $FileNameNew,
                    $hashedPwd,
                    $_SESSION['user_id'] // Change this to match your session variable
                );
            } else {
                mysqli_stmt_bind_param($stmt, "sssssssss", 
                    $username,
                    $email,
                    $first_name,
                    $last_name,
                    $gender,
                    $headline,
                    $bio, 
                    $FileNameNew,
                    $_SESSION['user_id'] // Change this to match your session variable
                );
            }

            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            // Update session variables
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['gender'] = $gender;
            $_SESSION['headline'] = $headline;
            $_SESSION['bio'] = $bio;
            $_SESSION['profile_image'] = $FileNameNew;

            $_SESSION['STATUS']['editstatus'] = 'Profile successfully updated';
            header("Location: ../");
            exit();
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../");
    exit();
}
