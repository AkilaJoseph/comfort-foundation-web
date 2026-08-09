<section class="error" style="padding:120px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 text-center">
                <img src="<?= e(asset('assets/images/error.webp')) ?>" alt="" style="max-width:420px;margin-bottom:34px;" loading="lazy">
                <h2 style="margin-bottom:16px;">We couldn't find that page</h2>
                <p style="margin-bottom:30px;">The page you are looking for may have moved, or the link may be out of date.</p>
                <div class="cta" style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
                    <a href="<?= e(url()) ?>" class="btn--primary">Back to Home <i class="fa-solid fa-arrow-right"></i></a>
                    <a href="<?= e(url('contact')) ?>" class="btn--tertiary">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</section>
