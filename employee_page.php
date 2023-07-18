<!DOCTYPE html>
<html>
<?php include "./head.php"; ?>

<?php
// Initialize the session
session_start();

// Include config file
require_once "db_connection.php";
 
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login_page.php");
    exit;
}

// Process task submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $workday_description = $_POST["workday_description"];
    $employee_id = $_SESSION["id"];

    // Prepare the SQL statement
    $sql = "INSERT INTO workday_description_data (date, start_time, end_time, workday_description, employee_id) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $pdo->prepare($sql)) {
        // Bind the parameters to the statement
        $stmt->bindParam(1, $date);
        $stmt->bindParam(2, $start_time);
        $stmt->bindParam(3, $end_time);
        $stmt->bindParam(4, $workday_description);
        $stmt->bindParam(5, $employee_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Task details successfully saved
            // You can perform any additional actions or display a success message here
        } else {
            // Error occurred while executing the statement
            // You can handle the error or display an error message here
        }

        // Close the statement
        unset($stmt);
    }
}

// Retrieve tasks for display
$id = (int) $_SESSION['id'];
$sql = "SELECT * FROM workday_description_data WHERE employee_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $id);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
unset($pdo);
?>

<body>
    <?php include "header.php"; ?>

    <main class="company-main">
        <div class="container">
            <div class="layout--2columns full-width">
                <div class="column narrow flex-center">
                    <img class="employe_picture" src="./images/attend-icon-10.png" alt="Fotografija zaposlenika" />
                </div>
                <div class="column">
                    <div class="company-main__column_employeinformation">
                        <h3>Hello, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>!</h3>

                        <ul class="employee-info__list">
                            <li>Name: <strong> <?php echo htmlspecialchars($_SESSION["name"]); ?></strong></li>
                            <li>Surname: <strong><?php echo htmlspecialchars($_SESSION["surname"]); ?></strong></li>
                            <li>Email: <strong><?php echo htmlspecialchars($_SESSION["email"]); ?></strong></li>
                        </ul>

                        <p>
                            <a href="reset_password.php" class="button--secondary">Reset password</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="container">
            <section class="section">
                <form class="task-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input type="time" class ="time-input" name="start_time" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input type="time" class ="time-input" name="end_time" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="workday_description">Description</label>
                        <textarea name="workday_description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group" id="submit-button">
                            <input type="submit" class="button--primary" value="Submit Task">
                    </div>
                </form>

                <table class="task-list__table">
                    <tr>
                        <th>Start time</th>
                        <th>End time</th>
                        <th>Date</th>
                        <th>Description</th>
                    </tr>
                    <?php foreach ($tasks as $task) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($task['start_time']); ?></td>
                            <td><?php echo htmlspecialchars($task['end_time']); ?></td>
                            <td><?php echo htmlspecialchars($task['date']); ?></td>
                            <td><?php echo htmlspecialchars($task['workday_description']); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </section>
        </div>
        <div class="modal">
            <div class="modal-content">
                <h2>SAVED</h2>
            </div>
        </div>
    </main>
    <script src="./js/script.js"></script>
    <?php include "./footer.php"; ?>
</body>

</html>
