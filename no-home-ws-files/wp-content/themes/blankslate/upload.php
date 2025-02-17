<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadDir = __DIR__ . '/user-uploads/';
    $maxFileSize = 0.5 * 1024 * 1024;
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/heic'];
    
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $fileName = basename($_FILES['file']['name']);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = $_FILES['file']['type'];
    $fileSize = $_FILES['file']['size'];
    
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Only JPEG, PNG, GIF and HEIC formats are accepted']);
    } elseif ($fileSize > $maxFileSize) {
        echo json_encode(['status' => 'error', 'message' => 'Max size of the file is 0.5 MB']);
    } elseif (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
        // Возвращаем относительный путь к файлу
        $relativePath = '/wp-content/themes/blankslate/user-uploads/' . $fileName;
        echo json_encode(['status' => 'success', 'message' => 'Your image is successfully uploaded', 'path' => $relativePath]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'There is a problem uploading your image']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error']);
}
?>