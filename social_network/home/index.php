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
    <link rel="stylesheet" href="../shared/styles/main.css" />
    <link rel="stylesheet" href="./slider/styles.css" />
    <link rel="stylesheet" href="../shared/components/overlays/post_images/styles.css" />
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
    <nav class="nav">
        <div class="nav__item nav__item--active">
            <img src="../assets/home.svg" alt="Home" class="nav__icon" />
            <div class="nav__dot"></div>
        </div>
        <div class="nav__item" onclick="redirectToPage('/profile')">
            <img src="../assets/profile.svg" alt="Profile" class="nav__icon" />
        </div>
        <div class="nav__item" onclick="redirectToPage('/create_post')">
            <img src="../assets/plus.svg" alt="Plus" class="nav__icon" />
        </div>
    </nav>

    <div class="feed">
        <?php foreach ($posts as $post) {
            include "post-template.php";
        } ?>
    </div>

    <?php include "../shared/components/overlays/post_images/overlay.php" ?>
    <script type="module" src="slider/postSliders.js"></script>
    <script type="module" src="modal.js"></script>
    <script src="postContentToggle.js"></script>
</body>

</html>