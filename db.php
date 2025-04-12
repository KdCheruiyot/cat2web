<?php
$host = 'localhost';         // usually localhost
$db   = 'fashion_store';     // your database name
$user = 'root';              // your database username (default for XAMPP is 'root')
$pass = '';                  // your database password (default for XAMPP is empty)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions for errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch results as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulated prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // In production, don't show errors like this – log them instead
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}
?>
