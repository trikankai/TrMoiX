<?php
$since = $_GET['since'] ?? 0;
$data = json_decode(file_get_contents('data.json'), true) ?: ['posts' => []];
$posts = array_filter($data['posts'], fn($p) => $p['id'] > $since);
header('Content-Type: application/json');
echo json_encode(array_values($posts));
?>
