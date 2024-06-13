<?php
session_start();
include "config.php";

$user = $_SESSION['email'];


$sql_employees = "SELECT emp_id, name,gender FROM employee WHERE role NOT IN ('manager', 'admin')";
$result_employees = mysqli_query($conn, $sql_employees);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee Skill</title>
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
        select {
            width: 100%;
            padding: 10px;
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
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add Employee Skills</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="employeeId" class="form-label">Employee</label>
                <select name="id" id="employeeId" class="form-select">
                    <option value="" selected disabled>Select employee ID</option>
                    <?php
                    if ($result_employees && mysqli_num_rows($result_employees) > 0) {
                        while ($row_employee = mysqli_fetch_assoc($result_employees)) {
                            $prefix = ($row_employee['gender'] == "male") ? "Mr." : "Mrs.";
                            $empId = $row_employee['emp_id'];
                            $name = $row_employee['name'];
                            echo "<option value='$empId'>$empId :$prefix $name </option>";
                        }
                    } else {
                        echo "<option value=''>No employees found</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="leader">Select Skill</label>
                <select name="skill" class="form-select form-control" aria-label=".form-select-lg example">
                    <option selected>Select Skill</option>
                    <?php
                    $sql = "SELECT * FROM `skill`";
                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            for ($i = 0; $i <= 1000; $i++) {
                                $row = mysqli_fetch_array($result);
                                if ($row !== null) {
                                    ?>
                                    <option value="<?php echo $row[0]; ?>">
                                        <?php echo $row[1]; ?>
                                    </option>
                                    <?php
                                } else {
                                    echo "null";
                                }
                            }
                        } else {
                            echo "rows are 0";
                        }
                    } else {
                        echo "Query not execute";
                    }
                    ?>
                </select>

            </div>

            <label for="grade">Skill Grade:</label>
            <input type="text" id="task_name" name="grade" required>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>

</html>


<?php
if (isset($_POST['submit'])) {
    include ('config.php');

    $id = $_POST['id'];
    $skill = $_POST['skill'];
    $grade = $_POST['grade'];


    $sql = "INSERT INTO `emp_skills`( `skill_id`, `emp_id`, `priority`) VALUES ('$skill','$id','$grade')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $message = 'Skill Added for ' . $id . ' successfully';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/skill.php';</script>";
    } else {
        $message = 'Something went wrong.';
        echo "<script type='text/javascript'>alert('$message');window.location.href='/project/manager/skill.php';</script>";
    }

    mysqli_close($conn);
}
?>