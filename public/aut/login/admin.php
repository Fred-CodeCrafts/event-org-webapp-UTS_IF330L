<?php
session_start();

require '../assets/includes/auth_functions.php';
require '../assets/includes/datacheck.php';
require '../assets/includes/security_functions.php';

// Check if user is already logged in
if (isset($_SESSION['auth']) && $_SESSION['auth'] === 'admin_loggedin') {
    header("Location: ../../admin/admin_dashboard.php");
    exit();
}

// Process login when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginsubmit'])) {
    // Sanitize input
    foreach ($_POST as $key => $value) {
        $_POST[$key] = _cleaninjections(trim($value));
    }

    // Verify CSRF token
    if (!verify_csrf_token()) {
        $_SESSION['STATUS']['loginstatus'] = 'Request could not be validated';
        header("Location: admin.php");
        exit();
    }

    require '../assets/setup/db.inc.php';

    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check for empty fields
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['STATUS']['loginstatus'] = 'Fields cannot be empty';
        header("Location: admin.php");
        exit();
    }

    // SQL query to fetch admin details
    $sql = "SELECT * FROM admin WHERE username=? AND email=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
        header("Location: admin.php");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if user exists
        if ($row = mysqli_fetch_assoc($result)) {
            // Direct password comparison
            if ($password !== $row['password']) {
                $_SESSION['ERRORS']['wrongpassword'] = 'Wrong password';
                header("Location: admin.php");
                exit();
            } else {
                // Set session variables for logged in admin
                $_SESSION['auth'] = 'admin_loggedin';
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $row['username'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['last_login_at'] = $row['created_at'];

                // Update last login time
                // $sql = "UPDATE admin SET last_login_at=NOW() WHERE id=?;";
                // $stmt = mysqli_stmt_init($conn);
                // if (mysqli_stmt_prepare($stmt, $sql)) {
                //     mysqli_stmt_bind_param($stmt, "i", $row['id']);
                //     mysqli_stmt_execute($stmt);
                // }

                // Redirect to admin dashboard
                header("Location: ../../admin/admin_dashboard.php");
                exit();
            }
        } else {
            $_SESSION['ERRORS']['nouser'] = 'Admin username or email does not exist';
            header("Location: admin.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Login as Admin</h2>
            <form action="admin.php" method="post">
                <?php insert_csrf_token(); ?>

                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" name="username" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-indigo-200" required>
                    <span class="text-red-500">
                        <?php if (isset($_SESSION['ERRORS']['nouser'])): ?>
                            <?php echo $_SESSION['ERRORS']['nouser']; unset($_SESSION['ERRORS']['nouser']); ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-indigo-200" required>
                    <span class="text-red-500">
                        <?php if (isset($_SESSION['ERRORS']['noemail'])): ?>
                            <?php echo $_SESSION['ERRORS']['noemail']; unset($_SESSION['ERRORS']['noemail']); ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-indigo-200" required>
                    <span class="text-red-500">
                        <?php if (isset($_SESSION['ERRORS']['wrongpassword'])): ?>
                            <?php echo $_SESSION['ERRORS']['wrongpassword']; unset($_SESSION['ERRORS']['wrongpassword']); ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div>
                    <button type="submit" name="loginsubmit" class="w-full bg-indigo-500 text-white py-2 rounded hover:bg-indigo-600">Login</button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <p>
                    <a href="../register/" class="text-indigo-500 hover:underline">Register</a>
                </p>
                <p>
                    <a href="../reset-password/" class="text-indigo-500 hover:underline">Forgot password?</a>
                </p>
                <div class="mt-4">
                    <a href="index.php" class="text-indigo-500 hover:underline">Back to Index</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
