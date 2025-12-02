<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

include("../db/config.php");
$user_email = $_SESSION['user_email']; 

$errors = [];
$success = "";

// ✅ Add Payment Method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method_type = $_POST['method_type'];
    $details = "";

    if ($method_type === 'Card') {
        $card_number = preg_replace('/\s+/', '', $_POST['card_number']);
        $card_name = trim($_POST['card_name']);
        $expiry_date = trim($_POST['expiry_date']);
        $cvv = trim($_POST['cvv']);

        // Validation
        if (!preg_match('/^\d{16}$/', $card_number)) $errors[] = "❌ Invalid card number (16 digits).";
        if (strlen($card_name) < 3) $errors[] = "❌ Enter a valid card holder name.";
        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry_date)) $errors[] = "❌ Invalid expiry date (MM/YY).";
        if (!preg_match('/^\d{3}$/', $cvv)) $errors[] = "❌ Invalid CVV (3 digits).";

        $details = "Card: **** **** **** " . substr($card_number, -4) . " | Name: $card_name | Exp: $expiry_date";
    } 
    elseif ($method_type === 'UPI') {
        $upi_id = trim($_POST['upi_id']);
        if (!preg_match('/^[\w.-]+@[\w.-]+$/', $upi_id)) $errors[] = "❌ Invalid UPI ID (example: user@upi)";
        $details = "UPI: $upi_id";
    } 
    else {
        $errors[] = "❌ Please select a valid payment method.";
    }

    // ✅ Insert only if no errors
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO payment_methods (user_email, method_type, method_details) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("❌ SQL Prepare Error (Insert): " . $conn->error);
        }
        $stmt->bind_param("sss", $user_email, $method_type, $details);

        if ($stmt->execute()) {
            $success = "✅ Payment method added successfully!";
        } else {
            $errors[] = "❌ Database Error (Insert): " . $stmt->error;
        }
        $stmt->close();
    }
}

// ✅ Delete Payment Method
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM payment_methods WHERE id=? AND user_email=?");
    if (!$stmt) {
        die("❌ SQL Prepare Error (Delete): " . $conn->error);
    }
    $stmt->bind_param("is", $delete_id, $user_email);

    if (!$stmt->execute()) {
        $errors[] = "❌ Database Error (Delete): " . $stmt->error;
    }
    $stmt->close();
}

// ✅ Fetch All Payment Methods
$stmt = $conn->prepare("SELECT * FROM payment_methods WHERE user_email = ? ORDER BY added_on DESC");
if (!$stmt) {
    die("❌ SQL Prepare Error (Fetch): " . $conn->error);
}
$stmt->bind_param("s", $user_email);
$stmt->execute();
$methods = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>💳 Payment Methods</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Poppins', sans-serif; }
        body {
            background: radial-gradient(circle at top, #0f0f0f, #000);
            color: #fff;
            padding: 2rem;
        }
        h2 {
            text-align: center;
            color: #00ffcc;
            margin-bottom: 2rem;
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            text-shadow: 0 0 15px #00ffcc;
        }
        form {
            background: #101010;
            padding: 2rem;
            max-width: 500px;
            margin: auto;
            border-radius: 15px;
            box-shadow: 0 0 25px #00ffcc55, inset 0 0 20px #00ffcc22;
            animation: glow 3s infinite alternate;
        }
        @keyframes glow {
            0% { box-shadow: 0 0 25px #00ffcc33, inset 0 0 20px #00ffcc11; }
            100% { box-shadow: 0 0 35px #00ffcc88, inset 0 0 30px #00ffcc22; }
        }
        input, select, button {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            background: #181818;
            border: 1px solid #00ffcc44;
            color: #00ffcc;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }
        input:focus, select:focus {
            border-color: #00ffcc;
            box-shadow: 0 0 10px #00ffcc66;
        }
        button {
            background: linear-gradient(90deg, #00ffcc, #00cc99);
            color: #000;
            font-weight: bold;
            cursor: pointer;
            border-radius: 25px;
            transition: 0.3s;
        }
        button:hover {
            background: linear-gradient(90deg, #00cc99, #00ffcc);
            box-shadow: 0 0 20px #00ffcc;
        }
        table {
            width: 90%;
            margin: 2rem auto;
            border-collapse: collapse;
            background: #101010;
            box-shadow: 0 0 20px #00ffcc33;
            border-radius: 12px;
            overflow: hidden;
        }
        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #222;
        }
        th {
            background: #00ffcc22;
            color: #00ffcc;
            font-family: 'Orbitron', sans-serif;
        }
        tr:hover { background: rgba(0,255,200,0.08); }
        a {
            color: #ff5555;
            text-decoration: none;
            font-weight: bold;
        }
        .error { color: #ff4444; text-align: center; font-weight: bold; margin-top:1rem; }
        .success { color: #00ffcc; text-align: center; font-weight: bold; margin-top:1rem; }
        .hidden { display: none; }
        .back-btn {
            display:block; 
            text-align:center; 
            margin-top:2rem;
            color:#00ffcc;
            text-decoration:none;
            font-weight:bold;
        }
    </style>
    <script>
        function toggleFields() {
            const type = document.querySelector('[name="method_type"]').value;
            document.getElementById('card-fields').style.display = type === 'Card' ? 'block' : 'none';
            document.getElementById('upi-field').style.display = type === 'UPI' ? 'block' : 'none';
        }
    </script>
</head>
<body>

<h2>💳 My Payment Methods</h2>

<?php
if (!empty($errors)) foreach ($errors as $err) echo "<p class='error'>$err</p>";
if (!empty($success)) echo "<p class='success'>$success</p>";
?>

<form method="POST">
    <select name="method_type" onchange="toggleFields()" required>
        <option value="">-- Select Method --</option>
        <option value="Card">Credit / Debit Card</option>
        <option value="UPI">UPI</option>
    </select>

    <div id="card-fields" class="hidden">
        <input type="text" name="card_number" placeholder="Card Number (16 digits)" maxlength="16" />
        <input type="text" name="card_name" placeholder="Card Holder Name" />
        <input type="text" name="expiry_date" placeholder="Expiry Date (MM/YY)" maxlength="5" />
        <input type="text" name="cvv" placeholder="CVV (3 digits)" maxlength="3" />
    </div>

    <div id="upi-field" class="hidden">
        <input type="text" name="upi_id" placeholder="UPI ID (e.g., user@upi)" />
    </div>

    <button type="submit">Add Payment Method</button>
</form>

<?php if ($methods && $methods->num_rows > 0): ?>
    <table>
        <tr>
            <th>Type</th>
            <th>Details</th>
            <th>Added On</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $methods->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['method_type']) ?></td>
                <td><?= htmlspecialchars($row['method_details']) ?></td>
                <td><?= htmlspecialchars($row['added_on']) ?></td>
                <td><a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this method?')">❌ Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p style="text-align:center; margin-top:2rem; color:#aaa;">No payment methods saved.</p>
<?php endif; ?>

<a href="../index.php" class="back-btn">← Back to Home</a>

<script>toggleFields();</script>
</body>
</html>
