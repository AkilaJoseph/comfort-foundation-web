<?php partial('page-banner', ['heading' => 'Terms & Conditions', 'eyebrow' => 'Using this website', 'crumbs' => ['Terms' => null]]); ?>
<section style="padding:100px 0;">
    <div class="container">
        <div class="row justify-content-center"><div class="col-12 col-xl-9">
            <div class="cf-prose" data-aos="fade-up" data-aos-duration="1000">
                <p><em>Last updated <?= e(date('F Y')) ?>.</em></p>

                <h2>Agreement</h2>
                <p>By using this website you agree to these terms. If you do not agree with them, please do not use the site.</p>

                <h2>About the organisation</h2>
                <p><?= e(setting('site_name')) ?> is a Non-Governmental Organisation registered in Tanzania under Reg. No. <?= e(setting('reg_number')) ?>, established in <?= e(setting('established_year')) ?>, with its head office at <?= e(setting('contact_address')) ?>.</p>

                <h2>Accuracy of information</h2>
                <p>We take care to keep the information on this site accurate and current. Programme details, event dates and figures may change. Nothing on this site is a guarantee of a particular service, outcome or eligibility.</p>

                <h2>Donations</h2>
                <ul>
                    <li>Donations are made directly to the bank or mobile money account published on our Donate page. This website does not process payments and does not collect card details.</li>
                    <li>A pledge submitted through the website is a notification of intent, not a payment. Our team will follow up to confirm.</li>
                    <li>Unless you designate a specific programme, donations are applied where the need is greatest.</li>
                    <li>If you believe a donation was made in error, contact us as soon as possible and we will work with you in good faith.</li>
                    <li>Always verify our bank and mobile money details on this website or by calling our office before transferring funds. We will never ask you to send money to a personal account.</li>
                </ul>

                <h2>Volunteering and partnership</h2>
                <p>Submitting an application or enquiry does not create an obligation on either side. Volunteer placements are subject to our selection process, available intakes, and any safeguarding checks required for work involving children.</p>

                <h2>Acceptable use</h2>
                <p>You agree not to use this site to submit unlawful, abusive or misleading content, to attempt to gain unauthorised access to any part of it, or to interfere with its operation.</p>

                <h2>Intellectual property</h2>
                <p>The Comfort Foundation name, logo, text and photographs on this site belong to the Foundation or are used with permission. You may quote or link to our content with attribution. Please contact us before reproducing photographs, particularly any showing programme participants.</p>

                <h2>Links to other sites</h2>
                <p>Where we link to another organisation's website, we do so for convenience. We are not responsible for their content or their privacy practices.</p>

                <h2>Liability</h2>
                <p>This site is provided as it is. To the extent permitted by Tanzanian law, we are not liable for loss arising from your use of, or reliance on, this website.</p>

                <h2>Governing law</h2>
                <p>These terms are governed by the laws of the United Republic of Tanzania.</p>

                <h2>Contact</h2>
                <p>Questions about these terms: <a href="mailto:<?= e(setting('contact_email')) ?>"><?= e(setting('contact_email')) ?></a> &middot; <a href="<?= e(fmt_phone_link(setting('contact_phone_raw', setting('contact_phone')))) ?>"><?= e(setting('contact_phone')) ?></a>.</p>
            </div>
        </div></div>
    </div>
</section>
