<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
    if ($stmt->execute([$email, $password])) {
        $_SESSION['message'] = 'Registration successful!';
        header('Location: login.php');
        exit();
    } else {
        $_SESSION['message'] = 'Registration failed!';
    }
}
?>
<?php include 'templates/header.php'; ?>
<h2>Register</h2>
<?php if (isset($_SESSION['message'])): ?>
    <div class="flash"><?= $_SESSION['message']; ?></div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>
<form action="register.php" method="POST">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Register">
</form>
<?php include 'templates/footer.php'; ?>
