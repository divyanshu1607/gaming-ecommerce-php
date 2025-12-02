<?php
include '../db/config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Safe count function
function getCount($conn, $sql) {
    $result = mysqli_query($conn, $sql);
    if (!$result) return 0;
    $row = mysqli_fetch_assoc($result);
    return (int)array_values($row)[0];
}

// Dashboard Data
$totalProducts = getCount($conn, "SELECT COUNT(*) FROM products");
$totalOrders = getCount($conn, "SELECT COUNT(*) FROM orders");
$totalUsers = getCount($conn, "SELECT COUNT(*) FROM users");

// Total Revenue (Fixed to total_price)
$resultRevenue = mysqli_query($conn, "SELECT IFNULL(SUM(total_price),0) AS sum FROM orders");
$totalRevenue = ($resultRevenue) ? mysqli_fetch_assoc($resultRevenue)['sum'] : 0;

// Latest Products
$latestProducts = mysqli_query($conn, "SELECT name, price, stock FROM products ORDER BY id DESC LIMIT 5");

// Latest Orders (Fixed to use 'id')
$latestOrders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GameZone Admin Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Orbitron:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

    body {
      display: flex;
      background: radial-gradient(circle at 25% 25%, #0f0f0f, #050505);
      color: #fff;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background: linear-gradient(180deg, #0b0b0b, #111);
      padding-top: 30px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      border-right: 2px solid #00ffcc55;
      box-shadow: 0 0 20px #00ffcc33;
    }
    .logo {
      font-size:2rem;font-weight:bold;
      font-family:'Orbitron', sans-serif;
      color:#00ffc3;text-shadow:0 0 10px #00ffc388;
      text-align:center;margin-bottom:40px;
    }
    .sidebar a{
      display:block;padding:15px 30px;color:#ccc;text-decoration:none;
      font-size:16px;position:relative;transition:0.3s;
    }
    .sidebar a i{margin-right:12px;width:20px;text-align:center;}
    .sidebar a:hover{
      background:#00ffc3;color:#000;font-weight:600;box-shadow:inset 0 0 12px #00ffc355;
      transform: translateX(5px);
    }

    /* Main */
    .main-content {
      margin-left:240px;
      padding:30px;
      width:100%;
      animation: fadeIn 0.8s ease-in-out;
    }
    @keyframes fadeIn { from{opacity:0; transform:translateY(20px);} to{opacity:1; transform:translateY(0);} }

    .topbar {margin-bottom:20px;}
    .username {font-size:1.3rem; color:#00ffc3;}

    /* Cards */
    .cards {
      display:grid;
      grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
      gap:20px;
      margin-bottom:40px;
    }
    .card {
      background:#151515;
      padding:20px;
      border-radius:15px;
      text-align:center;
      box-shadow:0 0 20px #00ffc311;
      transition:0.3s;
      animation: fadeIn 1s ease;
    }
    .card:hover {transform:scale(1.05); box-shadow:0 0 30px #00ffc388;}
    .card h3 {color:#00ffc3; font-size:2rem; transition:0.3s;}
    .card p {color:#aaa; margin-top:5px;}

    /* Charts */
    .charts {
      display:grid;
      grid-template-columns:1fr;
      gap:40px;
      margin-top:20px;
    }
    .chart-box {
      background:#151515;
      padding:25px;
      border-radius:15px;
      box-shadow:0 0 20px #00ffc311;
      display:flex;
      justify-content:center;
      align-items:center;
      min-height:350px;
      animation: fadeIn 1s ease;
    }
    .chart-box canvas {
      max-width:600px;
      max-height:320px;
    }

    /* Tables */
    .data-table {
      margin-top:50px;
      animation: fadeIn 1s ease;
    }
    .data-table h2 {
      margin-bottom:15px;
      color:#00ffc3;
    }
    .data-table table {
      width:100%;
      border-collapse:collapse;
      background:#151515;
      border-radius:15px;
      overflow:hidden;
    }
    .data-table th, .data-table td {
      padding:12px;
      text-align:left;
      border-bottom:1px solid #222;
    }
    .data-table th {
      background:#00ffc322;
      color:#00ffc3;
    }
    .data-table tr:hover {background:#00ffc311;}
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
<main class="main-content">
  <!-- Top Bar -->
  <header class="topbar">
    <div class="user-info">
      <span class="username">Welcome, Admin 👋</span>
    </div>
  </header>

  <!-- Dashboard Cards -->
  <section class="cards">
    <div class="card">
      <h3><?php echo $totalProducts; ?></h3>
      <p>Total Products</p>
    </div>
    <div class="card">
      <h3><?php echo $totalOrders; ?></h3>
      <p>Total Orders</p>
    </div>
    <div class="card">
      <h3><?php echo $totalUsers; ?></h3>
      <p>Users</p>
    </div>
    <div class="card">
      <h3 id="revenueCounter">₹0</h3>
      <p>Total Revenue</p>
    </div>
  </section>

  <!-- Charts -->
  <section class="charts">
    <div class="chart-box"><canvas id="visitorsChart"></canvas></div>
    <div class="chart-box"><canvas id="revenueChart"></canvas></div>
    <div class="chart-box"><canvas id="tasksChart"></canvas></div>
  </section>

  <!-- Products Table -->
  <section class="data-table">
    <h2>Products</h2>
    <table>
      <tr><th>Name</th><th>Stock</th><th>Price</th></tr>
      <?php
      if ($latestProducts && mysqli_num_rows($latestProducts) > 0) {
          while ($p = mysqli_fetch_assoc($latestProducts)) {
              echo "<tr>
                      <td>{$p['name']}</td>
                      <td>{$p['stock']}</td>
                      <td>₹{$p['price']}</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='3'>No products</td></tr>";
      }
      ?>
    </table>
  </section>

  <!-- Orders Table -->
  <section class="data-table">
    <h2>Latest Orders</h2>
    <table>
      <tr><th>Order ID</th><th>User ID</th><th>Total Price</th><th>Date</th></tr>
      <?php
      if ($latestOrders && mysqli_num_rows($latestOrders) > 0) {
          while ($o = mysqli_fetch_assoc($latestOrders)) {
              echo "<tr>
                      <td>#{$o['id']}</td>
                      <td>{$o['user_id']}</td>
                      <td>₹{$o['total_price']}</td>
                      <td>{$o['order_date']}</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='4'>No orders</td></tr>";
      }
      ?>
    </table>
  </section>
</main>

<!-- Inline JS for Charts and Revenue Counter -->
<script>
  const totalRevenue = <?php echo $totalRevenue; ?>;

  // Revenue Counter Animation
  const counter = document.getElementById('revenueCounter');
  let current = 0;
  const step = Math.ceil(totalRevenue / 80);
  const interval = setInterval(() => {
      current += step;
      if (current >= totalRevenue) {
          current = totalRevenue;
          clearInterval(interval);
      }
      counter.textContent = "₹" + current.toLocaleString();
  }, 40);

  // Chart Options
  const chartOptions = { 
    maintainAspectRatio: false,
    responsive: true,
    plugins: {legend:{labels:{color:'#fff'}}},
    scales: {x:{ticks:{color:'#fff'}}, y:{ticks:{color:'#fff'}}}
  };

  // Visitors Chart (Doughnut)
  new Chart(document.getElementById('visitorsChart'), {
    type: 'doughnut',
    data: {
      labels: ['Organic', 'Social', 'Direct'],
      datasets: [{
        data: [37,45,18],
        backgroundColor: ['#00ffc3','#007bff','#a020f0'],
      }]
    },
    options: { plugins: {legend:{labels:{color:'#fff'}}} }
  });

  // Revenue Chart (Bar)
  new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May','Jun'],
      datasets: [{
        label: 'Revenue',
        data: [50,60,80,40,70,90],
        backgroundColor:'#00ffc3'
      }]
    },
    options: chartOptions
  });

  // Tasks Chart (Line)
  new Chart(document.getElementById('tasksChart'), {
    type: 'line',
    data: {
      labels: ['Jan1','Jan16','Jan31','Feb8','Feb24'],
      datasets: [{
        label: 'Tasks',
        data: [100,200,150,220,180],
        borderColor:'#00ffc3',
        backgroundColor:'#00ffc355',
        fill:true,
        tension:0.3
      }]
    },
    options: chartOptions
  });
</script>
</body>
</html>
