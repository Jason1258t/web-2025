<?php

/**
 * @param array $images - массив путей к изображениям
 */
if (!isset($images) || empty($images)) return;
?>
<div class="slider">

    <?php foreach ($images as $index => $image): ?>
        <div class="slider__slide <?= $index === 0 ? 'slider__slide--active' : '' ?>">
            <img src="<?= htmlspecialchars($image) ?>" alt="Slide <?= $index + 1 ?>" class="slider__image">
        </div>
    <?php endforeach; ?>


    <?php if (count($images) > 1): ?>
        <div class="slider__controls">
            <div class="slider__arrows">
                <button class="slider__arrow slider__arrow--prev">
                    <img src="/assets/left.svg" alt="Previous">
                </button>
                <button class="slider__arrow slider__arrow--next">
                    <img src="/assets/right.svg" alt="Next">
                </button>
            </div>
        </div>
        <?php if (isset($displayCounter) && $displayCounter): ?>
            <div class="slider__counter">
                <span class="slider__current">1</span>/<?= count($images) ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>