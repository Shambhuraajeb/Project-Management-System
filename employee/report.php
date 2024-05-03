<?php
session_start();
include "include/config.php";
$user = $_SESSION['email'];

// SQL query to get the count of tasks based on each status
$sql = "SELECT SUM(CASE WHEN task_assign.status = 'to do' THEN 1 ELSE 0 END) AS todo_tasks, SUM(CASE WHEN task_assign.status = 'ongoing' THEN 1 ELSE 0 END) AS ongoing_tasks, SUM(CASE WHEN task_assign.status = 'complete' THEN 1 ELSE 0 END) AS completed_tasks, SUM(CASE WHEN task_assign.status = 'cancel' THEN 1 ELSE 0 END) AS cancelled_tasks, SUM(CASE WHEN task_assign.status = 'block' THEN 1 ELSE 0 END) AS blocked_tasks, SUM(CASE WHEN task_assign.status = 'hold' THEN 1 ELSE 0 END) AS on_hold_tasks FROM task_assign INNER JOIN task ON task_assign.task_id=task.task_id INNER JOIN employee ON task_assign.emp_id=employee.emp_id WHERE employee.email='$user'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $todoTasks = (int) $row['todo_tasks'];
    $ongoingTasks = (int) $row['ongoing_tasks'];
    $completedTasks = (int) $row['completed_tasks'];
    $cancelledTasks = (int) $row['cancelled_tasks'];
    $blockedTasks = (int) $row['blocked_tasks'];
    $onHoldTasks = (int) $row['on_hold_tasks'];
} else {
    $todoTasks = 0;
    $ongoingTasks = 0;
    $completedTasks = 0;
    $cancelledTasks = 0;
    $blockedTasks = 0;
    $onHoldTasks = 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Task Report</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file for styling -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        .name {
            text-align: center;
        }

        .report {
            margin-top: 20px;
        }

        .task {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .task:last-child {
            border-bottom: none;
        }

        .task span {
            font-weight: bold;
        }

        .task .description {
            margin-top: 5px;
            color: #666;
        }

        .task .status {
            color: green;
            /* You can adjust colors based on task status */
        }
    </style>

</head>

<body>
    <div class="container">
        <h1>Employee Task Report</h1>
        <div class="task">
            <?php
            $sql_tasks = "SELECT employee.name,employee.gender from employee where employee.email='$user'";
            $result_tasks = mysqli_query($conn, $sql_tasks);

            if ($result_tasks && mysqli_num_rows($result_tasks) > 0) {
                while ($row_tasks = mysqli_fetch_assoc($result_tasks)) {
                    if($row_tasks['gender']=="male")
                    {
                        $capitalizedStatus = ucfirst($row_tasks['name'] );
                    echo '<h1> Mr. ' . $capitalizedStatus . '<h2>';
                    }
                    else if($row_tasks['gender']=="female"){
                        $capitalizedStatus = ucfirst($row_tasks['name'] );
                    echo '<h1> Mrs. ' . $capitalizedStatus . '<h2>';
                    }
                }
            }
            ?>
        </div>

        <div>
            <canvas id="taskChart"></canvas>
            <script>
                var todoTasks = <?php echo $todoTasks; ?>;
                var ongoingTasks = <?php echo $ongoingTasks; ?>;
                var completedTasks = <?php echo $completedTasks; ?>;
                var cancelledTasks = <?php echo $cancelledTasks; ?>;
                var blockedTasks = <?php echo $blockedTasks; ?>;
                var onHoldTasks = <?php echo $onHoldTasks; ?>;

                var ctx = document.getElementById('taskChart').getContext('2d');
                var taskChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['To Do', 'Ongoing', 'Complete', 'Cancel', 'Block', 'Hold'],
                        datasets: [{
                            label: 'Task Status',
                            data: [todoTasks, ongoingTasks, completedTasks, cancelledTasks, blockedTasks, onHoldTasks],
                            backgroundColor: [
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(153, 102, 255, 0.8)',
                                'rgba(0, 0, 0, 0.5)',
                            ],
                            borderColor: [
                                'rgba(255, 206, 86, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(0, 0, 0, 0.5)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 1500,
                        },
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                fontColor: 'black',
                            }
                        },
                        tooltips: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            bodyFontColor: '#fff',
                            titleFontColor: '#fff',
                            displayColors: false,
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var label = data.labels[tooltipItem.index] || '';
                                    var value = data.datasets[0].data[tooltipItem.index];
                                    return label + ': ' + value + ' tasks';
                                }
                            }
                        }
                    }
                });
            </script>
        </div>
        <div class="report">
            <h2>Employee Task Details</h2>
            <?php
            $sql_tasks = "SELECT task.task_id, task.name AS task_name, task.description, task_assign.status, employee.name AS employee_name FROM task INNER JOIN task_assign ON task.task_id=task_assign.task_id INNER JOIN employee ON task_assign.emp_id = employee.emp_id WHERE employee.email='$user'";
            $result_tasks = mysqli_query($conn, $sql_tasks);

            if ($result_tasks && mysqli_num_rows($result_tasks) > 0) {
                while ($row_tasks = mysqli_fetch_assoc($result_tasks)) {
                    echo '<div class="task">';
                    echo '<span>Task ID:</span> ' . $row_tasks['task_id'] . '<br>';
                    echo '<span>Name:</span> ' . $row_tasks['task_name'] . '<br>';
                    echo '<div class="description">' . $row_tasks['description'] . '</div>';
                    echo '<span>Status:</span> <span class="status">' . $row_tasks['status'] . '</span><br>';

                    echo '</div>';
                }
            } else {
                echo 'No tasks found.';
            }
            ?>
        </div>
    </div>

    </div>
</body>

</html>