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

<body class="page">
    <nav class="nav">
        <div class="nav__item" onclick="redirectToPage('/home')">
            <img src="../assets/home.svg" alt="Home" class="nav__icon" />
        </div>
        <div class="nav__item nav__item--active">
            <img src="../assets/profile.svg" alt="Profile" class="nav__icon" />
            <div class="nav__dot"></div>
        </div>
        <div class="nav__item">
            <img src="../assets/plus.svg" alt="Plus" class="nav__icon" />
        </div>
    </nav>

    <div class="profile">
        <img src="<?= $user['avatar'] ?>" alt="User avatar" class="profile__avatar" />
        <h1 class="profile__name"><?= $user['name'] ?></h1>
        <p class="profile__bio"><?= $user['bio'] ?></p>
        <div class="profile__stats">
            <img src="../assets/img.svg" alt="Posts icon" class="profile__stats-icon" />
            <span><?= $user['postCount'] ?> posts</span>
        </div>
        <div class="posts-grid">
            <?php foreach ($posts as $post) {
                include "post.php";
            }
            ?>
        </div>
    </div>

</body>

</html>