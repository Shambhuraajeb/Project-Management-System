<?php
session_start();
if (!isset($_SESSION['email'])) {
    $message = 'You are not logged in. Please login to access this page.'. $email;
    echo "<script type='text/javascript'>alert('$message'); window.location='/project/index.php'</script>";
    exit();
}


$user = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <style>
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
        <nav class="nav1">
            <a href="dashboard.html" class="text-white">Dashboard</a>
            <a href="project.php" class="text-white">Projects</a>
            <a href="task.php" class="text-white">Tasks</a>
            <a href="team.php" class="text-white">Team</a>
            <a href="allresource.php" class="text-white">Resource</a>
            <a href="resources.php" class="text-white">Allocation</a>
            <a href="employee.php" class="text-white">Employee</a>
            <a href="document.php" class="text-white">Document</a>
            <a href="select_report.php" class="text-white">Reports</a>
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
                    echo "<h2>$user</h2>";
                    
                    include "include/config.php";
                    $sql = "SELECT employee.email,task.name FROM `task` INNER JOIN task_assign ON task.task_id=task_assign.task_id INNER JOIN employee on task_assign.emp_id=employee.emp_id";

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
                    $sql = "SELECT task.name,task.description,task.start_time,task.end_time,task_assign.status,employee.name FROM `task` INNER JOIN task_assign ON task_assign.task_id=task.task_id INNER JOIN employee on task_assign.emp_id=employee.emp_id";

                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            for ($i = 0; $i <= 1000; $i++) {
                                $row = mysqli_fetch_array($result);
                                if ($row !== null) {
                                    ?>
                                    <b>
                                        <h6><?php echo $row[0]; ?> (<i><?php echo $row[4]; ?></i>)</h6>
                                    </b>
                                    <i>
                                        <p><?php echo $row[1]; ?></p>
                                        <p>(<?php echo $row[2]; ?> - <?php echo $row[3]; ?>)</p>
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php

?>