<?php
if (!isset($post)) {
    echo "post data not passed";
    return;
}
?>
<div class="post">
    <div class="post__header">
        <div class="post__user">
            <img
                src="<?= htmlspecialchars($post['author']['avatar']) ?>"
                alt="user avatar"
                class="post__avatar" />
            <p class="post__username"><?= htmlspecialchars($post['author']['name']) ?></p>
        </div>
        <img src="../assets/edit.svg" alt="Edit" class="post__edit" />
    </div>
    <div class="post__content">
        <?php
        $images = $post['images'];
        $displayCounter = true;
        include "../shared/components/slider/slider.php";
        ?>
    </div>
    <div class="post__like">
        <img src="../assets/like.png" alt="Like" class="post__like-icon" />
        <span><?= $post['likesCount'] ?></span>
    </div>
    <?php !empty($post['description']) && print('<p class="post__text">' . htmlspecialchars($post['description']) . '</p> <span class="post__more">...еще</span>') ?>
    <p class="post__time"><?= htmlspecialchars(date("d M Y", $post["createdAt"])) ?></p>
</div>