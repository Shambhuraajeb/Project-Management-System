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
    include ("nav.php")
        ?>


    <main>
        <div class="container">
            <div class="dashboard-content">
                <h4>Team Information</h4>
                <button class="btn btn-info" data-toggle="modal" data-target="#addTeamModal">Add Team</button>

                <div class="table-responsive">
                    <table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th scope="col">Team ID</th>
                                <th scope="col">Team Name</th>
                                <th scope="col">Team Leader</th>
                                <th scope="col">Team Member</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "include/config.php";
                            $sql = "SELECT team.team_id, team.team_name, employee_manager.name AS team_leader_name, GROUP_CONCAT(employee.name) AS team_member_names FROM team INNER JOIN employee AS employee_manager ON team.team_leader = employee_manager.emp_id LEFT JOIN team_member ON team.team_id = team_member.team_id LEFT JOIN employee ON team_member.emp_id = employee.emp_id GROUP BY team.team_id, team.team_name, team_leader_name";

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
                                                <td><i><?php echo $row[3]; ?></i></td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm" onclick="deleteTeam()">Delete</button>
                                                    <script>
                                                        function deleteTeam() {
                                                            window.location = "include/deleteTeam.php?id=<?php echo $row[0]; ?>";
                                                        }
                                                    </script>
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

    <!-- Add Project Modal -->
    <div class="modal fade" id="addTeamModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Add Team</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="include/addteam.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="projectName">Team Name</label>
                            <input type="text" name="nm" class="form-control" id="projectName"
                                placeholder="Enter team name">
                        </div>
                        <div class="form-group">
                            <label for="projectName">Team Leader</label>
                            <select name="manager" class="form-select form-control" aria-label=".form-select-lg example">
                                <option selected>Select manager</option>
                                <?php
                                $sql = "SELECT employee.emp_id,employee.name FROM `employee` where role='manager'";
                                if ($result = mysqli_query($conn, $sql)) {
                                    if (mysqli_num_rows($result) > 0) {
                                        for ($i = 0; $i <= 29; $i++) {
                                            $row = mysqli_fetch_array($result);
                                            if ($row !== null) {
                                                ?>
                                                <option value="<?php echo $row[0]; ?>">
                                                    <?php echo $row[1]; ?></i>
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
                            <label for="projectName">Team Members</label>

                            <select name="emp[]" class="form-select form-control" aria-label=".form-select-lg example"
                                multiple>
                                
                                <?php
                                $sql = "SELECT employee.emp_id,employee.name FROM `employee` where employee.role='employee'";
                                if ($result = mysqli_query($conn, $sql)) {
                                    if (mysqli_num_rows($result) > 0) {
                                        for ($i = 0; $i <= 29; $i++) {
                                            $row = mysqli_fetch_array($result);
                                            if ($row !== null) {
                                                ?>
                                                <option value="<?php echo $row[0]; ?>">
                                                    <?php echo $row[1]; ?></i>
                                                </option>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </select>
                            <i>if you want to select multiple press <b>ctrl+click</b></i>
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

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTeamModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Team</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add form fields for editing task -->
                    <div class="form-group">
                        <label for="projectName">Team Name</label>
                        <input type="text" class="form-control" id="projectName" placeholder="Enter team name">
                    </div>
                    <div class="form-group">
                        <label for="projectName">Team Leader</label>
                        <input type="text" class="form-control" id="projectName" placeholder="Enter team leader">
                    </div>
                    <div class="form-group">
                        <label for="projectName">Team Member1</label>
                        <input type="text" class="form-control" id="projectName" placeholder="Enter team member 1 name">
                    </div>
                    <div class="form-group">
                        <label for="projectName">Team Member2</label>
                        <input type="text" class="form-control" id="projectName" placeholder="Enter team member 2 name">
                    </div>
                    <div class="form-group">
                        <label for="projectName">Team Member3</label>
                        <input type="text" class="form-control" id="projectName" placeholder="Enter team member 3 name">
                    </div>
                    <div class="form-group">
                        <label for="projectName">Team Member4</label>
                        <input type="text" class="form-control" id="projectName" placeholder="Enter team member 4 name">
                    </div>
                    <div class="form-group">
                        <label for="projectName">Team Member5</label>
                        <input type="text" class="form-control" id="projectName" placeholder="Enter team member 5 name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showTeamModal" tabindex="-1" role="dialog" aria-labelledby="showProjectModalLabel"
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