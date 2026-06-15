# Technisch herinrichtingshandboek — WordPress Thinking Local

Dit document is het complete handboek om de Thinking Local WordPress-site op te zetten of te herbouwen.

---

## 1. Overzicht van de omgeving

| Parameter | Waarde |
|---|---|
| **Productiesite** | https://thinkinglocal.be (Hostinger) |
| **VPS-site** | https://wordpress.thinkinglocal.be (optioneel — dev/staging) |
| **VPS IP** | `23.94.220.181` |
| **WordPress versie** | Meest recente |
| **Page builder** | Elementor |
| **Database** | MariaDB (Hostinger beheerd) |

### Architectuur — productie

```
Internet → Cloudflare DNS
    A-record: thinkinglocal.be → Hostinger server IP
    Proxy: UIT (grijs wolkje)
  → Hostinger hPanel → WordPress installatie
```

---

## 2. Stap 1: Domein toevoegen op Hostinger

1. Log in op [hpanel.hostinger.com](https://hpanel.hostinger.com)
2. **Websites → Add website** of voeg toe als addon-domein aan bestaand plan
3. Voer `thinkinglocal.be` in
4. Noteer het **Hostinger server IP** (staat in hPanel → DNS Zone of Email Setup)

---

## 3. Stap 2: Cloudflare instellen

`thinkinglocal.be` is geregistreerd maar nog niet in Cloudflare. Eerst nameservers overzetten, dan DNS toevoegen.

### 3a. Zone toevoegen
1. [dash.cloudflare.com](https://dash.cloudflare.com) → **Add a Site** → `thinkinglocal.be` → Free plan
2. Noteer de twee Cloudflare nameservers

### 3b. Nameservers updaten bij registrar
Vervang de nameservers bij de registrar (Easyhost of andere) door de Cloudflare nameservers.
Propagatie: 0–24 uur (meestal < 1 uur).

### 3c. A-records toevoegen in Cloudflare

```
Type:  A
Name:  @
Value: [Hostinger server IP]
Proxy: UIT (grijs wolkje)

Type:  A
Name:  www
Value: [Hostinger server IP]
Proxy: UIT (grijs wolkje)
```

> Proxy UIT zodat Let's Encrypt of Hostinger SSL correct werkt.

---

## 4. Stap 3: WordPress installeren op Hostinger

In hPanel van het Thinking Local domein:
1. **WordPress → Install**
2. Site title: `Thinking Local`
3. Admin URL: `https://thinkinglocal.be/wp-admin`

---

## 5. Stap 4: GitHub Actions deploy (voor VPS dev — optioneel)

Als je ook een VPS-versie wil (zoals `wordpress.workinglocal.be` voor Working Local):

### Coolify op VPS

1. In Coolify: **New Resource → Docker Compose**
2. Plak de inhoud van `docker-compose.yml`
3. Environment variables:
   - `DB_NAME` — `thinkinglocal_wp`
   - `DB_USER` — `thinkinglocal`
   - `DB_PASSWORD` — `openssl rand -base64 32`
   - `DB_ROOT_PASSWORD` — `openssl rand -base64 32`
4. Domein: `https://wordpress.thinkinglocal.be`
5. Deploy

### GitHub Secrets (voor auto-deploy naar VPS)

| Secret | Waarde |
|---|---|
| `SSH_HOST` | `23.94.220.181` |
| `SSH_USER` | `root` |
| `SSH_PRIVATE_KEY` | Private SSH key |
| `WP_CONTAINER` | Container naam uit Coolify |

---

## 6. Huisstijl

Tokens en kleuren: `design-allthingslocal/brands/thinking-local/tokens.css`
(In opbouw — wordt ingevuld na Claude design sessie)

CSS injecteren via WP-CLI (VPS) of via WordPress Additional CSS (Hostinger):
```bash
docker exec <container> wp css update --allow-root --css="<css-code>"
```
