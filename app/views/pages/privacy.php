<?php partial('page-banner', ['heading' => 'Privacy Policy', 'eyebrow' => 'How we handle your information', 'crumbs' => ['Privacy' => null]]); ?>
<section style="padding:100px 0;">
    <div class="container">
        <div class="row justify-content-center"><div class="col-12 col-xl-9">
            <div class="cf-prose" data-aos="fade-up" data-aos-duration="1000">
                <p><em>Last updated <?= e(date('F Y')) ?>.</em></p>

                <h2>Who we are</h2>
                <p><?= e(setting('site_name')) ?> is a registered Tanzanian Non-Governmental Organisation (Reg. No. <?= e(setting('reg_number')) ?>) with its head office at <?= e(setting('contact_address')) ?>. This policy explains what personal information we collect through this website, why we collect it, and what we do with it.</p>

                <h2>Information we collect</h2>
                <ul>
                    <li><strong>Information you give us.</strong> When you use our contact, volunteer, partnership, donation-pledge or newsletter forms, we collect the details you enter — typically your name, email address, phone number and message.</li>
                    <li><strong>Technical information.</strong> Our server records the IP address a submission came from, together with the date and time. This is used to prevent abuse of our forms.</li>
                </ul>

                <h2>Why we use it</h2>
                <ul>
                    <li>To respond to your enquiry, application or pledge.</li>
                    <li>To acknowledge donations and, where you have asked for one, issue a receipt.</li>
                    <li>To send occasional updates about our work, if you subscribed to them.</li>
                    <li>To protect the website against spam and misuse.</li>
                </ul>

                <h2>What we do not do</h2>
                <p>We do not sell your personal information. We do not share it with third parties for their own marketing. We do not collect payment card details on this website — donations are made directly to our bank or mobile money account.</p>

                <h2>How long we keep it</h2>
                <p>Submissions are retained for as long as they are needed for the purpose above, and for our own record-keeping and accountability obligations. You may ask us to delete your details at any time.</p>

                <h2>Security</h2>
                <p>Submissions are stored on our web host in a database that is not publicly accessible. Access is restricted to authorised Comfort Foundation staff. No system is perfectly secure, so please do not send sensitive personal information — particularly about children — through the website forms. Contact us by phone instead.</p>

                <h2>Children's information</h2>
                <p>We work with children as programme participants, and we treat information about them with particular care. We do not knowingly collect personal information from children through this website. Enquiries about a child should be made by a parent, caregiver or referring professional.</p>

                <h2>Cookies</h2>
                <p>This website sets a single session cookie, which is required for our forms to work securely. It contains no personal information and expires when you close your browser. We do not use advertising or third-party tracking cookies. Where a page embeds a map, that service may set its own cookies.</p>

                <h2>Your rights</h2>
                <p>You may ask us what information we hold about you, ask us to correct it, or ask us to delete it. Write to <a href="mailto:<?= e(setting('contact_email')) ?>"><?= e(setting('contact_email')) ?></a> or call <a href="<?= e(fmt_phone_link(setting('contact_phone_raw', setting('contact_phone')))) ?>"><?= e(setting('contact_phone')) ?></a>.</p>

                <h2>Changes to this policy</h2>
                <p>If we change how we handle personal information, we will update this page and change the date at the top.</p>
            </div>
        </div></div>
    </div>
</section>
