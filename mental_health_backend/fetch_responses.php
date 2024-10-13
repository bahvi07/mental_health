<?php
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli('127.0.0.1', 'bhavishya', 'bk995031', 'mental_health');

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}


$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

$stmt = $conn->prepare("SELECT * FROM responses WHERE post_id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

$responses = [];
while ($row = $result->fetch_assoc()) {
    $responses[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($responses);
?>
