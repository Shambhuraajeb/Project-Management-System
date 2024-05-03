<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $id = $_POST['id'];
    

    // Construct the SQL query
    $sql = "UPDATE `resources` SET `availability`='free' WHERE res_id='$id'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $message = 'Resources freed successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/resources.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/resources.php';</script>";
    }

    // Close the connection
    mysqli_close($conn);
}
else{
    echo "Database not connected";
}
?>