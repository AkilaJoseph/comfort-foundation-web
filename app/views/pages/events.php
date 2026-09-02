<?php
$perPage  = 6;
$page     = max(1, (int) get('page', '1'));
$when     = in_array(get('when'), ['upcoming', 'past'], true) ? get('when') : 'upcoming';
$total    = events_count($when);
$pg       = paginate($total, $perPage, $page, 'events');
$items    = events($perPage, $pg['offset'], $when);
?>
<?php partial('page-banner', ['heading' => page_banner('events', 'heading', 'Events'), 'eyebrow' => page_banner('events', 'eyebrow', 'Trainings, sessions & gatherings'), 'crumbs' => ['Events' => null]]); ?>

<section class="event event-alt" style="padding:100px 0;">
    <div class="container">
        <?= render_flash() ?>
        <div class="row justify-content-center">
            <div class="col-12 col-xl-8">
                <div class="section__header text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>What's on</span>
                    <h2 class="title-animation"><?= $when === 'past' ? 'Past' : 'Upcoming' ?> <span>events</span></h2>
                </div>
                <div class="text-center" style="margin-bottom:44px;display:flex;gap:12px;justify-content:center;">
                    <a href="<?= e(url('events')) ?>?when=upcoming" class="<?= $when === 'upcoming' ? 'btn--primary' : 'btn--tertiary' ?>">Upcoming</a>
                    <a href="<?= e(url('events')) ?>?when=past" class="<?= $when === 'past' ? 'btn--primary' : 'btn--tertiary' ?>">Past Events</a>
                </div>
            </div>
        </div>

        <?php if (!$items): ?>
            <div class="cf-empty"><i class="fa-regular fa-calendar"></i>
                <p>No <?= e($when) ?> events are listed right now. Follow our news page for announcements.</p>
                <a href="<?= e(url('news')) ?>" class="btn--primary" style="margin-top:18px;">Read the News</a>
            </div>
        <?php else: ?>
        <div class="row gutter-30">
            <?php foreach ($items as $i => $ev): ?>
            <div class="col-12 col-lg-6" style="margin-bottom:20px;">
                <?php partial('event-card', ['event' => $ev, 'alt' => (bool) ($i % 2), 'delay' => ($i % 2) * 150]); ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php partial('pagination', ['pg' => $pg, 'query' => 'when=' . rawurlencode($when) . '&']); ?>
        <?php endif; ?>
    </div>
</section>
