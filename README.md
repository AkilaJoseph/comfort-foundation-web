# Comfort Foundation — website

A PHP + MySQL website for **Comfort Foundation**, a registered Tanzanian NGO in
Nyamagana District, Mwanza (Reg. No. 00NGO/R/6025).

Built on the Charifund HTML template, re-skinned to the Foundation's identity,
converted to PHP with a small admin panel, and optimised for speed — **every
image on the site is WebP**.

---

## 1. What you need

* PHP **8.1 or newer** (8.2 / 8.3 recommended)
* MySQL 5.7+ or MariaDB 10.3+
* Apache or LiteSpeed with `mod_rewrite` (standard on cPanel hosting)
* PHP extensions: `pdo_mysql`, `mbstring`, `gd` **with WebP support** (or Imagick)

> The `gd` WebP support is what converts images you upload in the admin.
> If it is missing, uploads still work — they are simply stored in their
> original format.

---

## 2. Install

### Step 1 — Upload the files

Upload everything in this folder into your web root (`public_html` on cPanel).

### Step 2 — Create the database

In cPanel → *MySQL Databases*, create a database and a user, and give that user
**all privileges** on the database. Note down the three values.

### Step 3 — Import the tables

In cPanel → *phpMyAdmin*, select your new database, open the **Import** tab and
import these two files **in this order**:

1. `database/schema.sql` — creates the tables
2. `database/seed.sql` — fills in the Foundation's content and the admin login

### Step 4 — Enter your database details

Open `app/config.php` and fill in:

```php
'db' => [
    'host' => 'localhost',
    'name' => 'yourcpanel_comfort',
    'user' => 'yourcpanel_comfortuser',
    'pass' => 'your-password',
],

'site_url' => 'https://yourdomain.or.tz',
```

`app/config.php` is the **only** file you need to edit.

### Step 5 — Check folder permissions

These two folders must be writable by PHP (permissions `755`, or `775` if your
host needs it):

```
uploads/
storage/cache/
```

### Step 6 — Open the site

Visit your domain. If you see a "Setup required" page, the database details in
`app/config.php` are not yet correct.

---

## 3. Signing in to the admin

Go to **`/admin`**.

```
Email:     infocomfort2024@gmail.com
Password:  ComfortAdmin2024!
```

> **Change this password immediately.** Sign in, open **My Account**, and set a
> new password of at least 10 characters.

### What you can manage

| Section | What it controls |
|---|---|
| **Programmes** | The three core business areas and their detail pages |
| **News & Stories** | Articles, with categories, images and publish dates |
| **Events** | Upcoming and past events |
| **Team** | Staff and volunteer profiles |
| **Gallery** | Photographs, grouped by category |
| **Categories** | Categories used by news articles |
| **Impact Numbers** | The animated counters on the home and impact pages |
| **Partners** | Partner logos shown on the home page |
| **Testimonials** | Community quotes on the home page |
| **FAQ** | Questions and answers |
| **Inbox** | Every contact, volunteer, partnership, pledge and newsletter submission |
| **Site Settings** | Contact details, bank and mobile money numbers, social links, vision, mission |

Anything left empty is simply hidden from the site — for example, a social
media link with no URL shows no icon.

---

## 4. Speed

The site is built to load quickly on a Tanzanian mobile connection.

| Technique | Where |
|---|---|
| **WebP for every image** | All 322 bundled images were converted; uploads are re-encoded to WebP automatically |
| Uploaded images resized | Anything wider than 1800px is scaled down on upload |
| Bundled CSS/JS | One `.css` and one `.js` file instead of ~27 requests |
| Full-page HTML cache | Anonymous visitors are served a cached page (15 minutes) |
| Lazy loading | Below-the-fold images load only when scrolled to |
| Long cache headers | Assets cached for a year, with automatic cache-busting on change |
| Gzip / Brotli | Enabled in `.htaccess` |
| Deferred JavaScript | Scripts never block the first paint |

### Re-building the bundles

`app/config.php` ships with `'use_bundle' => true`, which serves
`assets/dist/site.min.css` and `assets/dist/site.min.js`.

**If you edit any CSS or JS file, rebuild the bundles**, otherwise your change
will not appear:

```bash
php tools/build-assets.php
```

No shell access? Set `'use_bundle' => false` in `app/config.php`. The site then
loads the individual files — slightly slower, but always current.

### Converting older uploads

If images were uploaded while WebP support was unavailable:

```bash
php tools/convert-uploads-to-webp.php
```

### Clearing the cache

Saving anything in the admin clears the page cache automatically. There is also
a **Clear cache** button at the top right of every admin screen.

---

## 5. Going live — checklist

- [ ] Change the admin password
- [ ] Set `'site_url'` in `app/config.php` to your real domain
- [ ] Set `'debug' => false` in `app/config.php`
- [ ] Install an SSL certificate, then uncomment the **Force HTTPS** block in `.htaccess`
- [ ] Set `'mail_from'` to an address on your own domain (e.g. `website@yourdomain.or.tz`) so form notifications are not rejected as spam
- [ ] Check the bank and mobile money details on the Donate page in **Site Settings**
- [ ] Add your social media links in **Site Settings** (blank ones stay hidden)
- [ ] Add real team photos, gallery images and impact numbers
- [ ] Submit `https://yourdomain.or.tz/sitemap.xml` to Google Search Console

---

## 6. How it is organised

```
.htaccess                 Rewrites, compression, caching, security headers
index.php                 Public front controller — all pages route through here
robots.txt

app/
  config.php              >>> the only file you edit <<<
  config.example.php      A clean copy, in case you need to start over
  bootstrap.php           Loads config, sessions, error handling
  database.php            PDO connection and query helpers
  repository.php          Every database read the public site performs
  helpers.php             Escaping, URLs, dates, CSRF, view rendering
  forms.php               Contact / volunteer / partner / pledge handling
  uploads.php             Image upload and WebP conversion
  auth.php                Admin login
  cache.php               Full-page cache
  mailer.php              Notification emails
  sitemap.php             XML sitemap
  views/
    layouts/base.php      The page shell — <head>, header, footer
    partials/             Header, footer, nav, cards, pagination
    pages/                One file per page

admin/
  index.php               Admin front controller
  crud.php                Content-type definitions and generic CRUD
  views/                  Admin screens
  assets/admin.css

assets/
  css/  js/  fonts/       Template libraries + comfort-brand.css
  images/                 All WebP
  images/logo/            Logo, light logo, favicons
  dist/                   Built bundles

database/
  schema.sql              Tables
  seed.sql                Foundation content + admin login

tools/
  build-assets.php        Rebuild the CSS/JS bundles
  convert-uploads-to-webp.php

uploads/media/            Images uploaded through the admin
storage/cache/            Cached HTML
```

---

## 7. Brand

| | |
|---|---|
| Magenta | `#9E1F63` |
| Green | `#21B24B` |
| Ink | `#231F20` |

All brand colours live in one place: `assets/css/comfort-brand.css`. Change the
values under `:root` there and the whole site follows. (Then re-run
`php tools/build-assets.php`.)

---

## 8. Security notes

* Form submissions are protected by CSRF tokens, a honeypot field and rate limiting.
* Admin passwords are stored as bcrypt hashes; five failed logins lock the form for five minutes.
* HTML entered in the admin is filtered — `<script>`, `onclick=` and `javascript:` links are stripped.
* PHP execution is disabled inside `uploads/`.
* `app/`, `database/`, `storage/` and `tools/` are blocked from the web.

If you ever need to reset the admin password directly in the database, generate a
hash with `php -r "echo password_hash('your-new-password', PASSWORD_DEFAULT);"`
and update the `password_hash` column in the `users` table.

---

## 9. Troubleshooting

**"Setup required" page** — the database details in `app/config.php` are wrong,
or `schema.sql` has not been imported.

**Pages show 404 except the home page** — `mod_rewrite` is off, or `.htaccess`
was not uploaded (it is a hidden file; enable "show hidden files" in your file
manager).

**Site is in a subfolder** — set `'base_path' => '/foldername'` in
`app/config.php` and uncomment `RewriteBase` in `.htaccess`.

**A change is not showing** — click **Clear cache** in the admin. If it was a CSS
or JS edit, re-run `php tools/build-assets.php`.

**Uploaded image will not save** — check that `uploads/media/` is writable (755),
and that the file is under 8 MB.

**No notification emails** — many hosts block `mail()` from addresses outside
your domain. Set `'mail_from'` to an address on your own domain. Submissions are
always saved to the admin Inbox regardless, so nothing is lost.
