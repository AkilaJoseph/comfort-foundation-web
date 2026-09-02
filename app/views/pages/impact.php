<?php $stats = impact_stats(); ?>
<?php partial('page-banner', ['heading' => page_banner('impact', 'heading', 'Our Impact'), 'eyebrow' => page_banner('impact', 'eyebrow', 'Where we are heading'), 'crumbs' => ['Impact' => null]]); ?>

<section style="padding:100px 0 60px;">
    <div class="container">
        <?= render_flash() ?>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="section__header text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>Expected long-term impact</span>
                    <h2 class="title-animation">Measurable, community-rooted <span>transformation</span></h2>
                    <p>Over the next five years, Comfort Foundation aims to contribute to change that communities can see and feel.</p>
                </div>
            </div>
        </div>

        <?php if ($stats): ?>
        <div class="row"><div class="col-12">
            <div class="cf-facts" data-aos="fade-up" data-aos-duration="1000" style="margin-bottom:60px;">
                <div class="row g-0">
                    <?php foreach ($stats as $s): ?>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="cf-facts__item">
                            <h3><span class="odometer" data-odometer-final="<?= (int) $s['value'] ?>">0</span><?= e($s['suffix']) ?></h3>
                            <p><?= e($s['label']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div></div>
        <?php endif; ?>

        <div class="row gutter-30">
            <?php foreach (long_term_impact() as $i => $item): ?>
            <div class="col-12 col-md-6" style="margin-bottom:30px;">
                <div class="cf-pillar<?= $i % 2 ? ' cf-pillar--green' : '' ?>" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="<?= ($i % 2) * 150 ?>">
                    <span class="cf-pillar__num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <p style="font-size:17px;color:var(--cf-ink);"><?= e($item) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cf-approach" style="padding:90px 0;">
    <div class="container">
        <div class="row justify-content-center"><div class="col-12 col-xl-9">
            <div class="section__header text-center">
                <span class="sub-title"><i class="icon-donation"></i><?= e(setting('impact_measures_eyebrow', 'How we measure')) ?></span>
                <h2><?= e(setting('impact_measures_heading', 'Accountability is part of the programme')) ?></h2>
            </div>
            <div class="row gutter-30" style="margin-top:34px;">
                <?php foreach (impact_measures() as $m): ?>
                <div class="col-12 col-md-4" style="margin-bottom:24px;">
                    <div class="cf-approach__step"><h4 style="font-size:18px;"><?= e($m['title']) ?></h4><p><?= e($m['text']) ?></p></div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center" style="margin-top:20px;"><a href="<?= e(url('contact')) ?>" class="btn--primary">Request Our Reports <i class="fa-solid fa-arrow-right"></i></a></div>
        </div></div>
    </div>
</section>
