# Crux Nxtion Events — website redesign

Design prototypes for cruxnxtion.co.uk: Events (dark, logo blue/red/purple) and Business Consultancy (light, purple accent), with shared About, Contact, FAQ, Founder and legal pages.

- `design/pages/` — every page as a Claude Design canvas file (`*.dc.html`). `M_*` are the mobile versions; `_2` files continue long mobile pages. `canvas.json` holds the board layout.
- `design/images/by-blob-id/` — every image the pages use, named by the id the pages reference (`/_blob/<id>` becomes `<id>.jpg`).
- `design/images/crux-photos|live-site|stock|reference/` — the same and further source photos with readable names (Crux photos and flyers from the live site, partner images, Unsplash stock).
- `design/runtime/support.js` — the canvas runtime the pages load (`<script src="./support.js">`).
- `design/generators/` — the Node scripts that built the pages. Reference only: they depend on my original working folder (absolute paths, original prototypes) and will not run as-is.

Handing this to another developer or AI agent? Read HANDOFF.md first.

Notes: legal copy is a draft for solicitor review; founder facts (76+ events, "Oba of Events", Naija Food Carnival 400+ guests) need confirming.

## View the design on any machine

```
node design/preview.js
npx serve design/preview
```

Open http://localhost:3000. The script copies the pages, maps `/_blob/<id>` to the local images and adds the runtime. Mobile pages are 390px wide, so open them in a narrow window.
