<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $nm = $_POST['nm'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $emp = $_POST['emp'];
    $status = $_POST['status'];
    $dis = $_POST['dis'];

    // Construct the SQL query
    $sql = "INSERT INTO `task`( `name`, `start_time`, `end_time`, `emp_id`, `status`, `description`) 
            VALUES ('$nm', '$start', '$end', '$emp', '$status', '$dis')";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $message = 'Task Assigned successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/task.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/task.php';</script>";
    }

    // Close the connection
    mysqli_close($conn);
}
else{
    $message = 'Not subbmitted';
    echo "<script type='text/javascript'>alert('$message');window.location.href='/proj/task.php';</script>";
}
?>
