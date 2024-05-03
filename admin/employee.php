<?php
session_start();
$user = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects - Project Management System</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
            font-size: 15px;
            line-height: 1.7;
            color: #c4c3ca;
            background-color: #1f2029;
            background-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/1462889/pat.svg');
            overflow-x: hidden;
        }

        header {
            background-color: #00bcd4;
            color: #ffffff;
            text-align: center;
            padding: 1em 0;
            margin-bottom: 20px;
        }

        main {
            padding: 20px;
        }

        .container {
            max-width: 1000px;
        }

        .dashboard-content {
            background-color: #2a2b38;
            color: #c4c3ca;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 4px 8px 0 rgba(21, 21, 21, .2);
        }

        .table-responsive {
            margin-top: 20px;
        }

        .table th,
        .table td {
            color: #c4c3ca;
        }

        .table thead th {
            background-color: #102770;
            color: #ffeba7;
        }

        .btn-primary {
            background-color: #102770;
            border-color: #102770;
        }

        .btn-primary:hover {
            background-color: #1a3a8a;
            border-color: #1a3a8a;
        }

        .btn-danger {
            background-color: #d9534f;
            border-color: #d9534f;
        }

        .btn-danger:hover {
            background-color: #c9302c;
            border-color: #ac2925;
        }

        .btn-success {
            background-color: #5cb85c;
            border-color: #4cae4c;
        }

        .btn-success:hover {
            background-color: #4cae4c;
            border-color: #4cae4c;
        }

        .modal-content {
            background-color: #2a2b38;
            color: black;
        }

        .modal-header {
            border-bottom: 1px solid #3e3f4e;
        }

        .modal-footer {
            border-top: 1px solid #3e3f4e;
        }

        .form-control {
            background-color: #1f2029;
            color: #c4c3ca;
        }
    </style>
</head>

<body>
    <?php
    include "nav.php";
    ?>



    <main>
        <div class="container">
            <div class="dashboard-content">
                <h4>Employee's Information</h4>
                <button class="btn btn-info" data-toggle="modal" data-target="#addEmployeeModal">Add Employee's</button>

                <div class="table-responsive">
                    <table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th scope="col">Employee's ID</th>
                                <th scope="col">Employee's Name</th>
                                <th scope="col">Role</th>
                                <th scope="col">Email</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "include/config.php";
                            $sql = "SELECT * FROM `employee`";

                            if ($result = mysqli_query($conn, $sql)) {
                                if (mysqli_num_rows($result) > 0) {
                                    for ($i = 0; $i <= 29; $i++) {
                                        $row = mysqli_fetch_array($result);
                                        if ($row !== null) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row[0]; ?></td>
                                                <td><?php echo $row[1]; ?></td>
                                                <td><?php echo $row[2]; ?></td>
                                                <td><?php echo $row[3]; ?></td>
                                                <td style="display: flex;">
                                                    <button class="btn btn-danger btn-sm" onclick="deleteEmp()">Delete</button>
                                                    <script>
                                                        function deleteEmp() {
                                                            window.location = "include/deleteemp.php?id=<?php echo $row[0]; ?>";
                                                        }
                                                    </script>
                                                    <?php
                                                    include "include/config.php";
                                                    $sql1 = "SELECT employee.* FROM employee LEFT JOIN user ON employee.emp_id = user.emp_id WHERE user.emp_id IS NULL AND employee.emp_id='$row[0]'";

                                                    if ($result1 = mysqli_query($conn, $sql1)) {
                                                        if (mysqli_num_rows($result1) > 0) {
                                                            for ($j = 0; $j <= 29; $j++) {
                                                                $row1 = mysqli_fetch_array($result1);
                                                                if ($row1 !== null) {
                                                                    ?>
                                                                    <form action="include/createuser.php" method="post">
                                                                        <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                                                        <input type="hidden" name="email" value="<?php echo $row[3]; ?>">
                                                                        <button type="sunmit" name="submit" style="margin-left: 5px;"
                                                                            class="btn btn-info btn-sm">Create user ID</button>
                                                                    </form>
                                                                </td>
                                                                <?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Add employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Add Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="include/addemployee.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="projectName">Employee Name</label>
                            <input type="text" name="nm" class="form-control"
                                placeholder="Enter employee name & surname">
                        </div>
                        <div class="form-group">
                            <label for="projectName">Employee Role</label>
                            <select name="role" class="form-select" aria-label="Default select example">
                                <option selected>Select Role</option>
                                <option value="employee">Employee</option>
                                <option value="manager">Manager</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="projectName">Employee Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Enter employee email">
                        </div>
                        <div class="form-group">
                            <label for="projectName">Resume</label>
                            <input type="file" name="resume" class="form-control" placeholder="Enter employee resume">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit employee Modal -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add form fields for editing task -->
                    <div class="form-group">
                        <label for="projectName">Employee Id</label>
                        <input type="text" class="form-control" id="projectName" placeholder="Enter employee ID">
                    </div>
                    <div class="form-group">
                        <label for="projectName">Employee Name</label>
                        <input type="text" class="form-control" id="projectName" placeholder="Enter employee name">
                    </div>
                    <div class="form-group">
                        <label for="projectName">Employee Role</label>
                        <input type="text" class="form-control" id="projectName" placeholder="Enter employee role">
                    </div>
                    <div class="form-group">
                        <label for="projectName">Employee Email</label>
                        <input type="text" class="form-control" id="projectName" placeholder="Enter employee email">
                    </div>
                    <div class="form-group">
                        <label for="projectName">Resume</label>
                        <input type="file" class="form-control" id="projectName" placeholder="Enter employee resume">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="showProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showProjectModalLabel">Edit Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>