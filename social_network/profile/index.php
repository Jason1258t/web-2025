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

foreach ($posts as $post) {
    if (!validatePost($post)) die('Некорректные данные постов');
}

$userId = $_GET["id"] ?? 1;
$user = findUser($users, $userId);
if ($user == null) {
    header("Location: " .  "../home");
    die();
}

$posts = array_filter($posts, function ($post) use ($userId) {
    return $post["userId"] == $userId;
});
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css" />
    <title>Profile</title>
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
        <div class="nav-item" onclick="redirectToPage('/home')">
            <img src="../assets/home.svg" alt="Home" />
        </div>
        <div class="nav-item">
            <img src="../assets/profile.svg" alt="Profile" />
            <div class="dot"></div>
        </div>
        <div class="nav-item">
            <img src="../assets/plus.svg" alt="Plus" />
        </div>
    </div>
    <div class="content-wrapper">
        <div class="profile">
            <img src=<?= $user['avatar'] ?> alt="User 1" class="avatar" />
            <p class="text name"><?= $user['name'] ?></p>
            <p class="text description">
                <?= $user['bio'] ?>
            </p>
            <div class="counter">
                <img src="../assets/img.svg" alt="Posts" />
                <p class="text"><?= $user['postCount'] ?> posts</p>
            </div>

            <div class="userposts">
                <?php foreach ($posts as $post) {
                    include "post.php";
                } ?>
            </div>
        </div>
    </div>
</body>

</html>