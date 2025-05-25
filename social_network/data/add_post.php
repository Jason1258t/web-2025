<?php
header('Content-Type: application/json');

require_once 'database.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

try {
    if (!isset($_POST['json'])) {
        throw new Exception('Missing JSON data');
    }

    $input = json_decode($_POST['json'], true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON: ' . json_last_error_msg());
    }

    if (isset($input['description']) && strlen($input['description']) > 1000) {
        throw new Exception('Description must be less than 1000 characters');
    }

    if (!isset($input['description'])) {
        $input['description'] = null;
    }

    if (!isset($input['user_id']) || !filter_var($input['user_id'], FILTER_VALIDATE_INT)) {
        throw new Exception('Invalid or missing user_id');
    }

    // ...
    if (empty($_FILES['images']) || !is_array($_FILES['images']['tmp_name'])) {
        throw new Exception('At least one image is required');
    }

    $uploadedFilenames = [];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $uploadDir = '../images/posts/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['images']['error'][$index] !== UPLOAD_ERR_OK) {
            throw new Exception('Image upload error at index ' . $index);
        }

        $mimeType = mime_content_type($tmpName);
        if (!in_array($mimeType, $allowedTypes)) {
            throw new Exception("Invalid image type at index $index");
        }

        $ext = pathinfo($_FILES['images']['name'][$index], PATHINFO_EXTENSION);
        $filename = uniqid('img_') . '.' . $ext;
        $targetPath = $uploadDir . $filename;

        if (!move_uploaded_file($tmpName, $targetPath)) {
            throw new Exception("Failed to save image at index $index");
        }

        $uploadedFilenames[] = '../images/posts/' . $filename;
    }

    $pdo = connectDatabase();

    // Проверка пользователя
    $stmt = $pdo->prepare("SELECT id FROM user WHERE id = ?");
    $stmt->execute([$input['user_id']]);
    if (!$stmt->fetch()) {
        throw new Exception('User not found');
    }

    // Создание поста
    $stmt = $pdo->prepare("INSERT INTO post (description, user_id) VALUES (?, ?)");
    $stmt->execute([$input['description'], $input['user_id']]);
    $postId = $pdo->lastInsertId();

    // Вставка изображений
    $stmt = $pdo->prepare("INSERT INTO post_image (post_id, sort_order, image_path) VALUES (?, ?, ?)");
    foreach ($uploadedFilenames as $i => $imgPath) {
        $stmt->execute([$postId, $i, $imgPath]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Post created successfully',
        'images' => $uploadedFilenames
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
