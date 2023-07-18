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
    header("location: supervisor_page.php");
    exit;
}

?>

<body>
    <?php include "header.php"; ?>

    <main class="main__columns">
        <div class="main_columnright">
            <div class="container">
                <div class="layout--2columns full-width">
                    <div class="column narrow flex-center">
                        <img class="employe_picture" src="./images/attend-icon-10.png" alt="Employee photo" />
                    </div>
                    <div class="column">
                        <div class="company-main__column_employeinformation">
                            <h3>Hello, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>!</h3>

                            <ul class="employee-info__list">
                                <li>Name: <strong> <?php echo htmlspecialchars($_SESSION["name"]); ?></strong></li>
                                <li>Surname: <strong><?php echo htmlspecialchars($_SESSION["surname"]); ?></strong></li>
                                <li>Email: <strong><?php echo htmlspecialchars($_SESSION["email"]); ?></strong></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="filter-container">
                    <label for="date-filter">Filter by Date:</label>
                    <input type="date" id="date-filter" class="form-control">
                </div>
                <div class="filter-container">
                    <label for="name-filter">Filter by Name/Surname:</label>
                    <input type="text" id="name-filter" class="form-control">
                </div>
                <button id="filter-button" class="button--primary">Filter</button>

                <table class="task-list__table">
                    <!-- Zaglavlje tablice -->
                    <tr>
                        <th>Date</th>
                        <th>Start time</th>
                        <th>End time</th>
                        <th>Workday description</th>
                        <th>Employee</th>
                    </tr>

                    <?php
                    $results = mysqli_query($db, "SELECT w.*, e.name, e.surname FROM workday_description_data w JOIN employee_data e ON w.employee_id = e.id");
                    while ($data = mysqli_fetch_array($results)) { ?>
                        <tr>
                            <td><?php echo $data['date']; ?></td>
                            <td><?php echo $data['start_time']; ?></td>
                            <td><?php echo $data['end_time']; ?></td>
                            <td><?php echo $data['workday_description']; ?></td>
                            <td><?php echo $data['name'] . ' ' . $data['surname']; ?></td>
                        </tr>
                    <?php } ?>
                </table>

            </div>

    </main>
    <script src="./js/script1.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php
    include "./footer.php";
    mysqli_close($db); // Close connection
    ?>

</body>

</html>
