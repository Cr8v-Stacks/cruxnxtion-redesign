# Handoff: Claude to Antigravity (6 Oct 2026)

Read this first, then `STRIPE_EVENT_TICKETING_ARCHITECTURE.md` (Part A is yours, Part B is the Claude audit; Part B wins where they conflict) and `HANDOFF.md`.

Roles: **Antigravity writes the code. Claude plans and audits** (bugs, security, edge cases) before anything is merged. Show Claude each phase for review.

## 1. Environment changes already made (do not undo)

| What | State now |
|---|---|
| Git repo | `C:\Users\user\Dev\cruxnxtion-redesign` (outside OneDrive). Remote: `https://github.com/Cr8v-Stacks/cruxnxtion-redesign.git`. Cloned from the OneDrive repo, so it contains the Claude audit commit `c3e8f25`. **Not pushed yet.** |
| Local theme | `Local Sites\dev-playground\app\public\wp-content\themes\cruxnxtion-theme` is an NTFS **junction** to `Dev\cruxnxtion-redesign\cruxnxtion-theme` |
| Local plugin | `...\wp-content\plugins\crux-nxtion-core` is a **junction** to `Dev\cruxnxtion-redesign\crux-nxtion-core` |
| Where to edit | Edit **either** path: they are the same files. Commit from `C:\Users\user\Dev\cruxnxtion-redesign`. Local has no git of its own. |
| OneDrive copy | `C:\Users\user\OneDrive\Documents\Dev-Playground\cruxnxtion-redesign` is **retired**. Do not edit it. Not deleted yet. |
| Backups | `C:\Users\user\Dev\backups\`: theme zip, plugin zip, the two original folders (`*.pre-junction-bak`), and a full DB dump `dev-playground-db-20261006.sql` |
| Extra images | 84 images only the Local site had (`assets/images/crux-photos`, `live-site`, `reference`, `stock`) were copied into the clone. They are **untracked** in git. No PHP file references them. Undecided: commit or delete. |

Rules: never recreate the folders as real directories in `wp-content`; never run git inside the Local `wp-content` folders; never put the repo back in OneDrive.

## 2. Site state

- Site: `http://dev-playground.local` (LocalWP, PHP 8.2, MySQL on port 10006, DB `local`).
- Before the owner's changes the active theme was `cr8v-stacks-events` (Red Cap/BWC). The owner then activated the `crux-nxtion-core` plugin. `cr8v-events-core` was never active.
- At last check (after that activation) the front end still rendered with `cr8v-stacks-events`, so **`cruxnxtion-theme` is not confirmed active and has not been render-tested**. Files are served correctly through both junctions (HTTP 200).
- If the Red Cap/BWC setup must be restored: import the DB dump above.

## 2b. Render test after theme activation (6 Oct 2026, ~20:10 UTC)

`cruxnxtion-theme` and `crux-nxtion-core` are active. Junctions work.

| URL | Result |
|---|---|
| `/`, `/events/`, `/event/`, `/contact/`, `/about-us/`, `/gallery/`, `/faq/`, `/blog/` | HTTP 200, Crux titles/markup. First request after start was slow (cold start), then about 1s. |
| `/events/fake-event-slug/` | **HTTP 200 for an event that does not exist**, plus PHP warnings "Attempt to read property ID/post_type/post_parent on null" (`post-template.php` lines 679, 680, 735). |
| `/nonexistent-page-xyz/` (real 404) | **Connection dropped, no HTTP response, nothing in the PHP or nginx logs.** Reproduced twice. Cause not found. Unresolved. |

Cause of the soft-200: `inc/prevent-errors.php` (`crux_virtual_template_fallback`, `template_include` filter, priority 99) forces `single-event.php` for any `/event/*` or `/events/*` URL, sets `is_404=false` and returns 200 even when no post exists, so `$post` is null. It also maps ~25 page slugs to templates regardless of whether a WordPress page exists. This is the "Zero 404s guarantee" hack. **It must be reworked in Phase 0**: real event URLs must resolve through the `event` post type, unknown slugs must return a real 404. The 404 connection drop must be diagnosed (try `php -l`/error log with `WP_DEBUG` on, check `404.php`, `wp_body_open`, and the filters above).

## 3. Findings from the audit (details in Part B)

- `cruxnxtion-theme` is a static export: `archive-event.php`, `page-events.php`, `front-page.php` hold events in hardcoded markup. Per your own review, `single-event.php` and `archive-event.php` use a hardcoded `$all_events` array with Eventbrite links.
- `crux-nxtion-core` registers `inquiry`, `event`, `gallery_item`. The `event` type has only title, editor, thumbnail, excerpt. No fields.
- `cr8v-events-core` registers the same three kinds of content (events, gallery, inquiries) plus meta boxes with nonce/capability checks, `.ics` generation and a media cleaner. **Both register the post type `event`: never activate both.**
- No Customizer exists in `cruxnxtion-theme`. `cr8v-stacks-events/inc/customizer.php` is the in-house pattern.

## 4. Open architecture question: duplicate plugins (owner raised it)

The owner's view: Crux should have been part of the shared events/gallery plugin, not a separate core plugin. Claude's recommendation (awaiting owner decision):

- **Do not merge or rewrite the two core plugins now.** `crux-nxtion-core` carries a working inquiry system (AJAX `crux_submit_inquiry`, 47 KB) that the Crux theme depends on. A merge risks the live contact flow.
- **Put all new work (event fields, tiers, orders, Stripe, tickets) in ONE new shared plugin** (working name `cr8v-event-ticketing`) that attaches to the post type `event` and does not register the type itself. It works with whichever core plugin owns `event`, so it ports to Red Cap and BWC unchanged.
- Use one meta prefix, `_cr8v_*`, not the dual `_crux_*` / `_cr8v_*` bridge.
- Later, as a separate task, converge Crux onto `cr8v-events-core` (migrate inquiries and gallery) and retire `crux-nxtion-core`.
- Not verified: whether `cr8v-events-core` works with the Crux theme, and why `crux-nxtion-core` was created separately.

## 5. Next steps (in order)

1. Owner/Claude confirm the theme and plugin activation order and render-test the Crux pages (home, events, single event, contact). Check `logs\php\error.log`.
2. Decide the plugin architecture (section 4) and the 84 untracked images.
3. Phase 0: event fields + data-driven `archive-event.php`, `page-events.php`, `single-event.php`, homepage events block. Pixel-identical output.
4. Then Part A phases 1 to 4 with the Part B fixes: stock reservation with expiry, atomic counts (not JSON), integer pence, webhook with raw-body signature and idempotency, keys in `wp-config.php`, POST-only staff check-in, random tokens.
5. Customizer phase after events (see Part B section 16).

Each phase goes to Claude for audit against the checklist in Part B section 17 before merge. Test-mode Stripe only. Never enter or request live keys.
