# Huisstijl & Design System — Thinking Local

De volledige huisstijl is gedocumenteerd in de centrale design system repo:

**Repo:** `WorkingLocal/design-allthingslocal` (privé)
**Pad in repo:** `brands/thinking-local/`

## Wat staat er in de design system repo

| Bestand | Inhoud |
|---|---|
| `brands/thinking-local/tokens.css` | CSS custom properties: `--tl-primary`, `--tl-accent`, alle varianten |
| `brands/thinking-local/README.md` | Kleuroverzicht, status, verbonden platforms |
| `brands/thinking-local/content.md` | Volledige websitebriefing: positionering, diensten, paginastructuur |
| `brands/thinking-local/projectplan.md` | Volledig actieplan: merk, website, platform, klantprojecten |
| `brands/thinking-local/assets/` | Logo's (nog te ontwerpen) |
| `shared/base.css` | Gedeelde spacing, shadows, neutrale kleuren |
| `shared/typography.css` | Inter font stack, type scale |

## Kleuren (samenvatting)

| Token | Hex | Gebruik |
|---|---|---|
| `--tl-primary` | `#1A2E5A` | Primair — gedeeld navy, reeds live op AutoBA + BMS Portal |
| `--tl-accent` | `#F5B800` | Accent — CTA-knoppen, highlights |

Gedeeld basispalet over alle Local-initiatieven. Een eigen onderscheidende accentkleur voor Thinking Local is nog niet vastgelegd.

## Logo

Nog niet beschikbaar — zie `brands/thinking-local/README.md` voor de status.

## WordPress implementatie

Tokens implementeren als **WordPress Additional CSS** via WP-CLI.
Zie `docs/technisch.md` voor de Coolify/WP-CLI setup.
