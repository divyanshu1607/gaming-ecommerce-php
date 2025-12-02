<?php
session_start();
require_once '../db/config.php';

// OPTIONAL: enable during debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Validate & get product ID
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  header('Location: manage_products.php');
  exit();
}

$id = (int) $_GET['id'];
$msg = '';

// Helper for safe output
function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

// Fetch product row
$product = null;
if ($stmt = $conn->prepare('SELECT * FROM products WHERE id = ?')) {
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $res = $stmt->get_result();
  $product = $res->fetch_assoc();
  $stmt->close();
}

if (!$product) {
  $msg = '❌ Product not found!';
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $product) {
  $name        = trim($_POST['name'] ?? '');
  $price       = (float) ($_POST['price'] ?? 0);
  $category    = trim($_POST['category'] ?? '');
  $brand       = trim($_POST['brand'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $stock       = (int)   ($_POST['stock'] ?? 0);
  // NEW: Home page toggle (checkbox)
  $home_page   = isset($_POST['home_page']) ? 1 : 0;

  // Basic validation
  if ($name === '' || $category === '' || $brand === '' || $description === '') {
    $msg = '❌ Please fill all required fields.';
  }

  $image_will_update = false;
  $new_image_name    = null;

  // If a new image is uploaded, validate & move it
  if ($msg === '' && isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name']) && !empty($_FILES['image']['name'])) {
    $tmp       = $_FILES['image']['tmp_name'];
    $orig_name = $_FILES['image']['name'];
    $ext       = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));

    $allowed_ext  = ['jpg','jpeg','png','webp','gif'];
    $allowed_mime = ['image/jpeg','image/png','image/webp','image/gif'];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $tmp);
    finfo_close($finfo);

    if (!in_array($ext, $allowed_ext, true) || !in_array($mime, $allowed_mime, true)) {
      $msg = '❌ Unsupported image type. Use JPG, PNG, WEBP or GIF.';
    } else {
      $new_image_name = 'prod_' . $id . '_' . time() . '.' . $ext;
      $images_dir_real = realpath(__DIR__ . '/../images');
      if ($images_dir_real === false) {
        $msg = '❌ Images folder not found at ../images';
      } else {
        $target = $images_dir_real . DIRECTORY_SEPARATOR . $new_image_name;
        if (move_uploaded_file($tmp, $target)) {
          $image_will_update = true;
        } else {
          $msg = '❌ Failed to move uploaded image.';
        }
      }
    }
  }

  if ($msg === '') {
    if ($image_will_update) {
      // Update WITH image
      $sql = 'UPDATE products SET name=?, price=?, category=?, brand=?, description=?, stock=?, image=?, home_page=? WHERE id=?';
      $stmt = $conn->prepare($sql);
      if ($stmt === false) {
        $msg = '❌ DB Prepare Error: ' . h($conn->error);
      } else {
        $stmt->bind_param('sdsssisii', $name, $price, $category, $brand, $description, $stock, $new_image_name, $home_page, $id);
        if ($stmt->execute()) {
          $msg = '✅ Product updated successfully!';
        } else {
          $msg = '❌ DB Execute Error: ' . h($stmt->error);
        }
        $stmt->close();
      }
    } else {
      // Update WITHOUT image
      $sql = 'UPDATE products SET name=?, price=?, category=?, brand=?, description=?, stock=?, home_page=? WHERE id=?';
      $stmt = $conn->prepare($sql);
      if ($stmt === false) {
        $msg = '❌ DB Prepare Error: ' . h($conn->error);
      } else {
        $stmt->bind_param('sdsssiii', $name, $price, $category, $brand, $description, $stock, $home_page, $id);
        if ($stmt->execute()) {
          $msg = '✅ Product updated successfully!';
        } else {
          $msg = '❌ DB Execute Error: ' . h($stmt->error);
        }
        $stmt->close();
      }
    }

    // Refresh product data
    if ($stmt = $conn->prepare('SELECT * FROM products WHERE id = ?')) {
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $res = $stmt->get_result();
      $product = $res->fetch_assoc();
      $stmt->close();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Product - GameZone</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

    body {
      background: radial-gradient(circle at top left, #0f0f0f, #050505);
      color: #fff;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
    }

    .form-box {
      background: rgba(0, 255, 195, 0.05);
      padding: 30px;
      border-radius: 15px;
      width: 100%;
      max-width: 520px;
      box-shadow: 0 0 20px rgba(0,255,195,0.15);
      backdrop-filter: blur(12px);
      animation: fadeIn 0.7s ease;
    }

    h2 {
      font-family: 'Orbitron', sans-serif;
      text-align: center;
      color: #00ffc3;
      margin-bottom: 20px;
      text-shadow: 0 0 10px #00ffc355;
      letter-spacing: 1px;
    }

    label { display:block; margin-top: 8px; margin-bottom: 4px; color: #a9ffef; font-size: 13px; }

    input, select, textarea {
      width: 100%;
      padding: 12px;
      margin: 8px 0 14px;
      border: none;
      border-radius: 6px;
      background: #1a1a1a;
      color: #fff;
      font-size: 14px;
      box-shadow: inset 0 0 4px #00ffc322;
      transition: 0.3s;
    }

    input:focus, select:focus, textarea:focus {
      outline: none;
      background: #111;
      box-shadow: 0 0 6px #00ffc355;
    }

    textarea { resize: vertical; }

    button {
      width: 100%;
      background: #00ffc3;
      border: none;
      padding: 12px;
      border-radius: 6px;
      font-weight: bold;
      color: #000;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s ease;
      box-shadow: 0 0 10px #00ffc388;
    }

    button:hover { background: #00cc99; }

    .msg {
      text-align: center;
      margin-bottom: 10px;
      color: #00ffc3;
      font-weight: bold;
    }

    .back-btn {
      display: block;
      width: fit-content;
      margin: 25px auto 0;
      padding: 10px 20px;
      background: #00ffc3;
      color: #000;
      text-align: center;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      text-decoration: none;
      transition: background 0.3s;
      box-shadow: 0 0 10px #00ffc388;
    }

    .back-btn:hover { background: #00cc99; }

    .current-image { text-align: center; margin-bottom: 15px; }

    .current-image img {
      max-width: 160px;
      border-radius: 12px;
      box-shadow: 0 0 15px #00ffc388;
      transition: transform 0.3s;
    }

    .current-image img:hover { transform: scale(1.05); }

    /* Checkbox style */
    input[type="checkbox"] { width: auto; margin-right: 8px; transform: scale(1.15); accent-color: #00ffc3; }

    .row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Edit Product</h2>
    <?php if ($msg) echo '<div class="msg">' . h($msg) . '</div>'; ?>

    <?php if ($product): ?>
    <form method="post" enctype="multipart/form-data">
      <label for="name">Product Name</label>
      <input id="name" type="text" name="name" value="<?php echo h($product['name'] ?? ''); ?>" placeholder="Product Name" required />

      <div class="row">
        <div>
          <label for="price">Price (₹)</label>
          <input id="price" type="number" step="0.01" min="0" name="price" value="<?php echo h($product['price'] ?? '0'); ?>" placeholder="Price (₹)" required />
        </div>
        <div>
          <label for="stock">Stock</label>
          <input id="stock" type="number" min="0" name="stock" value="<?php echo h($product['stock'] ?? '0'); ?>" placeholder="Stock Quantity" required />
        </div>
      </div>

      <label for="category">Category</label>
      <select id="category" name="category" required>
        <?php $cat = $product['category'] ?? ''; ?>
        <option value="PC Gaming Accessories" <?php echo ($cat === 'PC Gaming Accessories') ? 'selected' : ''; ?>>PC Gaming Accessories</option>
        <option value="Phone Gaming Accessories" <?php echo ($cat === 'Phone Gaming Accessories') ? 'selected' : ''; ?>>Phone Gaming Accessories</option>
      </select>

      <label for="brand">Brand</label>
      <select id="brand" name="brand" required>
        <?php $br = $product['brand'] ?? ''; ?>
        <option value="NVIDIA"      <?php echo ($br === 'NVIDIA') ? 'selected' : ''; ?>>NVIDIA</option>
        <option value="AMD"         <?php echo ($br === 'AMD') ? 'selected' : ''; ?>>AMD</option>
        <option value="ASUS ROG"    <?php echo ($br === 'ASUS ROG') ? 'selected' : ''; ?>>ASUS ROG</option>
        <option value="Razer"       <?php echo ($br === 'Razer') ? 'selected' : ''; ?>>Razer</option>
        <option value="PlayStation" <?php echo ($br === 'PlayStation') ? 'selected' : ''; ?>>PlayStation</option>
        <option value="Xbox"        <?php echo ($br === 'Xbox') ? 'selected' : ''; ?>>Xbox</option>
        <option value="Other"       <?php echo ($br === 'Other') ? 'selected' : ''; ?>>Other</option>
      </select>

      <label for="description">Product Description</label>
      <textarea id="description" name="description" placeholder="Product Description" rows="4" required><?php echo h($product['description'] ?? ''); ?></textarea>

      <div class="current-image">
        <p>Current Image:</p>
        <?php $img = isset($product['image']) ? ('../images/' . $product['image']) : ''; ?>
        <?php if (!empty($product['image'])): ?>
          <img src="<?php echo h($img); ?>" alt="Product Image">
        <?php else: ?>
          <p style="opacity:.8">No image uploaded</p>
        <?php endif; ?>
      </div>

      <label for="image">Upload New Image</label>
      <input id="image" type="file" name="image" accept="image/*" />

      <label><input type="checkbox" name="home_page" <?php echo (!empty($product['home_page'])) ? 'checked' : ''; ?>> Show on Home Page</label>

      <button type="submit">💾 Save Changes</button>
    </form>
    <?php else: ?>
      <a href="manage_products.php" class="back-btn">⬅️ Back to Manage</a>
    <?php endif; ?>

    <a href="manage_products.php" class="back-btn">⬅️ Back to Manage</a>
  </div>
</body>
</html>
