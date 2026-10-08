# Ticketing tests

Command-line tests that load WordPress, so they run against the real LocalWP database. They create their
own throw-away events and orders and delete them afterwards. Run them after ANY change to
`inc/ticket-tiers.php`, `inc/stripe-checkout.php`, `inc/stripe-webhook.php`, `inc/tickets.php` or `inc/qr-*.php`.

LocalWP must be running. Use LocalWP's PHP (not another PHP) with these flags
(adjust the PHP path if the version changes):

```powershell
$php = (Get-ChildItem "$env:APPDATA\Local\lightning-services\php-8.2.29+0" -Recurse -Filter php.exe | Select -First 1).FullName
$ext = (Get-ChildItem (Split-Path $php) -Recurse -Directory -Filter ext | Select -First 1).FullName
$f = @('-d',"extension_dir=$ext",'-d','extension=mysqli','-d','extension=mbstring','-d','extension=openssl','-d','extension=curl','-d','mysqli.default_port=10006','-d','SMTP=127.0.0.1','-d','smtp_port=10001')
& $php @f cr8v-event-ticketing\tests\test_phase1_checkout_webhook.php   # expect: RESULT: 40 passed, 0 failed
& $php @f cr8v-event-ticketing\tests\test_phase23_audit.php             # expect: RESULT: 55 passed, 0 failed
& $php @f cr8v-event-ticketing\tests\test_phase2_phase3.php             # expect: SUMMARY: 30 PASSED, 0 FAILED
& $php @f cr8v-event-ticketing\tests\test_staff_and_csv.php              # expect: RESULT: 62 passed, 0 failed
& $php @f cr8v-event-ticketing\tests\test_mobile_staff_checkin.php           # expect: RESULT: 61 passed, 0 failed
& $php cr8v-event-ticketing\tests\test_repo_hygiene.php                  # expect: RESULT: scanned N files, 0 problem(s)   (no WordPress needed)
```

Concurrency (overselling) test: starts many PHP processes at the same instant, all trying to reserve the
last tickets. The number reserved must equal the capacity exactly.

```powershell
.\cr8v-event-ticketing\tests\race\run-race.ps1 -Workers 12 -Capacity 1   # expect: RESERVED x1, REJECTED x11
.\cr8v-event-ticketing\tests\race\run-race.ps1 -Workers 20 -Capacity 5   # expect: RESERVED x5, REJECTED x15
```

The SMTP flags send test emails to LocalWP's Mailpit (http://127.0.0.1:10000). Without them the email check in
`test_phase2_phase3.php` fails with "wp_mail failed", which is the environment, not the plugin.

The QR encoder was verified against an independent reader (jsQR) in a browser: 15 of 15 payloads decoded,
including real 122-byte ticket links. Re-verify after any change to `inc/qr-encoder.php`.