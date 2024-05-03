<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $nm = $_POST['nm'];
    $manager = $_POST['manager'];
    $emp = $_POST['emp'];

    // Construct the SQL query
    $sql = "INSERT INTO `team`(`team_name`, `team_leader`) 
            VALUES ('$nm', '$manager')";
    $result = mysqli_query($conn, $sql);
    $id=$conn->insert_id;
    

    foreach($emp as $e){
        
        $sql = "INSERT INTO `team_member`(`team_id`, `emp_id`) 
            VALUES ('$id', '$e')";
    $result = mysqli_query($conn, $sql);
    }
    
   
    if ($result) {
        $message = 'Team created successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/team.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/admin/team.php';</script>";
    }

    mysqli_close($conn);
}
?>
