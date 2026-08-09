<?php /** @var array $event */ $more = array_filter(events(4, 0, 'upcoming'), static fn($x) => $x['id'] !== $event['id']); ?>
<?php partial('page-banner', ['heading' => $event['title'], 'eyebrow' => 'Event', 'crumbs' => ['Events' => 'events', excerpt($event['title'], 40) => null]]); ?>

<section style="padding:100px 0;">
    <div class="container">
        <div class="row gutter-40">
            <div class="col-12 col-xl-8">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <?= img($event['image'], ['alt' => $event['title'], 'class' => 'w-100', 'fallback' => 'assets/images/event/one.webp']) ?>
                </div>
                <div class="cf-prose" style="margin-top:34px;">
                    <?php if (!empty($event['excerpt'])): ?>
                    <p style="font-size:20px;font-weight:600;color:var(--cf-ink);"><?= e($event['excerpt']) ?></p>
                    <?php endif; ?>
                    <?= safe_html($event['body']) ?>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="cm-sidebar-widget" data-aos="fade-up" data-aos-duration="1000">
                    <div class="intro"><h5>Event Details</h5></div>
                    <div class="cf-give-row"><span>Starts</span><strong><?= e($event['starts_at'] ? fmt_date($event['starts_at'], 'j M Y, H:i') : 'To be announced') ?></strong></div>
                    <?php if (!empty($event['ends_at'])): ?>
                    <div class="cf-give-row"><span>Ends</span><strong><?= e(fmt_date($event['ends_at'], 'j M Y, H:i')) ?></strong></div>
                    <?php endif; ?>
                    <?php if (!empty($event['location'])): ?>
                    <div class="cf-give-row"><span>Location</span><strong><?= e($event['location']) ?></strong></div>
                    <?php endif; ?>
                    <a href="<?= e(url('contact')) ?>" class="btn--primary" style="margin-top:22px;">Ask About This Event</a>
                </div>

                <?php if ($more): ?>
                <div class="cm-sidebar-widget" data-aos="fade-up" data-aos-duration="1000">
                    <div class="intro"><h5>More Events</h5></div>
                    <div class="cm-sidebar-post">
                        <?php foreach (array_slice($more, 0, 3) as $m): ?>
                        <div class="single-item">
                            <div class="thumb"><a href="<?= e(url('events/' . $m['slug'])) ?>"><?= img($m['image'], ['alt' => $m['title'], 'fallback' => 'assets/images/event/one.webp', 'width' => 90, 'height' => 90]) ?></a></div>
                            <div class="content">
                                <p><i class="fa-solid fa-calendar-days"></i> <span><?= e(fmt_date($m['starts_at'], 'j M Y')) ?></span></p>
                                <p><a href="<?= e(url('events/' . $m['slug'])) ?>"><?= e(excerpt($m['title'], 52)) ?></a></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
