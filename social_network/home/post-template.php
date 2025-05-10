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
        <div class="post__slider">
            <?php foreach ($post['images'] as $index => $image): ?>
                <div class="post__slide <?= $index === 0 ? 'post__slide--active' : '' ?>">
                    <img
                        src="<?= htmlspecialchars($image) ?>"
                        alt="post image"
                        class="post__image" />
                </div>
            <?php endforeach; ?>

            <?php if (count($post['images'] ?? []) > 1): ?>
                <div class="post__slider-controls">
                    <div class="post__slider-arrows">
                        <button class="post__slider-arrow post__slider-arrow--prev">
                            <img src="../assets/left.svg" alt="Previous" />
                        </button>
                        <button class="post__slider-arrow post__slider-arrow--next">
                            <img src="../assets/right.svg" alt="Next" />
                        </button>
                    </div>
                    <div class="post__slider-counter">
                        <span class="post__slider-current">1</span>/<?= count($post['images']) ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="post__like">
        <img src="../assets/like.png" alt="Like" class="post__like-icon" />
        <span><?= $post['likesCount'] ?></span>
    </div>
    <?php !empty($post['description']) && print('<p class="post__text">' . htmlspecialchars($post['description']) . '</p> <span class="post__more">...еще</span>') ?>
    <p class="post__time"><?= htmlspecialchars(date("d M Y", $post["createdAt"])) ?></p>
</div>
