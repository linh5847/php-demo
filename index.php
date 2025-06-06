<?php
$servername = "phpdb.mysql.database.azure.com";
$username = "dbadmin";
$password = "M!ke0rBr$ak1234";
$database = "phpdb";

// Create connection
// $conn = new mysqli($servername, $username, $password, $database);

$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL, "/var/www/html/DigiCertGlobalRootG2.crt.pem", NULL, NULL);
mysqli_real_connect($conn, $servername, $username, $password, $database, 3306, MYSQLI_CLIENT_SSL);

// Check connection
// if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
// }
if (mysqli_connect_errno($conn)) {
  die('Failed to connect to MySQL: '.mysqli_connect_error());
}

echo "Connected to the database successfully!";

// Perform database operations here...

// Close the connection
$conn->close();
?>
