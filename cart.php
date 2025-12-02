<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>🛒 Your Cart | GameZone</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
    body {
      background: linear-gradient(135deg, #0f0f0f, #1a1a1a);
      color: #fff;
      padding: 2rem;
      position: relative;
    }

    h1 {
      text-align: center;
      margin-bottom: 2rem;
      color: #00ffcc;
      font-size: 2.5rem;
      text-shadow: 0 0 15px #00ffcc88;
    }

    .cart-container {
      max-width: 1000px;
      margin: auto;
      background: #1f1f1f;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 0 25px #00ffcc33;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1.5rem;
    }

    th, td {
      padding: 14px 12px;
      text-align: center;
      border-bottom: 1px solid #333;
    }

    th {
      background: #00ffcc;
      color: #000;
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #262626;
    }

    .product-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 0 6px #00ffcc55;
    }

    .total {
      text-align: right;
      font-size: 1.4rem;
      font-weight: bold;
      margin-top: 15px;
      color: #00ffcc;
      text-shadow: 0 0 8px #00ffcc66;
    }

    .checkout-btn {
      display: block;
      text-align: center;
      background: #00ffcc;
      color: #000;
      padding: 14px 20px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: bold;
      margin: 20px auto 0;
      width: 280px;
      transition: 0.3s;
      box-shadow: 0 0 15px #00ffcc55;
    }

    .checkout-btn:hover {
      background: #00cc99;
      box-shadow: 0 0 20px #00ffccaa;
    }

    .remove-btn {
      background: #ff4d4d;
      color: #fff;
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
      transition: 0.3s;
      box-shadow: 0 0 6px #ff4d4d88;
    }

    .remove-btn:hover {
      background: #e60000;
      box-shadow: 0 0 10px #ff4d4d;
    }

    .empty {
      text-align: center;
      color: #aaa;
      margin-top: 50px;
      font-size: 1.2rem;
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

    @media(max-width: 768px) {
      .cart-container { padding: 1rem; }
      th, td { font-size: 0.9rem; }
      .product-img { width: 50px; height: 50px; }
      .checkout-btn { width: 90%; }
    }
  </style>
</head>
<body>

<!-- Back button top-left -->
<a href="index.php" class="back-btn">⬅ Home</a>

<h1>🛒 Your Cart</h1>

<div class="cart-container">
<?php
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<p class='empty'>Your cart is empty.</p>";
} else {
    echo "<table>
      <tr>
        <th>Image</th>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Action</th>
      </tr>";

    $total = 0;

    foreach ($_SESSION['cart'] as $index => $item) {
        $name = htmlspecialchars($item['name']);
        $image = htmlspecialchars($item['image']);
        $price = (float)$item['price'];
        $qty = (int)$item['quantity'];
        $subtotal = $price * $qty;
        $total += $subtotal;

        $imagePath = "images/{$image}";
        if (!file_exists(__DIR__ . "/images/{$image}") || empty($image)) {
            $imagePath = "https://via.placeholder.com/60?text=No+Image";
        }

        echo "<tr>
                <td><img src='{$imagePath}' alt='{$name}' class='product-img'></td>
                <td>{$name}</td>
                <td>₹{$price}</td>
                <td>{$qty}</td>
                <td>₹{$subtotal}</td>
                <td>
                  <form method='post' action='remove_from_cart.php'>
                    <input type='hidden' name='index' value='{$index}'>
                    <button type='submit' class='remove-btn'>Remove</button>
                  </form>
                </td>
              </tr>";
    }

    echo "</table>";
    echo "<p class='total'>Grand Total: ₹{$total}</p>";
    echo "<a href='checkout.php' class='checkout-btn'>🧾 Proceed to Checkout</a>";
}
?>
</div>

</body>
</html>
