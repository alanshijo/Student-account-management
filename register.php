<?php
include("./config.php");
session_start();
$username_check = $password_check = $confirm_password_check = $same_password_check = true;
if (isset($_POST['btn_register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if (empty($username)) {
        $username_check = false;
        $username_error_msg = 'Username is required';
    } else {
        if (!preg_match('/^[a-zA-Z0-9]*$/', $username)) {
            $username_check = false;
            $username_error_msg = 'Username must contain only letters and numbers';
        }
    }
    if (empty($password)) {
        $password_check = false;
        $password_error_msg = 'Password is required';
    } else {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+-]).{8,}$/', $password)) {
            $password_check = false;
            $password_error_msg = 'Password must contain At least one lowercase letter, At least one uppercase letter, At least one digit, At least one special character, Be at least 8 characters long';
        }
    }
    if (empty($confirm_password)) {
        $confirm_password_check = false;
        $confirm_password_error_msg = 'Confirm password is required';
    } else {
        if ($password !== $confirm_password) {
            $confirm_password_check = false;
            $confirm_password_error_msg = 'Passwords aren\'t match';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        }
    }
    if ($username_check && $password_check && $confirm_password_check) {
        $check_exists_sql = "SELECT `username` FROM `tbl_users` WHERE `username` = '$username'";
        $check_exists_result = $conn->query($check_exists_sql);
        if ($check_exists_result->num_rows > 0) {
            $msg = 'Username/account already exists';
        } else {
            $sql = "INSERT INTO `tbl_users`(`username`, `password`) VALUES ('$username','$hashed_password')";
            if ($conn->query($sql)) {
                header("Location: ./index.php");
                $_SESSION['msg'] = 'Account created successfully';
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <h1 class="mt-5 text-center">Register an account</h1>
    <form onsubmit="return valid();" id="registerForm" action="" method="POST" class="container-fluid mt-5 w-50 shadow-sm p-3 mb-5 bg-body-tertiary rounded">
        <?php if (isset($msg)) { ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong><?= $msg; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <div class="mb-3">
            <label for="username" class="form-label text-muted">Username</label>
            <input type="text" class="form-control <?php echo $username_check ? '' : 'is-invalid'; ?>" id="username" name="username">
            <?php if (!$username_check) ?>
            <div class="invalid-feedback" id="usernameErrorMsg">
                <?= $username_error_msg; ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label text-muted">Password</label>
            <input type="password" class="form-control <?php echo $password_check ? '' : 'is-invalid'; ?>" id="password" name="password">
            <?php if (!$password_check) ?>
            <div class="invalid-feedback" id="passwordErrorMsg">
                <?= $password_error_msg; ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label text-muted">Confirm Password</label>
            <input type="password" class="form-control <?php echo $confirm_password_check ? '' : 'is-invalid'; ?>" id="confirmPassword" name="confirm_password">
            <?php if (!$confirm_password_check) ?>
            <div class="invalid-feedback" id="confirmPasswordErrorMsg">
                <?= $confirm_password_error_msg; ?>
            </div>
        </div>
        <div class="d-grid gap-2 mb-3">
            <button class="btn btn-success" type="submit" name="btn_register">Sign up</button>
        </div>
        <div class="d-flex justify-content-center">
            <a href="index.php" class="text-decoration-none">Already registered? Log In</a>
        </div>
    </form>
    <script src="js/registerScript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>