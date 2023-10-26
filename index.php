<?php
include("./config.php");
session_start();
$username_check = $password_check = true;

if (isset($_POST['btn_login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username)) {
        $username_check = false;
        $username_error_msg = 'Username is required';
    }
    if (empty($password)) {
        $password_check = false;
        $password_error_msg = 'Password is required';
    }
    if ($username_check && $password_check) {
        $sql = "SELECT * FROM `tbl_users` WHERE `username` = '$username'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            if (password_verify($password, $data['password'])) {
                $_SESSION['user_id'] = $data['user_id'];
                $_SESSION['username'] = $data['username'];
                header('Location: User/index.php');
            } else {
                $msg = 'Invalid user credentials';
            }
        } else {
            $msg = 'User doesn\'t exist';
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <h1 class="mt-5 text-center">Sign In</h1>
    <form action="" method="POST" class="container-fluid w-50 mt-5 shadow-sm p-3 mb-5 bg-body-tertiary rounded">
        <?php if (isset($msg)) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?= $msg; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <div class="mb-3">
            <label for="username" class="form-label text-muted">Username</label>
            <input type="text" class="form-control <?php echo $username_check ? '' : 'is-invalid'; ?>" id="username" name="username">
            <?php if (!$username_check) ?>
            <div class="invalid-feedback">
                <?= $username_error_msg; ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label text-muted">Password</label>
            <input type="password" class="form-control <?php echo $password_check ? '' : 'is-invalid'; ?>" id="password" name="password">
            <?php if (!$password_check) ?>
            <div class="invalid-feedback">
                <?= $password_error_msg; ?>
            </div>
        </div>
        <div class="d-grid gap-2 mb-3">
            <button class="btn btn-success" type="submit" name="btn_login">Log in</button>
        </div>
        <div class="d-flex justify-content-center">
            <a href="register.php" class="text-decoration-none">Don't have an account? Register here!</a>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>