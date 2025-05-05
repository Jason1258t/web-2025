<?php
require_once "../utils/validators.php";

$users = json_decode(file_get_contents("../mock_data/users.json"), true);
$posts = json_decode(file_get_contents("../mock_data/posts.json"), true);

if (empty($users) || empty($posts)) {
    die('Невозможно подгрузить данные');
}


foreach ($users as $user) {
    if (!validateUser($user)) die('Некорректные данные пользователей');
}

foreach ($posts as $key => $post) {
    $posts[$key]['author'] = findUser($users, $post["userId"]);
    if (!validatePost($post)) die('Некорректные данные постов');
    
}


function getUserPosts($userId, $users, $posts)
{

    foreach ($users as $user) {
        if ($user['id'] == $userId) {
            return array_filter($posts, function ($post) use ($userId) {
                return $post['userId'] == $userId;
            });
        }
    }
    return null;
}

$userId = $_GET["id"] ?? null;
if ($userId != null) {
    $posts = getUserPosts($userId, $users, $posts);
    if ($posts == null) die("Невозможно найти посты для пользователя с id $userId");
}


require_once '../data/posts.php';

foreach ($posts as $post) {
    if (!validatePost($post)) {
        print_r($post);
        die('Некорректные данные постов');
    }
}



?>



<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css" />
    <title>Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap"
        rel="stylesheet" />
</head>
<script>
    function redirectToPage(page) {
        window.location.href = page;
    }
</script>

<body>
    <div class="navigation">
        <div class="nav-item">
            <img src="../assets/home.svg" alt="Home" />
            <div class="dot"></div>
        </div>
        <div class="nav-item" onclick="redirectToPage('/profile')">
            <img src="../assets/profile.svg" alt="Profile" />
        </div>
        <div class="nav-item">
            <img src="../assets/plus.svg" alt="Plus" />
        </div>
    </div>
    <div class="wrapper">
        <div class="posts">
            <?php foreach ($posts as $post) {
                include "post-template.php";
            } ?>
        </div>
    </div>
</body>

</html>