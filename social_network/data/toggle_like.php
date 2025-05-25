<?php
require_once 'database.php';

$pdo = connectDatabase();

$userId = $_GET['user_id'] ?? null;
$postId = $_GET['post_id'] ?? null;

if (!$userId || !$postId) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing user_id or post_id']);
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT 1 FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$userId, $postId]);
    $isLiked = $stmt->fetch();

    if ($isLiked) {
        $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$userId, $postId]);

        // Уменьшаем счетчик лайков
        $stmt = $pdo->prepare("UPDATE post SET likes_count = likes_count - 1 WHERE id = ?");
        $stmt->execute([$postId]);

        $action = 'unliked';
    } else {
        $stmt = $pdo->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
        $stmt->execute([$userId, $postId]);

        $stmt = $pdo->prepare("UPDATE post SET likes_count = likes_count + 1 WHERE id = ?");
        $stmt->execute([$postId]);

        $action = 'liked';
    }

    $stmt = $pdo->prepare("SELECT likes_count FROM post WHERE id = ?");
    $stmt->execute([$postId]);
    $likesCount = $stmt->fetchColumn();

    $pdo->commit();

    echo json_encode([
        'action' => $action,
        'likes_count' => $likesCount,
        'is_liked' => !$isLiked
    ]);
} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
