<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $id = $_POST['id'];
    

    // Construct the SQL query
    $sql = "DELETE FROM project WHERE proj_id='$id'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $message = 'Project deleted successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/project.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/project.php';</script>";
    }

    // Close the connection
    mysqli_close($conn);
}
else{
    echo "Database not connected";
}
?>