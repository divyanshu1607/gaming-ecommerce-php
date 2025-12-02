<?php
include '../db/config.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Handle Update Status
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id=$order_id");
}

// Handle Delete Order
if (isset($_POST['delete_order'])) {
    $order_id = intval($_POST['order_id']);
    mysqli_query($conn, "DELETE FROM orders WHERE id=$order_id");
}

// Fetch Orders
$query = "SELECT * FROM orders ORDER BY id DESC";
$result = mysqli_query($conn, $query) or die("❌ Query Failed: " . mysqli_error($conn));

// --- Dynamic Counts ---
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products"))['total'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders"))['total'];
$total_messages = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM contact_messages"))['total']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Orders - GameZone</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

    /* === Dashboard Theme === */
    body {
      display: flex;
      background: radial-gradient(circle at top left, #0f0f0f, #050505);
      color: #fff;
      min-height: 100vh;
    }
    .logo{
      font-size:2rem;font-weight:bold;
      font-family:'Orbitron', sans-serif;
      color:#00ffc3;text-shadow:0 0 8px #00ffc388;
      text-align:center;margin-bottom:40px;
    }
    /* Sidebar */
    .sidebar {
      width: 240px;
      background: #111;
      padding-top: 30px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      border-right: 2px solid #00ffcc55;
      box-shadow: 0 0 15px #00ffcc33;
    }
    .sidebar a{
      display:block;padding:15px 30px;color:#ccc;text-decoration:none;
      font-size:16px;position:relative;transition:0.3s;
    }
    .sidebar a i{margin-right:12px;width:20px;text-align:center;}
    .sidebar a:hover{
      background:#00ffc3;color:#000;font-weight:600;box-shadow:inset 0 0 10px #00ffc355;
    }

    /* Main Content */
    .main-content { margin-left: 240px; padding: 50px 40px; width: calc(100% - 240px); }
    .main-content h1 { 
      color: #00ffae; 
      font-size: 32px; 
      margin-bottom: 25px; 
      text-shadow: 0 0 6px #00ffc355;
      font-family:'Orbitron', sans-serif;
    }

    /* Table Box with Glow */
    .table-box {
      background: rgba(0,255,195,0.06);
      border: 1px solid #00ffc344;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 0 20px #00ffc322;
      overflow-x: auto;
      backdrop-filter: blur(10px);
      animation: fadeIn 0.7s ease;
    }

    @keyframes fadeIn {
      from {opacity:0; transform:translateY(20px);}
      to {opacity:1; transform:translateY(0);}
    }

    table { width: 100%; border-collapse: collapse; }
    th, td {
      padding: 15px;
      text-align: center;
      color: #ccc;
      border-bottom: 1px solid #222;
    }
    th {
      color: #00ffcc;
      background-color: rgba(0,255,195,0.15);
      font-weight: 600;
      text-shadow: 0 0 5px #00ffc366;
      font-family:'Orbitron', sans-serif;
    }
    tr:hover { background: rgba(0,255,195,0.08); }

    /* Status Dropdown + Buttons */
    .status-select {
      padding: 5px 8px;
      border-radius: 6px;
      border: none;
      outline: none;
      font-weight: 600;
      color: #000;
    }
    .btn-update, .btn-delete {
      padding: 6px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
    }
    .btn-update { background: #00ffae; color: #000; }
    .btn-update:hover { background: #00cc88; box-shadow: 0 0 10px #00ffc355; }
    .btn-delete { background: #ff3c3c; color: #fff; }
    .btn-delete:hover { background: #cc0000; box-shadow: 0 0 10px #ff3c3c88; }

    @media screen and (max-width: 768px) {
      .sidebar { width: 100%; height: auto; position: relative; display: flex; justify-content: space-around; padding: 10px 0; }
      .main-content { margin-left: 0; padding: 30px 20px; }
      .table-box { padding: 15px; }
    }
    .back-btn {
      display: block;
      width: fit-content;
      margin: 30px auto 10px;
      background: #00ffc3;
      color: #000;
      text-align: center;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: bold;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .back-btn:hover {
      background: #00cc99;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">G<span style="color:#fff;">ame</span>Z<span style="color:#fff;">one</span></div>
    <a href="add_product.php"><i class="fas fa-plus"></i> Add Product</a>
    <a href="manage_products.php"><i class="fas fa-box"></i> Manage Products</a>
    <a href="manage_orders.php"><i class="fas fa-list"></i> Orders</a>
    <a href="contact_messages.php"><i class="fas fa-envelope"></i> Messages</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h1>📦 All Orders</h1>
    <div class="table-box">
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Date</th>
            <th>Status</th>
            <th>Update</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <form method="POST">
              <td>#<?php echo $row['id']; ?></td>
              <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
              <td><?php echo htmlspecialchars($row['customer_email']); ?></td>
              <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
              <td><?php echo ucfirst($row['payment_method']); ?></td>
              <td><?php echo $row['created_at'] ?? 'N/A'; ?></td>
              <td>
                <select name="status" class="status-select" style="
                  background: <?php 
                    if($row['status']=='pending') echo '#ffe066';
                    elseif($row['status']=='placed') echo '#b2f2bb';
                    else echo '#ff6b6b';
                  ?>;">
                  <option value="pending" <?php if($row['status']=='pending') echo 'selected'; ?>>Pending</option>
                  <option value="placed" <?php if($row['status']=='placed') echo 'selected'; ?>>Placed</option>
                  <option value="cancelled" <?php if($row['status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
                </select>
              </td>
              <td>
                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="update_status" class="btn-update">Update</button>
              </td>
              <td>
                <button type="submit" name="delete_order" class="btn-delete" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
              </td>
            </form>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
     <a href="dashboard.php" class="back-btn">⬅️ Back to Dashboard</a>
  </div>

</body>
</html>
