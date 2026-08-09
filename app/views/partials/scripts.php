<?php
$useBundle = !empty($GLOBALS['cf_config']['use_bundle'])
          && is_file(CF_ROOT . '/assets/dist/site.min.js');
if ($useBundle): ?>
<script src="<?= e(asset('assets/dist/site.min.js')) ?>" defer></script>
<?php else: ?>
<script src="<?= e(asset('assets/js/jquery-3.7.1.min.js')) ?>"></script>
<script src="<?= e(asset('assets/js/bootstrap.bundle.min.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/jquery.nice-select.min.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/jquery.magnific-popup.min.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/swiper-bundle.min.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/viewport.jquery.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/odometer.min.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/vanilla-tilt.min.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/aos.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/gsap.min.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/ScrollTrigger.min.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/ScrollToPlugin.min.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/SplitText.min.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/custom.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/comfort.js')) ?>" defer></script>
<?php endif; ?>
