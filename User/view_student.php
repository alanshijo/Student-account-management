<?php
include("../config.php");
session_start();
if (!isset($_SESSION['username'])) {
    header('Location:../index.php');
}
if (isset($_POST['sign_out_btn'])) {
    if (session_destroy()) {
        header('Location:../index.php');
    }
}
if (isset($_POST['btn_view'])) {
    $student_id = $_POST['btn_view'];
    $student = "SELECT * FROM `tbl_students` WHERE `student_id` = '$student_id'";
    $student_result = $conn->query($student);
    $student_data = $student_result->fetch_assoc();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <nav class="navbar" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <a href="./index.php" class="navbar-brand text-uppercase fw-bold text-danger mx-4"><img src="./assets/images/logo.png" alt="" width="50" height="50"></a>
                <ol class="breadcrumb mt-3">
                    <li class="breadcrumb-item"><a href="javascript:history.back();" class="text-decoration-none text-danger fw-bold" title="Go home"><i class="fas fa-chevron-left mx-2"></i>Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student - <strong><?= $student_data['first_name'] . ' ' . $student_data['last_name']; ?></strong></li>
                </ol>
            </div>
            <form action="" method="post" class="d-flex">
                <button class="btn btn-outline-danger" type="submit" name="sign_out_btn">Sign out</button>
            </form>
        </div>
    </nav>
    <div class="container-fluid w-25">
        <div class="shadow-sm p-3 mb-5 bg-body-tertiary rounded mt-5 text-center">
            <img src="../Uploads/<?= $student_data['student_img']; ?>" width="240px" height="240px" class="img-thumbnail rounded mx-auto d-block" alt="...">
            <h2 class="text-danger text-uppercase fw-bold my-3"><?= $student_data['first_name'] . ' ' . $student_data['last_name'];; ?></h2>
            <p class="text-success fw-semibold"><?= date("d/m/Y", strtotime($student_data['dob'])); ?></p>
            <div class="d-flex flex-column align-items-start mx-5">
                <p><strong>Phone: </strong> <?= $student_data['phone_number']; ?></p>
                <p><strong>Email: </strong> <?= $student_data['email_address']; ?></p>
                <p><strong>Address: </strong> <?= $student_data['address']; ?></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>