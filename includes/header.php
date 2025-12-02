<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

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
  
    /* Logo Color Handling */
    .logo .g, .logo .z { color: #00ffcc; }
    .logo .ame, .logo .one { color: #fff; }
    .logo { font-size:1.8rem; font-weight:bold; cursor:pointer; }

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

<!-- Navbar -->
<nav class="navbar">
  <div class="logo" onclick="window.location.href='index.php'">
    <span class="g">G</span><span class="ame">ame</span><span class="z">Z</span><span class="one">one</span>
  </div>

  <div class="nav-right">
    <div class="search-container">
      <input type="text" id="searchInput" placeholder="Search...">
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

<!-- Navbar Scripts -->
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

  // Simple Search
  document.getElementById("searchInput").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let products = document.querySelectorAll(".product");
    products.forEach(product => {
      let text = product.innerText.toLowerCase();
      product.style.display = text.includes(filter) ? "" : "none";
    });
  });
</script>
