# Crux Nxtion & Cr8v Stacks Ecosystem
## Universal Stripe Event Ticketing & Booking Engine — Master Architecture Specification

> **Document Status**: Authoritative Engineering Blueprint  
> **Target Sites**: Crux Nxtion (`cruxnxtion.co.uk`), Red Cap Entertainment, Black and White Crafts (BWC)  
> **Core Plugin**: `crux-nxtion-core` / `cr8v-events-core`  
> **Version**: 1.0.0  
> **Date**: October 2026  

---

## 1. Executive Summary & Purpose

This document provides the definitive architectural blueprint for implementing native event ticketing and payments via **Stripe** across the **Cr8v Stacks ecosystem**.

While initial development and rollout are focused on **Crux Nxtion**, the underlying architecture is engineered as a **universal, reusable multi-brand engine** that operates seamlessly across all three sibling platforms:
1. **Crux Nxtion** (`cruxnxtion-theme` / `crux-nxtion-core`) — High-end luxury club nights, wedding showcases, galas, and cultural festivals.
2. **Red Cap Entertainment** (`red-cap-entertainment`) — Concerts, entertainment productions, and nightlife.
3. **Black and White Crafts / Cr8v Stacks Events** (`cr8v-stacks-events`) — Creative workshops, curated design gatherings, and artisanal craft experiences.

### Why Third-Party Event Plugins Were Rejected
Off-the-shelf plugins (such as *The Events Calendar*, *WooCommerce Bookings*, or *Eventbrite Embeds*) were explicitly evaluated and rejected for the following technical and commercial reasons:
* **Destruction of Bespoke Design Systems**: Existing plugins force their own rigid markup, external stylesheets, and clunky grid layouts. This directly destroys Crux Nxtion's signature slanted parallelogram geometry (`.bx`, clip-path polygons), customized punch-notch ticket cards (`.ticket-stub`, `.tilt-ticket`), and the refined editorial aesthetic of Red Cap and BWC.
* **Severe Asset Bloat & Performance Degradation**: Heavy plugins load dozens of unneeded CSS/JS assets, jQuery dependencies, and bloated tables on every page load.
* **Loss of Commission & Control**: Third-party iframe embeds (like Eventbrite) siphon customer data, take 6–10% per-ticket commission, and create mobile iframe scrolling bugs.
* **The Solution**: A lightweight, dependency-free, headless-compatible **WordPress CPT + Meta Engine** coupled directly with **Stripe Hosted Checkout**.

---

## 2. Multi-Site Ecosystem & Shared DNA

All three websites share a common architectural heritage rooted in `cr8v-events-core`. The new ticketing engine unifies them through a backwards-compatible schema:

```
                      ┌──────────────────────────────────────────────┐
                      │    UNIVERSAL STRIPE TICKETING ENGINE        │
                      │        (cr8v-events-ticketing / core)        │
                      └──────────────────────┬───────────────────────┘
                                             │
         ┌───────────────────────────────────┼───────────────────────────────────┐
         ▼                                   ▼                                   ▼
┌─────────────────────────────┐ ┌─────────────────────────────┐ ┌─────────────────────────────┐
│         CRUX NXTION         │ │    RED CAP ENTERTAINMENT    │ │   BLACK AND WHITE CRAFTS    │
├─────────────────────────────┤ ├─────────────────────────────┤ ├─────────────────────────────┤
│ • Slanted UI (.bx)          │ │ • Bold Entertainment UI     │ │ • Warm Artisanal Editorial  │
│ • Dark Ink (#0A0F26)        │ │ • Red/White High Voltage    │ │ • Terracotta & Mono Typo    │
│ • Ticket Punch Stub         │ │ • Concert & Tour Staging    │ │ • Workshops & Exhibitions   │
│ • Dual-Wing (Events/Biz)    │ │ • Artist & Production Roster│ │ • Craft & Design Masterclass│
└─────────────────────────────┘ └─────────────────────────────┘ └─────────────────────────────┘
```

### Shared Database Field Mapping
To guarantee that the ticketing system works across all sites without breaking existing templates, custom post meta fields are registered with dual-compatibility bridges:

| Field Purpose | Primary Key (`Crux Nxtion`) | Shared / Legacy Key (`Red Cap` & `BWC`) | Data Type | Notes |
|---|---|---|---|---|
| **Event Date** | `_crux_event_date` | `_cr8v_event_date` | `YYYY-MM-DD` | Used for schedule filtering and `.ics` generation |
| **Event Time** | `_crux_event_time` | `_cr8v_event_time` | String | e.g. `10:00 PM — Late` |
| **Venue Name** | `_crux_event_venue` | `_cr8v_event_venue` | String | e.g. `29 Dun Work, Sheffield` |
| **Venue Address / City** | `_crux_event_location`| `_cr8v_event_location`| String | e.g. `Sheffield, United Kingdom` |
| **Total Capacity** | `_crux_event_capacity`| `_cr8v_event_capacity`| Integer | e.g. `350` |
| **Booking Mode** | `_crux_booking_mode` | `_cr8v_booking_mode` | String | `stripe_native`, `external_url`, `free_rsvp`, `sold_out`, `disabled` |
| **Ticket Tiers** | `_crux_ticket_tiers` | `_cr8v_ticket_tiers` | JSON Array | Array of tier objects (pricing, capacity, sold) |
| **Max Tickets / Order** | `_crux_max_per_order`| `_cr8v_max_per_order` | Integer | Default `10` (anti-scalping control) |

---

## 3. Data Architecture & Database Models

The engine introduces two core data structures within WordPress:

### 3.1. Event Custom Post Type (`event`)
The existing `event` CPT is extended with a dedicated **Ticket Management & Pricing Meta Box**:

#### Ticket Tiers Structure (Stored as JSON):
```json
[
  {
    "id": "tier_std",
    "name": "Standard Admission",
    "price": 25.00,
    "description": "General access to main arena & dance floor",
    "capacity": 200,
    "sold": 45,
    "is_active": true
  },
  {
    "id": "tier_vip",
    "name": "VIP Table (Includes Bottle Service)",
    "price": 120.00,
    "description": "Reserved booth on mezzanine + priority entry",
    "capacity": 15,
    "sold": 12,
    "is_active": true
  }
]
```

#### Event Pricing Scenarios Supported:
1. **Free Events (£0 / RSVP)**: Price set to `0.00`. Customers receive instant registration and a ticket pass without touching Stripe.
2. **Single Flat-Price Events**: One single tier (e.g. "Standard Entry — £15.00").
3. **Multi-Tier Events**: Unlimited tiers (e.g. Early Bird, General Admission, VIP Table, Backstage Access).
4. **External Redirect (Hybrid Fallback)**: If `booking_mode` is set to `external_url`, the theme displays the external Eventbrite / Skiddle link as before.

---

### 3.2. Order Custom Post Type (`event_order`)
A new private CPT (`event_order`) registers every transaction, modeled on the existing high-converting **Crux Inquiries** dashboard:

#### Order Metadata Schema:
* `_order_event_id`: Post ID of the associated `event`.
* `_order_customer_name`: Primary contact full name.
* `_order_customer_email`: Billing email address.
* `_order_customer_phone`: Contact telephone number.
* `_order_items`: JSON array of tiers purchased and quantities:
  ```json
  [
    { "tier_id": "tier_std", "tier_name": "Standard Admission", "qty": 2, "unit_price": 25.00, "subtotal": 50.00 }
  ]
  ```
* `_order_currency`: `GBP` (default).
* `_order_subtotal`: e.g. `50.00`.
* `_order_total`: Total amount charged (e.g. `50.00`).
* `_order_stripe_session_id`: `cs_live_...` or `cs_test_...`.
* `_order_stripe_payment_intent`: `pi_...`.
* `_order_status`: `Pending`, `Paid`, `Refunded`, `Failed`, `Cancelled`.
* `_order_ticket_token`: Unique cryptographic hash (e.g. `CRUX-DANCE-8F92A-4B`).
* `_order_checkin_status`: `0` (Unchecked) or `1` (Checked In).
* `_order_checkin_timestamp`: Date and time ticket was validated at the door.

---

## 4. Stripe Integration & Payment Flow

### 4.1. Integration Methodology: Stripe Hosted Checkout
We utilize **Stripe Hosted Checkout** via the server-side Sessions API (`stripe.checkout.sessions.create`).

```
Customer on single-event.php
         │
         ▼
Clicks "Reserve Your Spot" ──► Slanted .bx Ticket Modal opens
         │
         ▼
Selects Quantities (e.g. 2x Standard) + enters Name & Email
         │
         ▼
AJAX: POST /wp-admin/admin-ajax.php (action: crux_create_checkout_session)
         │
         ├─► Validates live stock / capacity
         ├─► Creates draft `event_order` with status `Pending`
         └─► Calls Stripe API: /v1/checkout/sessions
                     │
                     ▼
             Stripe returns session URL
                     │
                     ▼
Frontend redirects customer to Stripe Hosted Checkout
                     │
   ┌─────────────────┴─────────────────┐
   ▼                                   ▼
[Payment Completed]             [Payment Cancelled]
   │                                   │
   ├─► Stripe Webhook fires             └─► User redirected back to event page
   │   (orders marked Paid)                 (Order remains pending / expires)
   │
   └─► User redirected to
       /booking-confirmation/?session_id=...
```

### 4.2. Why Stripe Hosted Checkout is Superior
1. **Zero PCI DSS Burden (SAQ-A)**: Payment credentials (card numbers, CVC, expiry) are entered strictly within Stripe’s certified secure environment. Crux Nxtion servers never touch or store sensitive financial data.
2. **Native 1-Tap Wallets**: Out-of-the-box support for **Apple Pay**, **Google Pay**, **Link**, **Revolut Pay**, and major UK credit/debit cards without writing complex custom JavaScript integrations.
3. **Automatic Strong Customer Authentication (SCA / 3D Secure)**: Fully compliant with UK and European banking regulations.
4. **Custom Branding**: Fully customized with Crux Nxtion branding (Logo, dark ink background `#0A0F26`, blue primary `#002671`, and red accent `#BA0000`).

---

## 5. Webhook Security & Real-Time Fulfillment

Relying solely on the browser redirect after checkout is insecure (customers may close their mobile browser before the redirect finishes). **Stripe Webhooks guarantee 100% order capture**.

### 5.1. Secure Webhook Endpoint
* **Route**: `POST /wp-json/crux/v1/stripe-webhook` (or `/wp-json/cr8v/v1/stripe-webhook`).
* **Cryptographic Signature Verification**: Every incoming webhook payload is validated against the `HTTP_STRIPE_SIGNATURE` header using the configured `whsec_...` signing secret. Requests failing signature verification are immediately rejected with HTTP `400 Bad Request`.

### 5.2. Webhook Event Processing
* **`checkout.session.completed`**:
  1. Retrieves the corresponding `event_order` using `client_reference_id` or `session_id`.
  2. Updates order status from `Pending` to `Paid`.
  3. Deducts ticket quantities from the event tier’s remaining capacity.
  4. Generates the attendee's unique digital ticket token and QR code.
  5. Dispatches the automated customer confirmation email (with digital ticket and calendar `.ics` file).
  6. Sends internal admin notification to `infoandsales@cruxnxtion.co.uk`.
* **`charge.refunded`**:
  1. Locates order by `payment_intent_id`.
  2. Updates order status to `Refunded`.
  3. Optionally restores ticket inventory back to the event.
* **`payment_intent.payment_failed`**:
  1. Marks order as `Failed`.

---

## 6. Viability, Feasibility & Operational Edge Cases

### 6.1. Confirmation Emails (Feasibility: 100% — Standard WP Core)
* **How it works**: Delivered via WordPress’s native `wp_mail()` function, formatted with Crux Nxtion’s editorial HTML email template.
* **Email Contents**:
  * Crux Nxtion branded header.
  * Event details: Name, Date, Doors Open Time, Venue Address, Dress Code.
  * Order breakdown: Tiers purchased, quantities, total amount paid in GBP (`£`).
  * Scannable digital ticket card with unique verification token.
  * Direct attachment: Calendar invite (`event.ics`) allowing 1-click import into Apple Calendar, Google Calendar, and Outlook.
* **Reliability Note**: For production delivery, SMTP routing (e.g. Postmark, SendGrid, or Brevo) is recommended over server-native `mail()` to prevent emails landing in junk folders.

---

### 6.2. QR Codes (Feasibility: 100% — Zero Hardware Required)
* **Misconception**: Many assume QR code ticketing requires expensive commercial laser scanners or specialized hardware.
* **The Reality**:
  * **QR Code Generation**: The server generates a clean, standalone QR code image (using a lightweight inline PHP SVG renderer or fast image generator). No heavy external libraries required.
  * **The Encoded Data**: The QR code encodes a secure verification URL:  
    `https://cruxnxtion.co.uk/gate-checkin/?token=CRUX-DANCE-8F92A&key=ab91f...`
  * **Door Staff Scanning**: Door staff simply point **any standard smartphone camera** (iPhone Camera app or Android Camera) at the attendee's phone screen or printed paper ticket.
  * **Instant Verification**: Tapping the scanned link opens a secured mobile verification screen that displays:
    * ✅ **VALID TICKET**: Green banner showing Attendee Name, Event Name, Tier (e.g. "VIP — 2 Guests"), and marks the ticket as **CHECKED IN**.
    * ⚠️ **ALREADY USED**: Red warning banner showing the exact time the ticket was previously checked in, preventing ticket duplication or sharing.
    * ❌ **INVALID TICKET**: Alert indicating the ticket does not exist or was refunded.

---

### 6.3. Door Check-In & Gate Control (Feasibility: 100% — Two Operational Modes)
We provide two straightforward check-in methods so event staff can choose what suits their venue:

1. **Digital Mobile Check-in (Interactive)**:
   * Event staff log into a secure, mobile-friendly check-in screen (`/event-door-roster/?event_id=123`).
   * Staff can either scan QR codes or type the attendee's surname in a search bar.
   * Tapping "Check In" instantly updates the database in real-time.
2. **Offline Printable Roster (Zero-Tech Fallback)**:
   * Inside the WordPress Admin, the event manager clicks **"Export Door Roster (CSV / Print)"**.
   * Prints an alphabetical guest list with ticket counts and check-off boxes for on-site clipboard security.

---

### 6.4. Pricing & Ticket Limits (Feasibility: 100%)
* **Minimum Purchase**: 1 ticket.
* **Maximum Purchase per Order**: Configurable per event (default: **10 tickets**). This prevents ticket hoarding and card testing bots.
* **Inventory Race Condition Protection**:
  * When a user clicks "Proceed to Checkout", the server checks available stock.
  * If stock is sufficient, the ticket quantity is temporarily reserved while the Stripe session is active.
  * If the session expires without payment, the reserved stock is released.

---

### 6.5. Refunds Handling (Feasibility: 100%)
* **Stripe-First Management**: The client can issue refunds directly within their Stripe Dashboard with one click.
* When a refund is processed in Stripe, the webhook automatically receives `charge.refunded` and updates the WordPress order status to `Refunded` without requiring any manual database editing.
* **Admin-Side Refund Action**: We also provide a "Process Refund via Stripe" button directly on the WordPress `event_order` screen for convenient single-dashboard management.

---

## 7. WordPress Admin Management & Settings

### 7.1. Stripe Gateway Settings Screen
Located under **Crux Events → Stripe Settings**:
* **Environment**: Toggle between `Test Mode (Sandbox)` and `Live Mode`.
* **API Credentials**:
  * `Publishable Key` (`pk_test_...` / `pk_live_...`)
  * `Secret Key` (`sk_test_...` / `sk_live_...`)
  * `Webhook Secret` (`whsec_...`)
* **Default Currency**: `GBP (£)` (with options for EUR, USD).
* **Statement Descriptor**: `CRUX NXTION EVENTS` (appears on customer bank statements).

### 7.2. Event Order Dashboard
Located under **Crux Events → Ticket Orders**:
* Displays all purchases with columns: Order ID, Attendee Name, Event, Tier Breakdown, Total Amount, Stripe Session ID, Payment Status, and Door Check-In Status.
* Status pills styled identically to Crux Inquiries:
  * 🟢 `Paid`
  * 🟡 `Pending`
  * 🔴 `Refunded` / `Failed`
* Filter orders by Event or Payment Status.
* **One-Click CSV Export**: Exports full attendee roster for security and door staff.

---

## 8. Frontend User Experience (Crux Slanted UI)

The frontend experience on [`single-event.php`](file:///c:/Users/user/OneDrive/Documents/Dev-Playground/cruxnxtion-redesign/cruxnxtion-theme/single-event.php) preserves 100% of Crux Nxtion's custom aesthetic:

1. **CTA Button**:
   * Slanted parallelogram button (`.bx`, clip-path polygon, red `#BA0000` background).
   * Displays "Reserve Your Spot" or "Get Tickets" with ticket price badge (e.g. "From £25").
2. **Slanted Booking Modal Overlay**:
   * Dark luxury ink background (`#111838`) with deep blue borders (`#1E2B5E`).
   * **Ticket Tier Cards**:
     * Tier title, description, and price.
     * Accessible `[-]` and `[+]` quantity incrementers.
     * Dynamic line-item price calculation.
   * **Buyer Dossier**:
     * Name, Email, Telephone.
   * **Order Summary**:
     * Subtotal, VAT / booking fee (if applicable), and total in GBP (`£`).
   * **Checkout Trigger**:
     * Slanted button: `"Proceed to Secure Payment →"`.
3. **Dedicated Confirmation Page (`/booking-confirmation/`)**:
   * Renders the confirmed ticket using the signature `.tilt-ticket` component:
     * Punched notch stub (`.ticket-stub`).
     * Real-time scannable QR Code.
     * Buttons: `"🖶 Print Ticket"` and `"📅 Add to Calendar (.ics)"`.

---

## 9. Phased Implementation Roadmap

```mermaid
flowchart TD
    subgraph Phase 1: Core Architecture & Data Models
        A1[Register event_order CPT] --> A2[Build Ticket Tiers Meta Box on event]
        A2 --> A3[Build Stripe Settings Admin Page]
    end

    subgraph Phase 2: Stripe Engine & Webhook Infrastructure
        B1[Implement Native Stripe REST Client] --> B2[Create Webhook Listener /wp-json/crux/v1/stripe-webhook]
        B2 --> B3[Implement Cryptographic Signature Check]
    end

    subgraph Phase 3: Frontend Slanted UI & Checkout Flow
        C1[Build Slanted Ticket Modal in single-event.php] --> C2[Implement AJAX Session Creation]
        C2 --> C3[Handle Stripe Redirect & Cancel Return]
    end

    subgraph Phase 4: Post-Payment Fulfillment & Gate Control
        D1[Generate SVG QR Code & Token] --> D2[Build page-booking-confirmation.php]
        D2 --> D3[Automate HTML Email Ticket & .ics Calendar Dispatch]
    end

    subgraph Phase 5: Operations, Multi-Site Deployment & Testing
        E1[Build Mobile Door Gate Verification Screen] --> E2[Test Round-Trip Payment in Sandbox]
        E2 --> E3[Package Shared Module for Red Cap & BWC]
    end

    Phase 1 --> Phase 2 --> Phase 3 --> Phase 4 --> Phase 5
```

---

## 10. Summary of Architectural Decisions

| Decision Area | Technical Choice | Strategic Rationale |
|---|---|---|
| **Payment Gateway** | Stripe Hosted Checkout | Zero PCI burden, native Apple/Google Pay, SCA compliant, highest mobile conversion |
| **Payment Currency** | British Pound (`GBP - £`) | Client and events are based in Sheffield / UK |
| **Plugin Strategy** | Bespoke CPT + Meta Engine | Protects unique slanted `.bx` UI, zero asset bloat, 100% theme integration |
| **Ticket Tiers** | Multi-Tier JSON Schema | Easily handles Free (£0), Flat Price, and Multi-Tier (VIP/Tables) without schema changes |
| **QR Code Verification** | Smartphone Camera Link | Zero hardware cost; works on any staff phone with real-time duplication protection |
| **Multi-Site Scope** | Universal Meta Schema | Reusable across Crux Nxtion, Red Cap Entertainment, and Black and White Crafts |
| **Order Tracking** | Dedicated `event_order` CPT | Provides persistent audit trail, CSV export, and check-in management in WP Admin |

---
*Crux Nxtion — Technical Architecture Manual*  
*Document persistent at: `cruxnxtion-redesign/STRIPE_EVENT_TICKETING_ARCHITECTURE.md`*
