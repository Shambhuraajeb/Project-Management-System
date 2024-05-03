<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $id = $_POST['id'];
    $email = $_POST['email'];

    $length = 8;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+[]{}|;:,.<>?';
    $pass = '';

    $charLength = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $pass .= $characters[rand(0, $charLength)];
    }

    // Construct the SQL query
    $sql = "INSERT INTO `user`(`email`, `pass`, `emp_id`) VALUES ('$email','$pass','$id')";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $message = 'User ID created successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/employee.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/employee.php';</script>";
    }

    // Close the connection
    mysqli_close($conn);
}
?>