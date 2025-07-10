<?php
// db.php

$host = 'localhost';  // Change if your MySQL server is on a different host
$db   = 'project_db'; // Database name
$user = 'root';       // Your MySQL username
$pass = 'mysql';           // Your MySQL password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

// Function to initialize the database if not already done
function initializeDatabase($pdo) {
    // SQL to create the users table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                is_admin BOOLEAN DEFAULT FALSE
            )";
    // Execute the query
    $pdo->exec($sql);

    // Predefine certain admin users by their email
    $adminEmails = ['admin1@example.com', 'admin2@example.com']; // Replace with actual admin emails
    foreach ($adminEmails as $adminEmail) {
        // Check if the admin email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$adminEmail]);
        if ($stmt->fetch() === false) {
            // Insert the admin user with a default password ('password123') if they don't exist
            $passwordHash = password_hash('password123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password, is_admin) VALUES (?, ?, 1)");
            $stmt->execute([$adminEmail, $passwordHash]);
        }
    }
}

// Initialize the database and create the admin users if necessary
initializeDatabase($pdo);
?>

