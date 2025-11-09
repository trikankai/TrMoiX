<?php
header('Content-Type: application/json');
if (!isset($_FILES['file'])) {
    echo json_encode(['success' => false, 'error' => 'No file']);
    exit;
}

$file = $_FILES['file'];
$caption = $_POST['caption'] ?? '';
$user = $_POST['user'] ?? 'Guest';
$verified = $_POST['verified'] ?? 'gray';

$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$id = time() . rand(1000, 9999);
$filename = "$id.$ext";
$filepath = "media/$filename";

if (!is_dir('media')) mkdir('media', 0755, true);
if (move_uploaded_file($file['tmp_name'], $filepath)) {
    $url = "https://trmoix.wuaze.com/media/$filename";
    $data = json_decode(file_get_contents('data.json'), true) ?: ['posts' => []];
    $data['posts'][] = ['id' => $id, 'url' => $url, 'caption' => $caption, 'user' => $user, 'verified' => $verified];
    file_put_contents('data.json', json_encode($data));
    echo json_encode(['success' => true, 'id' => $id, 'url' => $url]);
} else {
    echo json_encode(['success' => false, 'error' => 'Upload failed']);
}
?>
