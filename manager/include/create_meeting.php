<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $link = " ";
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $location = $_POST['location'];

    $sql = "INSERT INTO `meeting`(`title`, `description`, `meeting_link`, `date`, `start_time`, `location`) VALUES ('$title','$description','$date','$date','$start_time','$location')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $message = 'Meeting created successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/meeting.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/meeting.php';</script>";
    }

    mysqli_close($conn);
}
?>