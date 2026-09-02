<?php partial('page-banner', ['heading' => page_banner('privacy', 'heading', 'Privacy Policy'), 'eyebrow' => page_banner('privacy', 'eyebrow', 'How we handle your information'), 'crumbs' => ['Privacy' => null]]); ?>
<section style="padding:100px 0;">
    <div class="container">
        <div class="row justify-content-center"><div class="col-12 col-xl-9">
            <div class="cf-prose" data-aos="fade-up" data-aos-duration="1000">
                <p><em>Last updated <?= e(date('F Y')) ?>.</em></p>
                <?= setting('privacy_body') ?>
            </div>
        </div></div>
    </div>
</section>
