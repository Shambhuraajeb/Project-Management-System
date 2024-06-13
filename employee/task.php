<?php
session_start();

$user;
if (isset($_SESSION['email'])) {
    $user = $_SESSION['email'];

} else {
    echo "Session variable 'username' not set.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects - Project Management System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    include ("nav.php");
    ?>
    <main>
        <div class="container">
            <div class="dashboard-content">
                <h4>Task Information</h4>

                <div class="table-responsive">
                    <table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th scope="col">Task ID</th>
                                <th scope="col">Task Name</th>
                                <th scope="col">Task Period</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "include/config.php";
                            $sql = "SELECT task.task_id, task.name, task.start_time, task.end_time, employee.name AS employee_name, task_assign.status FROM task LEFT JOIN allocation ON task.task_id = allocation.task_id LEFT JOIN resources ON allocation.res_id = resources.res_id LEFT JOIN task_assign ON task.task_id=task_assign.task_id LEFT JOIN employee ON task_assign.emp_id = employee.emp_id WHERE employee.email = '$user'";

                            if ($result = mysqli_query($conn, $sql)) {
                                if (mysqli_num_rows($result) > 0) {
                                    for ($i = 0; $i <= 1000; $i++) {
                                        $row = mysqli_fetch_array($result);
                                        if ($row !== null) {
                                            ?>
                                            <tr>
                                                <?php
                                                if ($row[5] == "cancel") {
                                                    ?>
                                                    <s><td><?php echo $row[0]; ?></td></s>
                                                    <s></s><td><?php echo $row[1]; ?></td></s>
                                                    <s></s><td><?php echo $row[2]; ?>-<?php echo $row[3]; ?></td></s>
                                                    <s></s><td><?php echo $row[5]; ?></td></s>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <td><?php echo $row[0]; ?></td>
                                                    <td><?php echo $row[1]; ?></td>
                                                    <td><?php echo $row[2]; ?>-<?php echo $row[3]; ?></td>
                                                    <td><?php echo $row[5]; ?></td>
                                                    <?php
                                                }
                                                ?>
                                                <td style="display: flex;">
                                                    <?php
                                                    if ($row[5] == "ongoing") {
                                                        ?>
                                                        <form action="include/completetask.php" method="post">
                                                            <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                                            <button type="submit" name="submit"
                                                                class="btn btn-success btn-sm">Complete</button>
                                                        </form>
                                                        <?php
                                                    } else if ($row[5] == "complete") {
                                                        ?>
                                                            <button type="button" class="btn btn-outline-success" disabled>Completed</button>
                                                        <?php
                                                    } else if ($row[5] == "hold") {
                                                        ?>
                                                                <button type="button" class="btn btn-outline-warning" disabled>Holded</button>
                                                        <?php
                                                    } else if ($row[5] == "block") {
                                                        ?>
                                                                    <button type="button" class="btn btn-outline-danger" disabled>Blocked</button>
                                                        <?php
                                                    } else if ($row[5] == "cancel") {
                                                        ?>
                                                                        <button type="button" class="btn btn-outline-secondary" disabled>Canceled</button>
                                                        <?php
                                                    } else if ($row[5] == "to do") {
                                                        ?>
                                                                            <form action="include/starttask.php" method="post">
                                                                                <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                                                                <button type="submit" name="submit" class="btn btn-info btn-sm">Start</button>
                                                                            </form>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
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



    <!-- Edit task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Edit project form goes here -->
                    <form>
                        <div class="form-group">
                            <label for="projectName">Task Name</label>
                            <input type="text" class="form-control" id="taskName" placeholder="Enter task name">
                        </div>
                        <div class="form-group">
                            <label for="Period">Period</label>
                            <input type="text" class="form-control" id="Period" placeholder="Enter task Period"></input>
                        </div>
                        <div class="form-group">
                            <label for="Employee">Employee</label>
                            <input type="text" class="form-control" id="Employee" placeholder="Enter Employee">
                        </div>
                        <div class="form-group">
                            <label for="Manager">Manager</label>
                            <input type="text" class="form-control" id="Manager"
                                placeholder="Enter project Manager name">
                        </div>
                        <div class="form-group">
                            <label for="Taskstatus">Task status</label>
                            <input type="text" class="form-control" id="status" placeholder="Enter task status">
                        </div>
                        <div class="form-group">
                            <label for="Description">Task Description</label>
                            <input type="text" class="form-control" id="Description"
                                placeholder="Enter task Description">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!--Show task modal-->
    <div class="modal fade" id="showTaskModal" tabindex="-1" role="dialog" aria-labelledby="showProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showTaskModalLabel">Edit Project</h5>
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