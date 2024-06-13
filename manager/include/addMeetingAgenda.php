<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);

    $topic = $_POST['topic'];
    $topicdesc = $_POST['topicdesc'];

    $note = mysqli_real_escape_string($conn, $_POST['note']);

    $sql = "INSERT INTO `agenda`(`title`, `description`, `notes`) VALUES ('$title','$desc','$note')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $agenda_id = mysqli_insert_id($conn);

        if (count($topic) === count($topicdesc)) {
            foreach (array_combine($topic, $topicdesc) as $t => $td) {
                $sql1 = "INSERT INTO `agenda_topic`(`title`, `description`) VALUES ('$t', '$td')";
                $result1 = mysqli_query($conn, $sql1);

                if ($result1) {
                    $topic_id = mysqli_insert_id($conn);

                    $sql2 = "INSERT INTO `agenda_topic_key`(`agenda_id`, `topic_id`) VALUES ('$agenda_id', '$topic_id')";
                    $result2 = mysqli_query($conn, $sql2);

                    if (!$result2) {
                        $error_message = "Error inserting data into agenda_topic_key table: " . mysqli_error($conn);
                        echo $error_message; // Debugging: Print error message
                    }
                } else {
                    $error_message = "Error inserting data into agenda_topic table: " . mysqli_error($conn);
                    echo $error_message; // Debugging: Print error message
                }
            }
        } else {
            $error_message = "Error: Arrays have different lengths";
            echo $error_message; // Debugging: Print error message
        }
    } else {
        $error_message = "Error inserting data into agenda table: " . mysqli_error($conn);
        echo $error_message; // Debugging: Print error message
    }

    $sql3 = "INSERT INTO `meeting_agenda`(`meeting_id`, `agenda_id`) VALUES ('$id', '$agenda_id')";
    $result3 = mysqli_query($conn, $sql3);

    if ($result3) {
        $message = 'Meeting agenda added successfully';
    } else {
        $message = 'Something went wrong.';
    }

    echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/meeting.php';</script>";

    mysqli_close($conn);
}
?>
