<?php
function getDbConnection() {
    $config = require __DIR__ . '/../config/database.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}// adjust accordingly
?>// Implement database connection logic in db_connect.php
// Optimize database connection with error handling
// Add prepared statements to db_connect.php
// Add connection timeout handling
// Add database connection retry logic
// Implement database connection logic in db_connect.php
// Optimize database connection with error handling
// Add prepared statements to db_connect.php
// Add connection timeout handling
