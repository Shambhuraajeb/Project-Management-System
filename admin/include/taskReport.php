<?php
session_start();
include "config.php"; 

$user = $_SESSION['email'];


$sql_employees = "SELECT emp_id, name FROM employee WHERE role NOT IN ('manager', 'admin')";
$result_employees = mysqli_query($conn, $sql_employees);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Task Report</title>
    <link rel="stylesheet" href="styles.css"> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .employee-form {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f5f5f5;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.select-container {
    position: relative;
}

.select-box {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    appearance: none;
    -webkit-appearance: none;
    background-color: #fff;
    font-size: 16px;
    color: #333;
    outline: none;
}

.select-icon {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    color: #666;
}

.submit-button {
    display: block;
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-button:hover {
    background-color: #0056b3;
}

.report {
    padding-top: 20px;
    display: flex;
    flex-wrap: wrap;
}

.task {
    
    height: 50px; 
    margin: 0 10px 10px 10px;
    padding: 0 10px 50px 30px;
}


    </style>
</head>

<body>
<form method="POST" class="employee-form">
    
    <div class="select-container">
        <select name="employeeId" id="employeeId" class="select-box">
            <option value="" selected disabled>Select employee ID</option>
            <?php
            if ($result_employees && mysqli_num_rows($result_employees) > 0) {
                while ($row_employee = mysqli_fetch_assoc($result_employees)) {
                    $empId = $row_employee['emp_id'];
                    echo "<option value='$empId'>$empId</option>";
                }
            } else {
                echo "<option value=''>No employees found</option>";
            }
            ?>
        </select>
        <i class="fas fa-chevron-down select-icon"></i> 
    </div>
    <button type="submit" name="submit" class="submit-button">Show Tasks</button>
</form>


    <?php
    if (isset($_POST['submit'])) {
        $selectedEmployeeId = $_POST['employeeId'];

       
        $sql_tasks = "SELECT task.task_id, task.name AS task_name, task_assign.status, task.description, task.start_time, task.end_time 
        FROM task 
        INNER JOIN task_assign ON task.task_id = task_assign.task_id 
        WHERE task_assign.emp_id = '$selectedEmployeeId'";
        $result_tasks = mysqli_query($conn, $sql_tasks);

        if ($result_tasks && mysqli_num_rows($result_tasks) > 0) {
            echo '<div class="container">';
            echo '<center><h1>Employee Task Report - Employee ID: ' . $selectedEmployeeId . '</h1></center>';
            echo '<div class="report">';
            while ($row_tasks = mysqli_fetch_assoc($result_tasks)) {
                echo '<div class="task">';
                echo '<span>Task ID:</span> ' . $row_tasks['task_id'] . '<br>';
                echo '<span>Name:</span> ' . $row_tasks['task_name'] . '<br>';
                echo '<span>Status:</span> <span class="status">' . $row_tasks['status'] . '</span><br><br><br>';
                echo '</div>';
            }
            echo '</div>'; 

            echo '<div>';
            echo '<canvas id="taskChart_' . $selectedEmployeeId . '"></canvas>';
            echo '</div>';
            echo '</div>'; 
            
            echo '<script>';
            echo 'var ctx_' . $selectedEmployeeId . ' = document.getElementById("taskChart_' . $selectedEmployeeId . '").getContext("2d");';
            echo 'var taskChart_' . $selectedEmployeeId . ' = new Chart(ctx_' . $selectedEmployeeId . ', {';
            echo 'type: "doughnut",';
            echo 'data: {';
            echo 'labels: ["To Do", "Ongoing", "Complete", "Cancel", "Block", "Hold"],';
            echo 'datasets: [{';
            echo 'label: "Task Status",';
            echo 'data: ['; 
            $statusLabels = ["to do", "ongoing", "complete", "cancel", "block", "hold"];
            $statusColors = ["rgba(255, 206, 86, 0.8)", "rgba(54, 162, 235, 0.8)", "rgba(75, 192, 192, 0.8)", "rgba(255, 99, 132, 0.8)", "rgba(153, 102, 255, 0.8)", "rgba(0, 0, 0, 0.5)"];
            foreach ($statusLabels as $index => $label) {
                $sql_status_count = "SELECT COUNT(*) AS count FROM task_assign WHERE emp_id = '$selectedEmployeeId' AND status = '$label'";
                $result_status_count = mysqli_query($conn, $sql_status_count);
                $row_status_count = mysqli_fetch_assoc($result_status_count);
                $task_count = $row_status_count['count'];
                echo $task_count;
                if ($index < count($statusLabels) - 1) {
                    echo ', ';
                }
            }
            echo '],'; 
            echo 'backgroundColor: [';
            echo '"rgba(255, 206, 86, 0.8)",';
            echo '"rgba(54, 162, 235, 0.8)",';
            echo '"rgba(75, 192, 192, 0.8)",';
            echo '"rgba(255, 99, 132, 0.8)",';
            echo '"rgba(153, 102, 255, 0.8)",';
            echo '"rgba(0, 0, 0, 0.5)"';
            echo '],';
            echo 'borderColor: [';
            echo '"rgba(255, 206, 86, 1)",';
            echo '"rgba(54, 162, 235, 1)",';
            echo '"rgba(75, 192, 192, 1)",';
            echo '"rgba(255, 99, 132, 1)",';
            echo '"rgba(153, 102, 255, 1)",';
            echo '"rgba(0, 0, 0, 0.5)"';
            echo '],';
            echo 'borderWidth: 1';
            echo '}]';
            echo '},';
            echo 'options: {';
            echo 'responsive: true,';
            echo 'maintainAspectRatio: false,';
            echo 'cutout: "70%",';
            echo 'animation: {';
            echo 'animateRotate: true,';
            echo 'animateScale: true,';
            echo 'duration: 1500,';
            echo '},';
            echo 'legend: {';
            echo 'display: true,';
            echo 'position: "bottom",';
            echo 'labels: {';
            echo 'fontColor: "black",';
            echo '}';
            echo '},';
            echo 'tooltips: {';
            echo 'backgroundColor: "rgba(0, 0, 0, 0.8)",';
            echo 'bodyFontColor: "#fff",';
            echo 'titleFontColor: "#fff",';
            echo 'displayColors: false,';
            echo 'callbacks: {';
            echo 'label: function (tooltipItem, data) {';
            echo 'var label = data.labels[tooltipItem.index] || "";';
            echo 'var value = data.datasets[0].data[tooltipItem.index];';
            echo 'return label + ": " + value + " tasks";';
            echo '}';
            echo '}';
            echo '}';
            echo '}';
            echo '});';
            echo '</script>';
        } else {
            echo '<div class="container">';
            echo '<h1>Employee Task Report - ' . $selectedEmployeeId . '</h1>';
            echo '<div class="report">No tasks found.</div>';
            echo '<canvas id="taskChart_' . $selectedEmployeeId . '" width="200" height="200"></canvas>';
            echo '<script>';
            echo 'var ctx_' . $selectedEmployeeId . ' = document.getElementById("taskChart_' . $selectedEmployeeId . '").getContext("2d");';
            echo 'var sadEmoji = new Image();';
            echo 'sadEmoji.src = "img/sad-emoji.png";'; 
            echo 'sadEmoji.onload = function() {';
            echo '    ctx_' . $selectedEmployeeId . '.drawImage(sadEmoji, 75, 75, 50, 50);';
            echo '    ctx_' . $selectedEmployeeId . '.font = "14px Arial";';
            echo '    ctx_' . $selectedEmployeeId . '.fillText("Not Found", 75, 140);';
            echo '}';
            echo '</script>';
            echo '</div>';
        } 
    }
    ?>
</body>

</html>
