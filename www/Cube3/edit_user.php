<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
    header('Location: dashboard.php');
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('UPDATE users SET email = ?, password = ? WHERE id = ?');
    if ($stmt->execute([$email, $password, $id])) {
        $_SESSION['message'] = 'User updated successfully!';
        header('Location: admin.php');
        exit();
    } else {
        $_SESSION['message'] = 'User update failed!';
    }
}
?>
<?php include 'templates/header.php'; ?>
<h2>Edit User</h2>
<?php if (isset($_SESSION['message'])): ?>
    <div class="flash"><?= $_SESSION['message']; ?></div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>
<form action="edit_user.php?id=<?= $user['id']; ?>" method="POST">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="<?= $user['email']; ?>" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Update User">
</form>
<?php include 'templates/footer.php'; ?>
