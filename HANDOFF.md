# Crux Nxtion — handoff brief for the build-out agent

Read this whole file before writing code. It is the single source of truth for what was decided, what is confirmed, and what is still open. Where this file and the design pages disagree, the pages win for visuals and this file wins for intent.

## 1. What this is

Redesign of **cruxnxtion.co.uk** (Sheffield, UK). The business now has **two services**:

1. **Crux Nxtion Events** — plans, books and runs events (weddings, parties, cultural nights, festivals, corporate).
2. **Crux Nxtion Consultancy** (new) — "Turning business ideas into businesses that work." Five services: Business Setup & Strategy, Branding & Marketing, Business Growth, Activation Growth, Business Audit & Advisory.

The design is finished as **visual prototypes** (46 pages: desktop + mobile). Your job is to build it as a real website. The prototypes are HTML files in a proprietary "design canvas" format (`*.dc.html`); they are a specification, not production code.

Live site today: WordPress (Elementor, Evenex demo assets). Pages there: Home, Events, Services (5 sub-pages), Sponsor, Gallery, Career (empty), About Us, Contact Us, Blog.

## 2. Repo map

```
HANDOFF.md                     this file
README.md                      how to preview the design
design/pages/*.dc.html         every page. M_* = mobile (390px). *_2 = continuation of a long mobile page. canvas.json = board layout/titles
design/images/by-blob-id/       every image the pages use, named <id>.jpg (pages reference /_blob/<id>)
design/images/{crux-photos,live-site,stock,reference}/   the same and more, readable names
design/content/site.json        confirmed content: contact, services, events, sponsors, FAQ
design/runtime/support.js       the canvas runtime the .dc.html pages load (preview only, NOT for production)
design/preview.js               builds a local preview: node design/preview.js && npx serve design/preview
design/generators/              scripts that produced the pages. Reference only, will not run as-is
```

Page naming: `A` suffix = Events (dark). `A2a` = Consultancy (light). `S` suffix = shared (light). Example: `HomeA` = Events home, `HomeA2a` = Consultancy home, `AboutS` = shared About.

## 3. Sitemap and page inventory

| Page | File | Notes |
|---|---|---|
| Home — Events | HomeA | dark. hero, marquee, 5 services rows, events ticket wall, consultancy upsell band, gallery ticket wall, why-us, process, mini about, founder band, FAQ grid |
| Home — Consultancy | HomeA2a | light. hero with animated chat card, "sound familiar" carousel, 3 entry tickets, 5-panel accordion, 5 steps, bento "what you walk away with", why us, founder teaser, FAQ |
| Services — Events | ServicesA | 5 story blocks |
| Services — Consultancy | ServicesA2a | 5 story blocks + more SEO copy |
| About | AboutS | light page, dark founder band, Events/Consultancy tabs in "what we do" |
| Founder | FounderS | new page; full story |
| Contact | ContactS | ONE form (see 7.3) |
| FAQ | FAQS | one long page, two sections (Events 14, Consultancy 12) |
| Events | EventsA | ticket wall of 8 real events |
| Single event | SingleEventA | only Dance OUT 2023 designed; reuse as the template |
| Past events | EventsArchiveA | year-by-year list |
| Gallery | GalleryA | ticket-photo grid |
| Blog / single post | BlogA / SingleBlogA | **sample copy only** |
| Sponsors & partners | SponsorsA | content from the live /sponsor page |
| 404 | Error404A | |
| Privacy / Cookies / Terms | PrivacyS / CookiesS / TermsS | drafts, need solicitor review |
| Cookie banner | CookieBanner (+M_) | small card, no scrim, dismissible, re-open chip |
| Mega menu | Megamenuevents / Megamenulight | header Services menu shown open |
| Design system | DesignSystem | tokens + rules |

Global shell on every page: call-out bar → header (logo, nav, Services mega menu, Events|Consultancy switcher, CTA) → content → **cinematic pre-footer** (film-strip band, two CTAs) → footer (big CRUX over NXTION wordmark, links, legal links, socials).

## 4. Design system (authoritative values)

**Brand colours (from the logo):** blue `#002671`, red `#BA0000`. **Do not invent colours.**

**Events pages (dark, "A1"):** ink `#0A0F26`, surface `#111838`, line `#1E2B5E`, text `#F4F5FA`, muted `#A3A9C8`, accent tint `#5B8DEF`, red text `#E5383B`, hover blue `#1E48B0`.
**Consultancy + shared pages (light, "A2a"):** white, tint `#F3F1FC` (max 2 bands per page), line `#E1DEF3`, ink `#10142E`, muted `#5A5F86`, purple `#8C7AE6` (fills) / `#6C58DB` (text), red spark `#D9182A`.
**Rule 60·30·10:** 60% neutral, 30% blue (Events) or purple (Consultancy), 10% red for action. Colour = meaning: blue Events, purple Consultancy, red act. Ticket stubs cycle blue / red / purple (purple text `#10142E`, others white). Pre-footer and footer are always dark.

**Type:** Bebas Neue (headlines, uppercase) + Space Grotesk (body). Eyebrows: 11px, 3px tracking, uppercase.

**Buttons — ONE shape everywhere (user requirement):** slanted parallelogram. Primary = filled (red on Events, purple on Consultancy). Secondary = same shape as an outline. Tabs, chips, tags, icon buttons all use it. Active = filled, inactive = outline. Slant: 10px large, 8px medium, 6px small. Only text links are unshaped. Reference CSS is the `.bx` block in any page's `<style>` (clip-path polygon + an evenodd `::before` ring for outlines). Form inputs stay rectangular.

**Motifs:** ticket stubs with punched notches (`.ticket-stub`, `.strip-stub`), tilted cards, torn/film edges, marquee. Keep them. Cards tilt on hover.

**Motion (user wants "high-end" feel):** scroll reveals (CSS `animation-timeline: view()`, static fallback), slow hero photo drift, looping chat card (8s: messages appear, typing dots), bento illustrations that animate (action-plan ticks + bar fill, one-pager underline sweep, brand swatches pulse, roadmap bars grow, audit rings fill and count via `@property --p`), marquee, hover lifts. Respect `prefers-reduced-motion` when you build (not yet in the prototypes).

## 5. Behaviours to implement

1. **Header / mega menu:** hover (desktop) opens a panel with Events services, Consultancy services and a "Not sure which?" photo card. Header has an **Events | Consultancy switcher**; call-out bar above header on all pages.
2. **Mobile (390px):** the mobile pages are the desktop pages re-oriented, not redesigned. Hamburger opens a full drawer (switcher, Home, Services accordion with both lists, links, Book button). A **sticky Events|Consultancy pill fixed at the bottom of the viewport** (in the prototype it is drawn at the bottom of the first screen). Grids become 1 column (2 for small photo tiles and gallery), section-heading rows stack, tickets keep normal height with the photo on top, consultancy hero drops the photo and keeps the badge + chat card, "what we do" panels become a vertical accordion, carousel becomes native swipe.
3. **Consultancy home:** 5-panel accordion (hover/tap opens), carousel, FAQ accordion.
4. **About:** Events | Consultancy tabs switch the 5 services shown.
5. **FAQ:** native accordion; two sections; jump buttons.
6. **Cookie banner:** small card bottom-left (bottom on mobile), Accept all / Essential only / Preferences (toggle analytics, marketing), close ×, then a "Cookie settings" chip to reopen. Non-intrusive, no dimming layer.

### 7.3 Contact form (important, user was emphatic)
**One form only.** No Events/Consultancy switch or separate forms. A single list of ten service chips (5 event, 5 consultancy; multi-select). The form reveals fields from what is ticked: any event service → "About your event" (type, date, guests, venue); any consultancy service → "About your business" (name, stage); both → both; none → a hint. A line under the form says where it goes ("straight to our events crew / consultancy team / both crews"). Implementation guidance: one endpoint, tag the submission with the selected services, route by tag on the server. Do not build two forms.

## 6. Content: confirmed vs not

**Confirmed (taken from the live site, see `design/content/site.json`):** address, both phone numbers, email, social links, the five event services and their live URLs, the eight events (dates, times, Eventbrite links, flyers), the partner/vendor list and images, the events services copy themes.

**NOT confirmed — needs the owner before launch:**
- Founder claims: "Oba of Events", 76+ events sold out, Naija Food Carnival 400+ guests, founder of Nxtion Food Market (Abbeydale Road). Came from a web search, not from the client.
- All FAQ answers (written from live-site copy but not approved); consultancy client claim "retail, food, hospitality and services"; "now booking 2026/2027".
- Legal pages (Privacy, Cookies, Terms) are draft UK-GDPR-style text: **solicitor review required.**
- Blog posts are samples. Sponsor packages were removed (invented); the sponsor page now only shows real partners.
- Location/time for two events (LASGIDI, Becoming Mr & Mrs Crux Pt.3) are not on the live site; cards say "Tickets on Eventbrite". The Becoming Pt.3 Eventbrite URL was not captured.
- Career page: live page is empty, so none was designed.
- Website copy is functional but generic in places (much is the live site's own wording). It needs proof: real client quotes, real numbers, specifics.

## 7. Assets

- Logo: only a ~182×47 PNG exists (`design/images/by-blob-id/e4d72651b77d4c3cc1c086d9f6031149.jpg` is the PNG, misnamed). Headers show it on a white chip. **Ask for a vector/large logo.**
- Crux event photos: ~35 originals (1800px) pulled from `cruxnxtion.co.uk/wp-content/uploads`. They are heavy: resize/convert to WebP/AVIF, responsive `srcset`, lazy-load.
- Stock (Unsplash) photos of Black professionals/business owners are used on Consultancy pages. Keep licence attributions in the build.
- Event flyers: Eventbrite cover images (`ev_*.jpg`); treat as the client's own material.
- **Image rule (user requirement):** do not reuse one photo across many pages/sections; choose the right photo for each section. Consultancy pages still repeat a few stock photos because the set is small; source more.

## 8. Standing preferences of the client (follow these)

- Stick to the approved design. Do **not** redesign unilaterally; ask only when a real decision is needed, and never ask trivial questions.
- No invented colours; accent colours come from the logo. No internal notes ("[verify]") on pages.
- Sections should fill roughly a viewport (~600–820px). Hero/featured images follow the page alignment and are never narrower than the text column on mobile.
- Consistency comes from the design system: same button shape, same card designs across pages (e.g. home gallery cards = gallery page cards), same pre-footer/footer everywhere.
- Full founder bio lives on the Founder and About pages only; elsewhere use teasers (duplicate-content/SEO). (Events home currently uses a shortened band by client request.)
- Real content from the live site wherever it exists.

## 9. Known gaps and QA notes

- Screenshots in the design process were unreliable; the mobile Contact/FAQ pages, the animations and the About tabs were verified by code/DOM checks, not by eye. Do a visual QA pass against these prototypes.
- Prototype pages have no `<title>`/meta descriptions, structured data or alt text beyond basics. Add SEO: titles, descriptions, Open Graph, schema (Organization, Event, FAQPage, LocalBusiness), sitemap.
- Accessibility: contrast, focus states, keyboard navigation for menus/accordions/tabs, `prefers-reduced-motion`, form labels (the prototype uses placeholders only).
- Performance: fonts (self-host), image optimisation, avoid layout shift on scroll reveals.
- Cookie banner needs real consent logic (block analytics/marketing until accepted) and a footer "Cookie settings" link.
- Forms need spam protection, validation, GDPR consent line, and email delivery.

## 10. Suggested build plan

1. **Decide the stack with the owner** (the design files do not decide it). Options: keep WordPress with a custom theme (the owner also has a local WP dev site with a `cr8v-stacks-events` theme, and the live site is WordPress), or a static/Next build. Confirm before starting.
2. Set up tokens (CSS variables from section 4), fonts, the button component, ticket/tilt card components, header/mega menu/switcher, pre-footer/footer.
3. Build Events pages (Home, Services, Events, Single event, Gallery, Past events), then Consultancy pages, then shared pages (About, Founder, Contact, FAQ), then utility/legal pages.
4. Wire content: events from the live site (or a CPT with Eventbrite links), FAQs (FAQPage schema), sponsors, gallery.
5. Mobile: implement responsively from the same components (no separate mobile templates).
6. Forms, cookie banner, analytics, SEO, accessibility, performance, QA against the prototypes.

## 11. Questions to put to the owner before you start

1. Stack: WordPress theme vs another framework?
2. Vector logo and any brand guidelines?
3. Confirm the founder facts, FAQ answers and the "booking 2026/2027" line.
4. Real blog posts, testimonials/client logos and numbers for proof points.
5. Consultancy: real case studies or client types you may name?
6. Legal: who reviews Privacy/Cookies/Terms; is there a ICO registration number/company number for the footer?
7. Where should form submissions go (email, CRM), and who handles Events vs Consultancy enquiries?
8. More Consultancy stock or real photography of Bambad at work?

## 12. Working notes on the prototypes

- Pages are single self-contained HTML with inline styles; treat values as the spec. Some layout comes from JS-driven styles in the page's `<script type="text/x-dc">` (panels, carousel, tabs, contact chips); read that script for state logic.
- Image references use `/_blob/<32-hex-id>`; map to `design/images/by-blob-id/<id>.jpg` (the preview script does this).
- `data-m="…"` attributes on `M_*` pages record the mobile layout decisions per element (`g1`/`g2` grids, `stack`, `svcrow`, `herovis`, `collage`, `imgtop`, `scroller`/`track`, `hide`). They are a useful checklist of what changes at 390px.
- Canvas board heights are capped at 8000px, so the longest pages exist in mobile as two boards (`*_2` continues the first).
