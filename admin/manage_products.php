<?php
session_start();
include '../db/config.php';

$msg = "";

// Delete product
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $query = "DELETE FROM products WHERE id = $id";
  if (mysqli_query($conn, $query)) {
    $msg = "🗑️ Product deleted successfully.";
  } else {
    $msg = "❌ Failed to delete product.";
  }
}

// ✅ Pagination setup
$limit = 20; // products per page
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search products
$search = "";
$where = "";
if (isset($_GET['search']) && $_GET['search'] !== "") {
  $search = mysqli_real_escape_string($conn, $_GET['search']);
  $where = "WHERE name LIKE '%$search%'";
}

// Count total
$count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products $where");
$total_products = mysqli_fetch_assoc($count_query)['total'];
$total_pages = ceil($total_products / $limit);

// Fetch products
$products = mysqli_query($conn, "SELECT * FROM products $where ORDER BY id DESC LIMIT $offset, $limit");
$product_count = $total_products;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Products | GameZone</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Orbitron:wght@500;700&display=swap" rel="stylesheet" />
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

    body {
      background: linear-gradient(135deg, #0f0f0f, #050505);
      color: #fff;
      padding: 40px 20px;
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(10px);}
      to {opacity: 1; transform: translateY(0);}
    }

    h2 {
      text-align: center;
      color: #00ffc3;
      margin-bottom: 20px;
      text-shadow: 0 0 12px #00ffc355;
      font-family: 'Orbitron', sans-serif;
    }

    .search-box {
      width: 100%;
      max-width: 500px;
      margin: 0 auto 25px;
      display: flex;
      background: rgba(0, 255, 195, 0.05);
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px #00ffc333;
      animation: fadeIn 1s ease;
    }

    .search-box input {
      flex: 1;
      padding: 12px;
      background: #111;
      color: #fff;
      border: none;
      outline: none;
    }

    .search-box button {
      background: #00ffc3;
      color: #000;
      border: none;
      padding: 12px 18px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .search-box button:hover {
      background: #00cc99;
    }

    .msg {
      text-align: center;
      margin-bottom: 10px;
      color: #00ffc3;
      font-weight: bold;
      animation: fadeIn 0.8s ease;
    }

    .count {
      text-align: center;
      margin-bottom: 15px;
      font-size: 1.1rem;
      color: #00ffcc;
      font-family: 'Orbitron', sans-serif;
      animation: fadeIn 1s ease;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: rgba(255, 255, 255, 0.02);
      box-shadow: 0 0 15px #00ffc333;
      border-radius: 10px;
      overflow: hidden;
      margin-top: 10px;
      animation: fadeIn 1.2s ease;
    }

    th, td {
      padding: 14px 12px;
      text-align: left;
      border-bottom: 1px solid #333;
    }

    th {
      background: #1a1a1a;
      color: #00ffc3;
      font-family: 'Orbitron', sans-serif;
    }

    tr:hover {
      background: rgba(0, 255, 195, 0.07);
      transition: 0.3s;
    }

    td img {
      width: 60px;
      border-radius: 5px;
      box-shadow: 0 0 6px #00ffc344;
    }

    .action-btn, .delete-btn {
      padding: 6px 14px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
      font-size: 0.9rem;
    }

    .action-btn {
      background: #00ccff;
      color: #000;
    }

    .action-btn:hover {
      background: #0099cc;
      box-shadow: 0 0 10px #00ccff55;
    }

    .delete-btn {
      background: #ff4d4d;
      color: #000;
    }

    .delete-btn:hover {
      background: #e60000;
      box-shadow: 0 0 10px #ff4d4d88;
    }

    .back-btn {
      display: inline-block;
      margin-bottom: 20px;
      background: #00ffc3;
      color: #000;
      text-align: center;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: bold;
      text-decoration: none;
      transition: background 0.3s ease;
      font-family: 'Orbitron', sans-serif;
    }
    .back-btn:hover {
      background: #00cc99;
      box-shadow: 0 0 12px #00ffc355;
    }

    /* ✅ Pagination Styling */
    .pagination {
      text-align: center;
      margin-top: 20px;
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

    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr { display: block; }
      thead tr { display: none; }
      tr {
        margin-bottom: 15px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 10px;
        padding: 10px;
      }
      td {
        display: flex;
        justify-content: space-between;
        padding: 8px 10px;
        border-bottom: none;
      }
      td::before {
        content: attr(data-label);
        font-weight: bold;
        color: #00ffc3;
      }
      td img { margin-top: 8px; }
    }
  </style>
</head>
<body>

  <!-- ✅ Back button on top-left -->
  <a href="dashboard.php" class="back-btn">⬅️ Back to Dashboard</a>

  <h2>📝 Manage Products</h2>
  <?php if (!empty($msg)) echo "<div class='msg'>$msg</div>"; ?>

  <div class="search-box">
    <form method="GET" style="width: 100%; display: flex;">
      <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>" />
      <button type="submit">🔍 Search</button>
    </form>
  </div>

  <div class="count">📦 Total Products: <?php echo $product_count; ?></div>

  <table>
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price (₹)</th>
        <th>Category</th>
        <th>Brand</th>
        <th>Stock</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($products)) { ?>
        <tr>
          <td data-label="Image"><img src="../images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>"></td>
          <td data-label="Name"><?php echo $row['name']; ?></td>
          <td data-label="Price">₹<?php echo $row['price']; ?></td>
          <td data-label="Category"><?php echo $row['category']; ?></td>
          <td data-label="Brand"><?php echo $row['brand']; ?></td>
          <td data-label="Stock"><?php echo $row['stock']; ?></td>
          <td data-label="Actions">
            <a href="edit_product.php?id=<?php echo $row['id']; ?>"><button class="action-btn">Edit</button></a>
            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')">
              <button class="delete-btn">Delete</button>
            </a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- ✅ Pagination -->
  <?php if ($total_pages > 1): ?>
  <div class="pagination">
    <?php if ($page > 1): ?>
      <a href="?page=<?php echo ($page - 1); ?>&search=<?php echo urlencode($search); ?>">« Prev</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
        <?php echo $i; ?>
      </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
      <a href="?page=<?php echo ($page + 1); ?>&search=<?php echo urlencode($search); ?>">Next »</a>
    <?php endif; ?>
  </div>
  <?php endif; ?>

</body>
</html>
