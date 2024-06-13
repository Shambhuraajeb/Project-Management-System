<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $nm = $_POST['nm'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $gen = $_POST['gen'];
    $resume = $_POST['resume'];

    // Construct the SQL query
    $sql = "INSERT INTO `employee`(`name`, `role`, `email`, `resume`,`gender`) 
            VALUES ('$nm', '$role', '$email', '$resume','$gen')";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $message = 'Employee Added successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/employee.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/employee.php';</script>";
    }

    // Close the connection
    mysqli_close($conn);
}
?>
