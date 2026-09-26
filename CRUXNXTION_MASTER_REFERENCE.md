# Crux Nxtion — Master Technical Reference & System Manual

> **Document Purpose**: Authoritative, persistent documentation of the entire Crux Nxtion website redesign, architecture, design system rules, surgical fixes, automation scripts, and deployment workflows. Reference this file in all future engineering sessions.

---

## 1. Project Overview & Dual-Brand Architecture

Crux Nxtion (`cruxnxtion.co.uk`) operates two distinct commercial wings unified under one digital platform:

```
                       ┌─────────────────────────┐
                       │       CRUX NXTION       │
                       │   (cruxnxtion.co.uk)    │
                       └────────────┬────────────┘
                                    │
           ┌────────────────────────┴────────────────────────┐
           ▼                                                 ▼
┌──────────────────────────────┐          ┌──────────────────────────────┐
│     CRUX NXTION EVENTS       │          │   CRUX NXTION CONSULTANCY    │
│       (Dark / "A1")          │          │        (Light / "A2a")       │
├──────────────────────────────┤          ├──────────────────────────────┤
│ • "We plan it. We book it.   │          │ • "Turning business ideas    │
│    We run it."               │          │    into businesses that      │
│ • Ink (#0A0F26), Blue        │          │    work."                    │
│   (#002671), Red (#BA0000)   │          │ • White (#FFFFFF), Tint      │
│ • 5 Event Services           │          │   (#F3F1FC), Purple (#8C7AE6)│
│ • 8 Real Events + Ticket     │          │ • 5 Business Services        │
│   Wall (Eventbrite links)    │          │ • Animated Chat Card, Bento  │
│ • Gallery & Past Archives    │          │   illustrations & Accordions │
└──────────────────────────────┘          └──────────────────────────────┘
                                    │
                                    ▼
       ┌────────────────────────────────────────────────────────┐
       │             SHARED PAGES & GLOBAL SHELL                │
       ├────────────────────────────────────────────────────────┤
       │ • Call-out bar + Slanted Capsule Switcher (in Header)  │
       │ • Services Mega-Menu (showing both wings)              │
       │ • About Us, Founder Story, FAQ (two-section accordion) │
       │ • Contact: ONE Unified Form (multi-select 10 services) │
       │ • Scalloped Spinning Rosette Pre-Footer + Dark Footer  │
       └────────────────────────────────────────────────────────┘
```

### Business Identity & Location
- **Company**: Crux Nxtion Ltd
- **Founder**: Olabamidele "Bambad" Badmos
- **Headquarters**: 29 Dun Work, Sheffield S3 8FB, United Kingdom
- **Phone Lines**: `+44 7762 278076` / `+44 7341 366400`
- **Email**: `infoandsales@cruxnxtion.co.uk`
- **Calendly Booking**: `https://calendly.com/cruxnxtiongroupofcompany-info` (Consultancy Discovery Calls)

---

## 2. Authoritative Design System & Tokens

### Color Palette (Locked — Never Add Arbitrary Colors)
- **Brand Blue (Events)**: `#002671`
- **Brand Red (Action / CTAs)**: `#BA0000` / `#D9182A`
- **Brand Purple (Consultancy)**: `#8C7AE6` (fills) / `#6C58DB` (text)
- **Dark Mode Surfaces (Events)**:
  - Canvas / Background: `#0A0F26`
  - Cards / Sections: `#111838`
  - Borders / Dividers: `#1E2B5E`
  - Body Text: `#F4F5FA`
  - Muted Text: `#A3A9C8`
  - Accent Tint: `#5B8DEF`
  - Hover Blue: `#1E48B0`
- **Light Mode Surfaces (Consultancy)**:
  - Canvas / Background: `#FFFFFF`
  - Cards / Soft Tint: `#F3F1FC`
  - Borders / Dividers: `#E1DEF3`
  - Ink Dark Text: `#10142E`
  - Muted Text: `#5A5F86`

### Typography Hierarchy
- **Headings & Titles**: `'Bebas Neue', 'Arial Narrow', sans-serif` (uppercase, tight line height `0.92` to `0.98`)
- **Body & Captions**: `'Space Grotesk', system-ui, -apple-system, sans-serif`
- **Eyebrows**: `11px`, letter-spacing `2px` to `3px`, uppercase, bold

### Button & Shape Architecture (Slanted Parallelogram UI)
Every button, tag, tab, and chip across both wings uses the signature slanted parallelogram cut:
```css
.bx {
  position: relative;
  clip-path: polygon(var(--sl, 10px) 0, 100% 0, calc(100% - var(--sl, 10px)) 100%, 0 100%);
  border: 0 !important;
  border-radius: 0 !important;
  --bw: 1.5px;
  text-align: center;
  transition: transform 0.2s ease, filter 0.2s ease;
  display: inline-block;
  cursor: pointer;
}
.bx::before {
  content: '';
  position: absolute;
  inset: 0;
  background: var(--bc, transparent);
  pointer-events: none;
  clip-path: polygon(
    evenodd,
    var(--sl, 10px) 0, 100% 0, calc(100% - var(--sl, 10px)) 100%, 0 100%,
    var(--sl, 10px) 0,
    calc(var(--sl, 10px) + var(--bw)) var(--bw),
    calc(100% - var(--bw)) var(--bw),
    calc(100% - var(--sl, 10px) - var(--bw)) calc(100% - var(--bw)),
    var(--bw) calc(100% - var(--bw)),
    calc(var(--sl, 10px) + var(--bw)) var(--bw),
    var(--sl, 10px) 0
  );
}
```

---

## 3. Surgical Fixes & Technical Implementations

### 1. Full-Bleed 100% Edge-to-Edge Layout (No Widescreen Pillarboxing)
- **Problem**: Locking `[data-m~=root]` with `max-width: 1440px; margin: 0 auto;` created blank voids on 1920px+ monitors and cut off the hero background image.
- **Solution**:
  - `[data-m~=root]` set to `width: 100% !important; max-width: 100% !important; margin: 0 !important; overflow-x: clip !important;`.
  - Content maintains generous desktop side breathing room (`padding: 0 64px` on desktop, collapsing to `20px` on mobile $\le$ 900px).
  - `overflow-x: clip !important;` prevents horizontal scrolling without breaking CSS `position: sticky`.

### 2. Segmented Capsule Header Switcher (Slanted UI)
- **Housing**: Slanted parallelogram capsule (`clip-path: polygon(6px 0, 100% 0, calc(100% - 6px) 100%, 0 100%)`).
  - Dark Mode: background `#111838`, border `1px solid #1E2B5E`.
  - Light Mode: background `#EDE9FE`, border `1px solid #D5CEFA`.
- **Active Tab**: Slanted `.bx` button (`--sl: 5px;`) with drop shadow:
  - Events: `background: #1E48B0; color: #FFFFFF;`
  - Consultancy: `background: #8C7AE6; color: #10142E;`
- **Inactive Tab**: Clean unboxed text link (`color: #A3A9C8` dark / `#5A5F86` light) that illuminates on hover.
- Replicated seamlessly across desktop header, mobile navigation drawer, and floating bottom switcher (`.msw`).

### 3. Pre-Footer Spinning Rosette Badge (Red Cap Style)
- Replaced hero audio equalizer bars with an authentic circular scalloped seal in the pre-footer CTA band.
- **Perimeter**: 20-wave mathematical cosine scallop (`r_base=88, amplitude=5.5`).
- **Seam Overlap Fix**: Text string previously wrapped around the 364px circle and overlapped (`LIVE EPLAN`). Fixed with:
  - Events: `• CRUX NXTION EVENTS • LIVE ENERGY`
  - Consultancy: `• CRUX NXTION • DISCOVERY CALL • STRATEGY`
  - Configured with `textLength="336"` and `lengthAdjust="spacing"` on `r=58` circle path for a permanent 28px separation gap.
- **Motion**: `animation: rc-spin 14s linear infinite;`, pausing on hover / scale 1.08.

### 4. Consultancy Mobile Hero & White Space Optimization
- **Problem**: Excess vertical space pushed content down on mobile, and the consultant photo cluttered mobile viewports.
- **Solution**:
  - Hero mobile padding tightened to `padding: 24px 20px 36px !important; min-height: 0 !important; gap: 28px !important;`.
  - Consultant photo (`[data-m~=hv-img]`) set to `display: none !important;` on screens $\le$ 900px.
  - Animated discovery call card (`[data-m~=hv-chat]`) and badge (`[data-m~=hv-badge]`, *"ACTION PLANS, NOT JUST IDEAS."*) housed inside a soft lilac container (`[data-m~=herovis]`: `background: linear-gradient(160deg, #F3F1FC, #E6E0FA); border-radius: 24px; padding: 64px 14px 16px;`).
  - Discovery call card styled with `background: rgba(16,20,46,0.96) !important; backdrop-filter: blur(16px);` for high contrast.

### 5. Scroll Fade-in Animation Timing (`.reveal`)
- Previous threshold took too long and triggered too deep in the viewport (`cover 28%`).
- **Desktop**: Triggers in the last 18% of the viewport:
  ```css
  @keyframes revealUp {
    from { opacity: 0; transform: translateY(22px); }
    to { opacity: 1; transform: none; }
  }
  @supports (animation-timeline: view()) {
    .reveal {
      animation: revealUp linear both;
      animation-timeline: view();
      animation-range: entry 0% cover 18%;
    }
  }
  ```
- **Mobile ($\le$ 900px)**: Accelerated to the last 12% of the viewport:
  ```css
  @supports (animation-timeline: view()) {
    .reveal {
      animation-range: entry 0% cover 12% !important;
    }
  }
  ```

### 6. Card 5 Photo Differentiation ("What We Do" Section)
- Cards 4 (*Growth & Scaling*) and 5 (*Event Advisory*) previously shared identical boardroom shoot images.
- Replaced Card 5 with high-resolution glass-walled strategy boardroom image `052d83d28ee851b93069420ea3c10f8f.jpg`.

### 7. Universal Copy Harmonization
- Purged all occurrences of "Book The Room".
- Replaced with:
  - Events: **"Plan An Event"** / **"Plan An Event →"**
  - Consultancy: **"Book Discovery Call"** / **"Talk Business Strategy →"**

---

## 4. WordPress Architecture & Safety Systems

### Media Library Automatic Importer (`cruxnxtion-theme/inc/media-importer.php`)
- **Problem**: Images dropped in theme directories display on the frontend but are invisible in `wp-admin/upload.php` because they lack database rows in `wp_posts`.
- **Solution**:
  - Automatically iterates all 187 photos, flyers, and logos on theme switch.
  - Programmatically imports them into `wp-content/uploads/` via `wp_insert_attachment()` and `wp_generate_attachment_metadata()`.
  - Automatically binds `site_icon` (Favicon) and `custom_logo` in the Customizer.
  - Admin button available at **WP Admin > Appearance > Sync Media Library**.
  - `crux_get_blob_url( $blob_id )` checks media library first, falling back to disk asset.

### 404 & 403 Zero-Error Protection Engine (`cruxnxtion-theme/inc/prevent-errors.php`)
- **301 Redirect Engine**: Automatically intercepts legacy URLs on `cruxnxtion.co.uk` and 301-redirects them:
  - `/services/`, `/our-services/`, `/event-services/`, `/what-we-do/` &rarr; `/services/`
  - `/consulting/`, `/business-consultancy/` &rarr; `/consultancy/`
  - `/consultancy-services/` &rarr; `/services-consultancy/`
  - `/our-events/`, `/event/` &rarr; `/events/`
  - `/contact-us/`, `/contactus/`, `/book/`, `/plan/`, `/plan-an-event/` &rarr; `/contact/`
  - `/faqs/`, `/frequently-asked-questions/` &rarr; `/faq/`
- **Virtual Fallback Router**: If a visitor or client visits any valid theme slug before the page has been created in WP Admin, intercepts 404 via `template_include` and renders the template with **HTTP 200 OK**.
- **Cache-Safe Nonces & Honeypot**: Contact forms don't fail with 403 Forbidden if page caching plugins (WP Rocket, LiteSpeed, Cloudflare) cache an expired nonce. Automated spam caught silently via `crux_hp`.
- **Auto-Flush Rewrites**: Permalinks flushed automatically on `after_switch_theme`.

### Inquiries & Lead Intake Plugin (`crux-nxtion-core`)
- Registers **Crux Inquiries** (`inquiry`) CPT in WP Admin.
- Dynamic parsing of 10 service chips (5 Event, 5 Consultancy).
- Tags each submission with wing badges (`[EVENTS]`, `[CONSULTANCY]`, `[BOTH]`) and status pills (`New`, `Contacted`, `Booked`, `Archived`).
- Dispatches HTML notifications to `infoandsales@cruxnxtion.co.uk` with full client brief and sends a branded receipt to the customer.
- **3-Tier Anti-Spam Defense**: Honeypot (`crux_hp`) silent success, time-gate submission defense (< 3s), and IP rate limiting (max 5 submissions per 10 minutes via transient `crux_sub_rate_` + md5(ip)). Exposed public emails protected with `antispambot()`.

---

## 5. Repository File Map

```
cruxnxtion-redesign/
├── CRUXNXTION_MASTER_REFERENCE.md   # THIS MASTER REFERENCE FILE
├── AGENTS.md                        # Quick instructions for coding agents
├── CLAUDE.md                        # Claude assistant context
├── HANDOFF.md                       # Original client design brief
├── README.md                        # Project readme
├── crux-nxtion-core/                # Companion Plugin
│   └── crux-nxtion-core.php         # Inquiries CPT, form AJAX, email routing
├── crux-nxtion-core.zip             # Distributable Core Plugin ZIP
├── cruxnxtion-theme/                # Complete WordPress Theme
│   ├── style.css                    # Master stylesheet with responsive engine
│   ├── functions.php                # Asset enqueues & setup
│   ├── front-page.php / index.php   # Events Home (Dark / A1)
│   ├── page-consultancy.php         # Consultancy Home (Light / A2a)
│   ├── page-services.php            # Events Services (5 story cards)
│   ├── page-services-consultancy.php# Consultancy Services (5 story cards)
│   ├── page-events.php              # Events Ticket Wall
│   ├── single-event.php             # Single Event Detail
│   ├── page-events-archive.php      # Past Events Archive
│   ├── page-gallery.php             # Photo Gallery
│   ├── page-about.php               # About Us
│   ├── page-founder.php             # Founder Story (Bambad)
│   ├── page-contact.php             # Unified 10-Service Contact Form
│   ├── page-faq.php                 # Dual FAQ Accordions
│   ├── page-sponsors.php            # Sponsors & Partners
│   ├── page-blog.php / home.php     # Journal
│   ├── single.php                   # Single Journal Post
│   ├── 404.php                      # Custom 404 Page
│   ├── screenshot.png               # WP Dashboard Theme Card
│   ├── inc/
│   │   ├── media-importer.php       # Media library sync routine
│   │   ├── demo-importer.php        # 8 events & pages DB seeder
│   │   └── prevent-errors.php       # 404/403 engine & 301 redirects
│   └── assets/
│       ├── images/                  # 107 optimized photos, logos, SVGs
│       └── js/
│           ├── support.js           # Design runtime
│           └── main.js              # AJAX brief submission
├── cruxnxtion-theme.zip             # Distributable Theme ZIP (13.30 MB - 61% slimmed)
└── design/
    ├── pages/                       # Canonical .dc.html source files
    ├── images/by-blob-id/           # Canonical raw images
    └── preview/                     # Self-contained live preview (port 3000)
```

---

## 6. Automation Scripts & CLI Commands

All build scripts are located in `<appDataDir>\brain\<conversation-id>\scratch\`:

| Script Name | Purpose |
| :--- | :--- |
| `apply_surgical_redesign_fixes.py` | Master compilation script: processes `.dc.html` files, injects responsive CSS, compiles accordions, handles copy replacement, and writes all 19 WP templates and preview files. |
| `generate_badges.py` | Mathematical SVG generator for the scalloped pre-footer spinning rosette badges with non-overlapping circular text path. |
| `lint_all_php.py` | Verifies syntax across all 27 theme/plugin PHP files with PHP 8.2 linter (`php -l`). |
| `package_zips.py` | Builds Unix-compliant (`0755`/`0644`) ZIPs (`cruxnxtion-theme.zip`, `crux-nxtion-core.zip`) and deploys to Downloads, Desktop, and LocalWP. |
| `verify_latest_fixes.py` | Automated assertion suite checking image hashes, opacity, animation ranges, and CSS rules. |

### Common CLI Operations

```powershell
# 1. Start live preview server on port 3000:
python -m http.server 3000 --directory "c:\Users\user\OneDrive\Documents\Dev-Playground\cruxnxtion-redesign\design\preview"

# 2. Re-compile all preview pages and theme templates:
python C:\Users\user\.gemini\antigravity\brain\e33cb1b4-e0f2-4f3d-bca6-5b7b9c27ee9f\scratch\apply_surgical_redesign_fixes.py

# 3. Lint all PHP files:
python C:\Users\user\.gemini\antigravity\brain\e33cb1b4-e0f2-4f3d-bca6-5b7b9c27ee9f\scratch\lint_all_php.py

# 4. Package and deploy ZIPs to Downloads, Desktop, and LocalWP:
python C:\Users\user\.gemini\antigravity\brain\e33cb1b4-e0f2-4f3d-bca6-5b7b9c27ee9f\scratch\package_zips.py
```

---

## 7. What's Next: Execution Roadmap

Here is the exact step-by-step roadmap to move from current state to final delivery and payment:

```
                  CURRENT STATUS: 100% COMPLETE & VERIFIED
                                    │
                                    ▼
       ┌────────────────────────────────────────────────────────┐
       │ STEP 1: PRESENTATION & CLIENT SIGN-OFF (GET PAID)      │
       ├────────────────────────────────────────────────────────┤
       │ • Open http://localhost:3000/ to walk the client       │
       │   through the dual-brand experience.                   │
       │ • Demonstrate desktop and mobile responsiveness.       │
       │ • Test the single contact form submission.             │
       │ • Request client approval and milestone payment.       │
       └────────────────────────────┬───────────────────────────┘
                                    │
                                    ▼
       ┌────────────────────────────────────────────────────────┐
       │ STEP 2: INSTALLATION ON PRODUCTION (cruxnxtion.co.uk)  │
       ├────────────────────────────────────────────────────────┤
       │ • Upload and activate `crux-nxtion-core.zip` in        │
       │   WP Admin > Plugins.                                  │
       │ • Upload and activate `cruxnxtion-theme.zip` in        │
       │   WP Admin > Appearance > Themes.                      │
       │ • Navigate to Appearance > Sync Media Library and run   │
       │   the 1-click media seeder.                            │
       └────────────────────────────┬───────────────────────────┘
                                    │
                                    ▼
       ┌────────────────────────────────────────────────────────┐
       │ STEP 3: FINAL PRODUCTION SANITY VERIFICATION           │
       ├────────────────────────────────────────────────────────┤
       │ • Submit a live test brief through /contact/ and       │
       │   verify lead shows up in WP Admin > Crux Inquiries.   │
       │ • Verify email arrives at infoandsales@...             │
       │ • Verify legacy URLs (/services/, /about-us/) redirect │
       │   cleanly with zero 404s.                              │
       └────────────────────────────────────────────────────────┘
```


---

## 8. Client Updates: Hero Dual Option, Retail Transformation & Team Authority

### 1. Events Hero Updates (`front-page.php` & `index.php`)
- **Eyebrow**: Updated to `CULTURAL LIVE EVENT PRODUCTION & BUSINESS CONSULTANCY`.
- **Top-Front Dual Wing Selector**: Positioned directly above `WE PLAN IT.` headline:
  - Active: `[ • Events Wing ]` (Red badge)
  - Alternate: `[ Business Consultancy → ]` (Interactive hover pill linked to `/consultancy/`).
- **Hero Description**:
  *Crux Nxtion Events & Consultancy plans, books, and executes the live gatherings people talk about for weeks, while delivering the strategic business solutions that scale the enterprises behind them — your singular crew from the first brief to the final execution.*
- **Hero CTAs**:
  - Primary: `Plan An Event →` (`/contact/?type=events`)
  - Secondary: `Explore Consultancy →` (`/consultancy/`)

### 2. Commercial Infrastructure Showcase (Before & After Retail Fitouts)
- Client provided two authentic fitout photographs:
  - `consultancy-retail-unit.jpg` (empty shell under renovation): Caption **"We find the retail shop/unit/office"**
  - `consultancy-retail-stocked.jpg` (completed, stocked store & bakery): Caption **"We build it/stock it/set up"**
- Integrated into:
  - `page-consultancy.php` Hero visual: As slantly floating cards (`--r:-3deg` and `--r:3.5deg`) alongside the consultant background photo and compact discovery chat.
  - `front-page.php` / `index.php` Consultancy fork ("GOT A BUSINESS BEHIND THE EVENT?"): As floating physical proof cards.
  - `page-founder.php` Pillar 02 ("Infrastructure & Setup"): Embedded as a real commercial execution feature.
- **Mobile Responsive Design**:
  - On screens <= 900px, cards display as a clean side-by-side (50% / 50%) "Before & After Transformation" pair with captions underneath, completely eliminating overlapping or vertical bloat.

### 3. Jollof Rice Imagery Elimination & "Why Us" Mobile Decluttering
- **Asset Purge**: Replaced the buffet jollof rice chafing dish photo (`c8b6670f9dac6a75357ccbce7f844cd1` and `deb078ab60ebeff4781926f148155e63`) across all 10 theme templates with high-end live event production photography (`c5afda4fc4e4d4b0682377d6eb272c90` - illuminated stage with host).
- Also purged the African stew pot photo (`1ebf529508af3e82c1e2c01b3a050fe1`) from the home page mini-about strip.
- **Mobile Why Us Collage Fix**: Upgraded `.why-us-collage` in `style.css` to a touch-friendly **horizontal snap scroller with peek** (`scroll-snap-type: x mandatory`). All 3 images coexist cleanly at full resolution, allowing swipe navigation without vertical stacking or layout collisions.

### 4. "About Crux Nxtion Events & Consultancy" & "Meet the Team"
- Renamed all "Meet the Founder" blocks to **About Crux Nxtion Events & Consultancy** / **Meet the Team**.
- **Leadership & Core Crew**: Dynamic operations led by **Olabamidele Badmos (Bambad)** backed by a dedicated team of **10 active core members and specialized staff**.
- **Event Legacy (70+ Cultural Milestones)**:
  1. *YAGI Awards & Black Award Events*
  2. *Gangs of Lagos: Wedding Story (Parts 1 & 2)*
  3. *YAGI Trade Fair*
  4. *Naija Food Carnival* (400+ guests)
  5. *Marketplace Festivals (Volumes 1 through 6)*
- **Global Business Consultancy (Since 2024)**:
  - Guided **143 registered companies across the UK**.
  - **5 Strategic Pillars**:
    1. From Blueprint to Reality
    2. Infrastructure & Setup
    3. Scaling & Advisory
    4. Specialized Visas & Immigration Pathways (Global Talent & Innovator visas)
    5. Go-to-Market Mastery
- Applied across `front-page.php`, `index.php`, `page-founder.php`, `page-about.php`, and `page-consultancy.php`.
