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
if (isset($_POST['btn_delete'])) {
    $student_id = $_POST['btn_delete'];
    $delete_data = "DELETE FROM `tbl_students` WHERE `student_id` = '$student_id'";
    if ($conn->query($delete_data)) {
        header("Location: index.php");
        $_SESSION['msg'] = 'The student data has been deleted successfully';
    }
}
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$students_result_per_page = 3;
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
    <nav class="navbar" style="background-color: #e3f2fd;">
        <div class="container-fluid">
            <a href="./index.php" class="navbar-brand text-uppercase fw-bold text-danger mx-4"><img src="./assets/images/logo.png" alt="" width="50" height="50"></a>
            <form action="" method="post" class="d-flex">
                <button class="btn btn-outline-danger" type="submit" name="sign_out_btn">Sign out</button>
            </form>
        </div>
    </nav>
    <div class="container-fluid w-50">
        <div class="shadow-sm p-3 mb-5 bg-body-tertiary rounded mt-5">
            <?php
            if (isset($_SESSION['msg'])) {
            ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['msg']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div><?php
                        unset($_SESSION['msg']);
                    }
                        ?>

            <div class="d-grid gap-2 mb-4">
                <a class="btn btn-primary" href="add_student.php">Add Student</a>
            </div>
            <?php
            $students = "SELECT * FROM `tbl_students` WHERE `user_id` = '{$_SESSION['user_id']}'";
            $students_result = $conn->query($students);
            $students_result_num = $students_result->num_rows;
            $number_of_pages = ceil($students_result_num / $students_result_per_page);
            if ($students_result->num_rows > 0) {
                $per_page_result = ($page - 1) * $students_result_per_page;
                $students_per_page = "SELECT * FROM `tbl_students` WHERE `user_id` = '{$_SESSION['user_id']}' ORDER BY `created_at` DESC LIMIT $per_page_result , $students_result_per_page";
                $students_per_page_result = $conn->query($students_per_page);
                while ($row = $students_per_page_result->fetch_assoc()) {
            ?>
                    <div class="shadow-sm p-3 mb-4 rounded">
                        <div class="row">
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <img src="../Uploads/<?= $row['student_img']; ?>" class="img-fluid" alt="" width="200px" height="200px">
                            </div>
                            <div class="col-9">
                                <div class="row mb-3">
                                    <div class="col">
                                        <div>Name: <strong><?= $row['first_name'] . ' ' . $row['last_name']; ?></strong></div>
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
                                <div class="row mb-3">
                                    <form action="view_student.php" method="post">
                                        <button name="btn_view" id="btn_view" value="<?= $row['student_id']; ?>" class="border-0 bg-transparent" title="View"><i class="fa-solid fa-eye"></i></button>
                                    </form>
                                </div>
                                <div class="row mb-3">
                                    <form action="edit_student.php" method="post">
                                        <button name="btn_edit" id="btn_edit" value="<?= $row['student_id']; ?>" class="border-0 bg-transparent" title="Edit"><i class="fas fa-edit"></i></button>
                                    </form>
                                </div>
                                <div class="row">
                                    <form action="" method="POST" id="delete_data_form">
                                        <button type="submit" onclick="return submitForm(this)" name="btn_delete" id="btn_delete" value="<?= $row['student_id']; ?>" class="border-0 bg-transparent" title="Delete"><i class="fa-solid fa-trash"></i></button>
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
            <ul class="pagination justify-content-center">
                <?php if ($page >= 2) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page - 1; ?>">Previous</a></li>
                <?php
                }
                for ($i = 1; $i <= $number_of_pages; $i++) {
                    $active = ($i == $page) ? 'active' : '';
                ?>
                    <li class="page-item"><a class="page-link <?= $active; ?>" href="?page=<?= $i; ?>"><?= $i; ?></a></li>
                <?php
                }
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                if ($page + 1 <= $number_of_pages) {
                ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page + 1; ?>">Next</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <script>
        function submitForm(form) {
            if (confirm('Are you sure want to delete this student data?')) {
                form.submit();
            } else {
                return false;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>