<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit;
}

// Manejar eliminación de usuario
if (isset($_GET['delete_user'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id_user = ?");
    $stmt->execute([$_GET['delete_user']]);
    header("Location: admin.php");
    exit;
}

// Aprobar recurso
if (isset($_GET['approve'])) {
    $stmt = $pdo->prepare("UPDATE resources SET status = 'approved' WHERE id_resource = ?");
    $stmt->execute([$_GET['approve']]);
    header("Location: admin.php");
    exit;
}

// Eliminar recurso
if (isset($_GET['delete_resource'])) {
    $stmt = $pdo->prepare("DELETE FROM resources WHERE id_resource = ?");
    $stmt->execute([$_GET['delete_resource']]);
    header("Location: admin.php");
    exit;
}

// Obtener listados
$users = $pdo->query("SELECT * FROM users")->fetchAll();
$resources = $pdo->query("SELECT r.*, u.full_name FROM resources r JOIN users u ON r.uploaded_by = u.id_user")->fetchAll();
$messages = $pdo->query("SELECT * FROM messages ORDER BY sent_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel – FIEI</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="admin-container">
    <h1>Admin Panel</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['full_name']) ?> | <a href="logout.php">Logout</a></p>

    <h2>Users</h2>
    <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Career</th><th>Role</th><th>Actions</th></tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id_user'] ?></td>
            <td><?= htmlspecialchars($u['full_name']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= $u['career'] ?></td>
            <td><?= $u['role'] ?></td>
            <td><a href="?delete_user=<?= $u['id_user'] ?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Resources</h2>
    <table>
        <tr><th>ID</th><th>Title</th><th>Category</th><th>Status</th><th>Uploaded by</th><th>Actions</th></tr>
        <?php foreach ($resources as $r): ?>
        <tr>
            <td><?= $r['id_resource'] ?></td>
            <td><?= htmlspecialchars($r['title']) ?></td>
            <td><?= $r['category'] ?></td>
            <td><?= $r['status'] ?></td>
            <td><?= htmlspecialchars($r['full_name']) ?></td>
            <td>
                <?php if ($r['status'] == 'pending'): ?>
                <a href="?approve=<?= $r['id_resource'] ?>">Approve</a>
                <?php endif; ?>
                <a href="?delete_resource=<?= $r['id_resource'] ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Messages</h2>
    <?php foreach ($messages as $m): ?>
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <strong><?= htmlspecialchars($m['name']) ?></strong> (<?= htmlspecialchars($m['email']) ?>)<br>
            <small><?= $m['sent_at'] ?></small>
            <p><?= nl2br(htmlspecialchars($m['message'])) ?></p>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>