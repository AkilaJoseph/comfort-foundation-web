<?php
$counts = [
    ['Programmes',  (int) scalar('SELECT COUNT(*) FROM programs', [], 0),      'fa-diagram-project', 'programs'],
    ['Articles',    (int) scalar('SELECT COUNT(*) FROM posts', [], 0),         'fa-newspaper',       'posts'],
    ['Events',      (int) scalar('SELECT COUNT(*) FROM events', [], 0),        'fa-calendar-days',   'events'],
    ['Team members',(int) scalar('SELECT COUNT(*) FROM team_members', [], 0),  'fa-users',           'team'],
    ['Gallery photos',(int) scalar('SELECT COUNT(*) FROM gallery', [], 0),     'fa-images',          'gallery'],
    ['Unread messages', admin_unread_count(),                                  'fa-inbox',           'inbox'],
];
$recent  = all('SELECT * FROM submissions ORDER BY created_at DESC LIMIT 6');
$drafts  = all('SELECT id, title FROM posts WHERE is_published = 0 ORDER BY id DESC LIMIT 5');
?>

<div class="grid grid--4" style="margin-bottom:26px;">
    <?php foreach ($counts as [$label, $n, $icon, $link]): ?>
    <a class="stat" href="<?= e(url('admin/' . $link)) ?>" style="text-decoration:none">
        <i class="fa-solid <?= e($icon) ?>"></i>
        <b><?= $n ?></b>
        <span><?= e($label) ?></span>
    </a>
    <?php endforeach; ?>
</div>

<div class="grid grid--2">
    <div class="card card--pad0">
        <div style="padding:20px 24px;border-bottom:1px solid var(--line);display:flex;justify-content:space-between;align-items:center">
            <h3 style="margin:0">Recent submissions</h3>
            <a href="<?= e(url('admin/inbox')) ?>" class="btn btn--ghost btn--sm">View all</a>
        </div>
        <?php if (!$recent): ?>
            <div class="empty"><i class="fa-solid fa-inbox"></i><p>No submissions yet.</p></div>
        <?php else: ?>
        <table>
            <tbody>
            <?php foreach ($recent as $r): ?>
            <tr>
                <td style="width:110px"><span class="pill <?= $r['is_read'] ? 'pill--off' : 'pill--new' ?>"><?= e(ucfirst($r['kind'])) ?></span></td>
                <td>
                    <a href="<?= e(url('admin/inbox/view')) ?>?id=<?= (int) $r['id'] ?>"><strong><?= e($r['name'] ?: $r['email']) ?></strong></a>
                    <div style="color:var(--ink-soft);font-size:13px"><?= e(excerpt($r['subject'] ?: $r['message'], 54)) ?></div>
                </td>
                <td style="width:130px;color:var(--ink-soft);font-size:13px"><?= e(fmt_date($r['created_at'], 'j M, H:i')) ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <div>
        <div class="card">
            <h3>Quick actions</h3>
            <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:14px">
                <a class="btn" href="<?= e(url('admin/posts/create')) ?>"><i class="fa-solid fa-plus"></i> New article</a>
                <a class="btn btn--green" href="<?= e(url('admin/events/create')) ?>"><i class="fa-solid fa-plus"></i> New event</a>
                <a class="btn btn--ghost" href="<?= e(url('admin/team/create')) ?>"><i class="fa-solid fa-plus"></i> Team member</a>
                <a class="btn btn--ghost" href="<?= e(url('admin/gallery/create')) ?>"><i class="fa-solid fa-plus"></i> Gallery photo</a>
                <a class="btn btn--ghost" href="<?= e(url('admin/settings')) ?>"><i class="fa-solid fa-sliders"></i> Settings</a>
            </div>
        </div>

        <?php if ($drafts): ?>
        <div class="card">
            <h3>Unpublished drafts</h3>
            <ul style="margin:10px 0 0;padding-left:18px">
                <?php foreach ($drafts as $d): ?>
                <li style="margin-bottom:6px"><a href="<?= e(url('admin/posts/edit')) ?>?id=<?= (int) $d['id'] ?>"><?= e($d['title']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="card">
            <h3>Housekeeping</h3>
            <p style="color:var(--ink-soft);font-size:14px;margin-bottom:0">
                Pages are cached for speed. Saving content clears the cache automatically — use
                <strong>Clear cache</strong> at the top right if a change is not showing.
            </p>
        </div>
    </div>
</div>
