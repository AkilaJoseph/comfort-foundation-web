<?php /** @var array $member */ $delay = $delay ?? 0; ?>
<div class="team__single-wrapper" data-aos="fade-up" data-aos-duration="1000"<?= $delay ? ' data-aos-delay="' . (int) $delay . '"' : '' ?>>
    <div class="team__single van-tilt">
        <div class="team__single-thumb">
            <a href="<?= e(url('team/' . $member['slug'])) ?>">
                <?= img($member['image'], ['alt' => $member['name'], 'fallback' => 'assets/images/team/one.webp', 'width' => 300, 'height' => 340]) ?>
            </a>
            <?php
            $links = array_filter([
                'fa-brands fa-facebook-f'  => $member['facebook'],
                'fa-brands fa-twitter'     => $member['twitter'],
                'fa-brands fa-instagram'   => $member['instagram'],
                'fa-brands fa-linkedin-in' => $member['linkedin'],
            ]);
            if ($links): ?>
            <div class="team__icons">
                <div class="team__single-content__icon"><i class="fa-solid fa-plus"></i></div>
                <div class="team__single__thumb-social">
                    <ul>
                        <?php foreach ($links as $icon => $href): ?>
                        <li><a href="<?= e($href) ?>" target="_blank" rel="noopener" aria-label="social profile"><i class="<?= e($icon) ?>"></i></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="team__single-content">
            <h6><a href="<?= e(url('team/' . $member['slug'])) ?>"><?= e($member['name']) ?></a></h6>
            <p><?= e($member['role_title']) ?></p>
        </div>
    </div>
</div>
