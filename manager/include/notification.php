<?php
if (isset($_POST['submit'])) {
    include "config.php";

    $id = $_POST['id'];
   
    $check_sql = "SELECT * FROM `notification` WHERE `meeting_id` = '$id'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) == 0) {
        $sql = "INSERT INTO `notification`(`meeting_id`) VALUES ('$id')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
           
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
       
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .container {
            width: 400px;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }

        .select-box {
            margin-bottom: 20px;
        }

        .select-box label {
            display: block;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }

        .select-box select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 16px;
            cursor: pointer;
            outline: none;
        }

        .select-box select option {
            padding: 10px;
            transition: background-color 0.3s;
        }

        .select-box select option:hover {
            background-color: #e9e9e9;
        }

        .select-box select option:checked {
            background-color: #007bff;
            color: #fff;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Meeting Notification</h1>
        <form action="notify.php" method="post">
            <div class="select-box">
            <input type="hidden" name="id" value="<?php echo $_POST['id'];?>">

                <label for="users">Select Users:</label>
                <select name="emp[]" class="form-select form-control" aria-label=".form-select-lg example" multiple>

                    <?php
                    include "config.php";
                    $sql = "SELECT employee.emp_id,employee.name,employee.gender FROM `employee`";
                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            for ($i = 0; $i <= 100; $i++) {
                                $row = mysqli_fetch_array($result);
                                if ($row !== null) {
                                    $prefix = ($row['gender'] == "male") ? "Mr." : "Mrs.";
                                    ?>
                                    <option value="<?php echo $row[0]; ?>">
                                        <?php echo $prefix . " " . $row[1]; ?></i>
                                    </option>
                                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn" name="submit">Send</button>
        </form>
    </div>
</body>

</html>