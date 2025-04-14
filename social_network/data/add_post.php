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
    // Проверка и парсинг JSON (из поля json в form-data)
    if (!isset($_POST['json'])) {
        throw new Exception('Missing JSON data');
    }

    $input = json_decode($_POST['json'], true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON: ' . json_last_error_msg());
    }

    // Валидация данных
    if (empty($input['description'])) {
        throw new Exception('Description is required');
    }

    if (strlen($input['description']) > 1000) {
        throw new Exception('Description must be less than 1000 characters');
    }

    if (!isset($input['user_id']) || !filter_var($input['user_id'], FILTER_VALIDATE_INT)) {
        throw new Exception('Invalid or missing user_id');
    }

    // Валидация наличия файла
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Image file is required and must be uploaded successfully');
    }

    // Валидация типа файла
    $fileTmp = $_FILES['image']['tmp_name'];
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($fileInfo, $fileTmp);
    finfo_close($fileInfo);

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($mimeType, $allowedTypes)) {
        throw new Exception('Only JPG, PNG, or GIF images are allowed');
    }

    // Сохранение изображения
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('img_') . '.' . $ext;
    $uploadDir = '../images/posts/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $targetPath = $uploadDir . $filename;
    if (!move_uploaded_file($fileTmp, $targetPath)) {
        throw new Exception('Failed to save uploaded image');
    }

    // Сохранение в базу данных
    $pdo = connectDatabase();

    // Проверка наличия пользователя
    $stmt = $pdo->prepare("SELECT id FROM user WHERE id = ?");
    $stmt->execute([$input['user_id']]);
    if (!$stmt->fetch()) {
        throw new Exception('User not found');
    }

    // Вставка поста
    $stmt = $pdo->prepare("INSERT INTO post (description, user_id) VALUES (?, ?)");
    $stmt->execute([
        $input['description'],
        $input['user_id']
    ]);

    $stmt = $pdo->prepare("INSERT INTO post_image (post_id, sort_order, image_path) VALUES (?, ?, ?)");
    $stmt->execute([
        $pdo->lastInsertId(),
        0,
        '../images/posts/' . $filename
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Post created successfully',
        'image_url' => 'images/posts/' . $filename
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
