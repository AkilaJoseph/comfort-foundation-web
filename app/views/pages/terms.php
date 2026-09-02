<?php partial('page-banner', ['heading' => page_banner('terms', 'heading', 'Terms & Conditions'), 'eyebrow' => page_banner('terms', 'eyebrow', 'Using this website'), 'crumbs' => ['Terms' => null]]); ?>
<section style="padding:100px 0;">
    <div class="container">
        <div class="row justify-content-center"><div class="col-12 col-xl-9">
            <div class="cf-prose" data-aos="fade-up" data-aos-duration="1000">
                <p><em>Last updated <?= e(date('F Y')) ?>.</em></p>
                <?= setting('terms_body') ?>
            </div>
        </div></div>
    </div>
</section>
