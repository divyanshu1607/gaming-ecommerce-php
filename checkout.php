<?php
session_start();
include('db/config.php');

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "❌ Your cart is empty. <a href='index.php' style='color:#00ffcc;'>Go Shopping</a>";
    exit();
}

$orderPlaced = false;
$message = "";

// Handle order placement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));
    $payment_method = mysqli_real_escape_string($conn, trim($_POST['payment_method']));

    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($payment_method)) {
        $message = "❌ Please fill all fields and select a payment method.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "❌ Invalid email address.";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $message = "❌ Invalid phone number. Enter 10 digits.";
    } else {
        $product_details_array = [];
        $total_price = 0;
        $out_of_stock = false;

        foreach ($_SESSION['cart'] as $item) {
            $product_name = mysqli_real_escape_string($conn, $item['name']);
            $price = (float)$item['price'];
            $quantity = (int)$item['quantity'];

            $stock_result = mysqli_query($conn, "SELECT stock FROM products WHERE name = '$product_name'");
            if ($stock_result && mysqli_num_rows($stock_result) > 0) {
                $row = mysqli_fetch_assoc($stock_result);
                if ($row['stock'] < $quantity) {
                    $out_of_stock = true;
                    $message .= "❌ Not enough stock for $product_name. Available: {$row['stock']}<br>";
                    continue;
                }
            }

            $product_details_array[] = "$product_name x $quantity";
            $total_price += $price * $quantity;
        }

        if (!$out_of_stock) {
            $product_details = implode(", ", $product_details_array);

            $stmt = $conn->prepare("INSERT INTO orders (user_id, customer_name, customer_email, customer_phone, customer_address, product_details, total_price, payment_method) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("sssssss", $name, $email, $phone, $address, $product_details, $total_price, $payment_method);
                if ($stmt->execute()) {
                    foreach ($_SESSION['cart'] as $item) {
                        $product_name = mysqli_real_escape_string($conn, $item['name']);
                        $quantity = (int)$item['quantity'];
                        mysqli_query($conn, "UPDATE products SET stock = stock - $quantity WHERE name = '$product_name' AND stock >= $quantity");
                    }
                    unset($_SESSION['cart']);
                    $orderPlaced = true; // Trigger JS popup
                } else {
                    $message = "❌ Failed to place order: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $message = "❌ SQL Prepare failed: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout | GameZone</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    background: radial-gradient(circle at top, #0f0f0f, #1a1a1a);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    padding: 2rem;
}
.nav-buttons { display: flex; gap: 1rem; margin-bottom: 1rem; }
.nav-buttons a {
    padding: 10px 20px; background: #222; color: #00ffcc; text-decoration: none; border-radius: 8px; font-weight: bold; transition: 0.3s;
}
.nav-buttons a:hover { background: #00ffcc; color:#111; box-shadow:0 0 15px #00ffccaa; }

.steps { display:flex; justify-content:space-around; margin-bottom:1.5rem; }
.step { text-align:center; font-size:0.9rem; color:#aaa; }
.step.active { color:#00ffcc; font-weight:bold; text-shadow:0 0 8px #00ffcc99; }

.checkout-container {
    max-width: 1100px;
    margin: auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    background: #1a1a1a;
    border-radius: 15px;
    box-shadow: 0 0 25px #00ffcc55;
    padding: 2rem;
    animation: fadeIn 0.7s ease-in-out;
}
@keyframes fadeIn { from {opacity:0; transform:translateY(20px);} to {opacity:1; transform:translateY(0);} }

input, textarea {
    width: 100%; padding: 12px; margin: 10px 0; background:#2a2a2a; color:#fff; border:none; border-radius:8px; font-size:1rem; transition:0.3s;
}
input:focus, textarea:focus { outline:none; box-shadow:0 0 10px #00ffcc66; }

.payment-methods { display:flex; gap:1rem; margin:1rem 0; }
.payment-method {
    flex:1; background:#222; padding:1rem; text-align:center; border:2px solid #333; border-radius:10px; cursor:pointer; transition:0.3s;
}
.payment-method:hover { border-color:#00ffcc; box-shadow:0 0 15px #00ffcc99; transform:translateY(-3px); }
.payment-method.active { border-color:#00ffcc; box-shadow:0 0 20px #00ffccdd; background:#1b1b1b; }
.payment-method input { display:none; }
.payment-method label { cursor:pointer; font-weight:bold; display:block; }

.summary-section { background:#111; padding:1.5rem; border-radius:12px; box-shadow: inset 0 0 15px #00ffcc33; }
.summary-item { display:flex; justify-content:space-between; margin:0.5rem 0; border-bottom:1px solid #333; padding-bottom:0.5rem; }
.total { font-size:1.3rem; font-weight:bold; color:#00ffcc; margin-top:1rem; }
.extra-info { margin-top:1rem; font-size:0.9rem; color:#aaa; }
.place-order-btn {
    background:#00ffcc; color:#111; font-weight:bold; padding:14px 30px; border:none; border-radius:30px; width:100%; margin-top:1.2rem; cursor:pointer; transition:0.3s; font-size:1.1rem;
}
.place-order-btn:hover { background:#00cc99; box-shadow:0 0 15px #00ffcc99; }

@media (max-width:768px) { .checkout-container { grid-template-columns:1fr; } }
</style>
</head>
<body>

<div class="nav-buttons">
    <a href="index.php">← Continue Shopping</a>
    <a href="cart.php">🛒 View Cart</a>
</div>

<div class="steps">
    <div class="step active">Step 1: Details</div>
    <div class="step active">Step 2: Payment</div>
    <div class="step">Step 3: Confirm</div>
</div>

<div class="checkout-container">
    <div class="form-section">
        <h2>🧾 Shipping Details</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <textarea name="address" rows="3" placeholder="Shipping Address" required></textarea>

            <h3>💳 Payment Method</h3>
            <div class="payment-methods">
                <div class="payment-method" onclick="selectPayment(this)">
                    <input type="radio" id="cod" name="payment_method" value="Cash on Delivery" required>
                    <label for="cod">COD</label>
                </div>
                <div class="payment-method" onclick="selectPayment(this)">
                    <input type="radio" id="upi" name="payment_method" value="UPI">
                    <label for="upi">UPI</label>
                </div>
                <div class="payment-method" onclick="selectPayment(this)">
                    <input type="radio" id="card" name="payment_method" value="Credit/Debit Card">
                    <label for="card">Card</label>
                </div>
            </div>

            <button type="submit" class="place-order-btn">✅ Place Order</button>
        </form>
        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>
    </div>

    <div class="summary-section">
        <h3>🛒 Order Summary</h3>
        <?php
        $grand_total = 0;
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])):
            foreach ($_SESSION['cart'] as $item):
                $subtotal = $item['price'] * $item['quantity'];
                $grand_total += $subtotal;
        ?>
        <div class="summary-item">
            <span><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?></span>
            <span>₹<?= number_format($subtotal, 2) ?></span>
        </div>
        <?php endforeach; endif; ?>
        <div class="extra-info">
            Shipping: <span style="color:#00ffcc;">Free</span><br>
            Estimated Delivery: <span style="color:#00ffcc;"><?= date('D, d M', strtotime('+5 days')) ?></span>
        </div>
        <div class="total">Grand Total: ₹<?= number_format($grand_total, 2) ?></div>
    </div>
</div>

<?php if ($orderPlaced): ?>
<script>
    alert("🎉 Thank you for shopping! Your order has been placed successfully!");
    window.location.href = 'index.php';
</script>
<?php endif; ?>

<script>
function selectPayment(element) {
    document.querySelectorAll('.payment-method').forEach(method => method.classList.remove('active'));
    element.classList.add('active');
    element.querySelector('input').checked = true;
}
</script>

</body>
</html>
