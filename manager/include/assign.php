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
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            letter-spacing: 0.5px;
        }

        h2,
        h4 {
            color: #333;
        }

        .container1 {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: linear-gradient(to right, #ffffff, #f2f3f5);
        }

        .btn-info {
            transition: transform 0.2s ease-in-out;
        }

        .btn-info:hover {
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .container1 {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <br><br>

    <?php
    // Include database configuration file
    include ('config.php');

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Sanitize and validate input
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id !== false) {
            // Prepare and execute SQL query to get required skills
            $sql = "SELECT req_skill.skill FROM task LEFT JOIN req_skill ON task.task_id=req_skill.task_id WHERE task.task_id=?";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    mysqli_stmt_bind_result($stmt, $required_skills_input);
                    mysqli_stmt_fetch($stmt);

                    if (!empty($required_skills_input)) {
                        $required_skills_array = explode(',', $required_skills_input);
                        $required_skills_imploded = "'" . implode("','", $required_skills_array) . "'";

                        foreach ($required_skills_array as $skill) {
                            // Prepare and execute SQL query to get suggested employees
                            $query = "SELECT 
                                        e.name,
                                        e.emp_id,
                                        e.gender,
                                        GROUP_CONCAT(
                                            CONCAT(s.name, ' (', es.priority, ')') ORDER BY 
                                            CASE WHEN s.name = ? THEN es.priority ELSE 0 END DESC
                                        ) AS skills,
                                        SUM(CASE WHEN s.name = ? THEN es.priority ELSE 0 END) AS total_priority
                                    FROM 
                                        employee e
                                    INNER JOIN 
                                        emp_skills es ON e.emp_id = es.emp_id
                                    INNER JOIN 
                                        skill s ON es.skill_id = s.id
                                    WHERE 
                                        e.emp_id IN (
                                            SELECT emp_id 
                                            FROM emp_skills 
                                            INNER JOIN skill ON emp_skills.skill_id = skill.id 
                                            WHERE skill.name = ?
                                        )
                                    GROUP BY 
                                        e.emp_id, e.name, e.gender
                                    ORDER BY 
                                        total_priority DESC
                                    LIMIT 2;";
                            $stmt2 = mysqli_prepare($conn, $query);

                            if ($stmt2) {
                                mysqli_stmt_bind_param($stmt2, "sss", $skill, $skill, $skill);
                                mysqli_stmt_execute($stmt2);
                                mysqli_stmt_store_result($stmt2);

                                if (mysqli_stmt_num_rows($stmt2) > 0) {
                                    echo "<h2>Suggested Employees:</h2><br>";
                                    mysqli_stmt_bind_result($stmt2, $name, $emp_id, $gender, $skills, $total_priority);
                                    while (mysqli_stmt_fetch($stmt2)) {
                                        $prefix = ($gender == "male") ? "Mr." : "Mrs.";
                                        echo "<div class='container1'>";
                                        echo "<h4>$prefix " . ucfirst($name) . " </h4>";
                                        echo "(" . ucfirst($skills) . ") <br>";
                                        echo "Score: " . $total_priority . "<br>";
                                        echo "<form action='updatetaskstatus.php' method='post'>";
                                        echo "<input type='hidden' name='task_id' value='$id'>";
                                        echo "<input type='hidden' name='emp_id' value='$emp_id'><br>";
                                        echo "<button class='btn btn-info' type='submit' name='submit'>Assign</button>";
                                        echo "</form>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "No suggested employees found for skill: $skill";
                                }
                                mysqli_stmt_close($stmt2);
                            } else {
                                echo "Error in preparing query: " . mysqli_error($conn);
                            }
                        }
                    } else {
                        echo "No required skills specified.";
                    }
                } else {
                    echo "Task ID not found.";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "Error in preparing query: " . mysqli_error($conn);
            }
        } else {
            echo "Invalid task ID.";
        }
    }
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>