<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $task_id = $_POST['task_id'];
    $emp_id = $_POST['emp_id'];


    $sql = "INSERT INTO `task_assign`(`task_id`, `emp_id`) VALUES ('$task_id', '$emp_id')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $sql1 = "UPDATE `task_status` SET `assigned` = '1' WHERE `task_id` = '$task_id' AND `task_id` IN (SELECT `task_id` FROM `task` WHERE `task_id` = '$task_id')";
        $result1 = mysqli_query($conn, $sql1);


        if ($result) {
            $message = 'Task Assigned successfully';
            echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/task.php';</script>";
        }
        else{
            $message = 'Task not assigned.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/task.php';</script>";
        }
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/task.php';</script>";
    }
} else {
    $message = 'Not subbmitted';
    echo "<script type='text/javascript'>alert('$message');window.location.href='/proj/task.php';</script>";
}
?>