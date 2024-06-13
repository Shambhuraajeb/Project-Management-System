<?php
if (isset($_POST['submit'])) {
    include "config.php";

    $id = $_POST['id'];
    $emp = $_POST['emp'];

    foreach ($emp as $e) {
        $e = mysqli_real_escape_string($conn, $e);
        $sql = "INSERT INTO `notify_user`(`notification_id`, `user_id`) 
            VALUES ($id, '$e')";
        $result = mysqli_query($conn, $sql);
    }


    if ($result) {
        $message = 'Notifications sent successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/meeting.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/meeting.php';</script>";
    }

    mysqli_close($conn);
}
?>