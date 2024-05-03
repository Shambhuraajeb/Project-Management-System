<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $nm = $_POST['nm'];
    $dis = $_POST['dis'];
    $status = $_POST['status'];
    $manager = $_POST['manager'];
    $client = $_POST['client'];
    

    // Construct the SQL query
    $sql = "INSERT INTO `project`(`name`, `description`, `status`, `man_id`, `client`) 
            VALUES ('$nm', '$dis', '$status', '$manager', '$client')";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $message = 'Project Added successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/project.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/project.php';</script>";
    }

    // Close the connection
    mysqli_close($conn);
}
?>
