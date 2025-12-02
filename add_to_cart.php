<?php 
session_start();
include('db/config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['product_name'] ?? null;
    $price = $_POST['price'] ?? null;
    $image = $_POST['image'] ?? 'default.png';
    $quantity_requested = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;

    if ($name && $price) {
        // ✅ Prepared statement to fetch stock
        $stmt = $conn->prepare("SELECT stock FROM products WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row) {
            $stock_available = (int)$row['stock'];

            // ✅ Initialize cart if empty
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['name'] === $name) {
                    $new_total_quantity = $item['quantity'] + $quantity_requested;

                    if ($new_total_quantity > $stock_available) {
                        $_SESSION['msg'] = "❌ Cannot add more than {$stock_available} {$name} in cart!";
                        header("Location: cart.php");
                        exit;
                    }

                    $item['quantity'] = $new_total_quantity; // Update quantity
                    $_SESSION['msg'] = "✅ Updated {$name} quantity in cart.";
                    $found = true;
                    break;
                }
            }
            unset($item); // Break reference to last loop element

            if (!$found) {
                // ✅ Add as a new product
                if ($quantity_requested > $stock_available) {
                    $_SESSION['msg'] = "❌ Only {$stock_available} {$name} available in stock!";
                } else {
                    $_SESSION['cart'][] = [
                        'name' => $name,
                        'price' => $price,
                        'quantity' => $quantity_requested,
                        'image' => $image
                    ];
                    $_SESSION['msg'] = "✅ Added {$quantity_requested} {$name} to cart.";
                }
            }
        } else {
            $_SESSION['msg'] = "❌ Product '{$name}' not found!";
        }
    } else {
        $_SESSION['msg'] = "❌ Missing product information.";
    }
} else {
    $_SESSION['msg'] = "❌ Invalid request.";
}

header("Location: cart.php"); 
exit;
?>
