<?php
session_start();
include('../db/config.php');

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Fetch only the current user's orders
$result = mysqli_query($conn, "SELECT * FROM orders WHERE customer_email='$user_email' ORDER BY order_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Orders | GameZone</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      background: radial-gradient(circle at top left,#0f0f0f,#050505);
      color: #fff;
      font-family: 'Poppins', sans-serif;
      padding: 2rem;
    }

    h1 {
      text-align: center;
      font-family: 'Orbitron', sans-serif;
      color: #00ffcc;
      margin-bottom: 2rem;
      text-shadow: 0 0 8px #00ffc388;
    }

    .order {
      background: #1a1a1a;
      margin: 1rem auto;
      padding: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 0 15px #00ffcc55;
      max-width: 700px;
      transition: 0.3s;
      animation: fadeIn 0.6s ease;
    }

    .order:hover {
      transform: scale(1.02);
      box-shadow: 0 0 20px #00ffcc88;
    }

    .order h3 {
      color: #00ffcc;
      font-size: 1.3rem;
      margin-bottom: 10px;
      text-shadow: 0 0 6px #00ffc355;
    }

    .order p {
      margin: 6px 0;
      color: #ccc;
    }

    .status {
      font-weight: bold;
      color: #00ffcc;
    }

    /* Back button in top-left */
    .back-btn {
      position: absolute;
      top: 20px;
      left: 20px;
      background: #00ffcc;
      color: #000;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 0.95rem;
      font-weight: bold;
      text-decoration: none;
      transition: 0.3s;
      box-shadow: 0 0 12px #00ffc388;
    }

    .back-btn:hover {
      background: #00cc99;
      box-shadow: 0 0 15px #00ffc3aa;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media(max-width: 768px) {
      .order {
        padding: 1rem;
        margin: 1rem;
      }
    }
  </style>
</head>
<body>
  <!-- Back button on top-left -->
  <a href="../index.php" class="back-btn">⬅ Home</a>

  <h1>📦 My Orders</h1>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="order">
        <h3>Order #<?= $row['id'] ?></h3>
        <p><strong>Products:</strong> <?= htmlspecialchars($row['product_details']) ?></p>
        <p><strong>Total:</strong> ₹<?= htmlspecialchars($row['total_price']) ?></p>
        <p><strong>Order Date:</strong> <?= htmlspecialchars($row['order_date']) ?></p>
        <p><strong>Status:</strong> <span class="status"><?= ucfirst($row['status']) ?></span></p>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center;color:#888;">❌ No orders found.</p>
  <?php endif; ?>

</body>
</html>
