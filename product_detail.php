<?php
session_start();
include('db/config.php'); // DB connection

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product
$stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

// Product not found
if (!$product) {
    echo "<h2 style='color: red; font-family: Arial;'>⚠️ Product not found!</h2>";
    echo "<a href='index.php' style='color: #00ccff; text-decoration: none;'>← Back to Products</a>";
    exit();
}

// Fetch related products
$related_products = mysqli_query($conn, "SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 12");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($product['name']) ?> | GameZone</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

  <!-- Header Styles -->
  <style>
    * {margin:0;padding:0;box-sizing:border-box;}
    body, p, a, li {font-family:'Poppins', sans-serif;}
    .logo, h1, h2, h3, .section-title {
      font-family:'Orbitron', sans-serif;
      letter-spacing:2px;
      font-weight:700;
      text-shadow:0 0 8px #00ffcc88;
    }

    /* Navbar */
    .navbar {
      background: rgba(20,20,20,0.9);
      backdrop-filter: blur(10px);
      padding: 15px 30px;
      display:flex;justify-content:space-between;align-items:center;
      position: sticky;top:0;z-index:1000;
      box-shadow:0 0 20px #00ffcc44;
    }
    .logo { font-size:1.8rem; cursor:pointer; }
    .logo .g, .logo .z { color: #00ffcc; }
    .logo .ame, .logo .one { color: #fff; }

    .nav-right {display:flex;align-items:center;gap:20px;}
    .nav-links {list-style:none;display:flex;gap:25px;align-items:center;}
    .nav-links li a {
      color:#fff;text-decoration:none;font-weight:500;
      transition:color 0.3s ease;
    }
    .nav-links li a:hover {color:#00ffcc;}

    /* Search */
    .search-container input {
      padding:8px 15px;border-radius:30px;border:none;
      background:#1f1f1f;color:#00ffcc;box-shadow:0 0 10px #00ffcc44;
      transition:0.3s;width:200px;
    }
    .search-container input:focus {outline:none;width:250px;}

    /* Profile Dropdown */
    .profile-dropdown {position:relative;display:inline-block;}
    .profile-icon {
      width:40px;height:40px;border-radius:50%;
      background: url('<?php echo isset($_SESSION['user_image']) ? $_SESSION['user_image'] : "images/default.png"; ?>') no-repeat center;
      background-size:cover;cursor:pointer;border:2px solid #00ffcc;
    }
    .dropdown-menu {
      display:none;position:absolute;top:50px;right:0;
      background-color:#222;border-radius:8px;
      box-shadow:0 0 10px #00ffcc66;overflow:hidden;z-index:999;min-width:180px;
    }
    .dropdown-menu a {
      display:block;padding:10px 20px;color:#fff;text-decoration:none;transition:background 0.3s ease;
    }
    .dropdown-menu a:hover {background-color:#00ffcc22;}
    .dropdown-open .dropdown-menu {display:block;}
  </style>

  <!-- Product Page Styles -->
  <style>
    body {background: #0f0f0f; color: #fff;}
    .container {
      max-width: 1100px;
      margin: 2rem auto;
      background: #1c1c1c;
      border-radius: 12px;
      overflow: hidden;
      display: flex;
      flex-wrap: wrap;
      box-shadow: 0 0 20px #00ffcc44;
      animation: fadeIn 0.7s ease;
    }
    @keyframes fadeIn { from {opacity:0; transform:translateY(20px);} to {opacity:1; transform:translateY(0);} }

    .image-section { flex: 1 1 50%; background: #111; display:flex; align-items:center; justify-content:center; padding:1.5rem; }
    .image-section img { width:100%; max-width:450px; border-radius:12px; object-fit:cover; box-shadow:0 0 20px #00ffcc55; }
    .details-section { flex:1 1 50%; padding:2rem; display:flex; flex-direction:column; justify-content:center; }
    .details-section h1 { color:#00ffcc; margin-bottom:0.8rem; font-size:2rem; text-shadow:0 0 8px #00ffcc44; }
    .price { font-size:1.8rem; margin:0.5rem 0; color:#fff; font-weight:bold; }
    .stock { font-size:1rem; margin-bottom:0.8rem; font-weight:bold; text-shadow:0 0 5px currentColor; }
    .stock.in-stock { color: #00ff99; }
    .stock.out-stock { color: #ff4444; }
    .rating { color:#ffd700; font-size:1.2rem; margin-bottom:1rem; }
    .description { font-size:1rem; line-height:1.6; margin-bottom:1.5rem; color:#ccc; }

    form { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
    .quantity-control { display:flex; align-items:center; background:#222; border-radius:8px; overflow:hidden; }
    .quantity-control button { background:#00ffcc; border:none; color:#111; font-size:1.2rem; padding:6px 12px; cursor:pointer; transition:0.3s; }
    .quantity-control button:hover { background:#00cc99; }
    .quantity-control input { width:60px; text-align:center; border:none; background:#111; color:#fff; font-size:1rem; padding:6px; }
    form button[type="submit"] { background:#00ffcc; color:#111; border:none; padding:12px 25px; font-weight:bold; border-radius:25px; cursor:pointer; transition:0.3s ease; box-shadow:0 0 10px #00ffcc66; }
    form button[type="submit"]:hover { background:#00cc99; box-shadow:0 0 20px #00ffccaa; }
    .back-link { display:inline-block; margin-top:1.5rem; color:#00ccff; text-decoration:none; font-weight:bold; }
    .back-link:hover { text-decoration:underline; }

    .related-section { max-width:1200px; margin:5rem auto; text-align:center; }
    .related-section h2 { color:#00ffcc; margin-bottom:1.5rem; text-shadow:0 0 8px #00ffcc55; }
    .related-products { display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:1.2rem; padding:0 1rem; }
    .related-card { background:#1f1f1f; border-radius:12px; box-shadow:0 4px 10px rgba(0,255,204,0.2); transition:0.3s; text-align:center; overflow:hidden; }
    .related-card:hover { transform:translateY(-5px); box-shadow:0 6px 15px rgba(0,255,204,0.4); }
    .related-card img { width:210px; height:210px; object-fit:cover; border-radius:12px 12px 0 0; }
    .related-card h3 { color:#00ffcc; margin:0.5rem; font-size:1rem; }
    .related-card .price { color:#fff; margin-bottom:0.8rem; font-size:1rem; }

    @media (max-width:768px) { .container { flex-direction:column; } .image-section, .details-section { flex:1 1 100%; text-align:center; } form { justify-content:center; } }
  </style>
</head>
<body>

<!-- Header/Navbar -->
<nav class="navbar">
  <div class="logo" onclick="window.location.href='index.php'">
    <span class="g">G</span><span class="ame">ame</span><span class="z">Z</span><span class="one">one</span>
  </div>

  <div class="nav-right">
    <div class="search-container">
      <input type="text" id="searchInputHeader" placeholder="Search...">
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

<!-- Product Details -->
<div class="container">
  <div class="image-section">
    <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
  </div>
  <div class="details-section">
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <div class="price">₹<?= htmlspecialchars($product['price']) ?></div>
    <div class="stock <?= $product['stock'] > 0 ? 'in-stock' : 'out-stock' ?>">
      <?= $product['stock'] > 0 ? "In Stock: {$product['stock']}" : "Out of Stock" ?>
    </div>
    <div class="rating">
      <?php
        $stars = isset($product['rating']) ? intval($product['rating']) : 4;
        for ($i = 1; $i <= 5; $i++) {
            echo $i <= $stars ? "★" : "☆";
        }
      ?>
    </div>
    <p class="description"><?= htmlspecialchars($product['description']) ?></p>

    <?php if ($product['stock'] > 0): ?>
    <form action="add_to_cart.php" method="POST">
      <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
      <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
      <input type="hidden" name="price" value="<?= htmlspecialchars($product['price']) ?>">
      <input type="hidden" name="image" value="<?= htmlspecialchars($product['image']) ?>">

      <div class="quantity-control">
        <button type="button" onclick="changeQty(-1)">-</button>
        <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
        <button type="button" onclick="changeQty(1)">+</button>
      </div>

      <button type="submit">🛒 Add to Cart</button>
    </form>
    <?php else: ?>
      <p style="color:#ff4444; font-weight:bold;">⚠️ Currently Out of Stock</p>
    <?php endif; ?>

    <a href="index.php" class="back-link">← Back to Products</a>
  </div>
</div>

<!-- Related Products -->
<div class="related-section">
  <h2>🎯 Related Products</h2>
  <div class="related-products">
    <?php while ($rel = mysqli_fetch_assoc($related_products)): ?>
      <div class="related-card">
        <a href="product.php?id=<?= $rel['id'] ?>" style="text-decoration:none;color:inherit;">
          <img src="images/<?= htmlspecialchars($rel['image']) ?>" alt="<?= htmlspecialchars($rel['name']) ?>">
          <h3><?= htmlspecialchars($rel['name']) ?></h3>
          <p class="price">₹<?= htmlspecialchars($rel['price']) ?></p>
        </a>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<script>
  // Profile dropdown toggle
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

  // Quantity Control
  function changeQty(num) {
    let qty = document.getElementById('quantity');
    let newVal = parseInt(qty.value) + num;
    if(newVal >= 1 && newVal <= parseInt(qty.max)) {
      qty.value = newVal;
    }
  }

  // Header Search
  document.getElementById("searchInputHeader").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let products = document.querySelectorAll(".related-card");
    products.forEach(product => {
      let text = product.innerText.toLowerCase();
      product.style.display = text.includes(filter) ? "" : "none";
    });
  });
</script>

</body>
</html>
