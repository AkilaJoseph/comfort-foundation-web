<?php $items = faqs(); ?>
<?php partial('page-banner', ['heading' => 'Frequently Asked Questions', 'eyebrow' => 'Good to know', 'crumbs' => ['FAQ' => null]]); ?>

<section class="faq" style="padding:100px 0;">
    <div class="container">
        <?= render_flash() ?>
        <div class="row justify-content-center">
            <div class="col-12 col-xl-9">
                <?php if (!$items): ?>
                    <div class="cf-empty"><i class="fa-regular fa-circle-question"></i><p>No questions have been published yet.</p></div>
                <?php else: ?>
                <div class="accordion" id="cfFaq" data-aos="fade-up" data-aos-duration="1000">
                    <?php foreach ($items as $i => $f): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqH<?= $i ?>">
                            <button class="accordion-button<?= $i ? ' collapsed' : '' ?>" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faqC<?= $i ?>"
                                    aria-expanded="<?= $i ? 'false' : 'true' ?>" aria-controls="faqC<?= $i ?>"
                                    style="font-weight:700;color:var(--cf-ink);">
                                <?= e($f['question']) ?>
                            </button>
                        </h2>
                        <div id="faqC<?= $i ?>" class="accordion-collapse collapse<?= $i ? '' : ' show' ?>" aria-labelledby="faqH<?= $i ?>" data-bs-parent="#cfFaq">
                            <div class="accordion-body" style="color:var(--cf-ink-soft);"><?= e($f['answer']) ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="text-center" style="margin-top:44px;">
                    <p style="margin-bottom:16px;">Still have a question?</p>
                    <a href="<?= e(url('contact')) ?>" class="btn--primary">Contact Us <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/ld+json"><?= json_encode([
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(static fn(array $f): array => [
        '@type'          => 'Question',
        'name'           => $f['question'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['answer']],
    ], $items),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
