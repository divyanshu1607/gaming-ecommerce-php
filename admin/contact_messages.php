<?php
include '../db/config.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Delete message if requested
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM contact_messages WHERE id = $id");
    header("Location: contact_messages.php");
    exit();
}

// Fetch messages
$result = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin | Contact Messages</title>

<!-- Google Fonts for Gaming Style -->
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: radial-gradient(circle at top, #111 0%, #000 100%);
        color: #fff;
        margin: 0;
        padding: 0;
    }
    h1 {
        text-align: center;
        margin: 30px 0;
        color: #00ffcc;
        font-family: 'Orbitron', sans-serif;
        font-size: 2rem;
        letter-spacing: 2px;
        text-shadow: 0 0 12px #00ffcc88, 0 0 24px #00ffcc44;
        animation: glow 2s ease-in-out infinite alternate;
    }
    table {
        width: 92%;
        margin: 25px auto;
        border-collapse: collapse;
        background: rgba(20,20,20,0.75);
        backdrop-filter: blur(10px);
        box-shadow: 0 0 25px #00ffcc33, inset 0 0 10px #00ffcc22;
        border-radius: 12px;
        overflow: hidden;
        animation: fadeIn 0.6s ease;
    }
    th, td {
        padding: 15px;
        border-bottom: 1px solid #222;
        text-align: left;
        font-size: 0.95rem;
    }
    th {
        background: linear-gradient(90deg, #00ffcc33, #00666622);
        color: #00ffcc;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }
    tr {
        transition: 0.3s ease;
    }
    tr:hover {
        background: rgba(0, 255, 204, 0.08);
    }
    .actions a {
        color: #ff4d4d;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }
    .actions a:hover {
        color: #ff6666;
        text-shadow: 0 0 8px #ff4d4d88;
    }

    .back-btn {
        display: block;
        width: fit-content;
        margin: 30px auto 10px;
        background: linear-gradient(90deg, #00ffc3, #00bfff);
        color: #000;
        text-align: center;
        padding: 12px 26px;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s ease;
        box-shadow: 0 0 15px #00ffc388;
    }
    .back-btn:hover {
        background: linear-gradient(90deg, #00cc99, #0099ff);
        transform: scale(1.05);
        box-shadow: 0 0 20px #00ffc399;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes glow {
        from { text-shadow: 0 0 10px #00ffcc66; }
        to { text-shadow: 0 0 25px #00ffccaa; }
    }
</style>
</head>
<body>

<h1>📩 Contact Messages</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Date</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['subject']); ?></td>
        <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td class="actions">
            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this message?')">🗑 Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

<a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>

</body>
</html>
