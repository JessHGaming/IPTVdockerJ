<?php require 'init.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    die("Access denied.");
}

$users = $db->query("SELECT id, username, role FROM users")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $db->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
    header("Location: admin.php");
    exit;
}
?>
<h2>Admin Panel</h2>
<table border="1">
    <tr><th>ID</th><th>Username</th><th>Role</th><th>Action</th></tr>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= $u['role'] ?></td>
            <td>
                <?php if ($u['id'] !== $_SESSION['user']['id']): ?>
                    <a href="?delete=<?= $u['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                <?php else: ?>—
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="dashboard.php">Back</a>
