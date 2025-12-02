<?php
session_start();
include('../db/config.php');

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['user_email'];
$message = "";

// Fetch current user info
$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$user_email'");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "❌ User not found!";
    exit();
}

// Current profile pic from DB or session fallback
$profile_pic_path = !empty($user['profile_pic'])
    ? "../uploads/" . $user['profile_pic']
    : "https://www.gstatic.com/images/branding/product/2x/avatar_circle_512dp.png";

$username = htmlspecialchars($user['username']);
$phone = htmlspecialchars($user['phone']);
$address = htmlspecialchars($user['address']);
$email = htmlspecialchars($user['email']); // readonly

// Update profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $new_phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $new_address = mysqli_real_escape_string($conn, trim($_POST['address']));

    $profile_pic_db = $user['profile_pic']; // default

    // ✅ Handle Image Upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
        $filename = $_FILES['profile_pic']['name'];
        $tempname = $_FILES['profile_pic']['tmp_name'];
        $targetDir = "../uploads/";
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $newname = time() . "_" . rand(1000, 9999) . "." . $ext;

        if (move_uploaded_file($tempname, $targetDir . $newname)) {
            $profile_pic_db = $newname;
        }
    }

    // ✅ Update user info
    $update_query = "UPDATE users 
                     SET username='$new_username', phone='$new_phone', address='$new_address', profile_pic='$profile_pic_db' 
                     WHERE email='$user_email'";
    $update = mysqli_query($conn, $update_query);

    if ($update) {
        // ✅ Update session image path (for consistency)
        $_SESSION['user_image'] = "../uploads/" . $profile_pic_db;

        // ✅ Reload page to show updated image instantly
        header("Location: edit_profile.php?success=1");
        exit();
    } else {
        $message = "❌ Failed to update profile!";
    }
}

// If image updated successfully, show message
if (isset($_GET['success'])) {
    $message = "✅ Profile updated successfully!";
}

// Update $profile_pic_path again after possible update
$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$user_email'");
$user = mysqli_fetch_assoc($result);
$profile_pic_path = !empty($user['profile_pic'])
    ? "../uploads/" . $user['profile_pic'] . "?v=" . time() // 👈 avoid cache
    : "https://www.gstatic.com/images/branding/product/2x/avatar_circle_512dp.png";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Profile | GameZone</title>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
<style>
body { background: radial-gradient(circle at top left,#0f0f0f,#050505); color:#fff; font-family:'Poppins',sans-serif; padding:2rem; display:flex; justify-content:center; align-items:center; min-height:100vh; }
.back-btn { position:absolute; top:20px; left:20px; padding:10px 18px; background:#00ffcc; color:#000; font-weight:bold; text-decoration:none; border-radius:25px; box-shadow:0 0 10px #00ffcc99; transition:0.3s; }
.back-btn:hover { background:#00cc99; box-shadow:0 0 18px #00ffccaa; }
.edit-box { max-width:600px; width:100%; background:#1a1a1a; padding:2rem; border-radius:12px; box-shadow:0 0 20px #00ffcc55; text-align:center; animation: fadeIn 1s ease; }
.edit-box h2 { font-family:'Orbitron',sans-serif; color:#00ffcc; margin-bottom:1rem; text-shadow:0 0 8px #00ffc366; }
.edit-box img { width:120px; height:120px; object-fit:cover; border-radius:50%; border:2px solid #00ffcc; box-shadow:0 0 15px #00ffcc88; margin-bottom:1rem; transition:0.3s; }
.edit-box img:hover { transform:scale(1.05); box-shadow:0 0 25px #00ffccaa; }
.edit-box input[type="text"], .edit-box input[type="file"], .edit-box textarea { display:block; width:100%; padding:12px; margin:12px 0; border:none; border-radius:8px; background:#2a2a2a; color:#fff; font-size:1rem; transition:0.3s; }
.edit-box input:focus, .edit-box textarea:focus { outline:none; box-shadow:0 0 8px #00ffcc; }
.edit-box input[readonly] { background:#444; color:#aaa; }
.edit-box button { background:#00ffcc; border:none; padding:12px 30px; color:#000; font-weight:bold; font-size:1rem; border-radius:25px; cursor:pointer; margin-top:10px; transition:0.3s; }
.edit-box button:hover { background:#00cc99; box-shadow:0 0 15px #00ffc388; }
.message { margin-top:1rem; font-weight:bold; color:#00ffcc; animation: fadeIn 0.5s ease; }
@keyframes fadeIn { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }
@media (max-width:768px) { .edit-box { padding:1.5rem; } .edit-box img { width:100px; height:100px; } }
</style>
</head>
<body>

<a href="profile.php" class="back-btn">⬅ Back</a>

<div class="edit-box">
    <h2>✏️ Edit Profile</h2>
    <!-- ✅ Always show latest image -->
    <img id="previewImg" src="<?= $profile_pic_path ?>" alt="Profile Picture" />

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="username" value="<?= $username ?>" placeholder="Username" required />
        <input type="text" name="phone" value="<?= $phone ?>" placeholder="Phone Number" required />
        <textarea name="address" rows="3" placeholder="Address" required><?= $address ?></textarea>
        <input type="text" name="email" value="<?= $email ?>" readonly />
        <input type="file" name="profile_pic" accept="image/*" onchange="previewFile(this)" />
        <button type="submit">💾 Update Profile</button>
    </form>

    <?php if($message) echo "<div class='message'>$message</div>"; ?>
</div>

<!-- ✅ Preview uploaded image instantly -->
<script>
function previewFile(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
</script>

</body>
</html>
