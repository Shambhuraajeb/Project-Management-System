<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $nm = $_POST['nm'];
    $dis = $_POST['dis'];
    $status = $_POST['status'];

    // Construct the SQL query
    $sql = "INSERT INTO `resources`(`name`, `description`, `status`) VALUES ('$nm','$dis','$status')";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $message = 'Resources Added successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/allresource.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/allresource.php';</script>";
    }

    // Close the connection
    mysqli_close($conn);
}
else{
    echo "Database not connected";
}
?>