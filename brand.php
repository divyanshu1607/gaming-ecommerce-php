<?php
session_start();
include('db/config.php');

$brand = $_GET['brand'] ?? '';
$brand = trim($brand);

// ✅ Prepared statement for safety
$stmt = $conn->prepare("SELECT * FROM products WHERE brand = ?");
$stmt->bind_param("s", $brand);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($brand) ?> | GameZone</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    /* ---- Global Styles ---- */
    * {margin:0;padding:0;box-sizing:border-box;}
    body, p, a, li {font-family:'Poppins', sans-serif;}
    .logo, h1, h2, h3, .section-title {
      font-family:'Orbitron', sans-serif;
      letter-spacing:2px;
      font-weight:700;
      text-shadow:0 0 8px #00ffcc88;
    }
    body {
      background: radial-gradient(circle at top, #0f0f0f, #1a1a1a);
      color:#fff;
      padding-bottom:2rem;
      transition:background 0.4s, color 0.4s;
    }
    body.light-mode {background:#f5f5f5;color:#222;}

    /* ---- Navbar ---- */
    .navbar {
      background: rgba(20,20,20,0.9);
      backdrop-filter: blur(10px);
      padding: 15px 30px;
      display:flex;justify-content:space-between;align-items:center;
      position: sticky;top:0;z-index:1000;
      box-shadow:0 0 20px #00ffcc44;
    }

    /* 🔹 Back Home button */ 
    .back-home { 
      position: absolute; top: 100px; 
      left: 20px;
      padding: 8px 18px;
      background: #00ffcc; 
      color: #000; font-weight: bold; 
      border-radius: 25px;
      text-decoration: none; 
      transition: 0.3s; 
      box-shadow: 0 0 10px #00ffcc88; 
    } 
    .back-home:hover { background: #00cc99; box-shadow: 0 0 20px #00ffcc; }

    /* ✅ Logo same as index.php */
    .logo {
      font-size:1.8rem; 
      font-weight:bold; 
      cursor:pointer; 
      letter-spacing: 0;
      display: flex;
      align-items: center;
      gap: 4px;
      font-family: 'Orbitron', sans-serif;
    }
    .logo span {
      font-weight: 700;
      text-shadow:0 0 8px #00ffcc88;
    }
    .logo .g, .logo .z { color: #00ffcc; }
    .logo .ame, .logo .one { color: #fff; }
    body.light-mode .logo .g, 
    body.light-mode .logo .z { color: #00b8a9; }
    body.light-mode .logo .ame, 
    body.light-mode .logo .one { color: #222; }

    /* ---- Search ---- */
    .search-container input {
      padding:8px 15px;border-radius:30px;border:none;
      background:#1f1f1f;color:#00ffcc;box-shadow:0 0 10px #00ffcc44;
      transition:0.3s;width:200px;
    }
    .search-container input:focus {outline:none;width:250px;}

    /* ---- Nav Links ---- */
    .nav-right {display:flex;align-items:center;gap:20px;}
    .nav-links {list-style:none;display:flex;gap:25px;align-items:center;}
    .nav-links li a {color:#fff;text-decoration:none;font-weight:500;transition:color 0.3s;}
    .nav-links li a:hover {color:#00ffcc;}

    /* ---- Profile ---- */
    .profile-dropdown {position:relative;display:inline-block;}
    .profile-icon {
      width:40px;height:40px;border-radius:50%;
      background:url('<?php echo isset($_SESSION['user_image']) ? $_SESSION['user_image'] : ""; ?>') no-repeat center;
      background-size:cover;cursor:pointer;border:2px solid #00ffcc;
    }
    .dropdown-menu {display:none;position:absolute;top:50px;right:0;background-color:#222;border-radius:8px;
      box-shadow:0 0 10px #00ffcc66;overflow:hidden;z-index:999;min-width:180px;}
    .dropdown-menu a {display:block;padding:10px 20px;color:#fff;text-decoration:none;}
    .dropdown-menu a:hover {background-color:#00ffcc22;}
    .dropdown-open .dropdown-menu {display:block;}

    /* ---- Brand Page ---- */
    h1 {
      color:#00ffcc;text-align:center;margin:2rem 0;
      text-shadow:0 0 15px #00ffcc;
    }
    .product-grid {
      display:grid;
      grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));
      gap:1.5rem;
      padding:0 2rem;
    }
    .product {
      background:rgba(30,30,30,0.85);border-radius:12px;padding:1rem;text-align:center;
      box-shadow:0 0 15px #00ffcc22;transition:0.3s;
    }
    .product:hover {transform:translateY(-5px);box-shadow:0 0 25px rgba(0,255,153,0.25);}
    .product img {max-width:100%;height:200px;object-fit:cover;border-radius:8px;}
    .product h3 {color:#00ffcc;margin-top:1rem;font-size:1.1rem;}
    .product p {margin:0.5rem 0;color:#ccc;}
    .product a {display:inline-block;margin-top:0.5rem;padding:8px 18px;background:#00ffcc;color:#000;font-weight:bold;border-radius:25px;text-decoration:none;}
    .product a:hover {background:#00cc99;}
    .no-products {text-align:center;color:#ccc;margin-top:2rem;font-size:1.2rem;}
  </style>
</head>
<body>

<!-- 🔹 Navbar -->
<nav class="navbar">

  <!-- Logo -->
  <div class="logo" onclick="window.location.href='index.php'">
    <span class="g">G</span><span class="ame">ame</span><span class="z">Z</span><span class="one">one</span>
  </div>

  <div class="nav-right">
    <div class="search-container">
      <input type="text" id="searchInput" onkeyup="filterProducts()" placeholder="Search...">
    </div>
    <ul class="nav-links">
      <li><a href="cart.php">🛒 Cart</a></li>
      <?php if (isset($_SESSION['user_email'])): ?>
        <li class="profile-dropdown" id="profileDropdown">
          <div class="profile-icon" onclick="toggleDropdown()"></div>
          <div class="dropdown-menu">
            <a href="user/profile.php">👤 View Profile</a>
            <a href="user/edit_profile.php">✏️ Edit Profile</a>
            <a href="user/orders.php">📦 My Orders</a>
            <a href="user/payment_methods.php">💳 Payment Methods</a>
            <a href="user/logout.php">🚪 Logout</a>
          </div>
        </li>
      <?php else: ?>
        <li><a href="user/login.php">Login</a></li>
        <li><a href="user/register.php">Register</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<!-- 🔹 Brand Products -->
<h1><?= htmlspecialchars($brand) ?> Products</h1>
<div class="product-grid" id="productGrid">
  <?php if($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): 
      $image = !empty($row['image']) ? "images/{$row['image']}" : "images/default.png"; ?>
      <div class="product">
        <img src="<?= $image ?>" alt="<?= htmlspecialchars($row['name']) ?>">
        <h3><?= htmlspecialchars($row['name']) ?></h3>
        <p>₹<?= htmlspecialchars($row['price']) ?></p>
        <a href="product.php?id=<?= $row['id'] ?>">View Details</a>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="no-products">No products found for this brand.</p>
  <?php endif; ?>
</div>
<a href="index.php" class="back-home">← Back Home</a>
<script>
  // 🔹 Search filter
  function filterProducts() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const products = document.querySelectorAll('.product');
    products.forEach(product => {
      const name = product.querySelector('h3').textContent.toLowerCase();
      product.style.display = name.includes(input) ? 'block' : 'none';
    });
  }

  // 🔹 Profile dropdown
  function toggleDropdown() {
    document.getElementById('profileDropdown').classList.toggle('dropdown-open');
  }
  window.onclick = function(event) {
    if (!event.target.matches('.profile-icon')) {
      const dropdown = document.getElementById('profileDropdown');
      if (dropdown && dropdown.classList.contains('dropdown-open')) {
        dropdown.classList.remove('dropdown-open');
      }
    }
  }
</script>

</body>
</html>
