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
            max-width: 1500px;
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
                <h4>Resources Information</h4>
                
                <button class="btn btn-info" data-toggle="modal" data-target="#assignResourceModal">Assign</button>

                <div class="table-responsive">
                    <table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Resource Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Assigned Employee</th>
                                <th scope="col">Assigned Task</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Availability</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "include/config.php";
                            $sql = "SELECT resources.res_id, resources.name, resources.description, resources.status, employee.name AS employee_name, task.name AS task_name, allocation.date, allocation.start_time, allocation.end_time, resources.availability FROM allocation LEFT JOIN resources ON allocation.res_id = resources.res_id LEFT JOIN employee ON allocation.emp_id = employee.emp_id LEFT JOIN task ON allocation.task_id = task.task_id WHERE resources.availability='occupied'";

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
                                                <td><?php echo $row[4]; ?></td>
                                                <td><?php echo $row[5]; ?></td>
                                                <td><?php echo $row[6]; ?></td>
                                                <td><?php echo $row[7]; ?>-<?php echo $row[8]; ?></td>
                                                <td><?php echo $row[9]; ?></td>
                                                <td>
                                                <form action="include/freeresources.php" method="post">
                                                        <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                                        <button type="submit" name="submit"
                                                            class="btn btn-info btn-sm">Free</button>
                                                    </form>
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



   

    <!-- assign resource Modal -->
    <div class="modal fade" id="assignResourceModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addResourceModalLabel">Assign Resources</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="include/assign.php" method="post">
                    <div class="modal-body">
                        
                        <div class="form-group">
                        <label for="projectName">Resource name</label>
                            <select name="res" class="form-select form-control"
                                aria-label=".form-select-lg example">
                                <option selected>Select resource</option>
                                <?php
                                $sql = "SELECT resources.res_id, resources.name FROM resources";
                                if ($result = mysqli_query($conn, $sql)) {
                                    if (mysqli_num_rows($result) > 0) {
                                        for ($i = 0; $i <= 100; $i++) {
                                            $row = mysqli_fetch_array($result);
                                            if ($row !== null) {
                                                ?>
                                                <option value="<?php echo $row[0]; ?>">
                                                    <?php echo $row[1]; ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="projectName">Task name</label>
                            <select name="task" class="form-select form-control"
                                aria-label=".form-select-lg example">
                                <option selected>Select task</option>
                                <?php
                                $sql = "SELECT task.task_id,task.name FROM task";
                                if ($result = mysqli_query($conn, $sql)) {
                                    if (mysqli_num_rows($result) > 0) {
                                        for ($i = 0; $i <= 100; $i++) {
                                            $row = mysqli_fetch_array($result);
                                            if ($row !== null) {
                                                ?>
                                                <option value="<?php echo $row[0]; ?>">
                                                    <?php echo $row[1]; ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="projectName">Employee Name</label>
                            <select name="emp" class="form-select form-control"
                                aria-label=".form-select-lg example">
                                <option selected>Select employee</option>
                                <?php
                                $sql = "SELECT employee.emp_id,employee.name FROM `employee`";
                                if ($result = mysqli_query($conn, $sql)) {
                                    if (mysqli_num_rows($result) > 0) {
                                        for ($i = 0; $i <= 100; $i++) {
                                            $row = mysqli_fetch_array($result);
                                            if ($row !== null) {
                                                ?>
                                                <option value="<?php echo $row[0]; ?>">
                                                    <?php echo $row[1]; ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="projectName"> Date</label>
                            <input type="date" name="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="projectName">Start Time</label>
                            <input type="time" name="start" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="projectName">End Time</label>
                            <input type="time" name="end" class="form-control">
                        </div>
                        <!-- Add more project fields as needed -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editResourceModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="projectName">Resource Name</label>
                            <input type="text" class="form-control" id="projectName" placeholder="Enter project name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" rows="3"
                                placeholder="Enter project description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="projectName">Maintenance</label>
                            <input type="text" class="form-control" id="projectName" placeholder="Enter project name">
                        </div>
                        <div class="form-group">
                            <label for="projectName">Availability</label>
                            <input type="text" class="form-control" id="projectName" placeholder="Enter project name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="showResourceModal" tabindex="-1" role="dialog" aria-labelledby="showProjectModalLabel"
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