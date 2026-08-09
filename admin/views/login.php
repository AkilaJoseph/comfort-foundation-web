<div class="login">
    <div class="login__box">
        <img src="<?= e(asset('assets/images/logo/logo.webp')) ?>" alt="<?= e(setting('site_name')) ?>">
        <h2>Sign in to manage the website</h2>
        <?php foreach (take_flash() as $f): ?>
        <div class="alert alert--<?= $f['type'] === 'error' ? 'err' : 'ok' ?>"><?= e($f['message']) ?></div>
        <?php endforeach; ?>
        <form method="post" action="<?= e(url('admin/login')) ?>">
            <?= csrf_field() ?>
            <div class="field">
                <label for="email">Email address</label>
                <input type="email" name="email" id="email" required autocomplete="username" autofocus>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required autocomplete="current-password">
            </div>
            <button class="btn" type="submit"><i class="fa-solid fa-right-to-bracket"></i> Sign in</button>
        </form>
        <p style="text-align:center;margin:22px 0 0;font-size:13px;color:var(--ink-soft)">
            <a href="<?= e(url()) ?>">&larr; Back to the website</a>
        </p>
    </div>
</div>
