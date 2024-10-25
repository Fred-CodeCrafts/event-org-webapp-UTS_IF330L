<?php

if (isset($_POST['update-profile'])) {
    // Ensure old password, new password, and repeated password are set
    if (!empty($oldPassword) && !empty($newpassword) && !empty($passwordrepeat)) {
        $sql = "SELECT password FROM user WHERE user_id=?;";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
            header("Location: ../");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                // Verify the old password
                $pwdCheck = password_verify($oldPassword, $row['password']);

                if ($pwdCheck == false) {
                    $_SESSION['ERRORS']['passworderror'] = 'incorrect current password';
                    header("Location: ../");
                    exit();
                }
                if ($oldPassword == $newpassword) {
                    $_SESSION['ERRORS']['passworderror'] = 'new password cannot be same as old password';
                    header("Location: ../");
                    exit();
                }
                if ($newpassword !== $passwordrepeat) {
                    $_SESSION['ERRORS']['passworderror'] = 'confirmed password does not match new password';
                    header("Location: ../");
                    exit();
                }

                // If all checks pass, update the password
                $hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);
                $updateSql = "UPDATE user SET password=? WHERE user_id=?;";
                $updateStmt = mysqli_stmt_init($conn);
                
                if (!mysqli_stmt_prepare($updateStmt, $updateSql)) {
                    $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR during update';
                    header("Location: ../");
                    exit();
                } else {
                    mysqli_stmt_bind_param($updateStmt, "ss", $hashedPassword, $_SESSION['id']);
                    mysqli_stmt_execute($updateStmt);
                    // Optionally set a success message
                    $_SESSION['STATUS']['updateStatus'] = 'Password updated successfully';
                    header("Location: ../");
                    exit();
                }
            } else {
                $_SESSION['ERRORS']['nouser'] = 'User not found';
                header("Location: ../");
                exit();
            }
        }
    } else {
        $_SESSION['ERRORS']['passworderror'] = 'password fields cannot be empty for password updation';
        header("Location: ../");
        exit();
    }
} else {
    header("Location: ../");
    exit();
}
