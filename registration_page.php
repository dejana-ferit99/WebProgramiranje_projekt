<!DOCTYPE html>
<html>
<?php include "./head.php"; ?>

<?php
// Include config file
require_once "db_connection.php";
 
// Define variables and initialize with empty values
$email = $password = $confirm_password = $name = $surname = "";
$email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

     // Validate username
     if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    }else{
        $sql = "SELECT id FROM employee_data WHERE email= :email";

        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            $param_email = trim($_POST["email"]);

            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $email_err = "Employee with this email is already registred.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! We have a proble, try again later.";
            }

            unset($stmt);
        }
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Molimo upisite ponovo lozinku.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Lozinka treba biti minimalno 6 znakova.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Molimo potvrdite lozinku.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Lozonka ne odgovara.";
        }
    }

    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){

        $sql = "INSERT INTO employee_data (email, password, name, surname) VALUES (:email, :password, :name, :surname)";



        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":surname", $param_surname, PDO::PARAM_STR);

            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            $param_name = trim($_POST["name"]);
            $param_surname = trim($_POST["surname"]);

            var_dump($param_email);

            if($stmt->execute()){
                header("location: login_page.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}
?>

<body>
<?php include "./header.php"; ?>

    <main class="company-main__loginpage">
        <div class="login-form__wrapper">
        
            <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <ul class="form__list">
                <li>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php  $email; ?>">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>   
                </li>
                <li>
                    <div class="form-group">
                        <label for="password">Name</label>
                        <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php  $name; ?>">
                    </div>
                </li>
                <li>
                    <div class="form-group">
                        <label for="password">Surname</label>
                        <input type="text" name="surname" class="form-control <?php echo (!empty($surname_err)) ? 'is-invalid' : ''; ?>" value="<?php  $surname; ?>">
                    </div>
                </li>
                <li>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php  $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                </li>
                <li>
                    <div class="form-group">
                        <label label="confirm_password">Confirm password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                </li>
                <li>
                    <div class="form-group--inline">
                        <input type="submit" class="button--primary button__login" value="Submit">
                        <input type="reset" class="button--secondary" value="Reset">
                    </div>
                </li>
            </ul>
            </form>

            <p>Već imate račun? <a href="login_page.php">Prijavi se ovdje</a>.</p>
        </div>
    </main>

    <?php include "./footer.php"; ?>

</body>

</html>