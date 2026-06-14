# Thinking Local — Persoonlijk merk & portfolio

**URL:** https://thinkinglocal.be (in opbouw) | https://wordpress.thinkinglocal.be (VPS — ontwikkelomgeving)

Thinking Local is een persoonlijk platform voor projecten, experimenten en inzichten — van homelab en AI tot BI en strategische reflecties. Deze repo bevat de WordPress-website en de volledige infrastructuurconfiguratie om die website te draaien op de eigen VPS.

---

## Hoe is de website technisch opgebouwd?

De website draait op **WordPress** met **Elementor** als page builder, via **Coolify** op VPS-WORKINGLOCAL.

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
| **AutoBA** | autoba.thinkinglocal.be | AI-gestuurde projectopvolging |
| **Gitea** | gitea.thinkinglocal.be | Self-hosted git repositories |
| **BookStack** | docs.thinkinglocal.be | Kennisbank en documentatie |

---

## Huisstijl

Volledige huisstijldocumentatie, logo's en tokens: zie repo `design-allthingslocal` → `brands/thinking-local/`
Lokale samenvatting: `docs/design-system.md`

---

## Repository structuur

```
wordpress-thinkinglocal/
├── docker-compose.yml              # WordPress + MariaDB definitie voor Coolify
├── .env.template                   # Environment variabelen sjabloon
├── .github/
│   └── workflows/
│       └── deploy.yml              # Automatische SSH-deploy bij push naar master
└── docs/
    ├── technisch.md                # Volledig herinrichtingshandboek
    └── howto.md                    # Veelgebruikte handelingen stap voor stap
```

---

## Infrastructuur in één oogopslag

```
Internet → Cloudflare DNS (proxy UIT) → VPS 23.94.220.181
  → Coolify (Traefik/Caddy) met automatisch SSL
    → Docker: wordpress container (Apache + PHP 8.x)
      → Docker: db container (MariaDB LTS)
        → Volume: wordpress_data (/var/www/html)
        → Volume: db_data (/var/lib/mysql)
```

Voor het volledige herinrichtingsplan, zie [docs/technisch.md](docs/technisch.md).
