<?php $me = auth_user(); ?>
<form method="post" action="<?= e(url('admin/account')) ?>">
    <?= csrf_field() ?>
    <div class="card">
        <h3>Your details</h3>
        <div class="field">
            <label for="a_name">Name</label>
            <input type="text" name="name" id="a_name" value="<?= e($me['name']) ?>" required>
        </div>
        <div class="field">
            <label for="a_email">Email address</label>
            <input type="email" name="email" id="a_email" value="<?= e($me['email']) ?>" required>
            <div class="hint">This is the address you sign in with.</div>
        </div>
    </div>

    <div class="card">
        <h3>Change password</h3>
        <p style="color:var(--ink-soft);font-size:14px">Leave these blank to keep your current password.</p>
        <div class="field">
            <label for="a_cur">Current password</label>
            <input type="password" name="current_password" id="a_cur" autocomplete="current-password">
        </div>
        <div class="field">
            <label for="a_new">New password</label>
            <input type="password" name="new_password" id="a_new" autocomplete="new-password">
            <div class="hint">At least 10 characters. A short phrase you can remember works well.</div>
        </div>
        <div class="field">
            <label for="a_conf">Confirm new password</label>
            <input type="password" name="confirm_password" id="a_conf" autocomplete="new-password">
        </div>
    </div>

    <button class="btn" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
</form>
