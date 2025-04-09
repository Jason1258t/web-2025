<?php
if (!isset($post)) {
    return;
}

?>

<img
    src=<?= $post['images'][0] ?>
    alt="post"
    class="pic" />