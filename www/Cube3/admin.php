<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
    header('Location: dashboard.php');
    exit();
}

$users = $pdo->query('SELECT * FROM users')->fetchAll();
?>
<?php include 'templates/header.php'; ?>
<h2>Admin Dashboard</h2>
<table>
    <thead>
        <tr>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['email']; ?></td>
            <td>
                <a href="edit_user.php?id=<?= $user['id']; ?>">Edit</a>
                <a href="delete_user.php?id=<?= $user['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="create_user.php">Create User</a>
<?php include 'templates/footer.php'; ?>
