<!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Setup required — Comfort Foundation</title>
<style>
body{margin:0;font-family:system-ui,-apple-system,"Segoe UI",sans-serif;background:#FBF7F9;color:#231F20;
     display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px}
.card{max-width:640px;background:#fff;border-radius:20px;padding:44px;box-shadow:0 20px 50px rgba(35,31,32,.08)}
h1{color:#9E1F63;font-size:26px;margin:0 0 14px}
code{background:#F6E9F0;color:#9E1F63;padding:2px 8px;border-radius:6px;font-size:14px}
ol{line-height:1.9;padding-left:20px}
p{line-height:1.7;color:#5A5254}
</style></head><body>
<div class="card">
<h1>Almost there — the database is not connected yet</h1>
<p>The website files are installed correctly. To finish setup:</p>
<ol>
  <li>Create a MySQL database and user in your hosting control panel.</li>
  <li>Import <code>database/schema.sql</code>, then <code>database/seed.sql</code>.</li>
  <li>Open <code>app/config.php</code> and enter your database name, user and password.</li>
  <li>Reload this page.</li>
</ol>
<p>Full instructions are in <code>README.md</code> in the site folder.</p>
</div></body></html>
