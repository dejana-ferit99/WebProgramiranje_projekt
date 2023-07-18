<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'dejana123');
define('DB_PASSWORD', '12345');
define('DB_NAME', 'employee');
 
try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

// potrebna varijabla kako bi preko mysqli dohvatili zadatke za ispis
$db = mysqli_connect("localhost", DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}

?>
