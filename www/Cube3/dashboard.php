<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>
<?php include 'templates/header.php'; ?>
<h2>Welcome, <?= $_SESSION['user']['email']; ?>!</h2>
<?php include 'templates/footer.php'; ?>
