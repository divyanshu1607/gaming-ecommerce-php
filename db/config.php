<?php
// Database configuration
$conn = new mysqli("localhost", "root", "", "gamezone");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
