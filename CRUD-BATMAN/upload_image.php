<?php
session_start();
if (!isset($_SESSION['username'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

header('Content-Type: application/json');

$allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
$max_size = 5 * 1024 * 1024; // 5MB

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'No file uploaded or upload error.']);
    exit();
}

$file = $_FILES['image'];

if (!in_array($file['type'], $allowed_types)) {
    echo json_encode(['success' => false, 'error' => 'Invalid file type. Only JPG, PNG, GIF, WEBP allowed.']);
    exit();
}

if ($file['size'] > $max_size) {
    echo json_encode(['success' => false, 'error' => 'File too large. Max 5MB.']);
    exit();
}

// Sanitize filename
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$safe_name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
$filename = $safe_name . '.' . $ext;

// If file exists, append a number
$upload_dir = '../img/';
$dest = $upload_dir . $filename;
$counter = 1;
while (file_exists($dest)) {
    $filename = $safe_name . '_' . $counter . '.' . $ext;
    $dest = $upload_dir . $filename;
    $counter++;
}

if (move_uploaded_file($file['tmp_name'], $dest)) {
    echo json_encode(['success' => true, 'filename' => 'img/' . $filename]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to save file. Check folder permissions.']);
}
