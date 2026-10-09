# CRUX NXTION — CUSTOMIZER MAPPING & ARCHITECTURE SPECIFICATION

**Document Version:** 1.0.0  
**Target Repository:** `C:\Users\user\Dev\cruxnxtion-redesign`  
**Reference Pattern:** `cr8v-stacks-events/inc/customizer.php`  
**Scope:** Read-only architectural mapping for `cruxnxtion-theme`. **NO CODE CHANGES MADE.**  
**Security Notice:** No Stripe keys, SMTP credentials, or runtime constants are touched by this document.

---

## 0. PREREQUISITE (ADDED BY CLAUDE REVIEW): THE THEME HAS NO SHARED HEADER, FOOTER OR PRE-FOOTER

This document assumes "global" settings (Section 3) that change the header, footer, contact details and pre-footer on every page. **The theme cannot do that today.** Measured in `cruxnxtion-theme`:

| Fact | Measured value |
|---|---|
| `header.php`, `footer.php` or any template part | none exist |
| Templates that are a complete standalone HTML document (own `<!DOCTYPE html>`, `wp_head()` and `wp_footer()`) | 24 of 24 |
| Header markup inside each template | about 13 KB (logo, mega menu, mobile drawer, switcher) |
| Footer markup inside each template | about 4 KB, plus the pre-footer band |
| Inline `<style>` block inside each template | about 26 KB, in 9 slightly different variants |
| Main phone number hardcoded | `+44 7448 614051` in 23 files; two more numbers elsewhere (see 6.3, confirmed) |

Consequence: a Customizer setting such as `crux_company_phone_primary` or the pre-footer headline would have to be edited in **24 copies**, and any edit would risk making pages drift apart. Building the Customizer on top of this first would multiply the work and the bugs.

**Phase C0 (must come first, no new features):** extract the shared pieces into theme parts and include them from every template, with the pages looking pixel-identical before and after:
1. `header.php` (document head, `wp_head()`, call-out bar, header, mega menu, mobile drawer, sticky switcher) and `footer.php` (pre-footer band, footer, `wp_footer()`); the 24 templates then start with `get_header()` and end with `get_footer()`.
2. Move the shared CSS to one enqueued stylesheet; keep only genuinely page-specific CSS in the page.
3. Verify with a before/after screenshot comparison at 1280px and 375px for every template, the hygiene test (no BOM or double-encoded text), and `scrollWidth` against `innerWidth` on each page.
4. Only then add the Customizer settings in Section 3, reading their values inside the new parts.

Risk: the 9 variants of the inline stylesheet differ for a reason (light pages versus dark pages, legal pages, the 404). They must be diffed and merged deliberately, not assumed identical.

---

## 1. ARCHITECTURAL OVERVIEW & TAXONOMY

The Crux Nxtion web platform operates on a **dual-wing design system**:
1. **The Events Wing (Dark Canvas):** Primary background `#0A0F26`, brand navy `#002671`, accent blue `#5B8DEF`, danger/action red `#BA0000` / `#E5383B`, and light typography `#F4F5FA`.
2. **The Consultancy Wing (Light Canvas):** Primary background `#FFFFFF`, lavender tone `#F3F1FC`, royal purple `#8C7AE6`, deep violet `#6C58DB`, charcoal typography `#10142E`, and crimson accents `#FF2E3D`.

Following the established reference architecture in `cr8v-stacks-events/inc/customizer.php`, the Crux Customizer implementation organizes all customizable content into three major tiers:
- **Global Settings & Layout Elements:** Company identity, brand logos, telephony, emails, social channels, and universal footers/shoutout bars.
- **Events Wing Panels & Sections:** Dedicated Customizer sections for event production, artist booking, ticket showcase, and event FAQs.
- **Consultancy Wing Panels & Sections:** Dedicated sections for business transformation, strategic stages, founder profile, and advisory FAQs.

### 1.1 Contextual `active_callback` Engine
To keep the WordPress Customizer preview sidebar clean and prevent overwhelming the site manager, Customizer sections must only display when the corresponding template is active in the preview iframe:

```php
function crux_is_events_wing_active() {
    return is_front_page() || is_page( 'events' ) || is_page( 'services' ) || is_singular( 'event' ) || is_page( 'gallery' );
}

function crux_is_consultancy_wing_active() {
    return is_page( array( 'consultancy', 'services-consultancy', 'founder', 'about' ) );
}

function crux_is_legal_page_active() {
    return is_page( array( 'privacy-policy', 'terms-conditions', 'cookie-policy' ) );
}
```

### 1.2 Custom Controls: The Studio Quicklink Pattern
Following `CR8V_Customizer_Quicklink_Control` from `cr8v-stacks-events/inc/customizer.php`, dynamic database records (such as Events CPT, Ticket Tiers, Orders, and Sponsors) should **not** have their data fields duplicated in Customizer settings. Instead, the Customizer provides clear Quicklink buttons pointing directly to the WordPress Admin menu:
- `Edit Events & Tickets` &rarr; `wp-admin/edit.php?post_type=event`
- `View Inquiries & Bookings` &rarr; `wp-admin/edit.php?post_type=inquiry`
- `Manage Media Assets` &rarr; `wp-admin/upload.php`

---

## 2. WHAT MUST NEVER BE EDITABLE BY THE CLIENT

To preserve visual brand identity, mathematical alignment, and structural stability, the following components **must remain locked in code** and must **never** be exposed to Customizer controls:

| Category | Component / Selector | Rationale |
|---|---|---|
| **Design Tokens** | Font Families (`Bebas Neue`, `Space Grotesk`) | Core typography system defines Crux brand identity. Changing fonts breaks headline tracking and uppercase layouts. |
| **Color System Tokens** | `#0A0F26`, `#002671`, `#5B8DEF`, `#8C7AE6`, `#10142E` | The dual-wing contrast model depends on mathematically locked color pairings and glassmorphism filters. |
| **Slanted Button Cuts** | `.bx`, `--sl: 10px`, `--sl: 8px`, `clip-path: polygon(...)` | The slanted button geometry is a locked brand signature across Crux and Red Cap. Client customization risks asymmetric clipping. |
| **Ticket Motion Mechanics** | `.tilt-ticket`, `--r: -1deg`, `--r: 1.5deg`, hover straightener | Precise rotational transform values calibrated to prevent CSS overflow while preserving playful tactile hover feel. |
| **Grid & Flex Layouts** | `[data-m~=g1]`, `[data-m~=root]`, `display: grid` | Mobile collapse logic (switching from 3-column to 1-column below 900px) is handled via locked CSS media queries. |
| **Site-Wing Pod Geometry** | `.crux-sw-pod`, `.crux-sw-tab` clip-paths | Dual-wing switcher uses nested polygon bevels (`clip-path: polygon(8px 0, 100% 0, calc(100% - 8px) 100%, 0 100%)`). |
| **Security & Ticket Logic** | Stripe API, HMAC tokens, PRG check-in redirect, Staff roles | Handled entirely by `cr8v-event-ticketing` plugin and locked templates. Never exposed to Customizer options. |

---

## 3. GLOBAL PANELS & SECTIONS

Global settings govern the unified components that render across all templates.

### 3.1 Global Header & Navigation (`crux_global_header_section`)

| Setting ID | Control Type | Proposed Default | Purpose / Rationale |
|---|---|---|---|
| `crux_brand_logo` | `image` | `blob:e4d72651b77d4c3cc1c086d9f6031149` | Primary Crux Nxtion logo with white container badge. Sanitized via attachment ID/URL. |
| `crux_events_shoutout_text` | `text` | `Now booking 2026/2027 across the UK —` | Top blue banner announcement for Events wing. Sanitized via `sanitize_text_field`. |
| `crux_events_shoutout_link_text`| `text` | `get in touch →` | Link label in Events top shoutout bar. |
| `crux_events_shoutout_link_url` | `url` | `/contact/?type=events` | Destination for Events shoutout link. |
| `crux_consultancy_shoutout_text`| `text` | `Now taking advisory clients for Q4 2026 / Q1 2027 —` | Top lavender banner announcement for Consultancy wing. |
| `crux_consultancy_shoutout_link_text`| `text` | `book discovery →` | Link label in Consultancy shoutout bar. |
| `crux_consultancy_shoutout_link_url` | `url` | `/contact/?type=consultancy` | Destination for Consultancy shoutout link. |
| `crux_nav_cta_events_text` | `text` | `Plan An Event` | Desktop header red slanted CTA button label. |
| `crux_nav_cta_events_url` | `url` | `/contact/?type=events` | Desktop header red CTA destination. |
| `crux_nav_cta_consultancy_text`| `text` | `Book Discovery` | Desktop header purple slanted CTA button label (Consultancy wing). |
| `crux_nav_cta_consultancy_url`| `url` | `/contact/?type=consultancy` | Desktop header purple CTA destination. |
| `crux_mega_menu_photo` | `image` | `blob:f269f7683bdb441b9b45df1336cd1485` | Founder photo in Column 3 of the header mega-menu card. |
| `crux_mega_menu_card_title` | `text` | `NOT SURE WHICH?` | Header mega-menu prompt title. |
| `crux_mega_menu_card_btn_text` | `text` | `Book A Call →` | Header mega-menu button label. |
| `crux_mega_menu_card_btn_url` | `url` | `/contact/` | Header mega-menu button destination. |

### 3.2 Global Company Contact Details & Socials (`crux_global_contact_section`)

> [!WARNING]
> **Phone Number Mismatch Hazard:** Three different phone numbers currently appear hardcoded across templates (`+44 7448 614051`, `+44 7762 278076`, and `+44 7341 366400`). The Customizer must centralize these into explicit fields to ensure brand consistency.

| Setting ID | Control Type | Proposed Default | Purpose / Rationale |
|---|---|---|---|
| `crux_company_phone_primary` | `tel` | `+44 7448 614051` | Primary direct phone rendered in mobile drawer overlay and global templates. |
| `crux_company_phone_events` | `tel` | `+44 7762 278076` | Dedicated event booking phone line (Contact page). |
| `crux_company_phone_consultancy`| `tel` | `+44 7341 366400` | Dedicated business advisory phone line (Contact page & FAQ). |
| `crux_company_email` | `email` | `infoandsales@cruxnxtion.co.uk` | Central sales and inquiries email address. Rendered with `antispambot()`. |
| `crux_company_address` | `text` | `29 Dun Work, Sheffield S3 8FB, United Kingdom` | Registered corporate business location. |
| `crux_calendly_url` | `url` | `https://calendly.com/cruxnxtiongroupofcompany-info` | Dedicated Calendly booking link for strategic discovery sessions. |
| `crux_social_instagram` | `url` | `https://instagram.com/cruxnxtion` | Official Instagram profile URL. |
| `crux_social_tiktok` | `url` | `https://tiktok.com/@cruxnxtion` | Official TikTok profile URL. |
| `crux_social_whatsapp` | `url` | `https://wa.me/447448614051` | Direct WhatsApp messaging link. |

### 3.3 Global Prefooter Call-To-Action (`crux_global_prefooter_section`)

> [!NOTE]
> The Prefooter CTA ("GOT A DATE, OR JUST A DIRECTION?") appears on almost every single template with identical copy and dual buttons, but switches between the Events rotating rosette (`prefooter-badge-events.svg`) and the Consultancy rosette (`prefooter-badge-consultancy.svg`). Consolidating this into a global section eliminates 15 duplicate copies.

| Setting ID | Control Type | Proposed Default | Purpose / Rationale |
|---|---|---|---|
| `crux_prefooter_bg_image` | `image` | `blob:aa52e28c3ca12b7f14d33300c774fb48` | Cinematic crowd backdrop image spanning full width. |
| `crux_prefooter_eyebrow` | `text` | `Ready When You Are` | Eyebrow caption in light blue/lavender. |
| `crux_prefooter_title` | `text` | `GOT A DATE, OR JUST A DIRECTION?` | Colossal Bebas Neue headline. |
| `crux_prefooter_desc` | `textarea`| `Planning an event or building a business — tell us what you have in mind and a real person will come back to you.` | Narrative paragraph under prefooter title. |
| `crux_prefooter_btn1_text` | `text` | `Plan An Event →` | Primary red slanted action button label. |
| `crux_prefooter_btn1_url` | `url` | `/contact/?type=events` | Primary action button destination. |
| `crux_prefooter_btn2_text` | `text` | `Talk Business Strategy →` | Secondary purple slanted action button label. |
| `crux_prefooter_btn2_url` | `url` | `/contact/?type=consultancy` | Secondary action button destination. |

### 3.4 Global Colossal Footer & Colophon (`crux_global_footer_section`)

| Setting ID | Control Type | Proposed Default | Purpose / Rationale |
|---|---|---|---|
| `crux_footer_brand_primary` | `text` | `CRUX` | Giant typographic brand element. |
| `crux_footer_brand_secondary`| `text` | `NXTION` | Giant typographic sub-brand element. |
| `crux_footer_copyright_text` | `text` | `Crux Nxtion Events • Sheffield, United Kingdom • All Rights Reserved` | Footer colophon copyright text (year rendered dynamically). |

---

## 4. TEMPLATE-BY-TEMPLATE DETAILED MAPPING

---

### Template 1: `front-page.php` (Events Wing Homepage)
*Scope: Primary landing page for cultural events, marquee, setlist rider services, event tickets, Why Crux, Process, Mini-About, Founder quote, FAQs.*

#### Proposed Section ID: `crux_frontpage_section`
- **Active Callback:** `is_front_page`
- **Estimated Settings:** 41 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_fp_hero_bg_image` | `image` | `blob:5e2df00e7ead10292f7266fc033953c3` | Hero background event crowd photo. |
| `crux_fp_hero_eyebrow` | `text` | `Cultural Live Event Production & Business Consultancy` | Top badge above hero headline. |
| `crux_fp_hero_line1` | `text` | `WE PLAN IT.` | Hero headline line 1 (Bebas Neue). |
| `crux_fp_hero_line2` | `text` | `WE BOOK IT.` | Hero headline line 2 (Bebas Neue). |
| `crux_fp_hero_line3` | `text` | `WE RUN IT.` | Hero headline line 3 (accent red). |
| `crux_fp_hero_desc` | `textarea`| `Crux Nxtion Events & Consultancy plans, books, and executes the live gatherings people talk about for weeks, while delivering the strategic business solutions that scale the enterprises behind them...` | Hero introductory paragraph. |
| `crux_fp_hero_btn1_text` | `text` | `Plan An Event →` | Red CTA button label. |
| `crux_fp_hero_btn1_url` | `url` | `/contact/?type=events` | Red CTA button URL. |
| `crux_fp_hero_btn2_text` | `text` | `Explore Consultancy →` | Purple secondary CTA button label. |
| `crux_fp_hero_btn2_url` | `url` | `/consultancy/` | Purple secondary CTA button URL. |
| `crux_fp_marquee_text` | `textarea`| `EVENT MANAGEMENT • ENTERTAINMENT BOOKING • EVENT DESIGN • ON-SITE COORDINATION • WEDDINGS • CULTURAL NIGHTS • FESTIVALS • CORPORATE GALAS •` | Slanted ticker marquee text. |
| `crux_fp_services_eyebrow` | `text` | `Event Services` | Eyebrow for "What We Do" services rider. |
| `crux_fp_services_title` | `text` | `WHAT WE DO` | Section heading for services rider. |
| `crux_fp_services_desc` | `textarea`| `Five services, one crew — from the first brief to the last guest.` | Section subtitle. |
| `crux_fp_service_{1..5}_title`| `text` (x5) | *(See services list in Section 3)* | Titles for each of the 5 services rider rows. |
| `crux_fp_service_{1..5}_desc` | `textarea` (x5) | *(See services list in Section 3)* | Descriptions for each rider row. |
| `crux_fp_service_{1..5}_image`| `image` (x5) | `blob:e6e06da...` | Square thumbnail photo for rider row. |
| `crux_fp_consultancy_fork_title`| `text` | `ALSO FROM CRUX` | Eyebrow for Consultancy split fork card. |
| `crux_fp_consultancy_fork_heading`| `text`| `LOOKING FOR BUSINESS CONSULTANCY?` | Headline for the consultancy card. |
| `crux_fp_consultancy_fork_desc`| `textarea`| `We help businesses scale, source commercial premises, and build sustainable growth...` | Narrative for consultancy card. |
| `crux_fp_consultancy_fork_btn_text`| `text`| `Explore Crux Consultancy →` | Button label for consultancy branch. |
| `crux_fp_consultancy_fork_btn_url`| `url` | `/consultancy/` | Link destination. |
| `crux_fp_miniabout_eyebrow`| `text` | `About Crux Nxtion` | Eyebrow for manifesto block. |
| `crux_fp_miniabout_title` | `text` | `BUILT ON THE DANCE FLOOR.` | Headline for manifesto block. |
| `crux_fp_miniabout_p1` | `textarea`| `Crux Nxtion was born out of a simple frustration: events that promised the world and fell apart on the night...` | Manifesto paragraph 1. |
| `crux_fp_miniabout_p2` | `textarea`| `Today, we are a multidisciplinary team operating across the UK...` | Manifesto paragraph 2. |
| `crux_fp_founder_quote` | `textarea`| `A great event is not an accident. It is planned down to the minute, and run with real people on the ground.` | Founder manifesto quote text. |
| `crux_fp_founder_name` | `text` | `Bambad` | Founder signature name. |
| `crux_fp_founder_role` | `text` | `Founder & Lead Producer, Crux Nxtion` | Founder corporate title. |

---

### Template 2: `page-about.php` (About Us)
*Scope: Brand origin, manifesto, 3-image hero collage, dual-wing tabs (Events & Consultancy), 4 difference pillars, Founder bio with Food Market reference, and 4-step journey timeline.*

#### Proposed Section ID: `crux_about_section`
- **Active Callback:** `cr8v_is_about_page_active`
- **Estimated Settings:** 36 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_about_hero_eyebrow` | `text` | `Who We Are` | Eyebrow badge for About hero. |
| `crux_about_hero_title` | `text` | `BUILT ON THE DANCE FLOOR. SHAPED BY BUSINESS.` | Main Bebas Neue headline. |
| `crux_about_hero_desc` | `textarea`| `Crux Nxtion is a UK-based cultural event production house and strategic business consultancy...` | Lead manifesto description. |
| `crux_about_collage_img1` | `image` | `blob:2b696c907bf5b4d0dc14a80e8cd60e15` | Hero collage left vertical image. |
| `crux_about_collage_img2` | `image` | `blob:e6e06da1a649b213d8dd573ea6511302` | Hero collage top-right image. |
| `crux_about_collage_img3` | `image` | `blob:6e1036b74f617a3d1887a7cf36398cff` | Hero collage bottom-right image. |
| `crux_about_story_heading` | `text` | `TWO WINGS. ONE RELENTLESS CREW.` | Story section title. |
| `crux_about_story_p1` | `textarea`| `Crux Nxtion started with a single observation: the most memorable nights were the ones where every detail worked invisibly...` | Story paragraph 1. |
| `crux_about_story_p2` | `textarea`| `Over time, our clients began asking for more than just event execution. They asked how to structure the companies behind the ideas...` | Story paragraph 2. |
| `crux_about_stat1_number` | `text` | `100+` | Stat badge 1 numeric metric. |
| `crux_about_stat1_label` | `text` | `Events Produced` | Stat badge 1 description. |
| `crux_about_stat2_number` | `text` | `50K+` | Stat badge 2 numeric metric. |
| `crux_about_stat2_label` | `text` | `Attendees Entertained` | Stat badge 2 description. |
| `crux_about_stat3_number` | `text` | `30+` | Stat badge 3 numeric metric. |
| `crux_about_stat3_label` | `text` | `Businesses Consulted` | Stat badge 3 description. |
| `crux_about_stat4_number` | `text` | `100%` | Stat badge 4 numeric metric. |
| `crux_about_stat4_label` | `text` | `Hands-On Execution` | Stat badge 4 description. |
| `crux_about_diff_{1..4}_title`| `text` (x4) | `End-to-End Ownership`, `Cultural Authenticity`, `Commercial Focus`, `On-the-Floor Presence` | Titles for the 4 Crux Difference pillars. |
| `crux_about_diff_{1..4}_desc` | `textarea` (x4)| *(Detailed descriptive copy for each pillar)* | Descriptions for the 4 pillars. |
| `crux_about_founder_heading` | `text` | `MEET THE FOUNDER` | Founder section heading. |
| `crux_about_founder_bio` | `textarea`| `Founded by Bambad, Crux Nxtion was built on the belief that cultural vibrancy and operational excellence must go hand in hand...` | Founder bio text. |
| `crux_about_founder_market_link`| `url` | `https://nxtionfoodmarket.com` | Link to external sister project (Nxtion Food Market). |
| `crux_about_timeline_{1..4}_yr`| `text` (x4) | `2021`, `2023`, `2024`, `2026+` | Year stamps for the Journey timeline. |
| `crux_about_timeline_{1..4}_txt`| `text` (x4) | *(Summary milestones for each timeline step)* | Milestone descriptions. |

---

### Template 3: `page-services.php` (Events Wing Services)
*Scope: Detailed riders for 5 core event services with planning triggers, delivery points, deliverables, and audience targets, plus 4-step event process.*

#### Proposed Section ID: `crux_services_events_section`
- **Active Callback:** `cr8v_is_services_page_active`
- **Estimated Settings:** 43 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_svc_ev_hero_eyebrow` | `text` | `Full-Service Production` | Services hero eyebrow. |
| `crux_svc_ev_hero_title` | `text` | `EVENT SERVICES` | Main Bebas Neue title. |
| `crux_svc_ev_hero_desc` | `textarea`| `From weddings and dance festivals to corporate showcases — five distinct event services handled by one singular crew.` | Introductory overview. |
| `crux_svc_ev_item_{1..5}_title`| `text` (x5) | *(5 Event Service Titles)* | Individual service titles. |
| `crux_svc_ev_item_{1..5}_desc` | `textarea` (x5)| *(5 Service Descriptions)* | Detailed service summaries. |
| `crux_svc_ev_item_{1..5}_planning`| `textarea` (x5)| `You might be planning...` | Triggers when a client needs this service. |
| `crux_svc_ev_item_{1..5}_handle` | `textarea` (x5)| `We'll handle...` | Detailed operational scope. |
| `crux_svc_ev_item_{1..5}_leave` | `textarea` (x5)| `You leave with...` | Client tangible deliverables. |
| `crux_svc_ev_item_{1..5}_image` | `image` (x5) | `blob:...` | Service banner photography. |
| `crux_svc_ev_process_eyebrow` | `text` | `How We Deliver` | Eyebrow for the 4-step process. |
| `crux_svc_ev_process_title` | `text` | `THE 4-STEP EVENT ENGINE` | Section title for event process. |
| `crux_svc_ev_step_{1..4}_title`| `text` (x4) | `01 Discovery & Brief`, `02 Planning & Curation`, `03 Production & Setup`, `04 Live Floor Delivery` | Titles for the 4 delivery phases. |
| `crux_svc_ev_step_{1..4}_desc` | `textarea` (x4)| *(Detailed phase descriptions)* | Scope for each phase. |

---

### Template 4: `page-services-consultancy.php` (Consultancy Services)
*Scope: Detailed business advisory riders for Business Setup, Branding, Business Growth, Commercial Fitout & Setup, and Specialized Visas & Advisory.*

#### Proposed Section ID: `crux_services_consultancy_section`
- **Active Callback:** `crux_is_consultancy_wing_active`
- **Estimated Settings:** 27 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_svc_cs_hero_eyebrow` | `text` | `Enterprise Solutions` | Eyebrow for consultancy services hero. |
| `crux_svc_cs_hero_title` | `text` | `CONSULTANCY SERVICES` | Main Bebas Neue title. |
| `crux_svc_cs_hero_desc` | `textarea`| `Strategic consulting, commercial retail development, brand architecture, and regulatory advisory for modern enterprises.` | Introductory summary. |
| `crux_svc_cs_{1..5}_title` | `text` (x5) | `Business Setup & Strategy`, `Branding & Positioning`, `Business Growth & Scaling`, `Commercial Fitout & Setup`, `Specialized Visas & Advisory` | Titles of the 5 business services. |
| `crux_svc_cs_{1..5}_desc` | `textarea` (x5)| *(Summaries for the 5 services)* | Comprehensive service scopes. |
| `crux_svc_cs_{1..5}_deliverables`| `textarea` (x5)| *(Walkaway deliverables for each)* | Key outcomes and tangible client assets. |
| `crux_svc_cs_{1..5}_good_for` | `text` (x5) | `Startups, founders, retail operators...` | Target enterprise profile. |
| `crux_svc_cs_cta_box_title` | `text` | `READY FOR STRATEGIC CLARITY?` | Callout card heading at section bottom. |
| `crux_svc_cs_cta_box_desc` | `textarea`| `Book a 45-minute discovery consultation with our senior advisory team.` | Callout card text. |
| `crux_svc_cs_cta_box_btn_text` | `text` | `Book Discovery Call (Calendly) →` | Direct Calendly action button label. |
| `crux_svc_cs_cta_box_btn_url` | `url` | `https://calendly.com/cruxnxtiongroupofcompany-info` | Calendly link destination. |

---

### Template 5: `page-consultancy.php` (Consultancy Wing Homepage)
*Scope: Flagship enterprise landing page with Before/After Retail Showcase, animated discovery call dialogue loop, Sound Familiar quote carousel, 3 entry points, 5 expandable panels, 4 climb stages, walkaway deliverables, Why Us, Founder advisory, and 9 Consultancy FAQs.*

#### Proposed Section ID: `crux_consultancy_home_section`
- **Active Callback:** `crux_is_consultancy_wing_active`
- **Estimated Settings:** 46 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_cs_hero_eyebrow` | `text` | `Crux Nxtion Advisory` | Eyebrow for consultancy hero. |
| `crux_cs_hero_title_line1` | `text` | `TURN PURPOSE INTO PROFIT.` | Headline line 1. |
| `crux_cs_hero_title_line2` | `text` | `TURN SCALE INTO CERTAINTY.` | Headline line 2. |
| `crux_cs_hero_desc` | `textarea`| `We help ambitious founders and retail businesses build viable commercial models, launch verified brand platforms, and scale sustainable revenue.` | Consultancy mission paragraph. |
| `crux_cs_hero_btn1_text` | `text` | `Book Discovery Call →` | Primary CTA label. |
| `crux_cs_hero_btn1_url` | `url` | `/contact/?type=consultancy` | Primary CTA URL. |
| `crux_cs_hero_btn2_text` | `text` | `View Client Transformations →`| Secondary CTA label. |
| `crux_cs_hero_btn2_url` | `url` | `#transformations` | Secondary CTA anchor link. |
| `crux_cs_chat_line1` | `text` | `We have the product, but retail footfall is stalled.` | Animated discovery call simulation prompt 1. |
| `crux_cs_chat_reply1` | `text` | `We diagnose the unit fitout, reposition pricing, and activate local footfall within 30 days.` | Simulated consultancy response 1. |
| `crux_cs_chat_line2` | `text` | `What about commercial unit leases?` | Simulated prompt 2. |
| `crux_cs_chat_reply2` | `text` | `Our team handles sourcing, landlord negotiations, and contractor fitout from day one.` | Simulated response 2. |
| `crux_cs_carousel_{1..3}_quote`| `textarea` (x3)| *(3 pain-point quotes: "Stuck at £150k turnover...", "No clear retail identity...", "Struggling with visa regulations...")* | Carousel founder quote cards ("Sound Familiar?"). |
| `crux_cs_carousel_{1..3}_author`| `text` (x3) | `Retail Founder, London`, `Hospitality Operator, Manchester`, `Creative Entrepreneur, Sheffield` | Attribution labels for pain points. |
| `crux_cs_stage_{1..4}_title` | `text` (x4) | `01 Foundation & Audit`, `02 Brand Architecture`, `03 Commercial Rollout`, `04 Scaled Growth` | The 4-step strategic "Climb" framework. |
| `crux_cs_stage_{1..4}_desc` | `textarea` (x4)| *(Detailed scope for each climb stage)* | Descriptions for each climb stage. |
| `crux_cs_why_us_p1` | `textarea`| `Traditional agencies deliver PowerPoint decks and disappear. Crux Nxtion stands in the room...` | Why Us narrative paragraph 1. |
| `crux_cs_why_us_p2` | `textarea`| `Every strategy we propose has been tested on real balance sheets, physical commercial units, and live market deployments.` | Why Us narrative paragraph 2. |
| `crux_cs_faq_{1..9}_q` | `text` (x9) | *(9 Consultancy FAQ Questions)* | Strategic FAQ questions. |
| `crux_cs_faq_{1..9}_a` | `textarea` (x9)| *(9 Consultancy FAQ Answers)* | Detailed answers. |

---

### Template 6: `page-contact.php` (Contact & Intake Hub)
*Scope: 3 Interactive Intake Tabs (Events, Consultancy, Sponsorship), 14 clickable service chip tags, 3 dynamic intake forms, AJAX submission, modal feedback alert, right-hand sidebar contact info, What Happens Next 3-step guide.*

#### Proposed Section ID: `crux_contact_section`
- **Active Callback:** `cr8v_is_contact_page_active`
- **Estimated Settings:** 16 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_contact_hero_eyebrow` | `text` | `Get In Touch` | Eyebrow above contact title. |
| `crux_contact_hero_title` | `text` | `START THE CONVERSATION` | Main Bebas Neue heading. |
| `crux_contact_hero_desc` | `textarea`| `Tell us what you have in mind — whether you're booking an event, planning a production, or scaling a business.` | Subtitle narrative. |
| `crux_contact_sidebar_title` | `text` | `DIRECT REACH` | Heading for right-hand contact card. |
| `crux_contact_events_phone` | `tel` | `+44 7762 278076` | Direct phone number for Events bookings. |
| `crux_contact_consultancy_phone`| `tel` | `+44 7341 366400` | Direct phone number for Consultancy inquiries. |
| `crux_contact_direct_email` | `email` | `infoandsales@cruxnxtion.co.uk` | Direct inquiry email address. |
| `crux_contact_office_address` | `textarea`| `29 Dun Work, Sheffield S3 8FB, United Kingdom` | Studio physical address. |
| `crux_contact_step1_title` | `text` | `1. We Review Your Brief` | Title for What Happens Next step 1. |
| `crux_contact_step1_desc` | `textarea`| `A real producer or consultant reads your requirements within 24 hours.` | Step 1 description. |
| `crux_contact_step2_title` | `text` | `2. The Discovery Call` | Title for step 2. |
| `crux_contact_step2_desc` | `textarea`| `We schedule a 30-minute consultation to walk through options, budget, and timeline.` | Step 2 description. |
| `crux_contact_step3_title` | `text` | `3. The Action Proposal` | Title for step 3. |
| `crux_contact_step3_desc` | `textarea`| `You receive a clear scope of work with transparent pricing — zero vague estimates.` | Step 3 description. |
| `crux_contact_modal_title` | `text` | `BRIEF RECEIVED` | Confirmation modal title upon AJAX success. |
| `crux_contact_modal_desc` | `textarea`| `Thank you for reaching out. A senior member of our team will review your requirements and respond within 24 hours.` | Confirmation modal text. |

---

### Template 7: `page-faq.php` (Frequently Asked Questions)
*Scope: Dual-wing FAQ repository with fast jump buttons (Events FAQ vs Consultancy FAQ), 35 questions on this page in total (verified in the template; the split between wings must be re-counted before building), and "Still Stuck?" contact prompt card.*

#### Proposed Section ID: `crux_faq_section`
- **Active Callback:** `is_page( 'faq' )`
- **Estimated Settings:** 33 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_faq_hero_eyebrow` | `text` | `Got Questions?` | FAQ hero eyebrow. |
| `crux_faq_hero_title` | `text` | `FREQUENTLY ASKED QUESTIONS` | Main Bebas Neue headline. |
| `crux_faq_hero_desc` | `textarea`| `Everything you need to know about working with Crux Nxtion — from event deposits and run-of-show logistics to business advisory frameworks.` | Overview description. |
| `crux_faq_tab1_label` | `text` | `Events & Production FAQ (18)` | Tab selector label for Events wing. |
| `crux_faq_tab2_label` | `text` | `Consultancy & Advisory FAQ (16)`| Tab selector label for Consultancy wing. |
| `crux_faq_ev_{1..6}_q` | `text` (x6) | *(Top 6 highlighted Events questions)* | Core event questions (e.g. deposit schedule, booking window, venue licensing). |
| `crux_faq_ev_{1..6}_a` | `textarea` (x6)| *(Top 6 highlighted Events answers)* | In-depth answers with pricing and policies. |
| `crux_faq_cs_{1..6}_q` | `text` (x6) | *(Top 6 highlighted Consultancy questions)*| Core advisory questions (e.g. engagement terms, retail sourcing, founder visas). |
| `crux_faq_cs_{1..6}_a` | `textarea` (x6)| *(Top 6 highlighted Consultancy answers)*| In-depth advisory methodology answers. |
| `crux_faq_stuck_card_title` | `text` | `CAN'T FIND YOUR ANSWER?` | Card heading for the "Still Stuck?" footer block. |
| `crux_faq_stuck_card_desc` | `textarea`| `Speak directly to our production or advisory team. Real people, no automated runaround.` | Prompt text. |
| `crux_faq_stuck_card_btn_text` | `text` | `Speak To Our Crew →` | Contact button label. |
| `crux_faq_stuck_card_btn_url` | `url` | `/contact/` | Contact button destination. |

---

### Template 8: `page-founder.php` (Meet The Founder)
*Scope: Executive biography of Bambad, 4 core leadership metrics, Event Legacy with 5 signature productions, and Global Business Consultancy with 5 strategic pillars.*

#### Proposed Section ID: `crux_founder_section`
- **Active Callback:** `is_page( 'founder' )`
- **Estimated Settings:** 18 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_founder_hero_eyebrow` | `text` | `Leadership & Vision` | Eyebrow above founder name. |
| `crux_founder_hero_title` | `text` | `BAMBAD` | Bebas Neue executive name. |
| `crux_founder_hero_subtitle` | `text` | `Founder, Lead Event Producer & Senior Business Strategist` | Professional title. |
| `crux_founder_hero_bio_p1` | `textarea`| `Bambad founded Crux Nxtion on a single premise: live cultural events and strategic enterprise consulting share the exact same core DNA — relentless execution, zero margin for error, and deep community trust.` | Biography paragraph 1. |
| `crux_founder_hero_bio_p2` | `textarea`| `Over the past five years, he has produced landmark cultural festivals, curated high-profile corporate galas, and steered UK commercial enterprises through unit acquisitions, brand pivots, and scaling rounds.` | Biography paragraph 2. |
| `crux_founder_portrait_image` | `image` | `blob:f269f7683bdb441b9b45df1336cd1485` | High-res executive portrait photo. |
| `crux_founder_stat1_metric` | `text` | `100+` | Milestone metric 1. |
| `crux_founder_stat1_label` | `text` | `Live Productions Delivered` | Milestone label 1. |
| `crux_founder_stat2_metric` | `text` | `50K+` | Milestone metric 2. |
| `crux_founder_stat2_label` | `text` | `Guests Admitted` | Milestone label 2. |
| `crux_founder_stat3_metric` | `text` | `30+` | Milestone metric 3. |
| `crux_founder_stat3_label` | `text` | `Enterprises Advised` | Milestone label 3. |
| `crux_founder_stat4_metric` | `text` | `£2M+` | Milestone metric 4. |
| `crux_founder_stat4_label` | `text` | `Economic Activity Generated`| Milestone label 4. |
| `crux_founder_legacy_heading` | `text` | `THE EVENT PRODUCTION LEGACY` | Event achievements section heading. |
| `crux_founder_legacy_desc` | `textarea`| `From underground cultural showcases in Sheffield to high-capacity festival tents across Greater London and Manchester...` | Narrative on live event achievements. |
| `crux_founder_advisory_heading`| `text` | `GLOBAL BUSINESS CONSULTANCY` | Advisory achievements section heading. |
| `crux_founder_advisory_desc` | `textarea`| `Guiding diaspora and UK founders through commercial leases, unit transformations, brand architecture, and visa advisory...` | Narrative on business consulting work. |

---

### Template 9: `page-gallery.php` (Photo Ticket Wall)
*Scope: Visual archive with 15 ticket-frame photography cards, stub badges, frame numbers, event labels, and CTA invitation.*

#### Proposed Section ID: `crux_gallery_section`
- **Active Callback:** `cr8v_is_gallery_page_active`
- **Estimated Settings:** 12 settings *(Template copy only; dynamic images managed via Media/CPT)*

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_gallery_hero_eyebrow` | `text` | `Frames From The Floor` | Eyebrow above gallery title. |
| `crux_gallery_hero_title` | `text` | `THE PHOTO WALL` | Bebas Neue main title. |
| `crux_gallery_hero_desc` | `textarea`| `Fifteen frames, punched by the same crew — wedding receptions, dance nights, festival runways, and behind-the-scenes production.` | Lead description. |
| `crux_gallery_filter_all` | `text` | `All Frames` | Filter pill 1 label. |
| `crux_gallery_filter_events` | `text` | `Events & Nights` | Filter pill 2 label. |
| `crux_gallery_filter_culture` | `text` | `Culture & Runway` | Filter pill 3 label. |
| `crux_gallery_filter_backstage`| `text` | `Backstage & Setup` | Filter pill 4 label. |
| `crux_gallery_end_card_eyebrow`| `text` | `Capture Your Night` | Eyebrow for the closing callout card. |
| `crux_gallery_end_card_title` | `text` | `PUT YOUR NIGHT IN THE FRAME.` | Closing card heading. |
| `crux_gallery_end_card_desc` | `textarea`| `Tell us about your upcoming event and our media crew will document every moment.` | Closing card text. |
| `crux_gallery_end_card_btn_text`| `text` | `Plan With Us →` | Action button label. |
| `crux_gallery_end_card_btn_url`| `url` | `/contact/?type=events` | Action button destination. |

---

### Template 10: `page-sponsors.php` (Partners & Collaborators)
*Scope: Showcase of 17 commercial sponsors, media partners, and venue collaborators, introductory narrative, and partner inquiry CTA card.*

#### Proposed Section ID: `crux_sponsors_section`
- **Active Callback:** `is_page( 'sponsors' )`
- **Estimated Settings:** 11 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_sponsors_hero_eyebrow` | `text` | `Our Partners` | Eyebrow above sponsors title. |
| `crux_sponsors_hero_title` | `text` | `PARTNERS & SPONSORS` | Main Bebas Neue heading. |
| `crux_sponsors_hero_desc` | `textarea`| `The brands, venues, media platforms, and cultural institutions that make our productions possible across the UK.` | Narrative summary. |
| `crux_sponsors_intro_p1` | `textarea`| `Crux Nxtion collaborates with progressive brands looking for authentic cultural engagement...` | Introductory context paragraph 1. |
| `crux_sponsors_intro_p2` | `textarea`| `From venue operators and sound engineering firms to beverage sponsors and ticketing partners...` | Introductory context paragraph 2. |
| `crux_sponsors_tier1_label` | `text` | `Headline Partners` | Grouping header for top tier partners. |
| `crux_sponsors_tier2_label` | `text` | `Media & Production Collaborators`| Grouping header for secondary tier. |
| `crux_sponsors_cta_box_title` | `text` | `BECOME A PARTNER` | Inquiries callout card title. |
| `crux_sponsors_cta_box_desc` | `textarea`| `Interested in sponsoring an upcoming Crux Nxtion event or exploring brand activation?` | Inquiries callout card text. |
| `crux_sponsors_cta_box_btn_text`| `text` | `Sponsorship Inquiries →` | Inquiries button label. |
| `crux_sponsors_cta_box_btn_url`| `url` | `/contact/?type=sponsorship` | Destination with preset sponsorship query tag. |

---

### Template 11: `page-events.php` / `archive-event.php` / `page-events-archive.php`
*Scope: Events Ticket Wall rendering all upcoming and past events via `crux_get_all_events()`, ticket stubs, and closing CTA card.*

#### Proposed Section ID: `crux_events_hub_section`
- **Active Callback:** `cr8v_is_events_page_active`
- **Estimated Settings:** 8 settings *(Events records dynamically queried from CPT)*

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_events_hero_eyebrow` | `text` | `The Ticket Wall` | Eyebrow above events title. |
| `crux_events_hero_title` | `text` | `EVENTS` | Bebas Neue title. |
| `crux_events_hero_desc` | `textarea`| `Every ticket we've printed, punched by the same crew — weddings, dance nights, awards and festivals across the UK.` | Narrative summary. |
| `crux_events_end_card_eyebrow` | `text` | `Your Night Next` | Closing ticket-wall card eyebrow. |
| `crux_events_end_card_title` | `text` | `PUT YOUR EVENT ON THE WALL.` | Closing card heading. |
| `crux_events_end_card_desc` | `textarea`| `Send us a brief and we will plan, book and run it.` | Closing card text. |
| `crux_events_end_card_btn_text`| `text` | `Get In Touch` | Slanted action button label. |
| `crux_events_end_card_btn_url` | `url` | `/contact/` | Action button destination. |

---

### Template 12: `single-event.php` (Single Event Booking & Detail)
*Scope: Single event display resolving `$ev_data`, breadcrumbs, hero banner with date badge, descriptions, gallery grid, booking ticket tier card, modal trigger, and "You Might Also Like" related events.*

#### Proposed Section ID: `crux_single_event_section`
- **Active Callback:** `is_singular( 'event' )`
- **Estimated Settings:** 8 settings *(Event-specific metadata is managed per post via `_cr8v_*` meta boxes)*

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_se_about_heading` | `text` | `ABOUT THIS EVENT` | Fixed section heading for event description. |
| `crux_se_gallery_heading` | `text` | `From The Gallery` | Subheading above event photo grid. |
| `crux_se_btn_reserve_text` | `text` | `Reserve Your Spot` | Primary booking button label (opens modal or Eventbrite). |
| `crux_se_btn_question_text` | `text` | `Ask A Question` | Secondary button label on event pass card. |
| `crux_se_btn_question_url` | `url` | `/contact/` | Inquiry link destination. |
| `crux_se_related_heading` | `text` | `YOU MIGHT ALSO LIKE` | Section heading for related events feed. |
| `crux_se_modal_eyebrow` | `text` | `SECURE TICKETING` | Eyebrow inside the ticket checkout modal dialog. |
| `crux_se_modal_honeypot_label` | `text` | `Leave this field empty` | Hidden accessibility label for spam honeypot field. |

---

### Template 13: `page-blog.php` / `home.php` / `index.php` (Journal Archive)
*Scope: Crux Journal ticket-style article feed with featured card, 5 category guide cards, read times, and story submission footer callout.*

#### Proposed Section ID: `crux_blog_archive_section`
- **Active Callback:** `cr8v_is_blog_page_active`
- **Estimated Settings:** 10 settings *(When mapped to static fallback items)*

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_blog_hero_eyebrow` | `text` | `Notes From The Crew` | Eyebrow above journal title. |
| `crux_blog_hero_title` | `text` | `THE JOURNAL` | Main Bebas Neue heading. |
| `crux_blog_hero_desc` | `textarea`| `Event recaps, planning guides and stories from the crew — filed like a ticket, punched by the same people.` | Introductory summary. |
| `crux_blog_submit_card_eyebrow`| `text` | `Have A Story We Should Cover?`| Eyebrow on submission card. |
| `crux_blog_submit_card_title` | `text` | `SEND US A NOTE` | Heading on submission card. |
| `crux_blog_submit_card_btn_text`| `text` | `Get In Touch` | Button label. |
| `crux_blog_submit_card_btn_url`| `url` | `/contact/` | Button destination. |
| `crux_blog_read_more_text` | `text` | `Read The Story →` | Card link label for featured article. |
| `crux_blog_badge_featured` | `text` | `FEATURED` | Ticket stub badge text for featured post. |
| `crux_blog_badge_guides` | `text` | `GUIDES` | Ticket stub badge text for planning guides. |

---

### Template 14: `single.php` (Single Blog Post)
*Scope: Single article view resolving `$post_data` with reading time, hero banner, numbered strategy points, stylized blockquote, and "Recent Posts" sidebar card.*

#### Proposed Section ID: `crux_single_post_section`
- **Active Callback:** `is_singular( 'post' )`
- **Estimated Settings:** 6 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_sp_recent_heading` | `text` | `Recent Posts` | Heading for the right-hand sidebar card. |
| `crux_sp_author_byline` | `text` | `Crux Nxtion Events` | Author attribution string before read time. |
| `crux_sp_share_prompt` | `text` | `Share This Note` | Social sharing prompt label. |
| `crux_sp_fallback_title` | `text` | `THE JOURNAL NOTE` | Default headline if post title is unavailable. |
| `crux_sp_fallback_quote` | `textarea`| `TURNING BOLD IDEAS INTO UNFORGETTABLE EXPERIENCES.` | Default blockquote if custom quote is empty. |
| `crux_sp_back_link_text` | `text` | `← Back To Journal` | Return link label in breadcrumb. |

---

### Template 15: Legal Pages (`page-privacy-policy.php`, `page-cookie-policy.php`, `page-terms-conditions.php`)
*Scope: Light theme canvas (`#FFFFFF`), sticky left navigation bar with anchor links, Questions card, 8 legal subheadings and legal narratives, and updated timestamps.*

#### Proposed Section ID: `crux_legal_pages_section`
- **Active Callback:** `crux_is_legal_page_active`
- **Estimated Settings:** 12 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_legal_eyebrow` | `text` | `Legal` | Eyebrow above legal title banner. |
| `crux_legal_questions_heading` | `text` | `Questions?` | Heading for the sticky questions card. |
| `crux_legal_questions_desc` | `textarea`| `Email us and a real person will reply.` | Prompt copy in questions card. |
| `crux_legal_questions_btn_text`| `text` | `Contact us →` | Contact link text. |
| `crux_legal_questions_btn_url` | `url` | `/contact/` | Contact link destination. |
| `crux_privacy_last_updated` | `text` | `Last updated 19 September 2026` | Date badge for Privacy Policy. |
| `crux_privacy_controller_email`| `email` | `infoandsales@cruxnxtion.co.uk` | Data controller contact email. |
| `crux_cookie_last_updated` | `text` | `Last updated 19 September 2026` | Date badge for Cookie Policy. |
| `crux_cookie_settings_link_text`| `text` | `cookie settings link in the site footer` | Consent management link label. |
| `crux_terms_last_updated` | `text` | `Last updated 19 September 2026` | Date badge for Terms & Conditions. |
| `crux_terms_governing_law` | `text` | `laws of England and Wales` | Legal jurisdiction statement. |
| `crux_terms_court_jurisdiction`| `text` | `courts of England and Wales` | Designated court jurisdiction. |

---

### Template 16: `404.php` (Page Not Found)
*Scope: Custom branded 404 experience with typographic gradient numeral, headline, guidance narrative, dual action buttons, and 4 quick-jump cards.*

#### Proposed Section ID: `crux_404_section`
- **Active Callback:** `is_404`
- **Estimated Settings:** 10 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_404_numeral` | `text` | `404` | Large gradient numeral display. |
| `crux_404_eyebrow` | `text` | `Off The Guest List` | Eyebrow above 404 headline. |
| `crux_404_title` | `text` | `THIS PAGE DIDN'T MAKE THE LINE-UP.` | Main Bebas Neue headline. |
| `crux_404_desc` | `textarea`| `The link may be old, or the page has moved. Head back to the main room, or pick one of the doors below.` | Explanation narrative. |
| `crux_404_btn_home_text` | `text` | `Back To Home` | Primary red button label. |
| `crux_404_btn_home_url` | `url` | `/` | Primary button destination. |
| `crux_404_btn_events_text` | `text` | `See Upcoming Events` | Secondary outlined button label. |
| `crux_404_btn_events_url` | `url` | `/events/` | Secondary button destination. |
| `crux_404_cards_heading` | `text` | `Take me there` | Label on the 4 quick-jump ticket stubs. |
| `crux_404_card4_desc` | `textarea`| `Tell us the date, we will do the rest.` | Subtitle on the Contact card. |

---

### Template 17: `page.php` (Default Page Fallback)
*Scope: Standard WordPress post loop fallback for arbitrary content pages, containing eyebrow, dynamic `the_title()`, and `the_content()`.*

#### Proposed Section ID: `crux_default_page_section`
- **Active Callback:** `is_page && ! is_page_template()`
- **Estimated Settings:** 2 settings

| Setting ID | Type | Proposed Default | Purpose & Rationale |
|---|---|---|---|
| `crux_page_default_eyebrow` | `text` | `Crux Nxtion` | Eyebrow caption rendered above `the_title()`. |
| `crux_page_sidebar_contact_prompt`| `text`| `Need assistance with this service?` | Footer helper prompt. |

---

## 5. CONSOLIDATED MASTER SETTINGS INVENTORY & ESTIMATES

The table below compiles the estimated setting counts per section and panel across the entire Crux theme:

| Panel / Group | Section Name | Section ID | Settings Count | Primary Control Types |
|---|---|---|:---:|---|
| **Global Brand Panel** | Header & Navigation | `crux_global_header_section` | 15 | text, url, image |
| **Global Brand Panel** | Contact Details & Socials | `crux_global_contact_section` | 9 | tel, email, text, url |
| **Global Brand Panel** | Prefooter Call-To-Action | `crux_global_prefooter_section` | 8 | text, textarea, image, url |
| **Global Brand Panel** | Colossal Footer & Colophon | `crux_global_footer_section` | 3 | text |
| **Events Wing Panel** | Homepage (Front Page) | `crux_frontpage_section` | 41 | text, textarea, image, url |
| **Events Wing Panel** | Events Hub & Archive | `crux_events_hub_section` | 8 | text, textarea, url |
| **Events Wing Panel** | Single Event Page | `crux_single_event_section` | 8 | text, url |
| **Events Wing Panel** | Event Services Rider | `crux_services_events_section` | 43 | text, textarea, image |
| **Events Wing Panel** | Photo Ticket Wall (Gallery)| `crux_gallery_section` | 12 | text, textarea, url |
| **Events Wing Panel** | Sponsors & Partners | `crux_sponsors_section` | 11 | text, textarea, url |
| **Events Wing Panel** | Journal & Blog Archive | `crux_blog_archive_section` | 10 | text, textarea, url |
| **Events Wing Panel** | Single Journal Post | `crux_single_post_section` | 6 | text, textarea |
| **Consultancy Wing Panel**| Consultancy Home Hub | `crux_consultancy_home_section` | 46 | text, textarea, url |
| **Consultancy Wing Panel**| Consultancy Services Rider| `crux_services_consultancy_section`| 27 | text, textarea, url |
| **Consultancy Wing Panel**| Meet The Founder (Bambad) | `crux_founder_section` | 18 | text, textarea, image |
| **Universal Pages** | About Us Page | `crux_about_section` | 36 | text, textarea, image, url |
| **Universal Pages** | Contact & Intake Hub | `crux_contact_section` | 16 | text, textarea, tel, email |
| **Universal Pages** | Frequently Asked Questions | `crux_faq_section` | 33 | text, textarea, url |
| **Universal Pages** | Legal & Compliance Pages | `crux_legal_pages_section` | 12 | text, textarea, email |
| **Universal Pages** | 404 Page Not Found | `crux_404_section` | 10 | text, textarea, url |
| **Universal Pages** | Default Page Fallback | `crux_default_page_section` | 2 | text |
| **TOTAL ESTIMATE** | **21 Sections Across 3 Panels** | — | **374 Settings** (corrected; see 5.1) | — |

---

### 5.1 Correction to the totals (Claude review)

The original table said 293 settings. Expanding the document's own repeating rows (for example `crux_svc_ev_item_{1..5}_title` is five settings, not one) gives **374**. Six section estimates were too low: front page 28 -> 41, about 36 (was 24), event services 43 (was 22), consultancy services 27 (was 20), consultancy home 46 (was 32), FAQ 33 (was 20). Use 374 for planning, and treat it as a floor, because Section 6.7 shows several lists that are not fully covered.

---

## 6. RISK ASSESSMENT & MITIGATION STRATEGY

### 6.1 Content Duplication Across Multiple Templates
- **Identified Hazard:** Several extensive content blocks are duplicated verbatim across separate templates:
  - *The Prefooter CTA ("GOT A DATE, OR JUST A DIRECTION?")* is repeated in 16 template files.
  - *The Founder Biography and metrics* appear on `front-page.php`, `page-about.php`, `page-consultancy.php`, and `page-founder.php`.
  - *Frequently Asked Questions* appear on `front-page.php`, `page-consultancy.php`, and `page-faq.php`.
- **Architectural Risk:** If settings are created separately per template, the client must edit the same phone number, quote, or CTA in 4 to 16 places, causing inevitable drift and broken copy.
- **Mitigation:**
  1. Centralize universal blocks into **Global Sections** (`crux_global_prefooter_section`, `crux_founder_section`, `crux_global_contact_section`).
  2. In template files, retrieve global options with a single helper function fallback:
     ```php
     $prefooter_title = get_theme_mod( 'crux_prefooter_title', 'GOT A DATE, OR JUST A DIRECTION?' );
     ```
  3. Provide an optional template-level override setting only where page-specific distinction is required.

---

### 6.2 Text Mixed Directly Into Inline HTML Spans & Line Breaks
- **Identified Hazard:** High-impact headings in several templates interweave hardcoded HTML tags, such as:
  ```html
  <h1 class="bebas">WE PLAN IT.<br>WE BOOK IT.<br><span style="color:#E5383B;">WE RUN IT.</span></h1>
  ```
  and gradient clipping spans:
  ```html
  <span style="background:linear-gradient(180deg, #F4F5FA 0%, #A9C0F5 25%, #1E2B5E 65%, transparent 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">CRUX</span>
  ```
- **Architectural Risk:** Exposing raw HTML strings in text controls causes non-technical clients to accidentally delete closing tags (`</span>`, `</div>`), corrupting the entire DOM tree and breaking layouts.
- **Mitigation:**
  1. Split composite headings into distinct line settings (e.g. `crux_fp_hero_line1`, `crux_fp_hero_line2`, `crux_fp_hero_line3`).
  2. Retain stylistic span tags and color styling inside template markup while injecting sanitized plain text.
  3. Where rich text is mandatory, use `wp_kses_post` as the strict sanitization callback.

---

### 6.3 Phone Number Inconsistencies & Telephony Drift
- **Identified Hazard:** The audit uncovered three conflicting telephone numbers across templates:
  - Header Mobile Drawer Overlay: `+44 7448 614051`
  - Contact Page Events Sidebar: `+44 7762 278076`
  - Contact Page Consultancy Sidebar & FAQ: `+44 7341 366400`
- **Architectural Risk:** Calling the wrong number frustrates clients and misroutes leads between the Events and Consultancy teams.
- **Mitigation:**
  Establish three named phone settings in `crux_global_contact_section`:
  - `crux_company_phone_primary` (Primary general line for header/mobile drawer)
  - `crux_company_phone_events` (Dedicated line for event management briefs)
  - `crux_company_phone_consultancy` (Dedicated line for business advisory briefs)

---

### 6.4 Blob IDs vs. WordPress Media Library Attachments
- **Identified Hazard:** All existing static templates reference local image assets via a custom hash-lookup function:
  ```php
  <?php echo crux_get_blob_url( "5e2df00e7ead10292f7266fc033953c3" ); ?>
  ```
- **Architectural Risk:** The standard WordPress Customizer `WP_Customize_Image_Control` returns standard attachment IDs or uploaded image URLs (`/wp-content/uploads/2026/10/...`), not 32-character blob hashes.
- **Mitigation:**
  Create a unified URL resolver helper in `inc/customizer.php`:
  ```php
  function crux_get_customizer_image_url( $setting_id, $default_blob_id ) {
      $val = get_theme_mod( $setting_id );
      if ( ! empty( $val ) ) {
          return is_numeric( $val ) ? wp_get_attachment_image_url( $val, 'full' ) : esc_url( $val );
      }
      return function_exists( 'crux_get_blob_url' ) ? crux_get_blob_url( $default_blob_id ) : '';
  }
  ```
  This guarantees 100% backward compatibility with static blob imports while allowing immediate Customizer media uploads.

---

### 6.5 Static Hardcoded Mock Content vs. Core Post Queries
- **Identified Hazard:** `page-blog.php` and `single.php` currently contain static, hardcoded mock arrays (`$blog_catalog`) rather than executing standard WordPress `WP_Query` loops over the `post` post type.
- **Architectural Risk:** If Customizer settings are built to edit 6 individual mock cards, publishing actual WordPress posts will not update the archive, creating a confusing hybrid state.
- **Mitigation:**
  1. Provide Customizer controls for the archive header, intro narrative, and submission card.
  2. Recommend that the blog archive be upgraded to loop through core WordPress posts, using the hardcoded `$blog_catalog` as initial demo-content seed posts.

---

### 6.6 Dual-Wing Theme Contrast Collision
- **Identified Hazard:** The platform dynamically toggles between dark backgrounds (`#0A0F26`) and light backgrounds (`#FFFFFF`, `#F3F1FC`). For instance, `page-privacy-policy.php` uses a light background with dark typography and a light switcher pod, whereas `front-page.php` uses dark navy throughout.
- **Architectural Risk:** Global settings (like header navigation link colors or logo badges) could break contrast if forced uniformly across both wings.
- **Mitigation:**
  Maintain strict wing-specific CSS classes in templates (`crux-sw-pod--dark` vs `crux-sw-pod--light`, `header-switcher--light`) and avoid exposing generic background color pickers to the client.

---

### 6.7 Lists the Customizer cannot hold properly (added by Claude review)

The Customizer has no repeater control. The mapping works around that by exposing the first few items of each list as numbered settings. That is wrong for content the client will keep adding to:

- **FAQ:** `page-faq.php` contains 35 questions, but Section 4 exposes only "the top 6" per wing (12 in total). The other 23 would stay hardcoded and the client could never edit or add them. `page-consultancy.php` and `front-page.php` each carry 7 more questions, and the document says 9 for the consultancy page (the template has 7).
- **Sponsors, gallery items, journal posts, event services, team or stats lists:** the same problem.

Recommendation: keep the Customizer for single headings, paragraphs, links and images, and move repeating content to the WordPress admin like events already are, with small custom post types (for example `faq` with a "wing" taxonomy, `sponsor`, `gallery_item` which `crux-nxtion-core` already registers). The templates then loop over posts, the client adds or reorders items in a normal list screen, and the Customizer only holds the section headings. This also removes about 100 numbered settings from the plan.

---

## 7. NEXT STEPS (REVISED BY CLAUDE REVIEW)

Order matters. Each phase ends with the full test battery plus a before/after screenshot comparison at 1280px and 375px.

1. **Phase C0 - Extract the shared header, footer, pre-footer and CSS** (Section 0). No new features and no visible change. This is the largest risk in the whole Customizer job and it must be proven pixel-identical first.
2. **Phase C1 - Repeating content moves to the admin** (Section 6.7): `faq` (with a wing taxonomy, importing all 35 existing questions), `sponsor`, and reuse of `gallery_item`. Templates loop over posts.
3. **Phase C2 - Scaffold `cruxnxtion-theme/inc/customizer.php`** with the Global panel only (header, contact, pre-footer, footer; 35 settings), following `cr8v-stacks-events/inc/customizer.php`. Prove with a real browser that changing a setting changes all 24 pages.
4. **Phase C3 - Page panels, one page group at a time** (Events wing, Consultancy wing, Universal pages), replacing hardcoded strings with `get_theme_mod( 'crux_*', $default )` using the defaults documented here, so a site with no saved settings renders exactly as today.
5. **Phase C4 - Selective refresh (`postMessage`) live preview**, only after C3 is stable.
6. **Verification at every phase:** `test_repo_hygiene.php`, the five suites and the race tests; add a Customizer test that every `get_theme_mod` default equals the text in the template today (so the default site is unchanged).

Estimated scope for planning: about 374 settings before Section 6.7 reduces the repeating lists.

---

## 8. IMPLEMENTATION STATUS (Claude, 8 Oct 2026)

Built and proven (tests in `cr8v-event-ticketing/tests`, all passing; every page compared with a baseline snapshot):

| Phase | What | Where | Proof |
|---|---|---|---|
| C0a, C0b | One shared header (announcement bar, mega menu, mobile drawer) and one shared pre-footer + footer replace 23 and 22 copies. | `parts/site-header.php`, `parts/site-footer.php`, `inc/layout.php` | 23 headers and 22 footers match the old blocks; 24 pages match the baseline except three deliberate unifications (announcement bar class and padding, generic page announcement, contact footer wraps on mobile) |
| C1 | Site-wide settings: 38 fields in 6 sections (contact details, announcement bar, header buttons and menu card, two pre-footer bands, footer). | `inc/customizer.php` | `test_customizer.php`, 65 checks |
| C2 | The wording of 13 pages, 714 fields, one panel per page, one section per page region. | `inc/content/<page>.php`, generated by `tools/extract-page-text.py` | `test_customizer_content.php` |
| C3 | The photos of 11 pages, 119 media fields. | `inc/content/images/<page>.php`, generated by `tools/extract-page-images.py` | same test (56 checks in total) |

Differences from the first mapping in sections 3 and 4 above, and why:
- The mapping listed about 40 hand-picked settings per page. Because the templates are static HTML, every visible piece of wording was turned into a field instead (nothing is left uneditable by accident), grouped by the page's own region comments. Setting ids are `crux_c_<page>_<region>_<kind>_<n>`, not the `crux_fp_*` style names.
- Button and link ADDRESSES of plain text buttons are editable (21 fields, right after the button wording; start with / for a page on this site or paste a full https address; javascript: and data: links are refused). Buttons whose address is built by code (event links, in-page anchors) stay fixed. The booking link, e-mail, phones and social links are editable in the site-wide section.
- Also editable now: the privacy, terms and cookie pages, the 404, and the fixed wording of the single event and single post templates (19 pages in all). Their panels load from a page key the preview announces (`crux_current_page_key()`), since events and posts have no fixed address.
- Not editable: fonts, colours and layout (colours are hard-coded in thousands of inline styles, so making them editable would need a CSS-variable refactor first), anything with tickets, payments or staff, and the event details themselves (those live in the event editor). The logo and the call-to-action band background photo are editable in the site-wide panel.
- A field the client empties stays empty (a line can be hidden). Site-wide fields fall back to the original wording when emptied.
- Visual editing: hovering any marked piece of the page in the preview shows a pencil that opens its field (819 of 833 page fields and 18 site-wide ones). Plain text updates instantly while typing; formatted text and photos reload the preview. The markers print only inside the Customizer (`crux_edit_attr`), generated by `tools/mark-editable.py`.

Formatted headings and paragraphs: 24 of the 25 use a friendly syntax in the field (Enter = new line, `{{words}}` = the accent colour of the original design, `**bold**`, `_italic_`) instead of HTML; the field type is `styled` and is only used where the original markup converts back exactly (`crux_rich_round_trips`). One heading on the consultancy home page keeps an HTML field.

How to add or change fields:
1. A new editable piece of wording on an existing page: add the text in the template as `<?php echo crux_h( 'page', 'key' ); ?>` and a line in `inc/content/<page>.php` (region, label, type, original wording). Or run `tools/extract-page-text.py <template> <page-key> --write` on a template that has no fields yet (it refuses nothing, so run it only once per template).
2. A new page: add it to `crux_content_pages()` in `inc/customizer.php` and make its manifest file.
3. Run `test_customizer.php` and `test_customizer_content.php`; they fail if a field is not used, not registered, or does not change its page.

Not verified: how the Customizer feels in a real browser (its page loads for an administrator with all panels and no PHP warnings; the pane could not sign in), and the live client site.
