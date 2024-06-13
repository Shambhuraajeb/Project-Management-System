<?php
session_start();
$user = $_SESSION['email'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects - Project Management System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style2.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 300;
            font-size: 15px;
            line-height: 1.7;
            color: black;
            background-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/1462889/pat.svg');
            overflow-x: hidden;
            background-color: #1f2029;
        }

        header {
            background-color: #00bcd4;
            color: #ffffff;
            text-align: center;
            padding: 1em 0;
            margin-bottom: 20px;
        }

        main {
            padding: 20px;
        }

        .container {
            max-width: 1500px;
        }

        .dashboard-content {
            background-color: #2a2b38;
            color: #c4c3ca;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 4px 8px 0 rgba(21, 21, 21, .2);
        }

        .table-responsive {
            margin-top: 20px;
        }

        .table th,
        .table td {
            color: #c4c3ca;
        }

        .table thead th {
            background-color: #102770;
            color: #ffeba7;
        }

        .btn-primary {
            background-color: #102770;
            border-color: #102770;
        }

        .btn-primary:hover {
            background-color: #1a3a8a;
            border-color: #1a3a8a;
        }

        .btn-danger {
            background-color: #d9534f;
            border-color: #d9534f;
        }

        .btn-danger:hover {
            background-color: #c9302c;
            border-color: #ac2925;
        }

        .btn-success {
            background-color: #5cb85c;
            border-color: #4cae4c;
        }

        .btn-success:hover {
            background-color: #4cae4c;
            border-color: #4cae4c;
        }

        .modal-content {
            background-color: #2a2b38;
            color: black;
        }

        .modal-header {
            border-bottom: 1px solid #3e3f4e;
        }

        .modal-footer {
            border-top: 1px solid #3e3f4e;
        }

        .form-control {
            background-color: #1f2029;
            color: #c4c3ca;
        }
    </style>
</head>

<body>
    <?php
    include ("nav.php");
    ?>
    <main>
        <div class="container">
            <div class="dashboard-content">
                <h4>Meeting Information</h4>
                <button class="btn btn-info" onclick="addTask()">Create Meeting</button>
                <script>
                    function addTask() {
                        window.location = "createmeeting.php";
                    }
                </script>

                <div class="table-responsive">
                    <table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Meeting Title</th>

                                <th>Meeting Agenda</th>

                                <th>Agenda Topics</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "include/config.php";
                            $sql = "SELECT meeting.id, meeting.title, meeting.description, COALESCE(agenda.title, '-') AS agenda_title, COALESCE(agenda.description, '-') AS agenda_description, GROUP_CONCAT(COALESCE(agenda_topic.title, '-')) AS agenda_topic_titles, meeting.location, meeting.date, meeting.start_time, COALESCE(agenda.notes, '-') AS agenda_notes FROM `meeting` LEFT JOIN meeting_agenda ON meeting.id = meeting_agenda.meeting_id LEFT JOIN agenda ON agenda.id = meeting_agenda.agenda_id LEFT JOIN agenda_topic_key ON agenda.id = agenda_topic_key.agenda_id LEFT JOIN agenda_topic ON agenda_topic_key.topic_id = agenda_topic.id GROUP BY meeting.id";

                            if ($result = mysqli_query($conn, $sql)) {
                                if (mysqli_num_rows($result) > 0) {
                                    for ($i = 0; $i <= 29; $i++) {
                                        $row = mysqli_fetch_array($result);
                                        if ($row !== null) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row[0]; ?></td>
                                                <td><?php echo $row[1]; ?></td>

                                                <td><?php echo $row[3]; ?></td>

                                                <td><?php echo $row[5]; ?></td>
                                                <td><?php echo $row[6]; ?></td>
                                                <td><?php echo $row[7]; ?></td>
                                                <td><?php echo $row[8]; ?></td>
                                                <td><?php echo $row[9]; ?></td>
                                                <td>
                                                    <div style="display: flex;">
                                                        <?php
                                                        if ($row[3] == '-') {
                                                            ?>
                                                            <form action="include/addAgenda.php" method="post">
                                                                <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                                                <button type="submit" name="submit" class="btn btn-success btn-sm">Add
                                                                    Agenda</button>
                                                            </form>
                                                            <?php
                                                        }
                                                        ?>

                                                        <form action="include/releasetask.php" method="post" style="margin-left: 15px;">
                                                            <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                                            <button type="submit" name="submit"
                                                                class="btn btn-info btn-sm">Update</button>
                                                        </form>

                                                        <?php
                                                        if ($row[3] == '-') {
                                                            ?>
                                                            <form action="include/notification.php" method="post"
                                                                style="margin-left: 15px;">
                                                                <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                                                <button type="submit" name="submit" class="btn btn-outline-primary btn-sm"
                                                                    disabled>Notify</button>
                                                            </form>
                                                            <?php
                                                        } else {

                                                            ?>
                                                            <form action="include/notification.php" method="post"
                                                                style="margin-left: 15px;">
                                                                <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                                                <button type="submit" name="submit"
                                                                    class="btn btn-primary btn-sm">Notify</button>
                                                            </form>
                                                            <?php
                                                        }
                                                        ?>


                                                        <form action="include/deletenotification.php" method="post"
                                                            style="margin-left: 15px;">
                                                            <input type="hidden" name="id" value="<?php echo $row[0]; ?>">
                                                            <button type="submit" name="submit"
                                                                class="btn btn-danger btn-sm">Delete</button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>



    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>