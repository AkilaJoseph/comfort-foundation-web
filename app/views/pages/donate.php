<?php partial('page-banner', ['heading' => page_banner('donate', 'heading', 'Donate'), 'eyebrow' => page_banner('donate', 'eyebrow', 'Support the work'), 'crumbs' => ['Donate' => null]]); ?>

<section class="community" style="padding:100px 0 60px;">
    <div class="container">
        <?= render_flash() ?>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="section__header text-center" data-aos="fade-up" data-aos-duration="1000">
                    <span class="sub-title"><i class="icon-donation"></i>Give with confidence</span>
                    <h2 class="title-animation">Your gift becomes <span>capital, skills and safety</span></h2>
                    <p><?= e(setting('donate_intro', 'Give directly to our bank account or by mobile money — then let us know, so we can acknowledge your gift and keep you informed about what it made possible.')) ?></p>
                </div>
            </div>
        </div>

        <div class="row gutter-30" style="margin-top:20px;">
            <div class="col-12 col-lg-6" style="margin-bottom:30px;">
                <div class="cf-give-card" data-aos="fade-up" data-aos-duration="1000">
                    <h5><i class="fa-solid fa-building-columns"></i> Bank transfer</h5>
                    <div class="cf-give-row"><span>Bank</span><strong><?= e(setting('bank_name')) ?></strong></div>
                    <div class="cf-give-row"><span>Account name</span><strong><?= e(setting('bank_account_name')) ?></strong></div>
                    <div class="cf-give-row">
                        <span>Account number</span>
                        <strong><span id="cfBankAcc"><?= e(setting('bank_account_number')) ?></span>
                        <button type="button" class="cf-copy-btn" data-copy="#cfBankAcc">Copy</button></strong>
                    </div>
                    <div class="cf-give-row"><span>Branch</span><strong><?= e(setting('bank_branch')) ?></strong></div>
                    <p style="margin-top:20px;font-size:14px;color:var(--cf-ink-soft);">Please use your name as the payment reference so we can identify and acknowledge your gift.</p>
                </div>
            </div>

            <div class="col-12 col-lg-6" style="margin-bottom:30px;">
                <div class="cf-give-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <h5><i class="fa-solid fa-mobile-screen-button"></i> Mobile money</h5>
                    <div class="cf-give-row">
                        <span>Number</span>
                        <strong><span id="cfMomo"><?= e(setting('mobile_money_number')) ?></span>
                        <button type="button" class="cf-copy-btn" data-copy="#cfMomo">Copy</button></strong>
                    </div>
                    <div class="cf-give-row"><span>Registered name</span><strong><?= e(setting('mobile_money_name')) ?></strong></div>
                    <div class="cf-give-row"><span>Currency</span><strong>TZS (Tanzanian Shilling)</strong></div>
                    <p style="margin-top:20px;font-size:14px;color:var(--cf-ink-soft);">Keep your confirmation SMS. If you would like a formal receipt, send us the transaction reference using the form below.</p>
                </div>
            </div>
        </div>

        <div class="row gutter-30">
            <?php foreach (donate_uses() as $i => $u): ?>
            <div class="col-12 col-md-4" style="margin-bottom:30px;">
                <div class="cf-pillar<?= $i % 2 ? ' cf-pillar--green' : '' ?>" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="<?= $i * 150 ?>">
                    <span class="cf-pillar__num"><i class="<?= e($u['icon']) ?>"></i></span>
                    <h5><?= e($u['title']) ?></h5>
                    <p><?= e($u['text']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- pledge form -->
<section class="contact-main volunteer" style="padding:0 0 100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-9">
                <div class="contact__form volunteer__form checkout__form" data-aos="fade-up" data-aos-duration="1000">
                    <div class="volunteer__form-content">
                        <h4>Tell us about your gift</h4>
                        <p>This form does not process a payment — it lets our team confirm your transfer, thank you properly and issue an acknowledgement.</p>
                    </div>
                    <form action="<?= e(url('donate')) ?>" method="post" class="cta">
                        <?= csrf_field() ?>
                        <input type="hidden" name="form" value="pledge">
                        <input type="text" name="website" tabindex="-1" autocomplete="off" style="display:none" aria-hidden="true">

                        <div class="row gutter-20">
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <input type="text" name="name" id="pName" placeholder="Your full name *" required value="<?= e(old('name')) ?>">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <input type="email" name="email" id="pEmail" placeholder="Email address" value="<?= e(old('email')) ?>">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <input type="tel" name="phone" id="pPhone" placeholder="Phone number" value="<?= e(old('phone')) ?>">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-single">
                                    <input type="text" name="amount" id="pAmount" placeholder="Amount (numbers only)" value="<?= e(old('amount')) ?>">
                                    <i class="fa-solid fa-coins"></i>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-single">
                                    <select name="currency" aria-label="Currency">
                                        <option value="TZS">TZS</option>
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                        <option value="GBP">GBP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-single">
                                    <select name="method" aria-label="Payment method">
                                        <option value="Bank transfer">Bank transfer</option>
                                        <option value="Mobile money">Mobile money</option>
                                        <option value="Cash / in person">Cash / in person</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-single">
                                    <select name="frequency" aria-label="Frequency">
                                        <option value="One-off">One-off gift</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Quarterly">Quarterly</option>
                                        <option value="Annually">Annually</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-single">
                                    <select name="designation" aria-label="Designation">
                                        <option value="Where it is needed most">Where it is needed most</option>
                                        <?php foreach (programs() as $p): ?>
                                        <option value="<?= e($p['title']) ?>"><?= e($p['title']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-single alter-input">
                                    <textarea name="message" id="pMessage" placeholder="Transaction reference, or anything you would like us to know…"><?= e(old('message')) ?></textarea>
                                    <i class="fa-solid fa-comments"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="radio-single" style="margin-bottom:18px;">
                                    <input type="checkbox" name="anonymous" id="pAnon" value="1">
                                    <label for="pAnon">Please keep my gift anonymous in any public acknowledgement</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-cta">
                            <button type="submit" class="btn--primary">Send Pledge <i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php clear_old(); ?>
