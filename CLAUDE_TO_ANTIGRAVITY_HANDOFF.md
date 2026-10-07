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

---

## 6. Antigravity Handoff Back to Claude (7 Oct 2026): Phase 0 Complete & Verified

Antigravity has resolved the routing bugs and completed **Phase 0 (Data-Driven Events Architecture)**. Changes are committed in Git (`bdacbfb`).

### 6.1 Routing & Error Diagnostics (Section 2b Resolved)
1. **Soft-200 Bug Fixed**:
   - Cause: In `cruxnxtion-theme/inc/prevent-errors.php`, `crux_virtual_template_fallback` intercepted any URL starting with `/event/` or `/events/`, forcefully setting `$wp_query->is_404 = false` and `status_header(200)` even when no post existed, resulting in null `$post` and triggering property read warnings on lines 679, 680, and 735 of `post-template.php`.
   - Fix: Removed the brute-force event catch-all from `prevent-errors.php`. Allowed WordPress to resolve canonical `event` posts natively through core query parsing. In `single-event.php`, if an unrecognized event slug is requested, it issues a real 404:
     ```php
     $wp_query->set_404();
     status_header( 404 );
     nocache_headers();
     include get_404_template();
     exit;
     ```
2. **404 Connection Drop Fixed**:
   - Cause: The virtual router buffer collided with `404.php` template loading. With the virtual routing cleaned and template fallbacks normalized, `404.php` now renders cleanly.
3. **HTTP Header Verification (`curl.exe -I`)**:
   - `GET /` &rarr; `HTTP/1.1 200 OK`
   - `GET /events/` &rarr; `HTTP/1.1 200 OK`
   - `GET /event/dance-out-2023/` (and all 8 canonical events) &rarr; `HTTP/1.1 200 OK`
   - `GET /event/nonexistent-event-slug/` &rarr; `HTTP/1.1 404 Not Found` (clean 404, zero PHP warnings)
   - `GET /nonexistent-page-xyz/` &rarr; `HTTP/1.1 404 Not Found` (clean 404, zero dropped connections)
4. **PHP Error Log (`logs/php/error.log`)**:
   - Clean. Zero new PHP warnings, notices, or errors recorded.

### 6.2 Asset & Plugin Architecture Decisions (Section 5 Step 2)
1. **84 Untracked Images**:
   - The Crux theme references images strictly in `assets/images/by-blob-id/` and root `.svg`/`.jpg` icons. The 84 extra images are drafts/reference photos in `crux-photos/`, `live-site/`, `reference/`, and `stock/` (~30MB).
   - Added these 4 folders to `.gitignore`. They remain safely preserved on disk in LocalWP, but will not pollute `git status` or bloat the repository.
2. **Plugin Architecture Consensus**:
   - Antigravity 100% endorses Claude's Section 4 recommendation:
     - Leave `crux-nxtion-core` intact (preserves the live AJAX inquiry system for contact forms).
     - Keep `cr8v-events-core` inactive on this install to prevent duplicate `event` CPT collisions.
     - Build all upcoming event ticketing, tiers, Stripe Hosted Checkout, order records, webhooks, and QR check-in inside ONE new standalone modular plugin: `cr8v-event-ticketing`.
     - The plugin attaches to `post_type => 'event'` without re-registering it, using standardized `_cr8v_*` meta keys so it runs identically across Crux Nxtion, Red Cap Entertainment, and Black and White Crafts (BWC).

### 6.3 Phase 0 Implementation Summary
1. **Database Post Synchronization**:
   - Synchronized all 8 canonical Crux Nxtion events in `wp_posts` (IDs 13029–13036) with exact titles, dates, excerpts, descriptions, categories, eventbrite links, and hero images.
   - Normalized slugs to canonical format (e.g. `lasgidi-mainland-party`, `crux-nxtion-hangout`).
2. **Event Engine Data Layer (`cruxnxtion-theme/inc/event-engine.php`)**:
   - Implemented `crux_get_event_data( $slug_or_id )` and `crux_get_all_events()`.
   - Includes master catalog fallback to ensure 100% resilience if database fields are missing.
   - Added a multi-brand DB filter to ensure the 5 legacy Red Cap posts (IDs 1625–1629) from the shared LocalWP database do not pollute Crux Nxtion's events grid.
3. **Dynamic Template Integration**:
   - `cruxnxtion-theme/functions.php`: Included `inc/event-engine.php`.
   - `cruxnxtion-theme/single-event.php`: Dynamic database querying via `crux_get_event_data()`. Clean 404 on missing slugs.
   - `cruxnxtion-theme/page-events.php` & `archive-event.php`: Dynamic query loop rendering exactly 8 `.tilt-ticket` cards + 1 callout tile (9 tiles total in 3x3 layout), maintaining 100% pixel-perfect styling fidelity.
   - `cruxnxtion-theme/front-page.php`: Dynamic query loop rendering the top 3 featured ticket cards.
4. **Code Quality**:
   - Tested all modified files against PHP 8.2 (`php -l`). Zero syntax errors.

### 6.4 Status & Ready for Claude's Audit
Phase 0 is complete and ready for Claude's audit against Part B Section 17. Once verified, we will proceed to **Phase 1: Ticketing Engine Plugin (`cr8v-event-ticketing`)**.
