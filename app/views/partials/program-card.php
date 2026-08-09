<?php /** @var array $program */ $delay = $delay ?? 0; $i = $i ?? 0; ?>
<div class="cf-pillar<?= $i % 2 ? ' cf-pillar--green' : '' ?>" data-aos="fade-up" data-aos-duration="1000"<?= $delay ? ' data-aos-delay="' . (int) $delay . '"' : '' ?>>
    <span class="cf-pillar__num"><?= e($program['number'] ?: str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
    <h4><a href="<?= e(url('programs/' . $program['slug'])) ?>"><?= e($program['title']) ?></a></h4>
    <p><?= e(excerpt($program['summary'], 175)) ?></p>
    <a href="<?= e(url('programs/' . $program['slug'])) ?>" class="cf-pillar__link">
        Explore this programme <i class="fa-solid fa-arrow-right"></i>
    </a>
</div>
