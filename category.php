<?php
session_start();
include('db/config.php');
include('includes/header.php');

if (isset($_GET['cat_id'])) {
    $cat_id = (int)$_GET['cat_id'];

    if ($cat_id == 1) {
        $category_name = "PC Gaming Accessories";
    } elseif ($cat_id == 2) {
        $category_name = "Phone Gaming Accessories";
    } else {
        $category_name = "Unknown Category";
    }

    // ✅ Pagination setup
    $limit = 20; // Products per page
    $page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Count total products
    $count_query = "SELECT COUNT(*) as total FROM products WHERE category='" . mysqli_real_escape_string($conn, $category_name) . "'";
    $count_result = mysqli_query($conn, $count_query);
    $total_products = mysqli_fetch_assoc($count_result)['total'];
    $total_pages = ceil($total_products / $limit);

    // Fetch products with LIMIT
    $result = mysqli_query($conn, "SELECT * FROM products WHERE category='" . mysqli_real_escape_string($conn, $category_name) . "' LIMIT $offset, $limit");
    if (!$result) {
        die("❌ DB Query Failed: " . mysqli_error($conn));
    }
} else {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $category_name; ?> | GameZone</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    * { margin:0; padding:0; box-sizing:border-box; }

    body, p, a, li { font-family:'Poppins', sans-serif; }
    .logo, h1, h2, h3, .section-title, .category-banner h1 {
      font-family:'Orbitron', sans-serif;
      letter-spacing:2px;
      font-weight:700;
      text-shadow:0 0 8px #00ffcc88;
    }

    body {
      background: radial-gradient(circle at top, #0f0f0f, #1a1a1a);
      color:#fff;
    }

    .container {
      max-width: 1200px;
      margin: auto;
      padding: 2rem;
    }

    .category-banner {
      text-align: center;
      margin-bottom: 2rem;
      padding: 2rem 1rem;
      background: linear-gradient(90deg, #00ffcc33, #00ccff33);
      border-radius: 20px;
      box-shadow: 0 0 30px #00ffcc33;
      animation: glow 3s infinite alternate;
    }

    @keyframes glow {
      from { box-shadow: 0 0 20px #00ffcc55; }
      to { box-shadow: 0 0 40px #00ccff99; }
    }

    .category-banner h1 {
      font-size: 2.5rem;
      color: #00ffcc;
      text-shadow: 0 0 15px #00ffccaa, 0 0 30px #00ccffaa;
    }

    .back-btn {
      display: inline-block;
      margin: 1rem 0 2rem;
      padding: 10px 25px;
      background: #00ffcc;
      color: #000;
      border-radius: 30px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
      box-shadow: 0 0 15px #00ffcc55;
    }
    .back-btn:hover {
      background: #00cc99;
      box-shadow: 0 0 20px #00ffccaa;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
    }

    .product {
      background: #1a1a1a;
      border-radius: 15px;
      padding: 1rem;
      text-align: center;
      transition: 0.3s;
      position: relative;
      overflow: hidden;
      box-shadow: 0 0 15px #00ffcc22;
    }
    .product:hover {
      transform: translateY(-10px) scale(1.03);
      box-shadow: 0 0 25px #00ffcc55;
    }
    .product img {
      max-width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
      transition: 0.3s;
      box-shadow: 0 0 15px #00ffcc33;
    }
    .product:hover img {
      transform: scale(1.05);
      box-shadow: 0 0 20px #00ffcc77;
    }
    .product h3 {
      color: #00ffcc;
      margin: 0.8rem 0 0.3rem;
      font-size: 1.2rem;
    }
    .product p {
      margin-bottom: 0.5rem;
      color: #ccc;
    }
    .view-btn {
      display: inline-block;
      margin-top: 0.5rem;
      padding: 8px 20px;
      background: #00ffcc;
      color: #000;
      font-weight: bold;
      border-radius: 25px;
      text-decoration: none;
      transition: 0.3s;
    }
    .view-btn:hover {
      background: #00cc99;
      box-shadow: 0 0 12px #00ffccaa;
    }

    .empty {
      text-align: center;
      color: #888;
      font-size: 1.2rem;
      margin-top: 3rem;
    }

    /* ✅ Pagination Styling */
    .pagination {
      text-align: center;
      margin-top: 2rem;
    }
    .pagination a {
      display: inline-block;
      padding: 8px 14px;
      margin: 0 5px;
      background: #111;
      color: #00ffcc;
      border-radius: 5px;
      text-decoration: none;
      transition: 0.3s;
    }
    .pagination a:hover {
      background: #00ffcc;
      color: #000;
    }
    .pagination .active {
      background: #00ffcc;
      color: #000;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="container">
  <a href="index.php" class="back-btn"> Home</a>

  <div class="category-banner">
    <h1><?php echo $category_name; ?></h1>
  </div>

  <div class="product-grid">
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $img = !empty($row['image']) ? "images/{$row['image']}" : "https://via.placeholder.com/250x200?text=No+Image";
            echo "<div class='product'>
                    <img src='{$img}' alt='".htmlspecialchars($row['name'])."'>
                    <h3>".htmlspecialchars($row['name'])."</h3>
                    <p>₹{$row['price']}</p>
                    <a href='product.php?id={$row['id']}' class='view-btn'>View Details</a>
                  </div>";
        }
    } else {
        echo "<p class='empty'> No products found in this category.</p>";
    }
    ?>
  </div>

  <!-- ✅ Pagination -->
  <?php if ($total_pages > 1): ?>
  <div class="pagination">
    <?php if ($page > 1): ?>
      <a href="?cat_id=<?php echo $cat_id; ?>&page=<?php echo ($page - 1); ?>">« Prev</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a href="?cat_id=<?php echo $cat_id; ?>&page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
        <?php echo $i; ?>
      </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
      <a href="?cat_id=<?php echo $cat_id; ?>&page=<?php echo ($page + 1); ?>">Next »</a>
    <?php endif; ?>
  </div>
  <?php endif; ?>
</div>

</body>
</html>
