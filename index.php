<?php
session_start();
include('db/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>GameZone | Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- AOS Animation Library -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />

  <style>
    * {margin:0;padding:0;box-sizing:border-box;}
    body, p, a, li {font-family:'Poppins', sans-serif;}
    .logo, h1, h2, h3, .section-title {
      font-family:'Orbitron', sans-serif;
      letter-spacing:2px;
      font-weight:700;
      text-shadow:0 0 8px #00ffcc88;
    }

    /* Default Dark Mode */
    body {
      background: radial-gradient(circle at top, #0f0f0f, #1a1a1a);
      color:#fff;
      padding-bottom:2rem;
      transition:background 0.4s, color 0.4s;
    }

    /* Light Mode */
    body.light-mode {
      background: #f5f5f5;
      color: #222;
    }
    body.light-mode .navbar {background: rgba(255,255,255,0.9); box-shadow:0 0 20px rgba(0,0,0,0.1);}
    body.light-mode .nav-links li a {color:#222;}
    body.light-mode .nav-links li a:hover {color:#00b8a9;}
    body.light-mode .category, body.light-mode .product, body.light-mode .brands-logos {
      background: rgba(255,255,255,0.8);
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    body.light-mode footer {background:#fff; border-top:1px solid #ccc; color:#222;}
    body.light-mode footer a {color:#222;}
    body.light-mode footer a:hover {color:#00b8a9;}
    body.light-mode footer .social-icons a {color:#222;}
    body.light-mode footer .social-icons a:hover {color:#00b8a9;}

    /* Logo Color Handling */
    .logo .g, .logo .z { color: #00ffcc; }
    .logo .ame, .logo .one { color: #fff; }
    body.light-mode .logo .g, 
    body.light-mode .logo .z { color: #00b8a9; }
    body.light-mode .logo .ame, 
    body.light-mode .logo .one { color: #222; }
    .logo { font-size:1.8rem; font-weight:bold; cursor:pointer; }

    /* Navbar */
    .navbar {
      background: rgba(20,20,20,0.9);
      backdrop-filter: blur(10px);
      padding: 15px 30px;
      display:flex;justify-content:space-between;align-items:center;
      position: sticky;top:0;z-index:1000;
      box-shadow:0 0 20px #00ffcc44;
      transition: background 0.4s, box-shadow 0.4s;
    }

    /* Search */
    .search-container input {
      padding:8px 15px;border-radius:30px;border:none;
      background:#1f1f1f;color:#00ffcc;box-shadow:0 0 10px #00ffcc44;
      transition:0.3s;width:200px;
    }
    .search-container input:focus {outline:none;width:250px;}
    body.light-mode .search-container input {
      background:#fff; color:#00b8a9; box-shadow:0 0 8px rgba(0,0,0,0.1);
    }

    .nav-right {display:flex;align-items:center;gap:20px;}
    .nav-links {list-style:none;display:flex;gap:25px;align-items:center;}
    .nav-links li a {
      color:#fff;
      text-decoration:none;
      font-weight:500;
      transition:color 0.3s ease;
    }
    .nav-links li a:hover {color:#00ffcc;}

    /* Profile Dropdown */
    .profile-dropdown {position:relative;display:inline-block;}
    .profile-icon {
      width:40px;height:40px;border-radius:50%;
      background: url('<?php echo isset($_SESSION['user_image']) ? $_SESSION['user_image'] : ""; ?>') no-repeat center;
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

    /* Banner */
    .banner {width:100%;height:450px;position:relative;overflow:hidden;margin-bottom:2rem;border-radius:15px;}
    .banner img {width:100%;height:450px;object-fit:cover;position:absolute;opacity:0;transition:opacity 1.2s ease-in-out;}
    .banner img.active {opacity:1;}

    /* Categories */
    .categories {display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:1.5rem;padding:0 2rem;}
    .category {
      background: rgba(30,30,30,0.8);
      border-radius:15px;overflow:hidden;cursor:pointer;
      box-shadow:0 0 15px #00ffcc22;backdrop-filter:blur(10px);
      transition:transform 0.4s ease, box-shadow 0.4s ease;
      transform-style: preserve-3d;
    }
    .category img {width:100%;height:220px;object-fit:cover;transition:transform 0.3s ease;}
    .category:hover img {transform:scale(1.05);}
    .category h3 {text-align:center;color:#00ffcc;margin:1rem 0;}
    .categories .category:nth-child(odd):hover {transform:perspective(800px) rotateY(10deg) scale(1.05);box-shadow:0 20px 40px rgba(0,255,204,0.4);}
    .categories .category:nth-child(even):hover {transform:perspective(800px) rotateY(-10deg) scale(1.05);box-shadow:0 20px 40px rgba(0,255,204,0.4);}
    body.light-mode .category h3 {color:#00b8a9;}

    /* Section Title */
    .section-title {text-align:center;font-size:1.8rem;margin:2rem 0 1rem;color:#00ffcc;}
    body.light-mode .section-title {color:#00b8a9;}

    /* Products */
    .product-grid {display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem;padding:0 2rem;}
    .product {
      background:rgba(30,30,30,0.85);border-radius:12px;padding:1rem;text-align:center;
      box-shadow:0 0 15px #00ffcc22;transition:0.3s;cursor:pointer;perspective:1000px;transform-style:preserve-3d;
    }
    .product:hover {transform:rotate3d(1, 1, 0, 8deg) scale(1.05);box-shadow:0 15px 30px rgba(0,255,204,0.3);}
    .product img {max-width:100%;height:200px;object-fit:cover;border-radius:8px;transition:transform 0.3s ease;}
    .product:hover img {transform:scale(1.08);}
    .product h3 {color:#00ffcc;margin:1rem 0 0.5rem;}
    .product p {margin-bottom:1rem;}
    .product a {display:inline-block;padding:8px 20px;background:#00ffcc;color:#000;font-weight:bold;border-radius:25px;text-decoration:none;transition:0.3s;}
    .product a:hover {background:#00cc99;}
    body.light-mode .product h3 {color:#00b8a9;}
    body.light-mode .product a {background:#00b8a9;color:#fff;}
    body.light-mode .product a:hover {background:#009e8a;}

    /* Brands */
    .brands-logos {display:grid;grid-template-columns:repeat(auto-fit,minmax(120px,1fr));gap:20px;padding:2rem;margin:2rem;background:rgba(20,20,20,0.8);border-radius:15px;box-shadow:0 0 15px #00ffcc22;}
    .brands-logos img {max-width:100px;filter:grayscale(100%);transition:0.3s;}
    .brands-logos img:hover {filter:grayscale(0%);transform:scale(1.1);}
    body.light-mode .brands-logos {background:rgba(255,255,255,0.8);}

    /* Footer */
    footer {background:#111;padding:2rem;text-align:center;margin-top:2rem;border-top:1px solid #333;}
    footer h2 {color:#00ffcc;margin-bottom:1rem;}
    footer a {color:#fff;text-decoration:none;margin:0 10px;transition:0.3s;}
    footer a:hover {color:#00ffcc;}
    footer .social-icons {margin-top:1rem;}
    footer .social-icons a {margin:0 8px;font-size:1.5rem;color:#fff;transition:0.3s;}
    footer .social-icons a:hover {color:#00ffcc;}
    footer p {margin-top:1rem;color:#aaa;}
    body.light-mode footer p {color:#555;}

    /* Parallax Banner */
    .banner img {transition: transform 1.5s ease, opacity 1.2s ease;}
    .banner:hover img.active {transform: scale(1.1);}
  </style>
</head> 
<body>

<!-- Navbar -->
<nav class="navbar">
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

<!-- Banner -->
<div class="banner" data-aos="fade-in">
  <img src="images/banner12.jpg" class="active" alt="Banner 1">
  <img src="images/banner9.jpg" alt="Banner 2">
  <img src="images/banner10.jpg" alt="Banner 3">
</div>

<!-- Categories -->
<h2 class="section-title" data-aos="zoom-in">Shop by Category</h2>
<div class="categories">
  <div class="category" data-aos="fade-up"
    onclick="<?php echo isset($_SESSION['user_email']) ? "window.location.href='category.php?cat_id=1'" : "alert('Please login to view this category.'); window.location.href='user/login.php'"; ?>">
    <img src="images/pc2.jpg" alt="PC Gaming Accessories">
    <h3>PC Gaming Accessories</h3>
  </div>
  <div class="category" data-aos="fade-up" data-aos-delay="100"
    onclick="<?php echo isset($_SESSION['user_email']) ? "window.location.href='category.php?cat_id=2'" : "alert('Please login to view this category.'); window.location.href='user/login.php'"; ?>">
    <img src="images/pc.jpg" alt="Phone Gaming Accessories">
    <h3>Phone Gaming Accessories</h3>
  </div>
</div>

<!-- Featured Products -->
<h2 class="section-title" data-aos="zoom-in">Featured Products</h2>
<div class="product-grid">
<?php
$result = mysqli_query($conn, "SELECT * FROM products WHERE home_page = 1");
$delay = 0;
while($row = mysqli_fetch_assoc($result)) {
  $delay += 100;
  if (isset($_SESSION['user_email'])) {
    echo "<div class='product' data-aos='fade-up' data-aos-delay='{$delay}' onclick=\"window.location.href='product.php?id={$row['id']}'\">
      <img src='images/{$row['image']}' alt='{$row['name']}'>
      <h3>{$row['name']}</h3>
      <p>₹{$row['price']}</p>
      <a href='product.php?id={$row['id']}'>View Details</a>
    </div>";
  } else {
    echo "<div class='product' data-aos='fade-up' data-aos-delay='{$delay}' onclick=\"alert('Please login to view product details.'); window.location.href='user/login.php';\">
      <img src='images/{$row['image']}' alt='{$row['name']}'>
      <h3>{$row['name']}</h3>
      <p>₹{$row['price']}</p>
      <a href='user/login.php' onclick=\"alert('Please login to buy this product.'); return false;\">View Details</a>
    </div>";
  }
}
?>
</div>

<!-- Brands -->
<h2 class="section-title" data-aos="zoom-in">Our Premium Partners</h2>
<div class="brands-logos">
  <a href="brand.php?brand=NVIDIA"><img src="images/brands/nvidia.jpeg" alt="NVIDIA" data-aos="fade-up"></a>
  <a href="brand.php?brand=AMD"><img src="images/brands/amd.jpeg" alt="AMD" data-aos="fade-up" data-aos-delay="100"></a>
  <a href="brand.php?brand=ASUS ROG"><img src="images/brands/asus.jpeg" alt="ASUS ROG" data-aos="fade-up" data-aos-delay="200"></a>
  <a href="brand.php?brand=Razer"><img src="images/brands/razer.jpeg" alt="Razer" data-aos="fade-up" data-aos-delay="300"></a>
  <a href="brand.php?brand=PlayStation"><img src="images/brands/sony.jpeg" alt="Sony PlayStation" data-aos="fade-up" data-aos-delay="400"></a>
  <a href="brand.php?brand=Xbox"><img src="images/brands/xbox.jpeg" alt="Xbox" data-aos="fade-up" data-aos-delay="500"></a>
</div>

<!-- Footer -->
<footer data-aos="fade-in">
  <div class="logo" onclick="window.location.href='index.php'">
    <span class="g">G</span><span class="ame">ame</span><span class="z">Z</span><span class="one">one</span>
  </div>
  <div>
    <a href="about.php">About Us</a> |
    <a href="contact.php">Contact</a> |
    <a href="privacy.php">Privacy Policy</a> |
    <a href="terms.php">Terms of Service</a> |
    <a href="faq.php">FAQ</a>
  </div>
  <div class="social-icons">
    <a href="#"><i class="fab fa-facebook-f"></i></a>
    <a href="#"><i class="fab fa-twitter"></i></a>
    <a href="#"><i class="fab fa-instagram"></i></a>
    <a href="#"><i class="fab fa-discord"></i></a>
    <a href="#"><i class="fab fa-youtube"></i></a>
  </div>
  

  <p>© 2025 GameZone. All rights reserved.</p>
</footer>

<!-- AOS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  AOS.init({ duration: 1000, once: true });
</script>

<script>
  // Banner slideshow
  let banners = document.querySelectorAll('.banner img');
  let currentBanner = 0;
  setInterval(() => {
    banners[currentBanner].classList.remove('active');
    currentBanner = (currentBanner + 1) % banners.length;
    banners[currentBanner].classList.add('active');
  }, 2000);

  // Product search
  function filterProducts() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const products = document.querySelectorAll('.product');
    products.forEach(product => {
      const name = product.querySelector('h3').textContent.toLowerCase();
      product.style.display = name.includes(input) ? 'block' : 'none';
    });
  }

  // Profile dropdown toggle
  function toggleDropdown() {
    document.getElementById('profileDropdown').classList.toggle('dropdown-open');
  }
  window.onclick = function(event) {
    if (!event.target.matches('.profile-icon')) {
      const dropdown = document.getElementById('profileDropdown');
      if (dropdown.classList.contains('dropdown-open')) {
        dropdown.classList.remove('dropdown-open');
      }
    }
  }
</script>


</body>
</html>
