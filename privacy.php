<?php
session_start();
include('db/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | GameZone</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: #0d0d0d;
            color: #fff;
            line-height: 1.6;
        }
        header {
            background: #111;
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid #ff4747;
            position: relative;
        }
        header h1 {
            color: #ff4747;
            margin: 0;
        }
        /* Back Home Button */
        .back-home {
            position: absolute;
            left: 20px;
            top: 20px;
            background: #ff4747;
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        .back-home:hover {
            background: #e63e3e;
            box-shadow: 0 0 12px #ff4747aa;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 20px;
        }
        h2 {
            color: #ff4747;
            margin-top: 40px;
        }
        p {
            margin-bottom: 15px;
        }
        .updates {
            background: #1a1a1a;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #ff4747;
        }
    </style>
</head>
<body>

<header>
    <a href="index.php" class="back-home">← Back Home</a>
    <h1>Privacy Policy</h1>
</header>

<div class="container">
    <h2>Who We Are</h2>
    <p>Welcome to <strong>GameZone</strong> — your ultimate destination for gaming gear, accessories, and merchandise. 
       We aim to provide gamers with the latest products, from high-performance gaming hardware to stylish collectibles. 
       Whether you’re a casual player or a competitive esports enthusiast, GameZone has something for you.</p>

    <h2>Our Mission</h2>
    <p>Our mission is simple — to bring the best gaming experience to our customers. 
       We focus on offering quality products, competitive pricing, and a community-driven platform 
       where gamers can connect, shop, and stay updated with the latest trends.</p>

    <h2>What We Offer</h2>
    <p>At GameZone, you can explore:</p>
    <ul>
        <li>Latest gaming consoles and accessories</li>
        <li>PC gaming components and gear</li>
        <li>Exclusive collectibles and merchandise</li>
        <li>Special discounts and gaming bundles</li>
    </ul>

    <h2>Latest Updates</h2>
    <div class="updates">
        <p>📅 <strong>August 2025:</strong> Added new arrivals in gaming keyboards and headsets.</p>
        <p>🔥 Upcoming Sale: “GameFest 2025” — Big discounts starting September 1st.</p>
        <p>💡 New Feature: Dark/Light mode toggle on our website for better user experience.</p>
    </div>
</div>

</body>
</html>
