<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $res = $_POST['res'];
    $task = $_POST['task'];
    $emp = $_POST['emp'];
    $date = $_POST['date'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    // Construct the SQL query
    $sql = "INSERT INTO `allocation`(`res_id`, `task_id`, `emp_id`, `date`, `start_time`, `end_time`) VALUES ('$res','$task','$emp','$date','$start','$end')";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $message = 'Resources assigned successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/resources.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/resources.php';</script>";
    }

    // Close the connection
    mysqli_close($conn);
}
?>