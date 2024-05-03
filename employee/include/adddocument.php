<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $nm = $_POST['nm'];
    $loc = $_POST['loc'];
    $dt = $_POST['dt'];
    $proj = $_POST['proj'];
    $emp = $_POST['emp'];
    

    // Construct the SQL query
    $sql = "INSERT INTO `document`(`name`, `location`, `datetime`, `proj_id`, `emp_id`) VALUES ('$nm','$loc','$dt','$proj','$emp')";
    
    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $message = 'Document Added successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/document.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/document.php';</script>";
    }

    // Close the connection
    mysqli_close($conn);
}
?>
