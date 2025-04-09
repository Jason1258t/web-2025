<?php
if (!isset($user, $post)) {
    echo "broken post";
    return;
}
?>
<div class="post">
    <div class="userdata">
        <div class="row">
            <img
                src=<?= htmlspecialchars($user['avatar']) ?>
                alt="user avatar"
                class="avatar" />
            <p class="text"><?= htmlspecialchars($user['name']) ?></p>
        </div>

        <img src="../assets/edit.svg" alt="Edit" class="edit" />
    </div>
    <div class="contentwrapper">
        <img
            src=<?= htmlspecialchars($post['images'][0]) ?>
            alt="post image"
            class="content" />
        <p class="count">1/3</p>
        <img src="src/left.png" alt="" class="left" />
        <img src="src/right.png" alt="" class="right" />
    </div>
    <div class="likes">
        <img src="../assets/like.png" alt="Like" />
        <p><?= $post['likesCount'] ?></p>
    </div>
    <?php !empty($post['description']) && print('<p class="content">' . htmlspecialchars($post['description']) . '</p> <span class="more">...еще</span>') ?>
    <p class="time"><?= htmlspecialchars(date("d M Y", $post["createdAt"])) ?></p>
</div>