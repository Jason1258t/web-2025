<?php
if (!isset($post)) {
    echo "broken post";
    return;
}
?>
<div class="post">
    <div class="post__header">
        <div class="post__user">
            <div class="post__avatar">
                <img
                    src="<?= htmlspecialchars($post['author']['avatar']) ?>"
                    alt="user avatar"
                    class="post__avatar-img" />
            </div>
            <p class="post__username"><?= htmlspecialchars($post['author']['name']) ?></p>
        </div>
        <img src="../assets/edit.svg" alt="Edit" class="post__edit" />
    </div>
    <div class="post__content">
        <img
            src="<?= htmlspecialchars($post['images'][0]) ?>"
            alt="post image"
            class="post__image" />
        <?php if (count($post['images'] ?? []) > 1): ?>
            <div class="post__image-navigation">
                <p class="post__image-count">1/<?= count($post['images']) ?></p>
                <img src="src/left.png" alt="Previous" class="post__nav-button post__nav-button--left" />
                <img src="src/right.png" alt="Next" class="post__nav-button post__nav-button--right" />
            </div>
        <?php endif; ?>
    </div>
    <div class="post__like">
        <img src="../assets/like.png" alt="Like" class="post__like-icon" />
        <span><?= $post['likesCount'] ?></span>
    </div>
    <?php !empty($post['description']) && print('<p class="post__text">' . htmlspecialchars($post['description']) . '</p> <span class="post__more">...еще</span>') ?>
    <p class="post__time"><?= htmlspecialchars(date("d M Y", $post["createdAt"])) ?></p>
</div>