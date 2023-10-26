<?php
include("../config.php");
session_start();
if (!isset($_SESSION['username'])) {
    header('../index.php');
}

if (isset($_POST['btn_delete'])) {
    $student_id = $_POST['btn_delete'];
    $delete_data = "DELETE FROM `tbl_students` WHERE `student_id` = '$student_id'";
    if ($conn->query($delete_data)) {
        header("Location: index.php?success=The student data has been successfully deleted");
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <div class="container-fluid w-50">
        <div class="shadow-sm p-3 mb-5 bg-body-tertiary rounded mt-5">
            <?php
            if (isset($_GET['success'])) {
            ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_GET['success']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div><?php
                    }
                    $students = "SELECT * FROM `tbl_students`";
                    $students_result = $conn->query($students);
                    if ($students_result->num_rows > 0) {
                        while ($row = $students_result->fetch_assoc()) {
                        ?>
                    <div class="shadow-sm p-3 mb-5 rounded">
                        <div class="row">
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <img src="../Uploads/<?= $row['student_img']; ?>" class="img-fluid" alt="" width="200px" height="200px">
                            </div>
                            <div class="col-9">
                                <div class="row mb-3">
                                    <div class="col">
                                        <div>Name: <strong class="text-uppercase"><?= $row['first_name'] . ' ' . $row['last_name']; ?></strong></div>
                                    </div>
                                    <div class="col">
                                        <div>Date of Birth: <strong><?= date("d/m/Y", strtotime($row['dob'])); ?></strong></div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <div>Phone: <strong><?= $row['phone_number']; ?></strong></div>
                                    </div>
                                    <div class="col">
                                        <div>Email: <strong><?= $row['email_address']; ?></strong></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div>Address: <strong><?= $row['address']; ?></strong></div>
                                    </div>
                                    <div class="col">
                                    </div>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="row mb-4">
                                    <form action="edit_student.php" method="post">
                                        <button name="btn_edit" id="btn_edit" value="<?= $row['student_id']; ?>" class="border-0 bg-transparent" title="Edit"><i class="fas fa-edit"></i></button>
                                    </form>
                                </div>
                                <div class="row">
                                    <form action="" method="post">
                                        <button type="submit" name="btn_delete" id="btn_delete" value="<?= $row['student_id']; ?>" class="border-0 bg-transparent" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    } else {
                ?>
                <p class="text-center text-muted fst-italic">No student records</p>
            <?php
                    }
            ?>
            <div class="d-grid gap-2">
                <a class="btn btn-primary" href="add_student.php">Add Student</a>
            </div>
        </div>
    </div>
    <script>
        // document.getElementById("btn_delete").addEventListener('click', (e) => {
        //     e.preventDefault();
        //     if (confirm('Are you sure want to delete this student data permanently?')) {
        //         document.getElementById('delete_data_form').submit();
        //     }
        // });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>