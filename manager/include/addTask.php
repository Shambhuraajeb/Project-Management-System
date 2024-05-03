<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Task</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
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
        input[type="date"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-top: 5px;
        }

        .suggested-employees {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Assign Task</h1>
        <form action="addTask.php" method="post">
            <label for="task_name">Task Name:</label>
            <input type="text" id="task_name" name="task_name" required><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>

            <input type="hidden" id="datetime" name="start">

            <script>
                var now = new Date();
                var formattedDatetime = now.toISOString().slice(0, 19).replace("T", " ");
                document.getElementById("datetime").value = formattedDatetime;
            </script>

            <label for="deadline">Deadline:</label>
            <input type="date" id="deadline" name="deadline" required><br>

            <label for="required_skills">Required Skills (comma-separated):</label>
            <input type="text" id="required_skills" name="required_skills" required><br>

            <button type="submit" name="submit">Assign Task</button><br><br>
        </form>



        <?php
        if (isset($_POST['submit'])) {
            include "config.php";

            // Sanitize input data
            $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $start = date('Y-m-d H:i:s'); // Current datetime
            $deadline = mysqli_real_escape_string($conn, $_POST['deadline']);
            $required_skills_input = mysqli_real_escape_string($conn, $_POST['required_skills']);
            //echo $required_skills_input;
        
            // Insert task into task table
            $sql = "INSERT INTO `task`(`name`, `start_time`, `end_time`, `description`) 
                    VALUES ('$task_name', '$start', '$deadline', '$description')";
            $result = mysqli_query($conn, $sql);
            $task_id = $conn->insert_id;

            if ($result) {
                // Insert task status
                $sql1 = "INSERT INTO `task_status`(`task_id`) VALUES ('$task_id')";
                $result2 = mysqli_query($conn, $sql1);

                if ($result2) {
                    // Insert required skills into req_skill table
                    $required_skills_array = explode(',', $required_skills_input);
                    $required_skills_imploded = "'" . implode("','", $required_skills_array) . "'";
                    

                    $sql3 = "INSERT INTO `req_skill`(`task_id`, `skill`) VALUES (?, ?)";
                    $stmt = mysqli_prepare($conn, $sql3);

                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, 'ss', $task_id, $required_skills_input);
                        $result3 = mysqli_stmt_execute($stmt);

                        if ($result3) {
                            $query = "SELECT e.name, e.emp_id, e.gender, 
                        GROUP_CONCAT(CONCAT(s.name, ' (', es.priority, ')') ORDER BY 
                        CASE WHEN s.name IN ($required_skills_imploded) THEN es.priority ELSE 0 END DESC) AS skills,
                        SUM(CASE WHEN s.name IN ($required_skills_imploded) THEN es.priority ELSE 0 END) AS total_priority
                        FROM employee e
                        INNER JOIN emp_skills es ON e.emp_id = es.emp_id
                        INNER JOIN skill s ON es.skill_id = s.id
                        WHERE e.emp_id IN (
                            SELECT emp_id FROM emp_skills 
                            INNER JOIN skill ON emp_skills.skill_id = skill.id 
                            WHERE skill.name IN ($required_skills_imploded)
                        )
                        GROUP BY e.emp_id, e.name, e.gender
                        ORDER BY total_priority DESC
                        LIMIT 2";

                    $result1 = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result1) > 0) {
                        echo "<h2>Suggested Employees:</h2><br>";
                        while ($row = mysqli_fetch_assoc($result1)) {
                            $prefix = ($row["gender"] == "male") ? "Mr." : "Mrs.";
                            $emp_id = $row['emp_id'];
                            echo "<div class='container1'>";
                            echo "<h4>$prefix " . ucfirst($row['name']) . " </h4>";
                            echo "(" . $row['skills'] . ")";
                            echo "Score: " . $row['total_priority'] . "";
                            echo "<form action='updatetaskstatus.php' method='post'>";
                            echo "<input type='hidden' name='task_id' value='$task_id'>";
                            echo "<input type='hidden' name='emp_id' value='$emp_id'>";
                            echo "<button class='btn btn-info' type='submit' name='submit'>Assign</button>";
                            echo "</form>";
                            echo "</div>";
                        }
                    } else {
                        echo "No employees found with the required skills.";
                    }
                            
                        } else {
                            echo "Error: " . mysqli_stmt_error($stmt);
                        }
                    } else {
                        echo "Error: Unable to prepare statement.";
                    }
                    
                } else {
                    echo "Task not added and task status not added.";
                }
            } else {
                echo "Task not added.";
            }

            mysqli_close($conn);
        }
        ?>
        <script>
            function assignTask() {
                window.location = "include/addTask.php";
            }
        </script>
</body>

</html>