<!DOCTYPE html>
<html>
<?php include "./head.php"; ?>

<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to the employee page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: employee_page.php");
    exit;
}

// Include config file
require_once "db_connection.php";

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, email, password, name, surname FROM employee_data WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = trim($_POST["email"]);
            $param_password = $password;
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if email exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $email = $row["email"];
                        $hashed_password = $row["password"];
                        $name = $row["name"];
                        $surname = $row["surname"];

                        if (password_verify($param_password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["name"] = $name;
                            $_SESSION["surname"] = $surname;
                            // Redirect user to employee page
                            header("location: employee_page.php");
                            exit;
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid password.";
                        }
                    } else {
                    // Email doesn't exist, display a generic error message
                        $login_err = "Invalid email or password.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                // Close statement
                unset($stmt);
            }
        }   
    }
    // Close connection
    unset($pdo);
}
?>

<body>
    <?php include "header.php"; ?>

    <main class="company-main__loginpage">
        <div class="container">
            <div class="login-form__wrapper">
                <?php if (!empty($login_err)) : ?>
                    <div class="alert alert-danger"><?php echo $login_err; ?></div>
                <?php endif; ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <ul class="form__list">
                        <li>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                            </div>
                        </li>
                        <li>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                            </div>
                        </li>
                        <li>
                            <input type="submit" class="button--primary" value="Login">
                        </li>
                    </ul>
                </form>

                <p class="text-style--bold">If you are not registered, <a class="link" href="registration_page.php">you can do it here</a>.</p>
            </div>
        </div>
    </main>

    <?php include "./footer.php"; ?>
</body>

</html>
