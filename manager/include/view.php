<?php
session_start();

$user;
if (isset($_SESSION['email'])) {
    $user = $_SESSION['email'];
} else {
    echo "Session variable 'username' not set.";
    exit;
}
$meet_id=$_GET['id'];
include "config.php";


$sql = "SELECT meeting.id AS meeting_id, 
meeting.title AS meeting_name, 
meeting.date AS meeting_date, 
meeting.description AS meeting_description, 
meeting.location AS meeting_location, 
meeting.start_time AS meeting_time, 
agenda.id AS agenda_id, 
agenda.title AS agenda_title, 
agenda.description AS agenda_description, 
agenda_topic.id AS topic_id, 
agenda_topic.title AS topic_title, 
agenda_topic.description AS topic_description 
FROM meeting 
LEFT JOIN meeting_agenda ON meeting.id = meeting_agenda.meeting_id 
LEFT JOIN agenda ON meeting_agenda.agenda_id = agenda.id 
LEFT JOIN agenda_topic_key ON agenda.id = agenda_topic_key.agenda_id 
LEFT JOIN agenda_topic ON agenda_topic_key.topic_id = agenda_topic.id 
WHERE meeting.id IN (SELECT meeting.id FROM notification 
              LEFT JOIN notify_user ON notification.id = notify_user.notification_id 
              LEFT JOIN employee ON notify_user.user_id = employee.emp_id 
              LEFT JOIN meeting ON notification.meeting_id = meeting.id WHERE meeting.id='$meet_id') 
ORDER BY meeting.id, agenda.id, agenda_topic.id;";

$result = mysqli_query($conn, $sql);

$meetings = [];

// Fetch results and structure data
while ($row = mysqli_fetch_assoc($result)) {
    $meetings[$row['meeting_id']]['name'] = $row['meeting_name'];
    $meetings[$row['meeting_id']]['date'] = $row['meeting_date'];
    $meetings[$row['meeting_id']]['description'] = $row['meeting_description'];
    $meetings[$row['meeting_id']]['location'] = $row['meeting_location'];
    $meetings[$row['meeting_id']]['start_time'] = $row['meeting_time'];
    $meetings[$row['meeting_id']]['agendas'][$row['agenda_id']]['title'] = $row['agenda_title'];
    $meetings[$row['meeting_id']]['agendas'][$row['agenda_id']]['description'] = $row['agenda_description'];
    $meetings[$row['meeting_id']]['agendas'][$row['agenda_id']]['topics'][] = [
        'title' => $row['topic_title'],
        'description' => $row['topic_description']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Notice</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e9ecef;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .header {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 4px solid #007bff;
        }

        h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }

        .logo {
            width: 50px;
            height: auto;
        }

        .meeting-details {
            padding: 20px 0;
        }

        h2 {
            margin-top: 0;
            color: #007bff;
            font-weight: 600;
        }

        p {
            margin: 5px 0;
        }

        .agenda {
            padding: 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .agenda h3 {
            margin-top: 0;
            color: #007bff;
            font-weight: 600;
        }

        .agenda-item {
            margin-bottom: 15px;
        }

        .agenda-item h4 {
            margin-top: 0;
            font-size: 18px;
            color: #343a40;
            font-weight: 600;
        }

        .agenda-item p {
            margin: 5px 0;
            color: #555;
        }

        .topic-item {
            margin-left: 20px;
        }

        .topic-item h5 {
            margin: 5px 0;
            font-size: 16px;
            color: #007bff;
            font-weight: 600;
        }

        .topic-item p {
            margin: 5px 0;
            color: #555;
        }
    </style>
</head>

<body>
    <?php foreach ($meetings as $meeting): ?>
        <div class="container">
            <div class="header">
                <h1>Meeting Notice</h1>
                <svg class="logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="50" height="50">
                    <rect width="512" height="512" fill="#ffffff" />
                    <path d="M384,96H128c-17.672,0-32,14.328-32,32v256c0,17.672,14.328,32,32,32h256c17.672,0,32-14.328,32-32V128C416,110.328,401.672,96,384,96z M384,160v96h-96v-96H384z M192,352H128v-96h64V352z M192,224H128v-64h64V224z M256,352h-64v-96h64V352z M256,224h-64v-64h64V224z M320,352h-64v-96h64V352z M320,224h-64v-64h64V224z M384,352h-64v-96h64V352z M384,224h-64v-64h64V224z" fill="#007bff" />
                    <path d="M447.984,0H64.016C28.672,0,0,28.672,0,64v384c0,35.344,28.672,64,64.016,64h383.969 C483.328,512,512,483.328,512,448V64C512,28.672,483.328,0,447.984,0z M480,448c0,11.016-8.984,20-20,20H64.016 c-11.016,0-20-8.984-20-20V64c0-11.016,8.984-20,20-20h383.969c11.016,0,20,8.984,20,20V448z" fill="#007bff" />
                </svg>
            </div>
            <div class="meeting-details">
                <h2><?php echo $meeting['name']; ?></h2>
                <p><strong>Date:</strong> <?php echo $meeting['date']; ?></p>
                <p><strong>Time:</strong> <?php echo $meeting['start_time']; ?></p>
                <p><strong>Location:</strong> <?php echo $meeting['location']; ?></p>
                <p><strong>Description:</strong><?php echo $meeting['description']; ?></p>
            </div>
            <div class="agenda">
                <h3>Agenda</h3>
                <?php foreach ($meeting['agendas'] as $agenda): ?>
                    <div class="agenda-item">
                        <h4><?php echo $agenda['title']; ?></h4>
                        <p><?php echo $agenda['description']; ?></p>
                        <?php if (!empty($agenda['topics'])): ?>
                            <?php foreach ($agenda['topics'] as $topic): ?>
                                <div class="topic-item">
                                    <h5><?php echo $topic['title']; ?></h5>
                                    <p><?php echo $topic['description']; ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</body>

</html>
