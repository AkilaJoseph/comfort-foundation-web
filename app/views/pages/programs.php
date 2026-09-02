<?php $progs = programs(); ?>
<?php partial('page-banner', ['heading' => page_banner('programs', 'heading', 'Our Programmes'), 'eyebrow' => page_banner('programs', 'eyebrow', 'Core business areas'), 'crumbs' => ['Programmes' => null]]); ?>

<section style="padding:100px 0;">
    <div class="container">
        <?= render_flash() ?>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="section__header text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>What we do</span>
                    <h2 class="title-animation">Three interconnected <span>focus areas</span></h2>
                    <p>Comfort Foundation's work is structured around three interconnected focus areas, united by a shared commitment to women-led community transformation.</p>
                </div>
            </div>
        </div>

        <?php if (!$progs): ?>
            <div class="cf-empty"><i class="icon-donation"></i><p>Programme details are being prepared. Please check back shortly.</p></div>
        <?php else: ?>
        <?php foreach ($progs as $i => $p): ?>
        <div class="row gutter-40 align-items-center" style="margin-bottom:70px;">
            <div class="col-12 col-lg-6 <?= $i % 2 ? 'order-lg-2' : '' ?>">
                <div data-aos="<?= $i % 2 ? 'fade-left' : 'fade-right' ?>" data-aos-duration="1000">
                    <?= img($p['image'], ['alt' => $p['title'], 'class' => 'w-100', 'fallback' => 'assets/images/cause/one.webp']) ?>
                </div>
            </div>
            <div class="col-12 col-lg-6 <?= $i % 2 ? 'order-lg-1' : '' ?>">
                <div class="help__content" data-aos="fade-up" data-aos-duration="1000">
                    <span class="cf-pillar__num" style="margin-bottom:16px;"><?= e($p['number'] ?: str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                    <h3 style="margin-bottom:16px;"><?= e($p['title']) ?></h3>
                    <p><?= e($p['summary']) ?></p>
                    <a href="<?= e(url('programs/' . $p['slug'])) ?>" class="btn--primary" style="margin-top:22px;">Read More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<section class="cf-approach" style="padding:90px 0;">
    <div class="container">
        <div class="row justify-content-center"><div class="col-12 col-xl-8">
            <div class="section__header text-center"><h2>Support a programme</h2>
            <p style="color:rgba(255,255,255,.75)">Your contribution goes directly into training, savings capital, caregiver support and safe spaces for children.</p></div>
            <div class="text-center" style="margin-top:26px;"><a href="<?= e(url('donate')) ?>" class="btn--primary">Donate Now <i class="fa-solid fa-arrow-right"></i></a></div>
        </div></div>
    </div>
</section>
