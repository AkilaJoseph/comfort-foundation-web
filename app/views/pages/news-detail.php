<?php
/** @var array $post */
$nb    = post_neighbours((int) $post['id'], $post['published_at']);
$share = rawurlencode(abs_url('news/' . $post['slug']));
$stitle = rawurlencode($post['title']);
?>
<?php partial('page-banner', [
    'heading' => $post['title'],
    'eyebrow' => $post['category_name'] ?? 'News',
    'crumbs'  => ['News' => 'news', excerpt($post['title'], 40) => null],
]); ?>

<section class="blog blog-main cm-details" style="padding:100px 0;">
    <div class="container">
        <?= render_flash() ?>
        <div class="row gutter-40">
            <div class="col-12 col-xl-8">
                <article data-aos="fade-up" data-aos-duration="1000">
                    <?= img($post['image'], ['alt' => $post['title'], 'class' => 'w-100']) ?>

                    <div class="blog__single-meta" style="margin:28px 0 18px;display:flex;gap:24px;flex-wrap:wrap;">
                        <p><i class="icon-user"></i> <?= e($post['author']) ?></p>
                        <p><i class="fa-regular fa-calendar"></i> <?= e(fmt_date($post['published_at'])) ?></p>
                        <?php if (!empty($post['category_name'])): ?>
                        <p><i class="fa-solid fa-tags"></i> <a href="<?= e(url('news/category/' . $post['category_slug'])) ?>"><?= e($post['category_name']) ?></a></p>
                        <?php endif; ?>
                    </div>

                    <h1 style="font-size:34px;margin-bottom:22px;"><?= e($post['title']) ?></h1>

                    <div class="cf-prose">
                        <?php if (!empty($post['excerpt'])): ?>
                        <p style="font-size:20px;font-weight:600;color:var(--cf-ink);"><?= e($post['excerpt']) ?></p>
                        <?php endif; ?>
                        <?= safe_html($post['body']) ?>
                    </div>

                    <div style="margin-top:36px;padding-top:26px;border-top:1px solid rgba(35,31,32,.1);display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                        <strong>Share:</strong>
                        <div class="social">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $share ?>" target="_blank" rel="noopener" aria-label="share on Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://twitter.com/intent/tweet?url=<?= $share ?>&text=<?= $stitle ?>" target="_blank" rel="noopener" aria-label="share on X"><i class="fa-brands fa-twitter"></i></a>
                            <a href="https://wa.me/?text=<?= $stitle ?>%20<?= $share ?>" target="_blank" rel="noopener" aria-label="share on WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $share ?>" target="_blank" rel="noopener" aria-label="share on LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </article>

                <?php if ($nb['prev'] || $nb['next']): ?>
                <div class="row gutter-30" style="margin-top:40px;">
                    <div class="col-12 col-md-6" style="margin-bottom:20px;">
                        <?php if ($nb['prev']): ?>
                        <a href="<?= e(url('news/' . $nb['prev']['slug'])) ?>" class="cf-pillar" style="display:block;">
                            <span style="font-size:13px;font-weight:700;color:var(--cf-green);text-transform:uppercase;letter-spacing:1px;"><i class="fa-solid fa-arrow-left"></i> Previous</span>
                            <h6 style="margin-top:10px;"><?= e(excerpt($nb['prev']['title'], 70)) ?></h6>
                        </a>
                        <?php endif; ?>
                    </div>
                    <div class="col-12 col-md-6" style="margin-bottom:20px;">
                        <?php if ($nb['next']): ?>
                        <a href="<?= e(url('news/' . $nb['next']['slug'])) ?>" class="cf-pillar cf-pillar--green" style="display:block;text-align:right;">
                            <span style="font-size:13px;font-weight:700;color:var(--cf-green);text-transform:uppercase;letter-spacing:1px;">Next <i class="fa-solid fa-arrow-right"></i></span>
                            <h6 style="margin-top:10px;"><?= e(excerpt($nb['next']['title'], 70)) ?></h6>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-12 col-xl-4"><?php partial('news-sidebar'); ?></div>
        </div>
    </div>
</section>
