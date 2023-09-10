<?php
require_once __DIR__ . '/includes/db_connect.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['startX'], $input['startY'], $input['endX'], $input['endY'], $input['color'], $input['thickness'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

try {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("INSERT INTO drawings (start_x, start_y, end_x, end_y, color, thickness, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([
        $input['startX'],
        $input['startY'],
        $input['endX'],
        $input['endY'],
        $input['color'],
        $input['thickness']
    ]);
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}//script to handle the connection with saving 
?>// Add save_drawing.php to store coordinates in database
// Add input validation to save_drawing.php
// Add batch insert support to save_drawing.php
// Add user authentication for saving drawings
// Optimize database queries in save_drawing.php
// Add metadata storage for drawings
// Add error logging for failed saves
// Add save_drawing.php to store coordinates in database
// Add input validation to save_drawing.php
// Add batch insert support to save_drawing.php
// Add user authentication for saving drawings
// Optimize database queries in save_drawing.php
// Add metadata storage for drawings
