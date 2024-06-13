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

    try {

        $sql = "INSERT INTO `user`(`email`, `pass`, `emp_id`) VALUES ('$email','$pass','$id')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            $message = 'User ID created successfully. Login credentials sent to user.';
            echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/employee.php';</script>";
        } else {
            $message = 'Failed to insert user into the database.';
           // echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/employee.php';</script>";
        }
    } catch (Exception $e) {
        $message = 'Exception: ' . $e->getMessage();
        //echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/employee.php';</script>";
    }

    mysqli_close($conn);
}
?>