<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate and sanitize the data (you can add your own validation logic here)

    // Connect to the MySQL database
    $servername = "localhost"; // Replace with your server name
    $username = "root"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password
    $database = "registration"; // Replace with your MySQL database name

    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user already exists
    $checkQuery = "SELECT * FROM register WHERE email = '$email'";
    $result = $conn->query($checkQuery);
    if ($result->num_rows > 0) {
        echo "You are already registered.";
        $conn->close();
        return;
    }

    // Prepare and execute the SQL statement to insert data
    $sql = "INSERT INTO register (firstname, lastname, email, password)
            VALUES ('$firstname', '$lastname', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Registration unsuccessful: " . $conn->error;
    }
    

    $mail = new PHPmailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username= 'ricardoharrison15@gmail.com';
    $mail->Password = 'ugttboxbopgsjfig '; //email app password
    $mail->SMTPSecure = 'ssl';
    $mail->Port =465;

    $mail->setFrom('ricardoharrison15@gmail.com');
    $mail->addAddress($_POST["email"]);
    $mail->isHTML(true);

    $mail-> Subject = "Hello! ".$_POST["firstname"]." ".$_POST["lastname"];
    $mail->Body = "<span style='font-family: Arial; font-weight: bold;'> Thank you for Registering! </span> <br><br>  As of now you're apart of the LDAC family. We hope to make your stay worth while.  <br><br> Warm regards, <br> Linstead Development Committee";

    $mail->send();

    echo "\n\nAn email has been sent to you.";

    
    $conn->close();
}
?>
