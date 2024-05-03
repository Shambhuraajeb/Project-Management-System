<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $id = $_POST['id'];
    $sql = "UPDATE task_assign INNER JOIN task ON task_assign.task_id=task.task_id SET task_assign.status='block' WHERE task.task_id='$id'";
    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $message = 'Task Blocked';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/task.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/task.php';</script>";
    }

}
?>
