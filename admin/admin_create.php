<?php
include("../db/config.php");

$username = "admin";
$password = "admin123";
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Delete old users with same name
mysqli_query($conn, "DELETE FROM admin WHERE username = '$username'");

// Insert new secure user
$sql = "INSERT INTO admin (username, password) VALUES ('$username', '$hashed')";
if (mysqli_query($conn, $sql)) {
    echo "✅ Admin created: $username / $password";
} else {
    echo "❌ Error: " . mysqli_error($conn);
}
?>
