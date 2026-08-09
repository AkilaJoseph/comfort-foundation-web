<div class="blog-main__sidebar">
    <div class="cm-details__sidebar">
        <div class="cm-sidebar-widget" data-aos="fade-up" data-aos-duration="1000">
            <div class="intro"><h5>Search</h5></div>
            <form action="<?= e(url('search')) ?>" method="get" role="search">
                <input type="search" name="q" placeholder="Search news…" value="<?= e(get('q')) ?>" aria-label="Search news" required>
                <button type="submit" aria-label="search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>

        <?php $recent = posts(4); if ($recent): ?>
        <div class="cm-sidebar-widget" data-aos="fade-up" data-aos-duration="1000">
            <div class="intro"><h5>Recent Posts</h5></div>
            <div class="cm-sidebar-post">
                <?php foreach ($recent as $r): ?>
                <div class="single-item">
                    <div class="thumb">
                        <a href="<?= e(url('news/' . $r['slug'])) ?>"><?= img($r['image'], ['alt' => $r['title'], 'width' => 90, 'height' => 90]) ?></a>
                    </div>
                    <div class="content">
                        <p><i class="fa-solid fa-calendar-days"></i> <span><?= e(fmt_date($r['published_at'], 'j M Y')) ?></span></p>
                        <p><a href="<?= e(url('news/' . $r['slug'])) ?>"><?= e(excerpt($r['title'], 52)) ?></a></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php $cats = categories_with_counts(); if ($cats): ?>
        <div class="cm-sidebar-widget" data-aos="fade-up" data-aos-duration="1000">
            <div class="intro"><h5>Categories</h5></div>
            <div class="cm-categories">
                <?php foreach ($cats as $c): ?>
                <a href="<?= e(url('news/category/' . $c['slug'])) ?>">
                    <span><?= e($c['name']) ?></span>
                    <span><?= str_pad((string) $c['total'], 2, '0', STR_PAD_LEFT) ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="cm-sidebar-widget" data-aos="fade-up" data-aos-duration="1000">
            <div class="intro"><h5>Support Our Work</h5></div>
            <p style="margin-bottom:18px;">Every contribution helps a woman start earning, a family find support, or a child feel safe.</p>
            <a href="<?= e(url('donate')) ?>" class="btn--primary">Donate Now <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>
</div>
