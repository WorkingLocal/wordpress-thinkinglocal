# Technisch herinrichtingshandboek — WordPress Thinking Local

Dit document is het complete handboek om de Thinking Local WordPress-site van nul te heropbouwen op een nieuwe machine, of om de bestaande omgeving te beheren.

---

## 1. Overzicht van de omgeving

| Parameter | Waarde |
|---|---|
| **Productiesite** | https://thinkinglocal.be |
| **VPS-site** | https://wordpress.thinkinglocal.be |
| **VPS IP** | `23.94.220.181` |
| **WordPress versie** | Meest recente |
| **Page builder** | Elementor |
| **Database** | MariaDB LTS |

---

## 2. Stap 1: Cloudflare instellen

`thinkinglocal.be` moet eerst als zone worden toegevoegd aan Cloudflare (domein is geregistreerd maar nameservers nog niet overgezet).

### 2a. Zone toevoegen in Cloudflare
1. Ga naar [dash.cloudflare.com](https://dash.cloudflare.com) → **Add a Site**
2. Voer `thinkinglocal.be` in → kies **Free plan**
3. Cloudflare scant bestaande DNS-records
4. Noteer de twee Cloudflare nameservers (bv. `ada.ns.cloudflare.com`)

### 2b. Nameservers updaten bij registrar
Ga naar je domeinregistrar (waar thinkinglocal.be geregistreerd staat) en vervang de nameservers door die van Cloudflare.
Propagatie duurt 0–24 uur (meestal <1 uur).

### 2c. A-records toevoegen in Cloudflare
```
Type:  A
Name:  @
Value: 23.94.220.181
Proxy: UIT (grijs wolkje)

Type:  A
Name:  www
Value: 23.94.220.181
Proxy: UIT (grijs wolkje)

Type:  A
Name:  wordpress
Value: 23.94.220.181
Proxy: UIT (grijs wolkje)
```

> Cloudflare proxy UIT houden zodat Let's Encrypt SSL-certificaat correct aangevraagd kan worden.

---

## 3. Stap 2: Deployment via Coolify

1. SSH naar VPS: `ssh root@23.94.220.181`
2. In Coolify dashboard: **New Resource → Docker Compose**
3. Plak de inhoud van `docker-compose.yml`
4. Stel de environment variables in:
   - `DB_NAME` — `thinkinglocal_wp`
   - `DB_USER` — `thinkinglocal`
   - `DB_PASSWORD` — genereer: `openssl rand -base64 32`
   - `DB_ROOT_PASSWORD` — genereer: `openssl rand -base64 32`
5. Domein instellen: `https://wordpress.thinkinglocal.be`
6. Deploy → Coolify vraagt automatisch SSL-certificaat via Let's Encrypt

---

## 4. Stap 3: WordPress basisinstallatie

Na de eerste deploy opent WordPress de installatiewizard:
- Site title: `Thinking Local`
- Admin URL: `https://wordpress.thinkinglocal.be/wp-admin`

---

## 5. Stap 4: GitHub Actions deploy instellen

In de GitHub repo `wordpress-thinkinglocal` → **Settings → Secrets and variables → Actions**:

| Secret | Waarde |
|---|---|
| `SSH_HOST` | `23.94.220.181` |
| `SSH_USER` | SSH gebruiker op de VPS |
| `SSH_PRIVATE_KEY` | Private SSH key (zelfde als andere WP-repos) |
| `WP_CONTAINER` | Container naam uit Coolify (zie Coolify dashboard) |

---

## 6. Huisstijl

Thinking Local kleurenpalet: nader te bepalen via `design-allthingslocal/brands/thinking-local/tokens.css`

Huisstijl-CSS injecteren via WP-CLI:
```bash
docker exec <container> wp css update --allow-root --css="<css-code>"
```
