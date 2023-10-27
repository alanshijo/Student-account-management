<?php
if (!isset($_SESSION['username'])) {
    header('Location:../index.php');
}
if (isset($_POST['sign_out_btn'])) {
    if (session_destroy()) {
        header('Location:../index.php');
    }
}
?>
<nav class="navbar" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a href="./index.php" class="navbar-brand text-uppercase fw-bold text-danger">Dashboard</a>
        <form action="" method="post" class="d-flex">
            <button class="btn btn-outline-danger" type="submit" name="sign_out_btn">Sign out</button>
        </form>
    </div>
</nav>