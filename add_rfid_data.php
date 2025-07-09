<?php
// Database credentials
$servername = "localhost";         // For 000webhost, use "localhost"
$username = "your_db_username";    // Replace with your DB username
$password = "your_db_password";    // Replace with your DB password
$dbname = "your_db_name";          // Replace with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if carduid and name are received
if (isset($_GET['carduid']) && isset($_GET['name'])) {
    $carduid = $_GET['carduid'];
    $name = $_GET['name'];

    // Optional: sanitize input
    $carduid = $conn->real_escape_string($carduid);
    $name = $conn->real_escape_string($name);

    // Insert into database
    $sql = "INSERT INTO rfid_logs (carduid, name, timestamp) VALUES ('$carduid', '$name', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Data Saved Successfully";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Missing Parameters";
}

$conn->close();
?>
