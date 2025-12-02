<?php
session_start();
include('../db/config.php');

if (!isset($_SESSION['user_email'])) {
  header("Location: login.php");
  exit();
}

$user_email = $_SESSION['user_email'];

// Fetch user data
$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$user_email'");
$user = mysqli_fetch_assoc($result);

if (!$user) {
  echo "❌ User not found!";
  exit();
}

// ✅ Fallbacks
$profile_pic = !empty($user['profile_pic']) ? "../uploads/" . htmlspecialchars($user['profile_pic']) : "https://www.gstatic.com/images/branding/product/2x/avatar_circle_512dp.png";
$username = isset($user['username']) ? htmlspecialchars($user['username']) : "Unknown User";
$phone = isset($user['phone']) ? htmlspecialchars($user['phone']) : "Not Provided";
$address = isset($user['address']) ? htmlspecialchars($user['address']) : "Not Provided";
$email = htmlspecialchars($user['email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>👤 My Profile | GameZone</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #0f0f0f, #050505);
      color: #fff;
      padding: 2rem;
      min-height: 100vh;
    }

    /* 🔙 Back button */
    .back-btn {
      position: absolute;
      top: 20px;
      left: 20px;
      padding: 10px 18px;
      background: #00ffcc;
      color: #000;
      font-weight: bold;
      text-decoration: none;
      border-radius: 25px;
      box-shadow: 0 0 10px #00ffcc99;
      transition: 0.3s;
    }

    .back-btn:hover {
      background: #00cc99;
      box-shadow: 0 0 18px #00ffccaa;
    }

    .profile-box {
      max-width: 550px;
      margin: auto;
      margin-top: 60px; /* Space below back button */
      background: rgba(255, 255, 255, 0.02);
      padding: 2rem;
      border-radius: 14px;
      box-shadow: 0 0 20px rgba(0, 255, 204, 0.2);
      text-align: center;
      backdrop-filter: blur(6px);
    }

    .profile-box img {
      width: 130px;
      height: 130px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #00ffcc;
      margin-bottom: 1rem;
      box-shadow: 0 0 12px #00ffcc44;
    }

    h2 {
      color: #00ffcc;
      margin-bottom: 1.5rem;
      text-shadow: 0 0 6px #00ffcc66;
    }

    .info {
      margin: 12px 0;
      font-size: 1.1rem;
      background: #1a1a1a;
      padding: 12px;
      border-radius: 8px;
      box-shadow: inset 0 0 8px #00ffcc11;
    }

    .info span {
      font-weight: bold;
      color: #00ffcc;
    }

    a.button {
      display: inline-block;
      margin-top: 2rem;
      padding: 12px 28px;
      background: #00ffcc;
      color: #000;
      text-decoration: none;
      border-radius: 25px;
      font-weight: bold;
      transition: 0.3s;
      box-shadow: 0 0 10px #00ffcc99;
    }

    a.button:hover {
      background: #00cc99;
      box-shadow: 0 0 18px #00ffccaa;
    }

    @media (max-width: 500px) {
      .profile-box {
        padding: 1.5rem;
      }

      .info {
        font-size: 1rem;
      }

      a.button {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <!-- 🔙 Back to Home -->
  <a href="../index.php" class="back-btn">⬅ Back</a>

  <div class="profile-box">
    <img src="<?= $profile_pic ?>" alt="Profile Picture">
    <h2>👤 My Profile</h2>

    <div class="info"><span>Username:</span> <?= $username ?></div>
    <div class="info"><span>Email:</span> <?= $email ?></div>
    <div class="info"><span>Phone:</span> <?= $phone ?></div>
    <div class="info"><span>Address:</span> <?= $address ?></div>

    <a class="button" href="edit_profile.php">✏️ Edit Profile</a>
  </div>

</body>
</html>
