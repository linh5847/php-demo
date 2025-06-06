<?php
$servername = "phpdb.mysql.database.azure.com";
$username = "dbadmin";
$password = "M!ke0rBr$ak1234";
$database = "phpdb";

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
