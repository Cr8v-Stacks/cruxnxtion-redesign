# Events convergence plan: Crux Nxtion onto the shared Cr8v plugins

Written 8 Oct 2026 by Claude after the owner pointed out that Crux events use the standard WordPress editor while Red Cap Entertainment and Black and White Crafts use a custom "Studio" editor, and that the intent was always one integrated system.

**Decision: the Customizer work is paused until Crux runs on the shared plugin. Building page settings and repeating-content post types on a split base would deepen the split.**

## 1. What is true today (measured)

| | Shared plugin `cr8v-events-core` (Red Cap, BWC) | `crux-nxtion-core` (Crux) |
|---|---|---|
| Registers post types | `event`, `gallery_item` (plus the inquiries system in `cpt-inquiries.php`, 83 KB) | `event`, `gallery_item`, `inquiry` (47 KB) |
| Can both be active? | **No.** Same post type names, so they collide. This is the duplicate-plugin mistake the owner raised at the start. | |
| Event editor | Block editor switched off. One classic "Event Staging, Schedule & Technical Studio" box | Standard block editor plus the box I added (`Event Details`) |
| Gallery editor | "Gallery Print Studio & Visual Settings" box | none (items by title and image) |

## 2. Field comparison (event)

| Content | Shared plugin key | Crux today | Convergence |
|---|---|---|---|
| Name | post title | post title | same |
| Short summary | `_cr8v_event_excerpt` (meta) | WordPress Excerpt | use the shared field; migrate |
| Long description | `_cr8v_event_scope` (meta) | post content | use the shared field; migrate |
| Poster image | `_cr8v_event_image_id` and `_cr8v_event_image_url` | Featured Image | use the shared poster; migrate |
| Gallery | `_cr8v_event_gallery_ids` | same key, same format | **identical, no work** |
| Time | `_cr8v_event_time` | same key | **identical** |
| Venue | `_cr8v_event_venue` | same key | **identical** |
| Date | `_cr8v_event_date`, free text ("2026 or 2024-02-24") | strict `YYYY-MM-DD` | **must be reconciled** (see 4) |
| Small heading above the title | `_cr8v_event_kicker` | `category` | map category to kicker |
| Booking link and button label | `_cr8v_event_cta_url`, `_cr8v_event_cta_txt` | `eventbrite` | map to cta_url; ticket modal replaces the link when tiers exist |
| Short title for cards | none | `short_title` | add as optional field to the shared box |
| Country or region | none | `location` | add as optional field |
| Ticket card colour | none | `badge_style` | add as optional field |
| Capacity | `capacity` (free text like "1,200 Attendees") | tier capacity (numbers) | different things; ticket numbers stay in the Ticket Tiers box |
| Production specs, lead production, scope | present | not used by Crux | Crux theme ignores them |

## 3. What this means for the work already done

| Layer | Where | Impact of converging |
|---|---|---|
| Ticketing engine: tiers, stock reservation, orders, Stripe checkout and webhook, QR, emails, calendar files, staff role, check-in | `cr8v-event-ticketing` | **None.** It attaches to the post type `event` from whichever plugin owns it and never registers it. This is the part that Red Cap and BWC also get for free. About 70 percent of everything built. |
| Seeder (creates and completes the 8 events), event engine (reads fields for the pages) | `cruxnxtion-theme/inc` | **Adapt.** Same logic, different keys (table above). The editability test is reused unchanged against the new box. |
| `Event Details` box | `cr8v-event-ticketing/inc/event-fields.php` | **Retire.** It duplicates the shared Studio box (4 identical keys). Its three Crux-only fields move into the shared box as optional fields. |
| Crux templates for the events page, single event and gallery | `cruxnxtion-theme` | **Stay** (they are Crux's own design, like the Red Cap pages are theirs). They read the shared keys. |

It is not a thin layer pasted on top: most of it is independent of the editor. The part that needs rework is the content-editing glue (about a third of the event code and its tests).

## 4. Risks to settle before building

1. **Date format.** The shared box accepts loose text; Crux needs a real date for sorting, calendar files and refusing past bookings. Plan: make the shared field a real date picker, and keep a separate free-text label for Red Cap/BWC events whose existing value does not parse. Their pages must look identical before and after (snapshot comparison).
2. **Source of truth for the shared plugin.** Copies exist in the Red Cap theme folder, the Local plugins folder and a zip. One git repository must be named as the owner before anything changes it.
3. **Inquiries.** The Crux contact form depends on its own 47 KB inquiry system (`crux_submit_inquiry` AJAX action and the theme's JavaScript). The shared plugin has its own 83 KB version. Plan: map the two, keep the Crux action name working through an adapter, and prove the form with a real submission before and after.
4. **Gallery items.** Both register `gallery_item`. Existing Crux gallery posts are migrated to the shared fields.
5. **The block editor.** Crux events currently use it. The shared Studio box is classic. Moving Crux to the Studio box is a visible change for the client; it is the same editor his sister brands use.

## 5. Order of work (each step proven before the next)

1. **E1: Extend the shared plugin** with the optional fields (short title, country, ticket colour) and the date reconciliation. Add automated tests for the shared plugin (it has none). Red Cap and BWC pages compared before and after.
2. **E2: Migrate Crux events** to the shared keys with an idempotent, tested migration (never overwrites the client's edits), and point the theme engine at them. Re-run the "type a value into every field, see it on the page" test against the Studio box.
3. **E3: Inquiries and gallery**: adapter and migration; real form submission test.
4. **E4: Switch the site over**: deactivate `crux-nxtion-core`, retire the `Event Details` box, run the whole test battery and a real-browser check of the edit screens.
5. **Then the Customizer**, starting with extracting the shared header and footer (see `CUSTOMIZER_MAPPING.md`, section 0).

No step changes Red Cap or BWC behaviour unless a snapshot comparison shows their pages unchanged.
