<?php

$user=$_SESSION['email'];
include_once "config.php";

// Fetch employee tasks from the database (example query)
$sql = "SELECT task.task_id, task.name, task.description, task.status 
        FROM task 
        INNER JOIN employee ON task.emp_id = employee.emp_id 
        WHERE employee.email = '$user'"; 

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="task">';
        echo '<span>Task ID:</span> ' . $row['task_id'] . '<br>';
        echo '<span>Name:</span> ' . $row['name'] . '<br>';
        echo '<div class="description">' . $row['description'] . '</div>';
        echo '<span>Status:</span> <span class="status">' . $row['status'] . '</span>';
        echo '</div>';
    }
} else {
    echo 'No tasks found.';
}

$conn->close();
?>
