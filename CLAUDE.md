# MarkU app: project notes (read first)

## Rules from the owner
- NEVER touch `android-new2.keystore` or any password. The owner builds the app.
- Back up a file before changing it. Build only with the owner's permission.
- Replies: short, clear Malayalam. UI text: simple English.

## App facts
- Play Store app `in.marku.app`, TWA by Bubblewrap. Host `marku.in`, start `/dashboard/`. Live on Play, 312 installs.
- assetlinks on marku.in is correct. Google verifies both SHA-256 keys:
  Play App Signing `9B:9D:74…DA:42` and `86:47:3A…8C:95`.
- Repo `main` still shows v1.0.0 / code 1 / notifications false. The real Play build is newer (code 4) and was built from a local folder, not this repo. Do not assume the repo matches Play.
- Do NOT use `.github/workflows/build.yml` (it regenerates the manifest and makes an unsigned APK).

## Verified on 2026-11-11 (owner's phone, Play app)
- No address bar. Notifications work in the app, shown as MarkU. Test push OK (`/wp-admin/?mkrs_diag=1` -> `ok`).
- So a new app build is NOT needed now. v2.0.1 files on branch `ccr-0824cfcb-r6t83v` are optional (icons, SDK bump).

## Website (marku.in, WordPress)
- Reminder system: Code Snippets #63, #64, #65 (Firebase push), #86 (sender, cron every 5 min), #88 (Dashboard soft-ask card).
- Settings page: `/reading-reminders/` (shortcode `[marku_push_settings]`, page id 10735).
- Reminder is skipped on a day the reader already opened the site/app. Default time 8:00 PM.
- Menu item "Reading Reminders" (id 20095) was added to MarkU Main Menu. Plan: remove it once the Account row works.
- Royal MCP cannot create snippets. The owner adds them in Snippets -> Add New.
- Pending: `wordpress/reading-reminders-account-row.php` (Account page row). Owner must add it as a PHP snippet.
- Assumption to verify: the ACCOUNT bottom tab opens `/my-account/`.

## Access limits
- No owner computer folder is attached in cloud sessions, so the owner's open Chrome cannot be controlled from here.
