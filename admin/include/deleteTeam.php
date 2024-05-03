<?php

    include ('config.php');

    $id = $_GET['id'];
    

    // Construct the SQL query
    $sql = "DELETE FROM team WHERE team_id='$id'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        $message = 'Team deleted successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/team.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/team.php';</script>";
    }

    // Close the connection
    mysqli_close($conn);

?>