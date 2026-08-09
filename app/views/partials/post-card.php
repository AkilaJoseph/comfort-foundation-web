<?php /** @var array $post */ $delay = $delay ?? 0; ?>
<div class="blog__single-wrapper" data-aos="fade-up" data-aos-duration="1000"<?= $delay ? ' data-aos-delay="' . (int) $delay . '"' : '' ?>>
    <div class="blog__single van-tilt">
        <div class="blog__single-thumb">
            <a href="<?= e(url('news/' . $post['slug'])) ?>">
                <?= img($post['image'], ['alt' => $post['title'], 'width' => 420, 'height' => 300]) ?>
            </a>
            <?php if (!empty($post['category_name'])): ?>
            <div class="tag">
                <a href="<?= e(url('news/category/' . $post['category_slug'])) ?>"><i class="fa-solid fa-tags"></i><?= e($post['category_name']) ?></a>
            </div>
            <?php endif; ?>
        </div>
        <div class="blog__single-inner">
            <div class="blog__single-meta">
                <p><i class="icon-user"></i><?= e($post['author']) ?></p>
                <p><i class="fa-regular fa-calendar"></i><?= e(fmt_date($post['published_at'], 'j M Y')) ?></p>
            </div>
            <div class="blog__single-content">
                <h5><a href="<?= e(url('news/' . $post['slug'])) ?>"><?= e($post['title']) ?></a></h5>
                <p><?= e(excerpt($post['excerpt'] ?: $post['body'], 105)) ?></p>
            </div>
            <div class="blog__single-cta">
                <a href="<?= e(url('news/' . $post['slug'])) ?>" aria-label="read <?= e($post['title']) ?>">Read More<i class="fa-solid fa-circle-arrow-right"></i></a>
            </div>
        </div>
        <img src="<?= e(asset('assets/images/blog/spade.webp')) ?>" alt="" class="spade-two" loading="lazy" aria-hidden="true">
    </div>
</div>
