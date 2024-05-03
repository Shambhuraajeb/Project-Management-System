<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $id = $_POST['id'];
    
    // Construct the SQL query
    $sql = "UPDATE task_assign INNER JOIN task ON task_assign.task_id=task.task_id SET task_assign.status='complete' WHERE task.task_id='$id'";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $message = 'Task Completed successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/task.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/task.php';</script>";
    }

    // Close the connection
    mysqli_close($conn);
}
?>
