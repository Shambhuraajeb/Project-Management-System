<?php
session_start();

$user;
if (isset($_SESSION['email'])) {
    $user = $_SESSION['email'];

} else {
    echo "Session variable 'username' not set.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .notification {
            background-color: #f0f0f0;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            border-left: 4px solid transparent;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
            transition: border-left-color 0.3s ease-in-out;
            animation: fadeIn 0.5s ease forwards;
        }

        .notification:last-child {
            margin-bottom: 0;
        }

        .notification p {
            margin: 0;
            color: #333;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notification.info {
            border-left-color: #3498db;
        }

        .notification.success {
            border-left-color: #2ecc71;
        }

        .notification.warning {
            border-left-color: #f39c12;
        }

        .notification.error {
            border-left-color: #e74c3c;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Notifications</h1>
        <?php
        include "include/config.php";
        $sql = "SELECT meeting.*, notify_user.* FROM notification LEFT JOIN notify_user ON notification.id = notify_user.notification_id LEFT JOIN employee ON notify_user.user_id=employee.emp_id LEFT JOIN meeting ON notification.meeting_id = meeting.id WHERE employee.email='$user'";

        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                for ($i = 0; $i <= 1000; $i++) {
                    $row = mysqli_fetch_array($result);
                    if ($row !== null) {
                        $id=$row[0];
                        ?>
                        <a href="include/view.php?id=<?php echo $id;?>" style="text-decoration: none;">
                            <div class="notification info">
                                <p><strong><?php echo $row[1]; ?>: </strong><?php echo $row[2]; ?></p>
                            </div>
                        </a>
                        <?php
                    }
                }
            }
        }
        ?>
    </div>

</body>

</html>