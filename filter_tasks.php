<?php
// Include config file
require_once "db_connection.php";

// Check if the user is logged in, if not then redirect him to login page
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: supervisor_page.php");
    exit;
}

// Check if the date or name parameter is provided
if (isset($_GET['date']) || isset($_GET['name'])) {
    // Retrieve the date and name parameters
    $date = isset($_GET['date']) ? $_GET['date'] : null;
    $name = isset($_GET['name']) ? $_GET['name'] : null;

    // Prepare the SQL query with placeholders for the date and name
    $query = "SELECT w.*, e.name, e.surname FROM workday_description_data w JOIN employee_data e ON w.employee_id = e.id";
    $conditions = array();

    // Prepare the conditions for filtering
    if ($date !== null) {
        $conditions[] = "w.date = :date";
    }
    if ($name !== null) {
        $conditions[] = "(e.name LIKE :name OR e.surname LIKE :name)";
    }

    // Combine the conditions
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    // Prepare the statement
    $statement = $pdo->prepare($query);

    // Bind the parameters to the placeholders
    if ($date !== null) {
        $statement->bindParam(':date', $date);
    }
    if ($name !== null) {
        $nameParam = "%" . $name . "%";
        $statement->bindParam(':name', $nameParam);
    }

    // Execute the query
    $statement->execute();

    // Fetch and process the filtered data
    $filteredTasks = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        // Process each row of data
        $filteredTasks[] = $row;
    }

    // Return the filtered tasks as JSON
    echo json_encode($filteredTasks);
}
?>
