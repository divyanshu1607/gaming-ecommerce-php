<?php
session_start();
include('db/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>About Us | GameZone</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: var(--bg-color, #0f0f0f);
      color: var(--text-color, #fff);
      transition: background 0.3s, color 0.3s;
    }

    /* 🔹 Back Home button */
    .back-home {
      position: absolute;
      top: 20px;
      left: 20px;
      padding: 8px 18px;
      background: #00ffcc;
      color: #000;
      font-weight: bold;
      border-radius: 25px;
      text-decoration: none;
      transition: 0.3s;
      box-shadow: 0 0 10px #00ffcc88;
    }
    .back-home:hover {
      background: #00cc99;
      box-shadow: 0 0 20px #00ffcc;
    }

    header {
      padding: 20px;
      background: #1a1a1a;
      text-align: center;
      border-bottom: 2px solid #00ffcc66;
      position: relative; /* ensures button aligns inside header */
    }
    header h1 {
      font-size: 2rem;
      color: #00ffcc66;
      text-shadow: 0 0 10px #00ffcc66;
    }

    .container {
      max-width: 1100px;
      margin: auto;
      padding: 20px;
    }

    .about-section {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      align-items: center;
    }

    .about-section img {
      flex: 1;
      max-width: 500px;
      border-radius: 15px;
      box-shadow: 0 0 15px #00ffcc66;
      transition: transform 0.3s;
    }
    .about-section img:hover {
      transform: scale(1.05);
    }

    .about-text {
      flex: 1;
    }
    .about-text h2 {
      font-size: 1.8rem;
      margin-bottom: 10px;
      color: #00ffcc66;
    }
    .about-text p {
      line-height: 1.6;
      font-size: 1rem;
      opacity: 0.9;
    }

    .features {
      margin-top: 40px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .feature-card {
      background: #1a1a1a;
      padding: 20px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 0 10px rgba(255, 0, 102, 0.4);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0 20px rgba(255, 0, 102, 0.8);
    }
    .feature-card i {
      font-size: 2rem;
      color: #00ffcc66;
      margin-bottom: 10px;
    }
    .feature-card h3 {
      margin-bottom: 8px;
      color: #00ffcc66;
    }

    footer {
      background: #1a1a1a;
      text-align: center;
      padding: 15px;
      margin-top: 40px;
      border-top: 2px solid #00ffcc66;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<header>
  <!-- 🔹 Back Home Button -->
  <a href="index.php" class="back-home">← Back Home</a>
  <h1>About GameZone</h1>
</header>

<div class="container">
  <div class="about-section">
    <img src="images/setup.jpeg" alt="GameZone Gaming Setup">
    <div class="about-text">
      <h2>Your Ultimate Gaming Marketplace</h2>
      <p>Welcome to <strong>GameZone</strong> — your one-stop hub for everything gaming! Whether you're a casual player or a competitive pro, we provide the latest gaming gear, high-performance accessories, and exclusive titles that bring your gaming dreams to life.  
      <br><br>
      At GameZone, we believe gaming isn’t just a hobby — it’s a lifestyle. Our mission is to deliver premium products, unbeatable deals, and a seamless shopping experience tailored for gamers worldwide.</p>
    </div>
  </div>

  <div class="features">
    <div class="feature-card">
      <i class="fas fa-gamepad"></i>
      <h3>Wide Product Range</h3>
      <p>From consoles to custom PC builds, find everything you need in one place.</p>
    </div>
    <div class="feature-card">
      <i class="fas fa-truck-fast"></i>
      <h3>Fast Delivery</h3>
      <p>Get your favorite gaming gear delivered quickly and securely.</p>
    </div>
    <div class="feature-card">
      <i class="fas fa-tags"></i>
      <h3>Exclusive Deals</h3>
      <p>Enjoy special discounts and offers available only on GameZone.</p>
    </div>
    <div class="feature-card">
      <i class="fas fa-headset"></i>
      <h3>Customer Support</h3>
      <p>Our gaming experts are here to help you 24/7 with all your queries.</p>
    </div>
  </div>
</div>

<footer>
  &copy; <?php echo date("Y"); ?> GameZone. All rights reserved.
</footer>

</body>
</html>
