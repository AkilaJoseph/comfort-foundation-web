<?php $crew = team_members(); ?>
<?php partial('page-banner', ['heading' => page_banner('team', 'heading', 'Our Team'), 'eyebrow' => page_banner('team', 'eyebrow', 'The people behind the work'), 'crumbs' => ['Team' => null]]); ?>

<section class="team" style="padding:100px 0;">
    <div class="container">
        <?= render_flash() ?>
        <?php if (!$crew): ?>
            <div class="cf-empty">
                <i class="icon-support-heart"></i>
                <p>Team profiles are being prepared. In the meantime, you can reach the office directly.</p>
                <a href="<?= e(url('contact')) ?>" class="btn--primary" style="margin-top:18px;">Contact Us</a>
            </div>
        <?php else: ?>
        <div class="row gutter-40">
            <?php foreach ($crew as $i => $m): ?>
            <div class="col-12 col-sm-6 col-xl-3" style="margin-bottom:30px;">
                <?php partial('team-card', ['member' => $m, 'delay' => ($i % 4) * 150]); ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="row" style="margin-top:40px;"><div class="col-12">
            <div class="section__cta cta text-center">
                <p style="margin-bottom:18px;">Interested in joining the team as a volunteer?</p>
                <a href="<?= e(url('volunteer')) ?>" class="btn--primary">Become a Volunteer <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div></div>
    </div>
</section>
