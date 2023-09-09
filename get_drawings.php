<?php
require_once __DIR__ . '/includes/db_connect.php';

header('Content-Type: text/xml');

try {
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT start_x, start_y, end_x, end_y, color, thickness FROM drawings ORDER BY created_at");
    $drawings = $stmt->fetchAll();

    $xml = new XMLWriter();
    $xml->openURI(__DIR__ . '/data/drawings.xml');
    $xml->startDocument('1.0', 'UTF-8');
    $xml->startElement('drawings');

    foreach ($drawings as $drawing) {
        $xml->startElement('line');
        $xml->writeAttribute('start_x', $drawing['start_x']);
        $xml->writeAttribute('start_y', $drawing['start_y']);
        $xml->writeAttribute('end_x', $drawing['end_x']);
        $xml->writeAttribute('end_y', $drawing['end_y']);
        $xml->writeAttribute('color', $drawing['color']);
        $xml->writeAttribute('thickness', $drawing['thickness']);
        $xml->endElement();
    }

    $xml->endElement();
    $xml->endDocument();
    $xml->flush();

    readfile(__DIR__ . '/data/drawings.xml');
} catch (Exception $e) {
    http_response_code(500);
    echo '<?xml version="1.0" encoding="UTF-8"?><error>Server error: ' . htmlspecialchars($e->getMessage()) . '</error>';
}//just make sure if you use some other like axios something otherthan xhr than make sure to adjust here too
?>// Add get_drawings.php to generate XML from database
// Optimize XML generation in get_drawings.php
// Add filtering by user in get_drawings.php
// Add caching for XML output in get_drawings.php
// Support metadata in XML output
// Add pagination to XML output
// Add get_drawings.php to generate XML from database
// Optimize XML generation in get_drawings.php
// Add filtering by user in get_drawings.php
// Add caching for XML output in get_drawings.php
