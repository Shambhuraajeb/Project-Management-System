<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software Project Expense Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Software Project Expense Calculator</h1>
    <form action="demo2.php" method="post">
        <label for="developer_rate">Developer Hourly Rate ($):</label>
        <input type="number" id="developer_rate" name="developer_rate" required>
        
        <label for="developer_hours">Developer Hours:</label>
        <input type="number" id="developer_hours" name="developer_hours" required>
        
        <label for="designer_rate">Designer Hourly Rate ($):</label>
        <input type="number" id="designer_rate" name="designer_rate" required>
        
        <label for="designer_hours">Designer Hours:</label>
        <input type="number" id="designer_hours" name="designer_hours" required>
        
        <label for="tester_rate">Tester Hourly Rate ($):</label>
        <input type="number" id="tester_rate" name="tester_rate" required>
        
        <label for="tester_hours">Tester Hours:</label>
        <input type="number" id="tester_hours" name="tester_hours" required>
        
        <label for="pm_rate">Project Manager Hourly Rate ($):</label>
        <input type="number" id="pm_rate" name="pm_rate" required>
        
        <label for="pm_hours">Project Manager Hours:</label>
        <input type="number" id="pm_hours" name="pm_hours" required>
        
        <label for="hardware_cost">Hardware Cost ($):</label>
        <input type="number" id="hardware_cost" name="hardware_cost" required>
        
        <label for="software_cost">Software Cost ($):</label>
        <input type="number" id="software_cost" name="software_cost" required>
        
        <label for="operational_cost">Operational Cost ($):</label>
        <input type="number" id="operational_cost" name="operational_cost" required>
        
        <label for="training_cost">Training Cost ($):</label>
        <input type="number" id="training_cost" name="training_cost" required>
        
        <label for="contingency">Contingency Percentage (%):</label>
        <input type="number" id="contingency" name="contingency" required>
        
        <input type="submit" value="Calculate Expense">
    </form>
</body>
</html>
