<?php
require_once 'database.php';

$pdo = connectDatabase();

$userId = $_GET['user_id'] ?? null;
$currentUserId = 1; // Захардкоженный ID текущего пользователя

$sql = "SELECT 
    p.id,
    p.description,
    p.likes_count as likesCount,
    p.created_at as createdAt,
    JSON_OBJECT(
        'id', u.id,
        'name', u.name,
        'avatar', u.avatar
    ) AS author,
    (
        SELECT JSON_ARRAYAGG(image_path)
        FROM post_image pi
        WHERE pi.post_id = p.id
        ORDER BY pi.sort_order
    ) AS images,
    EXISTS(
        SELECT 1 FROM likes 
        WHERE user_id = :current_user_id AND post_id = p.id
    ) AS isLiked
FROM 
    post p
JOIN 
    user u ON p.user_id = u.id";

if ($userId != null) {
    $sql .= " WHERE p.user_id = :user_id";
}

$sql .= " ORDER BY p.created_at DESC";

// Подготовка и выполнение запроса
$stmt = $pdo->prepare($sql);

// Привязываем параметры
$stmt->bindParam(':current_user_id', $currentUserId, PDO::PARAM_INT);

if ($userId != null) {
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
}

$stmt->execute();

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as $key => $post) {
    $posts[$key]['createdAt'] = new DateTime($post['createdAt'])->getTimestamp();
    $posts[$key]['author'] = json_decode($post["author"], true);
    $posts[$key]['images'] = json_decode($post["images"]);
    $posts[$key]['isLiked'] = (bool)$post['isLiked']; // Преобразуем в boolean
}