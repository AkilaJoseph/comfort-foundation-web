<?php
$areas = [
    'Training & facilitation',
    'Financial literacy & savings groups',
    'Psychosocial support / counselling',
    'Community mobilisation',
    'Communications & media',
    'Monitoring & evaluation',
    'Administration & finance',
    'Fundraising & grants',
];
?>
<?php partial('page-banner', ['heading' => 'Become a Volunteer', 'eyebrow' => 'Give your skills and time', 'crumbs' => ['Volunteer' => null]]); ?>

<section class="contact-main volunteer" style="padding:100px 0;">
    <div class="container">
        <?= render_flash() ?>
        <div class="row gutter-40">
            <div class="col-12 col-xl-5">
                <div class="contact__content">
                    <div class="section__content" data-aos="fade-up" data-aos-duration="1000">
                        <span class="sub-title"><i class="icon-donation"></i>Volunteer with us</span>
                        <h2 class="title-animation">Work alongside <span>women, families and children</span></h2>
                        <p>Volunteering with Comfort Foundation means real responsibility in real communities. You will work with our programme teams in Nyamagana District and surrounding areas — and you will learn as much as you give.</p>
                    </div>

                    <div class="help__content-list" style="margin-top:26px;">
                        <ul>
                            <li><i class="fa-solid fa-circle-check"></i> Facilitate training sessions and savings-group meetings</li>
                            <li><i class="fa-solid fa-circle-check"></i> Support parenting education and caregiver groups</li>
                            <li><i class="fa-solid fa-circle-check"></i> Help run safe spaces and child wellbeing activities</li>
                            <li><i class="fa-solid fa-circle-check"></i> Contribute professional skills — finance, media, M&amp;E, admin</li>
                        </ul>
                    </div>

                    <div class="contact-main__inner cta" style="margin-top:30px;">
                        <div class="contact-main__single">
                            <div class="thumb"><i class="fa-solid fa-location-dot"></i></div>
                            <div class="content"><h6>Where</h6><p><?= e(setting('contact_address')) ?></p></div>
                        </div>
                        <div class="contact-main__single">
                            <div class="thumb"><i class="fa-solid fa-clock"></i></div>
                            <div class="content"><h6>Office hours</h6><p><?= e(setting('office_hours')) ?></p></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-7">
                <div class="contact__form volunteer__form checkout__form" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="volunteer__form-content">
                        <h4>Volunteer application</h4>
                        <p>Fields marked * are required. We review applications ahead of each intake and will contact you either way.</p>
                    </div>
                    <form action="<?= e(url('volunteer')) ?>" method="post" class="cta">
                        <?= csrf_field() ?>
                        <input type="hidden" name="form" value="volunteer">
                        <input type="text" name="website" tabindex="-1" autocomplete="off" style="display:none" aria-hidden="true">

                        <div class="row gutter-20">
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <input type="text" name="name" placeholder="Full name *" required value="<?= e(old('name')) ?>">
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
                                    <input type="text" name="location" placeholder="Where you live (district / region)" value="<?= e(old('location')) ?>">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <select name="age_group" aria-label="Age group">
                                        <option value="">Age group</option>
                                        <option value="14-17">14 – 17</option>
                                        <option value="18-24">18 – 24</option>
                                        <option value="25-35">25 – 35</option>
                                        <option value="36-50">36 – 50</option>
                                        <option value="50+">Over 50</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <select name="availability" aria-label="Availability">
                                        <option value="">Availability</option>
                                        <option value="Weekdays">Weekdays</option>
                                        <option value="Weekends">Weekends</option>
                                        <option value="Evenings">Evenings</option>
                                        <option value="Flexible">Flexible</option>
                                        <option value="Remote only">Remote only</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-single">
                                    <input type="text" name="occupation" placeholder="Occupation or field of study" value="<?= e(old('occupation')) ?>">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>
                            </div>

                            <div class="col-12">
                                <p style="font-weight:700;margin:10px 0 14px;">Which areas would you like to support? *</p>
                                <div class="row">
                                    <?php foreach ($areas as $i => $a): ?>
                                    <div class="col-12 col-md-6">
                                        <div class="radio-single" style="margin-bottom:12px;">
                                            <input type="checkbox" name="areas[]" id="area<?= $i ?>" value="<?= e($a) ?>" <?= old_has('areas', $a) ? 'checked' : '' ?>>
                                            <label for="area<?= $i ?>"><?= e($a) ?></label>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="input-single alter-input">
                                    <textarea name="experience" placeholder="Relevant experience or qualifications"><?= e(old('experience')) ?></textarea>
                                    <i class="fa-solid fa-award"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-single alter-input">
                                    <textarea name="message" placeholder="Why would you like to volunteer with Comfort Foundation?"><?= e(old('message')) ?></textarea>
                                    <i class="fa-solid fa-comments"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-cta">
                            <button type="submit" class="btn--primary">Submit Application <i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php clear_old(); ?>
