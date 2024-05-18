<?php
include('../config/dbconnect.php');
include('myAlerts.php');
if(isset($_POST['logButton'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email exists
    $login_query = "SELECT * FROM users WHERE email=?";
    $stmt = mysqli_prepare($con, $login_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1) {
        $userdata = mysqli_fetch_assoc($result);
        $stored_password = $userdata['password'];

        // Verify password
        if(password_verify($password, $stored_password)) {
            $_SESSION['auth'] = true;
            $_SESSION['user_id'] = $userdata['user_id'];
            $_SESSION['auth_user'] = [
                'name' => $userdata['name'],
                'email' => $userdata['email']
            ];

            $role = $userdata['role'];
            $_SESSION['role'] = $role;

            if($role == 1) {
                $_SESSION['message'] = "Welcome to Admin Dashboard";
                header('Location: ../admin/index.php');
            } else {
                $_SESSION['message'] = "Logged in Successfully";
                header('Location: ../homepage.php');
            }
        } else {
            $_SESSION['message'] = "Invalid Credentials";
            header('Location: ../index.php');
        }
    } else {
        $_SESSION['message'] = "Invalid Credentials";
        header('Location: ../index.php');
    }
}
?>
