<?php
// Database credentials
$servername = "localhost";         // Usually "localhost" on 000webhost
$username = "your_db_username";    // Replace with your DB username
$password = "your_db_password";    // Replace with your DB password
$dbname = "your_db_name";          // Replace with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get all RFID records
$sql = "SELECT carduid, name, timestamp FROM rfid_logs ORDER BY timestamp DESC";
$result = $conn->query($sql);

// HTML and table start
echo "<!DOCTYPE html>
<html>
<head>
    <title>RFID Access Log</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        h2 {
            color: #333;
        }
    </style>
</head>
<body>
    <h2>RFID Access Log</h2>";

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Card UID</th>
                <th>Name</th>
                <th>Timestamp</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["carduid"]) . "</td>
                <td>" . htmlspecialchars($row["name"]) . "</td>
                <td>" . $row["timestamp"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No RFID data found.</p>";
}

echo "</body></html>";

$conn->close();
?>
