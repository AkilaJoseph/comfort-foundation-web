<?php partial('page-banner', ['heading' => 'Partner With Us', 'eyebrow' => 'Partnership strategy', 'crumbs' => ['Partner' => null]]); ?>

<section style="padding:100px 0 60px;">
    <div class="container">
        <?= render_flash() ?>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="section__header text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>Working together</span>
                    <h2 class="title-animation">Sustainable transformation requires <span>coordinated effort</span></h2>
                    <p>Comfort Foundation believes no single organisation can deliver community transformation alone. We actively build partnerships across systems — and we are straightforward about what each side brings.</p>
                </div>
            </div>
        </div>

        <div class="row gutter-30">
            <?php foreach (partnership_types() as $i => $pt): ?>
            <div class="col-12 col-md-6 col-xl-4" style="margin-bottom:30px;">
                <div class="cf-pillar<?= $i % 2 ? ' cf-pillar--green' : '' ?>" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="<?= ($i % 3) * 150 ?>">
                    <span class="cf-pillar__num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <h5><?= e($pt['title']) ?></h5>
                    <p><?= e($pt['text']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="contact-main volunteer" style="padding:0 0 100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-9">
                <div class="contact__form volunteer__form checkout__form" data-aos="fade-up" data-aos-duration="1000">
                    <div class="volunteer__form-content">
                        <h4>Tell us about your organisation</h4>
                        <p>We will review your enquiry and respond with a clear next step — usually a short call to explore fit.</p>
                    </div>
                    <form action="<?= e(url('partner')) ?>" method="post" class="cta">
                        <?= csrf_field() ?>
                        <input type="hidden" name="form" value="partner">
                        <input type="text" name="website" tabindex="-1" autocomplete="off" style="display:none" aria-hidden="true">

                        <div class="row gutter-20">
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <input type="text" name="organisation" placeholder="Organisation name *" required value="<?= e(old('organisation')) ?>">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <select name="org_type" aria-label="Organisation type">
                                        <option value="">Type of organisation</option>
                                        <option value="Government agency">Government agency</option>
                                        <option value="School or health facility">School or health facility</option>
                                        <option value="NGO / civil society">NGO / civil society</option>
                                        <option value="International development partner">International development partner</option>
                                        <option value="Private sector">Private sector</option>
                                        <option value="Individual philanthropist">Individual philanthropist</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <input type="text" name="name" placeholder="Contact person *" required value="<?= e(old('name')) ?>">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <input type="email" name="email" placeholder="Email address" value="<?= e(old('email')) ?>">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <input type="tel" name="phone" placeholder="Phone number" value="<?= e(old('phone')) ?>">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <input type="url" name="org_website" placeholder="Website (optional)" value="<?= e(old('org_website')) ?>">
                                    <i class="fa-solid fa-globe"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-single">
                                    <select name="interest" aria-label="Area of interest">
                                        <option value="">Area of interest</option>
                                        <option value="Programme collaboration">Programme collaboration</option>
                                        <option value="Grant or co-funding">Grant or co-funding</option>
                                        <option value="Technical support">Technical support</option>
                                        <option value="Market linkages">Market linkages for women producers</option>
                                        <option value="Referral pathway">Referral pathway (health / social welfare)</option>
                                        <option value="Corporate social responsibility">Corporate social responsibility</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-single alter-input">
                                    <textarea name="message" placeholder="Tell us what you have in mind…"><?= e(old('message')) ?></textarea>
                                    <i class="fa-solid fa-comments"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-cta">
                            <button type="submit" class="btn--primary">Send Enquiry <i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php clear_old(); ?>
