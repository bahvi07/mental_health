<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: http://localhost:3000"); 
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read JSON input
    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
    $content = isset($_POST['content']) ? $_POST['content'] : null;

    if (!$post_id || !$content) {
        echo json_encode(['status' => 'error', 'message' => 'No form data received']);
        exit;
    }

    $conn = new mysqli('127.0.0.1', 'bhavishya', 'bk995031', 'mental_health');

    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO responses (post_id, content) VALUES (?, ?)"); 
    $stmt->bind_param("is", $post_id, $content); 

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Response submitted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save data to the database: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
