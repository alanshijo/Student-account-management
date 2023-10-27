<?php
include("../config.php");
session_start();
$first_name_check = $last_name_check = $dob_check = $phone_check = $email_check = $address_check = $photo_check = true;
if (isset($_POST['btn_add_student'])) {
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
    if ($student_photo['error'] == 4 || ($student_photo['size'] == 0 && $student_photo['error'] == 0)) {
        $photo_check = false;
        $photo_error_msg = 'Photo is required';
    } else {
        $valid_extensions = array('image/jpeg', 'image/png');
        if (!in_array($student_photo['type'], $valid_extensions)) {
            $photo_check = false;
            $photo_error_msg = 'The photo isn\'t in jpg, jpeg or png format';
        }
        if ($student_photo['size'] > 5242880) {
            $photo_check = false;
            $photo_error_msg = "The photo size is larger than 5MB";
        }
    }
    if ($first_name_check && $last_name_check && $dob_check && $phone_check && $email_check && $address_check && $photo_check) {
        $check_exists = "SELECT * FROM `tbl_students` WHERE `email_address` = '$email'";
        $check_exists_result = $conn->query($check_exists);
        if ($check_exists_result->num_rows > 0) {
            $msg = 'A student with the email address already exists';
        } else {
            $target_directory = '../Uploads/';
            move_uploaded_file($student_photo['tmp_name'], $target_directory . $student_photo['name']);
            $insert_student = "INSERT INTO `tbl_students`(`first_name`, `last_name`, `dob`, `phone_number`, `email_address`, `address`, `student_img`) VALUES ('$first_name','$last_name','$dob','$phone_number','$email','$address','{$student_photo['name']}')";
            if ($conn->query($insert_student)) {
                header("Location: index.php");
                $_SESSION['msg'] = 'A student has been added to the record successfully';
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
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php require('./navbar.php'); ?>
    <h1 class="mt-5 text-center">Enter student details</h1>
    <form action="" method="POST" enctype="multipart/form-data" class="container-fluid mt-5 w-50 shadow-sm p-3 mb-5 bg-body-tertiary rounded">
        <?php if (isset($msg)) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?= $msg; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <div class="row g-3 mb-3">
            <div class="col">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control <?= $first_name_check ? '' : 'is-invalid'; ?>" placeholder="First name" id="first_name" name="first_name">
                <?php if (!$first_name_check) { ?>
                    <div class="invalid-feedback">
                        <?= $first_name_error_msg; ?>
                    </div>
                <?php } ?>
            </div>
            <div class="col">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control <?= $last_name_check ? '' : 'is-invalid'; ?>" placeholder="Last name" id="last_name" name="last_name">
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
                <input type="date" class="form-control <?= $dob_check ? '' : 'is-invalid'; ?>" placeholder="DD/MM/YYYY" id="dob" name="dob">
                <?php if (!$dob_check) { ?>
                    <div class="invalid-feedback">
                        <?= $dob_error_msg; ?>
                    </div>
                <?php } ?>
            </div>
            <div class="col">
                <label for="phone_num" class="form-label">Phone Number</label>
                <input type="tel" class="form-control <?= $phone_check ? '' : 'is-invalid'; ?>" placeholder="10 digit phone number" id="phone_num" name="phone_num">
                <?php if (!$phone_check) { ?>
                    <div class="invalid-feedback">
                        <?= $phone_error_msg; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Your email address" class="form-control <?= $email_check ? '' : 'is-invalid'; ?>">
            <?php if (!$email_check) { ?>
                <div class="invalid-feedback">
                    <?= $email_error_msg; ?>
                </div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" id="address" name="address" placeholder="Permanent address" class="form-control <?= $address_check ? '' : 'is-invalid'; ?>">
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
                    <img id="img_preview" src="https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg" class="img-fluid" alt="" width="150px" height="150px">
                </div>
                <div class="col">
                    <input class="form-control <?= $photo_check ? '' : 'is-invalid'; ?>" type="file" id="student_img" name="student_img">
                    <span class="fst-italic text-muted fw-lighter">The photo size should be less than 5MB and only jpeg, jpg and png formats are supported.</span>
                    <?php if (!$photo_check) { ?>
                        <div class="invalid-feedback">
                            <?= $photo_error_msg; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="submit" name="btn_add_student">Add Student</button>
        </div>
    </form>
    <script>
        document.querySelector("#student_img").addEventListener('change', (e) => {
            document.querySelector("#img_preview").src = URL.createObjectURL(e.target.files[0]);
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>