<?php
include ("include/config.php"); // Include your database connection script

$reportName = "Report Panel";

function formatStatus($status)
{
    switch ($status) {
        case 'In Progress':
            return 'in-progress';
        case 'Completed':
            return 'completed';
        case 'Pending':
            return 'pending';
        default:
            return '';
    }
}

function formatAvailability($availability)
{
    return $availability ? 'Available' : 'Not Available';
}

$statusLabels = $statusCounts = $availabilityLabels = $availabilityCounts = [];
$result_tasks = $result_resources = null;

if (isset($_GET['report'])) {
    $reportName = $_GET['report'];
    switch ($reportName) {
        case 'task':
            $sql_tasks = "SELECT emp_id, task.task_id, task.name AS task_name, task_assign.status, task.description, task.start_time, task.end_time 
                FROM task 
                INNER JOIN task_assign ON task.task_id = task_assign.task_id";
            $result_tasks = mysqli_query($conn, $sql_tasks);

            $sql_tasks1 = "SELECT status, COUNT(*) AS status_count 
                FROM task_assign 
                GROUP BY status";
            $result_tasks1 = mysqli_query($conn, $sql_tasks1);

            while ($row1 = mysqli_fetch_assoc($result_tasks1)) {
                $statusLabels[] = $row1['status'];
                $statusCounts[] = $row1['status_count'];
            }
            break;

        case 'resources':
            $sql_resources = "SELECT resources.res_id, resources.name, resources.description, resources.status, resources.availability, allocation.task_id, allocation.date, allocation.start_time, allocation.end_time 
            FROM resources 
            LEFT JOIN allocation ON resources.res_id = allocation.res_id";
            $result_resources = mysqli_query($conn, $sql_resources);

            $sql_availability = "SELECT availability, COUNT(*) AS availability_count 
            FROM resources 
            GROUP BY availability";
            $result_availability = mysqli_query($conn, $sql_availability);

            while ($row2 = mysqli_fetch_assoc($result_availability)) {
                $availabilityLabels[] = formatAvailability($row2['availability']);
                $availabilityCounts[] = $row2['availability_count'];
            }
            break;

        case 'report3':
            // SQL query and processing for Report 3
            break;

        default:
            // No specific report selected
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $reportName ?></title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="style1.css">
</head>

<body>
    <div class="sidebar">
        <h2>Report Options</h2>
        <div class="report-option"><a href="?report=task">Task</a></div>
        <div class="report-option"><a href="?report=resources">Resources</a></div>
        
    </div>

    <div class="main-content">
        <div id="report-container">
            <?php if (isset($_GET['report']) && $reportName === 'task' && $result_tasks && mysqli_num_rows($result_tasks) > 0): ?>
                <div class="container">
                    <center>
                        <h1>Employee Task Report - All Employees</h1>
                    </center>
                    <?php while ($row = mysqli_fetch_assoc($result_tasks)): ?>
                        <div class="task-card">
                            <h3>Employee ID: <?= $row['emp_id'] ?></h3>
                            <p><strong>Task ID:</strong> <?= $row['task_id'] ?></p>
                            <p><strong>Name:</strong> <?= $row['task_name'] ?></p>
                            <p><strong>Status:</strong> <span class="status <?= formatStatus($row['status']) ?>"><?= $row['status'] ?></span></p>
                            <p><strong>Description:</strong> <?= $row['description'] ?></p>
                            <p><strong>Start Time:</strong> <?= $row['start_time'] ?></p>
                            <p><strong>End Time:</strong> <?= $row['end_time'] ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
                <canvas id="statusChart" width="400" height="200"></canvas>
                <button class="print-button" onclick="window.print()">Print Report</button>
                <script>
                    var ctx = document.getElementById('statusChart').getContext('2d');
                    var statusChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?= json_encode($statusLabels) ?>,
                            datasets: [{
                                label: 'Task Status',
                                data: <?= json_encode($statusCounts) ?>,
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
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            <?php elseif ($reportName === 'resources' && $result_resources && mysqli_num_rows($result_resources) > 0): ?>
                <h2><?= ucfirst($reportName) ?></h2>
                <div class="container">
                    <center>
                        <h1>Resource Report</h1>
                    </center>
                    <?php while ($row = mysqli_fetch_assoc($result_resources)): ?>
                        <div class="resource-card">
                            <h3>Resource ID: <?= $row['res_id'] ?></h3>
                            <p><strong>Name:</strong> <?= $row['name'] ?></p>
                            <p><strong>Description:</strong> <?= $row['description'] ?></p>
                            <p><strong>Status:</strong> <?= $row['status'] ?></p>
                            <p><strong>Availability:</strong> <span class="availability <?= $row['availability'] ? 'free' : 'occupied' ?>"><?= formatAvailability($row['availability']) ?></span></p>
                            <p><strong>Task ID:</strong> <?= $row['task_id'] ?></p>
                            <p><strong>Date:</strong> <?= $row['date'] ?></p>
                            <p><strong>Start Time:</strong> <?= $row['start_time'] ?></p>
                            <p><strong>End Time:</strong> <?= $row['end_time'] ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
                <canvas id="availabilityChart" width="400" height="200"></canvas>
                <button class="print-button" onclick="window.print()">Print Report</button>
                <script>
                    var ctx = document.getElementById('availabilityChart').getContext('2d');
                    var availabilityChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?= json_encode($availabilityLabels) ?>,
                            datasets: [{
                                label: 'Resource Availability',
                                data: <?= json_encode($availabilityCounts) ?>,
                                backgroundColor: [
                                    <?php foreach ($availabilityCounts as $count): ?>
                                        'rgba(54, 162, 235, 0.8)',
                                    <?php endforeach; ?>
                                ],
                                borderColor: [
                                    <?php foreach ($availabilityCounts as $count): ?>
                                        'rgba(54, 162, 235, 1)',
                                    <?php endforeach; ?>
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            <?php else: ?>
                <h2>Welcome to the Report Page!</h2>
                <p>Please select a report from the options on the left.</p>

            <?php endif; ?>
        </div>
    </div>
</body>

</html>
