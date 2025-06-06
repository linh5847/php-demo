<?php
$servername = "phpdb.mysql.database.azure.com";
$username = "dbadmin";
$password = "M1ke0rBreak1234";
$database = "demo";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected to the database successfully!";

// Perform database operations here...

// Close the connection
$conn->close();
?>
