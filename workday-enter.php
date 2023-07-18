<?php
// Establish database connection
$servername = "localhost";
$username = "dejana123";
$password = "12345";
$dbname = "employee";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$workday_description = $_POST['workday_description'];

// Prepare and execute the SQL statement
$sql = "INSERT INTO workday_description_data (date, start_time, end_time, workday_description) VALUES ('$date', '$start_time', '$end_time', '$workday_description')";

if ($conn->query($sql) === TRUE) {
    echo "Task saved successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>
