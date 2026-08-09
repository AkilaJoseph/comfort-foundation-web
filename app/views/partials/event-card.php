<?php /** @var array $event */ $alt = $alt ?? false; $delay = $delay ?? 0; ?>
<div class="event__single-wrapper" data-aos="<?= $alt ? 'fade-left' : 'fade-up' ?>" data-aos-duration="1000"<?= $delay ? ' data-aos-delay="' . (int) $delay . '"' : '' ?>>
    <div class="event__single<?= $alt ? ' event-single-alt' : '' ?> van-tilt">
        <div class="event__single-thumb">
            <?= img($event['image'], ['alt' => $event['title'], 'fallback' => 'assets/images/event/one.webp', 'width' => 560, 'height' => 360]) ?>
        </div>
        <div class="event__content">
            <span><?= e($event['starts_at'] ? fmt_date($event['starts_at'], 'F j, Y') : 'Date to be announced') ?></span>
            <h4><a href="<?= e(url('events/' . $event['slug'])) ?>"><?= e($event['title']) ?></a></h4>
            <?php if (!empty($event['location'])): ?>
            <p><i class="fa-solid fa-location-dot"></i> <?= e($event['location']) ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
