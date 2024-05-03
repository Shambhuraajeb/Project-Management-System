<?php
session_start();
$user = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projects - Project Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
            font-size: 15px;
            line-height: 1.7;
            color: black;
            background-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/1462889/pat.svg');
            overflow-x: hidden;
            background-color: #1f2029;
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
                <h4>Project Information</h4>


                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add Project
                </button>


                <div class="table-responsive">
                    <table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th scope="col">Project ID</th>
                                <th scope="col">Project Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Team Leader</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "include/config.php";
                            $sql = "SELECT * FROM project INNER JOIN manager ON project.man_id = manager.man_id INNER JOIN employee ON manager.emp_id = employee.emp_id";

                            if ($result = mysqli_query($conn, $sql)) {
                                if (mysqli_num_rows($result) > 0) {
                                    for ($i = 0; $i <= 29; $i++) {
                                        $row = mysqli_fetch_array($result);
                                        if ($row !== null) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row[0]; ?></td>
                                                <td><?php echo $row[1]; ?></td>
                                                <td><?php echo $row['description']; ?></td>
                                                <td><?php echo $row[11]; ?></td>
                                                <td><i><?php echo $row['status']; ?></i></td>
                                                <td>
                                                    <form action="include/deleteproject.php" method="post">
                                                        <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                                        <button type="submit" name="submit"
                                                            class="btn btn-danger btn-sm">Delete</button>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="include/addproject.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="projectName">Project Name</label>
                            <input type="text" name="nm" class="form-control" id="projectName"
                                placeholder="Enter project name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="dis" id="description" rows="3"
                                placeholder="Enter project description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Project Status </label>
                            <input type="text" name="status" class="form-control" id="projectStatus"
                                placeholder="Enter project status">
                        </div>
                        <div class="form-group">
                            <label for="leader">Project Leader Name</label>
                            <select name="manager" class="form-select form-control"
                                aria-label=".form-select-lg example">
                                <option selected>Select manager</option>
                                <?php
                                $sql = "SELECT manager.man_id,employee.name,manager.department FROM `manager` INNER JOIN employee ON manager.emp_id=employee.emp_id";
                                if ($result = mysqli_query($conn, $sql)) {
                                    if (mysqli_num_rows($result) > 0) {
                                        for ($i = 0; $i <= 29; $i++) {
                                            $row = mysqli_fetch_array($result);
                                            if ($row !== null) {
                                                ?>
                                                <option value="<?php echo $row[0]; ?>">
                                                    <?php echo $row[1]; ?>
                                                    (<i><?php echo $row[2]; ?></i>)
                                                </option>
                                                <?php
                                            } else {
                                                echo "null";
                                            }
                                        }
                                    } else {
                                        echo "rows are 0";
                                    }
                                } else {
                                    echo "Query not execute";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="Client">Project Client Name</label>
                            <input type="text" name="client" class="form-control" id="projectClient"
                                placeholder="Enter project Client name">
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>