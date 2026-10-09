# Stripe hand-over: what to do, where to sign up, what we plug in

The ticketing plugin is finished and tested against Stripe's API shapes. The only thing missing is a Stripe account and its keys. Keys never go in the repo or in a chat; they go in `wp-config.php` on the server.

## 1. Whose account

The money must land in the **client's** business account (the UK client). Do not collect ticket money through a personal account of yours.

- **UK client:** signs up directly at https://dashboard.stripe.com/register (United Kingdom is a direct sign-up country). Needs business details, a UK bank account for payouts and identity verification. Currency: GBP.
- **If the account owner is in Nigeria:** Stripe's supported-countries page (https://stripe.com/global) lists Nigeria only as an "extended network" country that goes through Paystack, not direct Stripe sign-up. Do not try to open one with false details. Use the client's UK account, or Paystack for a Nigerian merchant (that needs a different payment module; ask before building).

## 2. How you get access without sharing the main login

1. Client opens Stripe Dashboard > Settings > Team and roles > **New member** and invites your e-mail with the **Developer** role (only what is needed). Never share the owner login or password.
2. Or the client sends you the **test** keys only, through a private channel, until go-live.

## 3. What to collect (test mode first)

| Item | Looks like | Goes in `wp-config.php` as |
|---|---|---|
| Secret key (test) | `sk_test_...` | `define( 'CRUX_STRIPE_SECRET_KEY', 'sk_test_...' );` |
| Webhook signing secret | `whsec_...` | `define( 'CRUX_STRIPE_WEBHOOK_SECRET', 'whsec_...' );` |

Publishable keys are not needed: the site uses Stripe-hosted Checkout.

## 4. Create the webhook (Dashboard > Developers > Webhooks > Add endpoint)

- URL: `https://<client-domain>/wp-json/cr8v-ticketing/v1/stripe-webhook`
- Events: `checkout.session.completed`, `checkout.session.async_payment_succeeded`, `checkout.session.async_payment_failed`, `checkout.session.expired`, `charge.refunded`, `charge.dispute.created`
- Copy the signing secret (`whsec_...`) into `CRUX_STRIPE_WEBHOOK_SECRET`.

## 5. Test, then go live

1. Buy a ticket with test card `4242 4242 4242 4242`, any future date, any CVC. Check: ticket e-mail with QR, order marked paid, ticket count reduced. Refund it in the dashboard and check the ticket is cancelled.
2. For local testing: `stripe listen --forward-to http://dev-playground.local/wp-json/cr8v-ticketing/v1/stripe-webhook` (Stripe CLI) prints a temporary `whsec_` secret.
3. Go live: client activates the account, then replace both constants with the **live** key (`sk_live_...`) and the live webhook's secret. Never leave live keys in a repo, a zip or a chat.

## 6. Before the first real sale

Real SMTP with SPF, DKIM and DMARC for the sending domain, HTTPS on the live site, two-factor sign-in for administrators, and the staff accounts for the door scanner.
