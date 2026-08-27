# Gaps, blockers, and inferred decisions

Hard rule 6: report gaps, do not fill them.

---

## B1 — BLOCKER: no Figma MCP tools available in this session

Phase 0 step 3 (verify connectivity) cannot pass. Diagnosis, from local inspection only:

1. A `figma` MCP server **is** configured, at user/global scope in `~/.claude.json`:
   `npx -y figma-developer-mcp --stdio` (Framelink), with `FIGMA_API_KEY` set.
   A process for it is running (PID 15460) — but **its tools are not exposed to this
   session**; no `mcp__figma__*` tool appears in the tool list. Only `code-review-graph`
   and `context7` MCP tools are available here.

2. **Tool-name mismatch, independent of (1).** The installed package is
   `figma-developer-mcp@0.13.2`, which registers exactly two tools:
   `get_figma_data` and `download_figma_images`.
   The mission mandates `get_metadata`, `get_design_context`, `get_screenshot`,
   `get_variable_defs`, `download_assets` — these belong to the **official Figma Dev Mode
   MCP server**, a different product. So even after fixing (1), the mission's tool calls
   would still not resolve.

3. The official Dev Mode server is **not running**: nothing is listening on
   `127.0.0.1:3845`, and there is no Figma desktop process. It requires the Figma desktop
   app open with Dev Mode MCP enabled (Figma menu → Preferences → Enable Dev Mode MCP
   server), and a Dev/Full seat on a paid plan.

4. Corroboration that it *was* available before: `docs/FIGMA-AUDIT.md` records
   "Audited via: Figma MCP connector (Dev Mode)", and `CLAUDE.md` cites `get_motion_context`
   results — both official-server capabilities. The environment has changed since.

5. The REST API key could not be tested: the outbound `api.figma.com` call was denied by the
   session's auto-mode permission classifier. So "is the key valid / does it reach this
   file" is **untested**, not "failing".

**Consequence:** Phases 1–5 are all gated on live reads. Hard rule 1 forbids writing style
values from memory or screenshots, so no implementation work can legitimately start.

---

## B2 — BLOCKER: the mission targets a different Figma file than this repo was built from

| | Figma file key | Name |
|---|---|---|
| Mission brief | `v1l4ANft5Wtb8wPThyP7P9` | SizdahMarketing |
| This repository | `HuuGewZFHRm2ekVUFPDQhR` | SahraMarketing (`docs/FIGMA-AUDIT.md`) |

Different files. Compounding facts:

- Per `CLAUDE.md`, this repo's frontend is **already complete**: every route has its
  component, all pages reconciled against the canonical LTR frames in `FIGMA-AUDIT.md` §4,
  the full §6 motion inventory implemented, fonts self-hosted, tokens extracted 1:1 from
  Figma variables. 10 page components exist under `resources/js/Pages/`.
- The mission's root node `0:1` is worth flagging: in the *Sahra* file, `0:1` is the page
  "Wirefarming", which `FIGMA-AUDIT.md` marks **ARCHIVED** — low-fidelity wireframes with
  Lorem Ipsum and no bound variables — and explicitly says earlier work built against `0:1`
  was superseded by page `1:2`. This is a different file so it is not the same page, but
  "start at `0:1`" was exactly the wrong call last time in this project, and is worth
  confirming rather than assuming.

**Consequence:** executing the brief as written means rebuilding a finished trilingual
production site against a different design. That is a scope decision only the user can make.

---

## Inferred / derived decisions

(none yet — no design has been read)
