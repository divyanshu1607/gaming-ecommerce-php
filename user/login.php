<?php
session_start();
include("../db/config.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_email'] = $user['email']; // Set session
        header("Location: ../index.php");
        exit();
    } else {
        $error = "❌ Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Login - GameZone</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
    body{background:#0f0f0f;display:flex;justify-content:center;align-items:center;height:100vh;}
    .box{position:relative;width:350px;height:460px;background:#1e1e1e;border-radius:20px;overflow:hidden;box-shadow:0 0 25px rgba(0,0,0,0.5);}
    .box::before{content:"";position:absolute;width:100%;height:100%;filter:drop-shadow(0 15px 50px #00ffff);border-radius:20px;animation:rotating 4s linear infinite;animation-delay:-1s;}
    .box::after{content:"";position:absolute;inset:4px;background:#2d2d39;border-radius:15px;border:8px solid #25252b;}
    @keyframes rotating{0%{transform:rotate(0deg);box-shadow:0 0 20px #00fff7,0 0 40px #ff006e;}100%{transform:rotate(360deg);box-shadow:0 0 40px #ff006e,0 0 20px #00fff7;}}
    .box-content{position:absolute;inset:20px;z-index:1;display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;}
    .box-content h2{color:#fff;font-size:24px;margin-bottom:20px;letter-spacing:1px;}
    .box-content input{width:100%;margin:10px 0;padding:10px;border:none;border-radius:20px;background:#2a2a2a;color:#fff;outline:none;text-align:center;font-size:16px;}
    .box-content button{width:100%;margin-top:15px;padding:10px;background:#00fff7;color:#000;font-weight:600;border:none;border-radius:20px;cursor:pointer;transition:0.3s ease;}
    .box-content button:hover{background:#00cccb;}
    .error{color:#ff4d4d;margin-bottom:10px;font-size:14px;}
    .signup-link{margin-top:15px;font-size:14px;color:#fff;}
    .signup-link a{color:#00ccff;text-decoration:none;font-weight:500;}
    .signup-link a:hover{text-decoration:underline;}
  </style>
</head>
<body>
  <div class="box">
    <div class="box-content">
      <h2>User Login</h2>
      <form method="POST">
        <?php if ($error != "") echo "<div class='error'>$error</div>"; ?>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign In</button>
      </form>
      <div class="signup-link">
        Don't have an account? <a href="register.php">Sign Up</a>
      </div>
    </div>
  </div>
</body>
</html>
