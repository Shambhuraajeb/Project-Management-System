<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $skill = $_POST['skill'];
    
    $sql = "INSERT INTO `skill`(`name`) VALUES ('$skill')";
    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $message = 'New Skill added successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/skill.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/skill.php';</script>";
    }

    mysqli_close($conn);
}
?>
