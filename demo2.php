<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values from the form
    $developer_rate = $_POST['developer_rate'];
    $developer_hours = $_POST['developer_hours'];
    $designer_rate = $_POST['designer_rate'];
    $designer_hours = $_POST['designer_hours'];
    $tester_rate = $_POST['tester_rate'];
    $tester_hours = $_POST['tester_hours'];
    $pm_rate = $_POST['pm_rate'];
    $pm_hours = $_POST['pm_hours'];
    $hardware_cost = $_POST['hardware_cost'];
    $software_cost = $_POST['software_cost'];
    $operational_cost = $_POST['operational_cost'];
    $training_cost = $_POST['training_cost'];
    $contingency_percentage = $_POST['contingency'];

    // Calculate labor costs
    $developer_cost = $developer_rate * $developer_hours;
    $designer_cost = $designer_rate * $designer_hours;
    $tester_cost = $tester_rate * $tester_hours;
    $pm_cost = $pm_rate * $pm_hours;
    $total_labor_cost = $developer_cost + $designer_cost + $tester_cost + $pm_cost;

    // Calculate total cost before contingency
    $total_cost_before_contingency = $total_labor_cost + $hardware_cost + $software_cost + $operational_cost + $training_cost;

    // Calculate contingency
    $contingency = ($contingency_percentage / 100) * $total_cost_before_contingency;

    // Calculate total estimated expense
    $total_estimated_expense = $total_cost_before_contingency + $contingency;

    echo "<h1>Estimated Expense for Software Project</h1>";
    echo "<p>Total Labor Cost: $" . number_format($total_labor_cost, 2) . "</p>";
    echo "<p>Hardware Cost: $" . number_format($hardware_cost, 2) . "</p>";
    echo "<p>Software Cost: $" . number_format($software_cost, 2) . "</p>";
    echo "<p>Operational Cost: $" . number_format($operational_cost, 2) . "</p>";
    echo "<p>Training Cost: $" . number_format($training_cost, 2) . "</p>";
    echo "<p>Contingency: $" . number_format($contingency, 2) . "</p>";
    echo "<h2>Total Estimated Expense: $" . number_format($total_estimated_expense, 2) . "</h2>";
} else {
    echo "Please submit the form to calculate the expense.";
}
?>
