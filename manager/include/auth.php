<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $message = 'You are not logged in. Please login to access this page.'. $email;
    echo "<script type='text/javascript'>alert('$message'); window.location='/project/index.php'</script>";
    exit();
}
?>
