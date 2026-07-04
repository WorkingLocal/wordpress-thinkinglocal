# Thinking Local — Website

**URL:** https://thinkinglocal.be (in opbouw — VPS via Coolify)

Thinking Local is het BA-consultancy & platform-merk: strategisch denken, technologie en business analyse, gebundeld in het zelfgehoste AutoBA-platform en toegepast in actieve klantprojecten (zoals BMS Digital Foundations). Deze repo bevat de WordPress-website en de volledige infrastructuurconfiguratie om die website te draaien op de eigen VPS.

---

## Wat staat er op deze website?

De website is het centrale communicatiepunt van Thinking Local. Bezoekers vinden er uitleg over het AutoBA-platform, de aanpak, klantcases en een contactmogelijkheid.

### Inhoud (zie `design-allthingslocal/brands/thinking-local/content.md` voor de volledige briefing)

| Pagina | Wat het is |
|---|---|
| Platform (AutoBA) | Het BA-platform — kernproduct |
| AI Agent | RAG-gebaseerde AI-ondersteuning |
| BMS Portal | Klantspecifiek Power BI service-portaal |
| Klantcases | BMS Digital Foundations en toekomstige cases |
| Diensten | Consulting / BI |

---

## Hoe is de website technisch opgebouwd?

De website draait op **WordPress** met **Elementor** als page builder, via **Coolify** op de eigen VPS — zelfde patroon als `wordpress.workinglocal.be` en `wordpress.hostinglocal.be`.

---

## Hoe worden wijzigingen gepubliceerd?

**Inhoud** (teksten, afbeeldingen) → direct via het WordPress-dashboard op https://wordpress.thinkinglocal.be/wp-admin

**Bestandswijzigingen** → via Git push naar `master`:

```
git push origin master
  → GitHub Actions verbindt via SSH met de VPS
  → Haalt de nieuwste bestanden op in de container
  → Leegt Elementor-CSS-cache en object cache
  → Klaar
```

---

## Verbonden platforms

| Platform | Domein | Rol |
|---|---|---|
| **AutoBA** | autoba.thinkinglocal.be | BA-platform — kernproduct |
| **AutoBA Agent** | autoba-agent.thinkinglocal.be | AI-ondersteuning (RAG) |
| **BMS Portal** | bms.thinkinglocal.be | Klantspecifiek Power BI service-portaal (BMS Digital Foundations) |

---

## Huisstijl

Volledige huisstijldocumentatie, logo's en tokens: zie repo `WorkingLocal/design-allthingslocal` → `brands/thinking-local/`
Lokale samenvatting: `docs/design-system.md`

Kleuren: `#1A2E5A` (marineblauw) + `#F5B800` (geel) — gedeeld over alle Local-initiatieven.

---

## Repository structuur

```
wordpress-thinkinglocal/
├── docker-compose.yml              # WordPress + MariaDB definitie voor Coolify
├── .env.template                   # Environment variabelen sjabloon
├── .github/
│   └── workflows/
│       └── deploy.yml              # Automatische SSH-deploy bij push naar master
├── wp-content/
│   └── mu-plugins/
│       └── thinking-local.php      # Huisstijl: SVG-logo (placeholder), CSS tokens, JS scroll
└── docs/
    ├── current-state.md            # Huidige staat van domein/hosting (inventaris)
    ├── design-system.md            # Verwijzing naar centrale huisstijl-repo
    ├── technisch.md                # Volledig herinrichtingshandboek
    └── howto.md                    # Veelgebruikte handelingen stap voor stap
```

---

## Infrastructuur in één oogopslag

```
Internet → Cloudflare DNS (zone actief, proxy UIT voor wordpress.thinkinglocal.be) → VPS
  → Coolify (Traefik/Caddy) met automatisch SSL
    → Docker: wordpress container (Apache + PHP 8.x)
      → Docker: db container (MariaDB LTS)
        → Volume: wordpress_data (/var/www/html)
        → Volume: db_data (/var/lib/mysql)
```

Voor het volledige herinrichtingsplan, zie [docs/technisch.md](docs/technisch.md).
Voor de huidige staat (wat al klaar is, wat nog moet), zie [docs/current-state.md](docs/current-state.md).
