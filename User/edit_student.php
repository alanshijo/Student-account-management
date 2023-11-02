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
if (isset($_POST['btn_edit'])) {
    $_SESSION['student_id'] = $_POST['btn_edit'];
}
$student = "SELECT * FROM `tbl_students` WHERE `student_id` = '{$_SESSION['student_id']}'";
$student_result = $conn->query($student);
$student_data = $student_result->fetch_assoc();
$first_name_check = $last_name_check = $dob_check = $phone_check = $email_check = $address_check = $photo_check = true;
if (isset($_POST['btn_edit_student'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $phone_number = $_POST['phone_num'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $student_photo = $_FILES['student_img'];
    if (empty($first_name)) {
        $first_name_check = false;
        $first_name_error_msg = 'First name is required';
    } else {
        if (!preg_match('/^[a-zA-Z]+$/', $first_name)) {
            $first_name_check = false;
            $first_name_error_msg = 'Alphabets only';
        }
    }
    if (empty($last_name)) {
        $last_name_check = false;
        $last_name_error_msg = 'Last name is required';
    } else {
        if (!preg_match('/^[a-zA-Z]+$/', $last_name)) {
            $last_name_check = false;
            $last_name_error_msg = 'Alphabets only';
        }
    }
    if (empty($dob)) {
        $dob_check = false;
        $dob_error_msg = 'Date of Birth is required';
    }
    if (empty($phone_number)) {
        $phone_check = false;
        $phone_error_msg = 'Phone number is required';
    } else {
        if (!preg_match('/^(?!(\d)\1{9})(?!0123456789|1234567890|0987654321)\d{10}$/', $phone_number)) {
            $phone_check = false;
            $phone_error_msg = 'Invalid Phone Number';
        }
    }
    if (empty($email)) {
        $email_check = false;
        $email_error_msg = 'Phone number is required';
    } else {
        if (!preg_match('/^[0-9a-zA-Z-_\$#]+@[0-9a-zA-Z-_\$#]+\.[a-zA-Z]{2,5}/', $email)) {
            $email_check = false;
            $email_error_msg = 'Invalid Email Address';
        }
    }
    if (empty($address)) {
        $address_check = false;
        $address_error_msg = 'Address is required';
    }
    if (is_uploaded_file($student_photo['tmp_name'])) {
        $valid_extensions = array('image/jpeg', 'image/png');
        if (!in_array($student_photo['type'], $valid_extensions)) {
            $photo_check = false;
            $photo_error_msg = 'The photo isn\'t in jpg, jpeg or png format';
        }
        if ($student_photo['size'] > 2097152) {
            $photo_check = false;
            $photo_error_msg = "The photo size is larger than 2MB";
        }
    }
    if ($first_name_check && $last_name_check && $dob_check && $phone_check && $email_check && $address_check && $photo_check) {
        function updateStudentData()
        {
            global $conn, $student_data, $student_photo, $first_name, $last_name, $dob, $phone_number, $email, $address;
            if (is_uploaded_file($student_photo['tmp_name'])) {
                $img_file_name = $student_photo['name'];
                $target_directory = '../Uploads/';
                move_uploaded_file($student_photo['tmp_name'], $target_directory . $img_file_name);
            } else {
                $img_file_name = $student_data['student_img'];
            }
            $update_student = "UPDATE `tbl_students` SET `first_name`='$first_name',`last_name`='$last_name',`dob`='$dob',`phone_number`='$phone_number',`email_address`='$email',`address`='$address',`student_img`='$img_file_name',`updated_at`= NOW() WHERE `student_id` = '{$_SESSION['student_id']}'";
            if ($conn->query($update_student)) {
                header("Location: index.php");
                $_SESSION['msg'] = 'The student data has been successfully updated';
            }
        }
        $check_exists = "SELECT * FROM `tbl_students` WHERE `email_address` = '$email'";
        $check_exists_result = $conn->query($check_exists);
        if ($check_exists_result->num_rows > 0) {
            $check_exists_current_user = "SELECT * FROM `tbl_students` WHERE `email_address` = '$email' AND `email_address` = '{$student_data['email_address']}'";
            $check_exists_current_user_result = $conn->query($check_exists_current_user);
            if ($check_exists_current_user_result->num_rows > 0) {
                updateStudentData();
            } else {
                $msg = 'A student with the email address already exists';
            }
        } else {
            updateStudentData();
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Student</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Edit student details</li>
                </ol>
            </div>
            <form action="" method="post" class="d-flex">
                <button class="btn btn-outline-danger" type="submit" name="sign_out_btn">Sign out</button>
            </form>
        </div>
    </nav>
    <h1 class="mt-5 text-center">Update student data</h1>
    <form id="studentForm" onsubmit="return valid();" action="" method="POST" enctype="multipart/form-data" class="container-fluid mt-5 w-50 shadow-sm p-3 mb-5 bg-body-tertiary rounded">
        <?php if (isset($msg)) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?= $msg; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <div class="row g-3 mb-3">
            <div class="col">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" value="<?= $student_data['first_name']; ?>" class="form-control <?= $first_name_check ? '' : 'is-invalid'; ?>" placeholder="First name" id="first_name" name="first_name">
                <div class="invalid-feedback" id="fname_error"></div>
                <?php if (!$first_name_check) { ?>
                    <div class="invalid-feedback">
                        <?= $first_name_error_msg; ?>
                    </div>
                <?php } ?>
            </div>
            <div class="col">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" value="<?= $student_data['last_name']; ?>" class="form-control <?= $last_name_check ? '' : 'is-invalid'; ?>" placeholder="Last name" id="last_name" name="last_name">
                <div class="invalid-feedback" id="lname_error"></div>
                <?php if (!$last_name_check) { ?>
                    <div class="invalid-feedback">
                        <?= $last_name_error_msg; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" value="<?= $student_data['dob']; ?>" class="form-control <?= $dob_check ? '' : 'is-invalid'; ?>" placeholder="DD/MM/YYYY" id="dob" name="dob">
                <div class="invalid-feedback" id="dob_error"></div>
                <?php if (!$dob_check) { ?>
                    <div class="invalid-feedback">
                        <?= $dob_error_msg; ?>
                    </div>
                <?php } ?>
            </div>
            <div class="col">
                <label for="phone_num" class="form-label">Phone Number</label>
                <input type="tel" value="<?= $student_data['phone_number']; ?>" class="form-control <?= $phone_check ? '' : 'is-invalid'; ?>" placeholder="10 digit phone number" id="phone_num" name="phone_num">
                <div class="invalid-feedback" id="phone_error"></div>
                <?php if (!$phone_check) { ?>
                    <div class="invalid-feedback">
                        <?= $phone_error_msg; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" value="<?= $student_data['email_address']; ?>" id="email" name="email" placeholder="Your email address" class="form-control <?= $email_check ? '' : 'is-invalid'; ?>">
            <div class="invalid-feedback" id="email_error"></div>
            <?php if (!$email_check) { ?>
                <div class="invalid-feedback">
                    <?= $email_error_msg; ?>
                </div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" value="<?= $student_data['address']; ?>" id="address" name="address" placeholder="Permanent address" class="form-control <?= $address_check ? '' : 'is-invalid'; ?>">
            <div class="invalid-feedback" id="address_error"></div>
            <?php if (!$address_check) { ?>
                <div class="invalid-feedback">
                    <?= $address_error_msg; ?>
                </div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="student_img" class="form-label">Student Photo</label>
            <div class="row">
                <div class="col">
                    <img id="img_preview" src="../Uploads/<?= $student_data['student_img']; ?>" class="img-fluid" alt="<?= $student_data['student_img']; ?>" width="200px" height="200px">

                    <input type="hidden" id="img_file_name" value="<?= $student_data['student_img']; ?>" class="form-control border-0 bg-body-tertiary" style="font-size: small;">
                </div>
                <div class="col">
                    <input class="form-control <?= $photo_check ? '' : 'is-invalid'; ?>" type="file" id="student_img" name="student_img">
                    <span class="fst-italic text-muted fw-lighter">The photo size should be less than 2MB and only jpeg, jpg and png formats are supported.</span>
                    <div class="invalid-feedback" id="img_error"></div>
                    <?php if (!$photo_check) { ?>
                        <div class="invalid-feedback">
                            <?= $photo_error_msg; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="submit" name="btn_edit_student">Update student data</button>
        </div>
    </form>
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>