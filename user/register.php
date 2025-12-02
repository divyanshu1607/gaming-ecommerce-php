<?php
include('../db/config.php');

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['username']); // Change username to name
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $msg = "❌ Passwords do not match!";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("sss", $name, $email, $hashed);

            if ($stmt->execute()) {
                $msg = "✅ Registration successful! <a href='login.php'>Login Now</a>";
            } else {
                $msg = "❌ Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            if (is_object($conn) && property_exists($conn, 'error')) {
                $msg = "❌ SQL Prepare failed: " . $conn->error;
            } else {
                $msg = "❌ SQL Prepare failed: Invalid database connection.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Registration - GameZone</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #0f0f0f;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .box {
      position: relative;
      width: 400px;
      height: 550px;
      background: #1e1e1e;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 0 25px rgba(0,0,0,0.5);
    }

    .box::before {
      content: "";
      position: absolute;
      width: 100%;
      height: 100%;
      filter: drop-shadow(0 15px 50px #00ffff);
      border-radius: 20px;
      animation: rotating 5s linear infinite;
      animation-delay: -1s;
    }

    .box::after {
      content: "";
      position: absolute;
      inset: 4px;
      background: #2d2d39;
      border-radius: 15px;
      border: 8px solid #25252b;
    }

    @keyframes rotating {
      0% {
        transform: rotate(0deg);
        box-shadow: 0 0 20px #00fff7, 0 0 40px #ff006e;
      }
      100% {
        transform: rotate(360deg);
        box-shadow: 0 0 40px #ff006e, 0 0 20px #00fff7;
      }
    }

    .box-content {
      position: absolute;
      inset: 20px;
      z-index: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .box-content h2 {
      color: #fff;
      font-size: 24px;
      margin-bottom: 15px;
    }

    .box-content input {
      width: 100%;
      margin: 8px 0;
      padding: 10px;
      border: none;
      border-radius: 20px;
      background: #2a2a2a;
      color: #fff;
      outline: none;
      text-align: center;
      font-size: 15px;
    }

    .box-content button {
      width: 100%;
      margin-top: 15px;
      padding: 10px;
      background: #00fff7;
      color: #000;
      font-weight: 600;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .box-content button:hover {
      background: #00cccb;
    }

    .msg {
      margin-top: 10px;
      color: #00ff99;
      font-size: 14px;
      font-weight: 500;
    }

    .msg a {
      color: #00ccff;
      text-decoration: none;
    }

    .msg a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="box">
    <div class="box-content">
      <h2>Register Account</h2>
      <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm" placeholder="Confirm Password" required><br>
        <button type="submit">Register</button>
      </form>
      <?php if ($msg): ?>
        <div class="msg"><?= $msg ?></div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
