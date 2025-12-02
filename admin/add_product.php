<?php
session_start();
include '../db/config.php';

$msg = "";

// Add product logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  $brand = mysqli_real_escape_string($conn, $_POST['brand']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $stock = (int)$_POST['stock'];
  $home_page = isset($_POST['home_page']) ? 1 : 0;

  $image = $_FILES['image']['name'];
  $tmp_name = $_FILES['image']['tmp_name'];
  $target_dir = "../images/" . $image;

  if (empty($category)) {
    $msg = "❌ Please select a category!";
  } elseif (empty($brand)) {
    $msg = "❌ Please select a brand!";
  } elseif (move_uploaded_file($tmp_name, $target_dir)) {
    $query = "INSERT INTO products (name, price, image, category, brand, description, stock, home_page) 
              VALUES ('$name', '$price', '$image', '$category', '$brand', '$description', '$stock', '$home_page')";
    if (mysqli_query($conn, $query)) {
      $msg = "✅ Product added successfully!";
    } else {
      $msg = "❌ DB Error: " . mysqli_error($conn);
    }
  } else {
    $msg = "❌ Failed to upload image!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add Product | GameZone</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Gaming & Modern Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

    body {
      background: radial-gradient(circle at top, #111 0%, #000 100%);
      color: #fff;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      overflow-x: hidden;
    }

    .form-box {
      background: rgba(0, 255, 195, 0.05);
      border: 2px solid #00ffc344;
      box-shadow: 0 0 30px #00ffc322, inset 0 0 15px #00ffc311;
      border-radius: 18px;
      padding: 35px;
      width: 100%;
      max-width: 500px;
      backdrop-filter: blur(14px);
      animation: fadeIn 0.7s ease;
    }

    h2 {
      text-align: center;
      color: #00ffc3;
      margin-bottom: 25px;
      font-family: 'Orbitron', sans-serif;
      text-shadow: 0 0 12px #00ffc388, 0 0 24px #00ffc344;
      letter-spacing: 1px;
    }

    .form-box input,
    .form-box select,
    .form-box textarea {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      background: #1a1a1a;
      color: #fff;
      font-size: 15px;
      box-shadow: inset 0 0 5px #00ffc333;
      transition: 0.3s;
    }

    .form-box input:focus,
    .form-box select:focus,
    .form-box textarea:focus {
      outline: none;
      background: #111;
      box-shadow: 0 0 12px #00ffc377, inset 0 0 8px #00ffc322;
    }

    .form-box label {
      margin-top: 8px;
      display: block;
      font-size: 0.9rem;
      color: #bbb;
      font-weight: 600;
    }

    textarea { resize: vertical; }

    button {
      width: 100%;
      background: linear-gradient(90deg, #00ffc3, #00bfff);
      border: none;
      padding: 14px;
      border-radius: 8px;
      font-weight: bold;
      color: #000;
      cursor: pointer;
      font-size: 17px;
      transition: 0.3s ease;
      box-shadow: 0 0 15px #00ffc388;
    }

    button:hover {
      background: linear-gradient(90deg, #00cc99, #0099ff);
      box-shadow: 0 0 20px #00ffc388;
      transform: translateY(-2px);
    }

    .msg {
      text-align: center;
      margin-bottom: 12px;
      color: #00ffc3;
      font-weight: bold;
      animation: pulse 1s infinite alternate;
    }

    .back-btn {
      display: block;
      width: fit-content;
      margin: 25px auto 0;
      padding: 10px 24px;
      background: #00ffc3;
      color: #000;
      text-align: center;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      text-decoration: none;
      transition: 0.3s;
      box-shadow: 0 0 12px #00ffc388;
    }

    .back-btn:hover {
      background: #00cc99;
      transform: scale(1.05);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse {
      from { text-shadow: 0 0 5px #00ffc377; }
      to { text-shadow: 0 0 15px #00ffc399; }
    }

    /* Checkbox style */
    input[type="checkbox"] {
      width: auto;
      margin-right: 8px;
      transform: scale(1.2);
      accent-color: #00ffc3;
    }
  </style>
</head>
<body>

  <div class="form-box">
    <h2>➕ Add Product</h2>
    <?php if ($msg) echo "<div class='msg'>$msg</div>"; ?>
    <form method="post" enctype="multipart/form-data">
      <input type="text" name="name" placeholder="Product Name" required />
      <input type="number" name="price" placeholder="Price (₹)" required />
      <input type="file" name="image" accept="image/*" required />

      <label for="category">Category:</label>
      <select name="category" required>
        <option value="">-- Select Category --</option>
        <option value="PC Gaming Accessories">PC Gaming Accessories</option>
        <option value="Phone Gaming Accessories">Phone Gaming Accessories</option>
      </select>

      <label for="brand">Brand:</label>
      <select name="brand" required>
        <option value="">-- Select Brand --</option>
        <option value="NVIDIA">NVIDIA</option>
        <option value="AMD">AMD</option>
        <option value="ASUS ROG">ASUS ROG</option>
        <option value="Razer">Razer</option>
        <option value="PlayStation">PlayStation</option>
        <option value="Xbox">Xbox</option>
        <option value="Other">Other</option>
      </select>

      <textarea name="description" placeholder="Product Description" rows="4" required></textarea>
      <input type="number" name="stock" placeholder="Stock Quantity" required />

      <label><input type="checkbox" name="home_page"> Show on Home Page</label><br><br>
      <button type="submit">Add Product</button>
    </form>
    <a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
  </div>

</body>
</html>
