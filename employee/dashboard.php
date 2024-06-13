<?php
session_start();
$user = $_SESSION['email'];

include "include/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #1f2029;
            background-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/1462889/pat.svg');
            color: #34495e;
            /* Darker text color */
            margin: 0;
            padding: 0;
            height: 100%;
            color: #ffffff;
        }

        h6,
        h4,
        p {
            color: #ffffff;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-light" style="background-color:rgb(37, 62, 73)">
        <div class="logo">
            <img src="logo.webp" alt="Logo">
        </div>
        <h1 style="color: white;">Dashboard</h1>
    </nav>


    <main>
        <?php
        $q = "SELECT COUNT(*) FROM notify_user INNER JOIN employee on notify_user.user_id=employee.emp_id WHERE employee.email='$user' AND isread=0;";
        $count = 0;

        if ($res = mysqli_query($conn, $q)) {
            $row = mysqli_fetch_array($res);
            $count = $row[0];
            mysqli_free_result($res);
        }
        ?>
        <nav class="nav1">
            <a href="dashboard.php" class="text-white">Dashboard</a>
            <a href="task.php" class="text-white">Tasks</a>
            <a href="document.php" class="text-white">Document</a>
            <a href="notification.php" class="text-white">Notification</a>
            <a href="report.php" class="text-white">Reports</a>
        </nav>
        <section>
            <div class="card">
                <h2>Welcome to Your Dashboard</h2>
                <p class="text-muted">Here you can manage your projects, tasks, and team efficiently.</p>
                <button class="btn btn-primary">Get Started</button>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Recent</h2>
                </div>
                <div class="card-body">
                    <?php
                    //echo $user;
                    if ($user != "") {
                        echo "<h4 style='color: white;'>Welcome $user</h4>";

                    } else {
                        echo "Session variable 'username' not set." . $user;
                    }

                    $sql = "SELECT employee.email,task.name FROM `task` INNER JOIN task_assign on task.task_id=task_assign.task_id INNER JOIN employee on task_assign.emp_id=employee.emp_id where employee.email='$user'";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            for ($i = 0; $i <= 100; $i++) {
                                $row = mysqli_fetch_array($result);
                                if ($row !== null) {
                                    ?>

                                    <h6><b><?php echo ($i + 1) . "]"; ?></b> <?php echo $row[1]; ?></h6>
                                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Task Overview</h2>
                </div>
                <div class="card-body">
                    <?php

                    $user;
                    if (isset($_SESSION['email'])) {
                        $user = $_SESSION['email'];

                    } else {
                        echo "Session variable 'username' not set.";
                    }
                    include "include/config.php";
                    $sql = "SELECT task.name, task_assign.status, task.description, task.start_time, task.end_time FROM task INNER JOIN task_assign ON task.task_id = task_assign.task_id INNER JOIN employee ON task_assign.emp_id = employee.emp_id WHERE employee.email = '$user'";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            for ($i = 0; $i <= 1000; $i++) {
                                $row = mysqli_fetch_array($result);
                                if ($row !== null) {
                                    ?>
                                    <b>
                                        <h6><?php echo $row[0]; ?> (<i><?php echo $row[1]; ?></i>)</h6>
                                    </b>
                                    <i>
                                        <p><?php echo $row[2]; ?></p>
                                        <p>(<?php echo $row[3]; ?> - <?php echo $row[4]; ?>)</p>
                                    </i><br>
                                    <?php
                                }
                            }
                        }
                    } else {
                        echo "query incorect";
                    }

                    ?>
                </div>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>