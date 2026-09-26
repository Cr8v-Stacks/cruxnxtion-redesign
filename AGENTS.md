# Instructions for AI coding agents

Start with `CRUXNXTION_MASTER_REFERENCE.md` and `HANDOFF.md`.
`CRUXNXTION_MASTER_REFERENCE.md` is the complete engineering reference containing the full dual-brand architecture, design system rules, surgical fixes, responsive rules, 404/403 safety systems, and build commands.

Ground rules
- The files in `design/pages/` are the approved visual spec. Do not redesign; reproduce them faithfully and ask the owner about anything genuinely undecided.
- Colours come from the logo (blue #002671, red #BA0000) plus the purple #8C7AE6 used for Consultancy. Do not add colours.
- One button shape everywhere (slanted parallelogram). See "Buttons" in HANDOFF.md.
- Do not present unconfirmed content (see HANDOFF.md section 6) as fact on the live site.
- Preview the design with `node design/preview.js && npx serve design/preview`.
