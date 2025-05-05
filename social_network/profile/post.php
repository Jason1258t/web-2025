<?php
if (!isset($post)) {
    return;
}

?>

<img src="<?= $post['images'][0] ?>"
    alt="Post image"
    class="posts-grid__image" />