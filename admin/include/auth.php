<?php
session_start();

if (!isset($_SESSION['user_info']) || $_SESSION['user_info'] == '') {
    $message = 'You are not logged in. Please login to access this page.';
    echo "<script type='text/javascript'>alert('$message'); window.location='/project/index.php'</script>";
    exit();
}
else{
    echo "<script>window.location='admin/dashboard.php'</script>";
}
?>
