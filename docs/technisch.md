# Technisch herinrichtingshandboek — WordPress Thinking Local

Dit document is het complete handboek om de Thinking Local WordPress-site van nul op te zetten of te herbouwen op de eigen VPS.

---

## 1. Overzicht van de omgeving

| Parameter | Waarde |
|---|---|
| **Productiesite** | https://thinkinglocal.be |
| **VPS-site** | https://wordpress.thinkinglocal.be |
| **VPS IP** | `23.94.220.181` (zelfde VPS als workinglocal/hostinglocal) |
| **WordPress versie** | Meest recente |
| **Page builder** | Elementor |
| **Database** | MariaDB LTS (eigen container) |

### Architectuur

```
Internet → Cloudflare DNS (zone reeds actief op thinkinglocal.be)
    A-record: wordpress.thinkinglocal.be → 23.94.220.181
    Proxy: UIT (grijs wolkje)
  → Coolify (Traefik/Caddy) → Docker: wordpress + db container
```

> De Cloudflare-zone voor thinkinglocal.be staat al actief (nameservers + root A-record wijzen al naar Cloudflare, gebruikt door de bestaande autoba/bms-subdomeinen). Er is alleen nog geen origin gekoppeld voor de website zelf — vandaar de 521-fout op het root-domein tot deze site live staat.

---

## 2. Deployment via Coolify

1. In Coolify: **New Resource → Docker Compose**
2. Plak de inhoud van `docker-compose.yml`
3. Stel de environment variables in:
   - `DB_NAME` — `thinkinglocal_wp`
   - `DB_USER` — `thinkinglocal`
   - `DB_PASSWORD` — genereer: `openssl rand -base64 32`
   - `DB_ROOT_PASSWORD` — genereer: `openssl rand -base64 32`
4. Domein instellen: `https://wordpress.thinkinglocal.be`
5. Deploy

---

## 3. WordPress basisinstallatie

Na de eerste deploy opent WordPress de installatiewizard:
- Site title: `Thinking Local`
- Admin URL: `https://wordpress.thinkinglocal.be/wp-admin`

---

## 4. DNS instellen (Cloudflare)

```
Type:  A
Name:  wordpress
Value: 23.94.220.181
Proxy: UIT (grijs wolkje)
```

> Cloudflare proxy UIT houden zodat Let's Encrypt SSL-certificaat correct aangevraagd kan worden.

Wanneer de site klaar is voor productie, het root-domein (`@`) ook naar de VPS wijzen (zelfde A-record patroon), of via een Cloudflare Page Rule/redirect naar `wordpress.thinkinglocal.be` totdat een definitieve keuze gemaakt is.

---

## 5. GitHub Actions deploy

In de GitHub repo secrets instellen:
- `SSH_HOST` — VPS IP (`23.94.220.181`)
- `SSH_USER` — SSH gebruiker op de VPS
- `SSH_PRIVATE_KEY` — private SSH key
- `WP_CONTAINER` — naam van de WordPress Docker container in Coolify

---

## 6. Huisstijl

Thinking Local kleurenpalet: gedeeld basispalet — marineblauw (`#1A2E5A`) + geel (`#F5B800`), reeds live op het AutoBA-platform en BMS Portal. Een eigen onderscheidende accentkleur is nog een open vraag voor de design-sessie.

Huisstijl-CSS injecteren via WP-CLI:
```bash
docker exec <container> wp css update --allow-root --css="<css-code>"
```

Volledige tokens: zie `design-allthingslocal/brands/thinking-local/tokens.css`.
