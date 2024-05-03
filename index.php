<?php
session_start();
if (isset($_POST['submit'])) {
    include ('admin/include/config.php');

    $email = $_POST['email'];
    $pw = $_POST['pass'];
    //echo $email;

    $q = "SELECT * FROM user INNER JOIN employee ON user.emp_id = employee.emp_id WHERE user.email = '$email' AND user.pass = '$pw'";
    $result = mysqli_query($conn, $q);
    if (mysqli_num_rows($result) > 0) {

        $a = mysqli_fetch_array($result);
        if ($a["role"] == "admin") {
            $_SESSION['email'] = $email;
            $message = 'Welcome Admin ' . $email;
            echo "<script type='text/javascript'>alert('$message'); window.location='admin/dashboard.php'</script>";
        } elseif ($a["role"] == "manager") {
            $_SESSION['email'] = $email;
            $message = 'Welcome Manager ' . $email;
            echo "<script type='text/javascript'>alert('$message'); window.location='manager/dashboard.php'</script>";
        } elseif ($a["role"] == "employee") {
            $_SESSION['email'] = $email;
            $message = 'Welcome Employee ' . $email;
            echo "<script type='text/javascript'>alert('$message'); window.location='employee/dashboard.php'</script>";
        }
    } else {
        $message = "Please login with this email and then try";
        echo "<script type='text/javascript'>alert('$message');</script> ";
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <form method="post">
            <h1>Login</h1>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="pass" placeholder="Password" required>
            <button name="submit">Login</button>
        </form>
    </div>
</body>

</html>