<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Agenda</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"],
        button[type="button"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        button[type="submit"]:hover,
        button[type="button"]:hover {
            background-color: #45a049;
        }

        .agenda-topic {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
            position: relative;
        }

        .agenda-topic-title {
            margin-bottom: 10px;
        }

        .remove-topic {
            position: absolute;
            top: -10px;
            right: -10px;
            background: none;
            border: none;
            color: red;
            cursor: pointer;
            font-size: 20px;
            padding: 5px;
            border-radius: 50%;
        }

        .optional-notes {
            color: #666;
            margin-top: 10px;
        }

        .optional-notes label {
            font-weight: normal;
        }

        .btn-close {
            background-color: red;
            position: absolute;
            top: 10px;
            right: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add Agenda</h1>
        <form action="addMeetingAgenda.php" method="post">
            <input type="text" name="id" value="<?php echo $_POST['id'];?>">
            <label for="agendaTitle">Agenda Title:</label>
            <input type="text" id="agendaTitle" name="title" required>

            <label for="agendaDescription">Agenda Description:</label>
            <textarea id="agendaDescription" name="desc" rows="3" required></textarea>

            <div id="agendaTopics">
                <div class="agenda-topic">
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="removeTopic(this)"></button>
                    <div class="agenda-topic-title">
                        <label for="topicTitle">Agenda Topic:</label>
                        <input type="text" id="topicTitle" name="topic[]" required>
                    </div>
                    <div>
                        <label for="topicDescription">Topic Description:</label>
                        <textarea id="topicDescription" name="topicdesc[]" rows="2" required></textarea>
                    </div>
                </div>
            </div>

            <button type="button" onclick="addTopic()">Add Another Topic</button>

            <div class="agenda-topic optional-notes">
                <b><label for="optionalNotes">Optional Notes:</label></b>
                <input type="text" id="optionalNotes" name="note">
            </div>

            <button type="submit" name="submit">Submit Agenda</button>
        </form>
    </div>

    <script>
        function addTopic() {
            const agendaTopics = document.getElementById('agendaTopics');
            const topicDiv = document.createElement('div');
            topicDiv.classList.add('agenda-topic');
            topicDiv.innerHTML = `
            <button  class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="removeTopic(this)"></button>
                <div class="agenda-topic-title">
                    <label for="topicTitle">Agenda Topic:</label>
                    <input type="text" id="topicTitle" name="topic[]" required>
                </div>
                <div>
                    <label for="topicDescription">Topic Description:</label>
                    <textarea id="topicDescription" name="topicdesc[]" rows="2" required></textarea>
                </div>`;
            agendaTopics.appendChild(topicDiv);
        }

        function removeTopic(element) {
            const agendaTopics = document.getElementById('agendaTopics');
            const topicDiv = element.parentNode;
            agendaTopics.removeChild(topicDiv);
        }
    </script>
</body>

</html>

