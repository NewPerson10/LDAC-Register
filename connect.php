<?php
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
        echo "Registration successful";
    } else {
        echo "Registration unsuccessful: " . $conn->error;
    }
    

    $conn->close();
}
?>
