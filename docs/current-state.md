# thinkinglocal.be — huidige staat (inventaris 2026-06-30)

## Hosting

| | Status |
|---|---|
| **Cloudflare zone** | ✅ Actief — nameservers (alfred + cruz) en root A-record wijzen al naar Cloudflare |
| **Root domein (thinkinglocal.be)** | ❌ Geen origin gekoppeld — geeft `521` (Cloudflare kan geen origin bereiken) |
| **wordpress.thinkinglocal.be (VPS)** | ⏳ Nog te deployen — repo + docker-compose.yml klaar |
| **Hostinger** | Niet van toepassing — bewust niet gebruikt, zie onderstaande beslissing |

## Beslissing hosting (2026-06-30)

Eerdere documentatie (`projectplan.md` in design-allthingslocal) ging uit van Hostinger als productieplatform. Dat is **bijgesteld**: thinkinglocal.be wordt net als workinglocal.be en hostinglocal.be rechtstreeks op de **VPS via Coolify** gebouwd. Hostinger wordt voor de andere Local-sites net afgebouwd (abonnement verloopt 2026-11-04, niet verlengen) — een nieuwe site daar nog opzetten zou tegenstrijdig zijn.

## Live platforms op thinkinglocal.be (al werkend, los van de website)

- `bms.thinkinglocal.be` — BMS Portal ✅
- `autoba.thinkinglocal.be` — AutoBA platform ✅ (sign-in pagina laadt correct)
- `autoba-agent.thinkinglocal.be` — AutoBA Agent ✅ (nginx resolver-bug gefixed 2026-06-30, zie autoba-thinkinglocal repo)

## Wat de site moet worden

**thinkinglocal.be** is de publieke website van **Thinking Local** — het BA-consultancy & platform-merk achter AutoBA. Doelgroep: bedrijven die een BA-traject willen opstarten en organisaties die zelfbedieningsportalen zoals BMS Portal willen.

Zie `design-allthingslocal/brands/thinking-local/content.md` voor de volledige positionering en paginastructuur.

## Volgende stappen

1. Coolify: New Resource → Docker Compose → plak `docker-compose.yml`
2. Domein instellen: `https://wordpress.thinkinglocal.be`
3. Basissite opbouwen (geen import — nieuwe content, zie content.md)
4. Huisstijl CSS injecteren (na logo-ontwerp, zie design-allthingslocal/brands/thinking-local/)
5. Wanneer klaar voor productie: root-domein A-record naar de VPS wijzen
