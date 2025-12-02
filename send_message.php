<?php
session_start();
include('db/config.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validate inputs
    if ($name == "" || $email == "" || $subject == "" || $message == "") {
        echo "<script>alert('❌ All fields are required!'); window.history.back();</script>";
        exit();
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Your message has been sent successfully! We will contact you soon.'); window.location.href='contact.php';</script>";
    } else {
        echo "<script>alert('❌ Something went wrong. Please try again later.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // If someone tries to access directly
    header("Location: contact.php");
    exit();
}
?>
