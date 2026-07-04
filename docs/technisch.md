# Technisch herinrichtingshandboek — WordPress Thinking Local

Dit document is het complete handboek om de Thinking Local WordPress-site op te zetten via CloudPanel op VM-WORDPRESS.

---

## 1. Overzicht van de omgeving

| Parameter | Waarde |
|---|---|
| **VM** | VM-WORDPRESS — 192.168.111.65 / 100.120.60.58 (Tailscale) |
| **SSH** | `ssh ubuntu@100.120.60.58` of via jump: `ssh -J root@100.81.170.58 ubuntu@192.168.111.65` |
| **CloudPanel admin** | https://100.120.60.58:8443 |
| **Stack** | CloudPanel CE — Nginx + Percona 8.4 + PHP-FPM per vhost |
| **Productiesite** | https://thinkinglocal.be |
| **Cloudflare zone** | ✅ Actief — Cloudflare nameservers live, root A-record ⏳ |
| **Cloudflare tunnel** | vm-wordpress-tunnel (CF Zero Trust — token vereist) |

---

## 2. Site aanmaken via CloudPanel CLI

```bash
# SSH naar VM-WORDPRESS
ssh ubuntu@100.120.60.58

# Site aanmaken (PHP 8.3 + WordPress template)
sudo clpctl site:add:php \
  --domainName=thinkinglocal.be \
  --phpVersion=8.3 \
  --vhostTemplate=WordPress \
  --siteUser=tl-admin \
  --siteUserPassword=$(openssl rand -base64 16)

# WordPress installeren (sla admin-wachtwoord op in Vaultwarden)
sudo clpctl wp:install \
  --domainName=thinkinglocal.be \
  --title="Thinking Local" \
  --adminUser=tl-admin \
  --adminPassword=$(openssl rand -base64 16) \
  --adminEmail=thomas@thinkinglocal.be \
  --locale=nl_NL
```

> Credentials (siteUser + WP admin) direct in Vaultwarden opslaan onder "VM-WORDPRESS / WordPress Sites".

---

## 3. Mu-plugin deployen

De mu-plugin staat in deze repo onder `wp-content/mu-plugins/thinking-local.php`. Kopieer naar de server:

```bash
# Vanop laptop
scp wp-content/mu-plugins/thinking-local.php \
  ubuntu@100.120.60.58:/tmp/thinking-local.php

# Op de server
sudo cp /tmp/thinking-local.php \
  /home/tl-admin/htdocs/thinkinglocal.be/wp-content/mu-plugins/thinking-local.php
sudo chown tl-admin:tl-admin \
  /home/tl-admin/htdocs/thinkinglocal.be/wp-content/mu-plugins/thinking-local.php
```

---

## 4. Kadence thema installeren

```bash
# Op de server (als site-user)
sudo -u tl-admin bash

wp --path=/home/tl-admin/htdocs/thinkinglocal.be \
  theme install kadence --activate

wp --path=/home/tl-admin/htdocs/thinkinglocal.be \
  plugin install kadence-blocks --activate

exit
```

---

## 5. DNS instellen (Cloudflare)

De Cloudflare zone voor thinkinglocal.be is al actief. Wijzig het root A-record zodra de site klaar is:

```
Type:  A
Name:  @
Value: <publiek IP> of CF Tunnel CNAME
Proxy: AAN (oranje wolkje)
```

Tijdelijk testen via hosts file:
```
100.120.60.58   thinkinglocal.be
```

---

## 6. GitHub Actions deploy

Deploy-workflow in `.github/workflows/deploy.yml` kopieert gewijzigde bestanden via SCP:

```yaml
# In GitHub repo secrets instellen:
# SSH_HOST     = 100.120.60.58
# SSH_USER     = ubuntu
# SSH_PRIVATE_KEY = <private key>
# WP_PATH      = /home/tl-admin/htdocs/thinkinglocal.be
```

---

## 7. Logo — placeholder vervangen

Het huidige logo in `thinking-local.php` is een SVG-placeholder (bar chart). Zodra het definitieve logo ontworpen is in `design-allthingslocal/brands/thinking-local/assets/`:

1. SVG exporteren naar `assets/logo-thinking-local.svg`
2. `tl_svg_logo()` in `wp-content/mu-plugins/thinking-local.php` vervangen
3. Deployen via SCP (zie stap 3)

---

## 8. Huisstijl

Thinking Local kleurenpalet (tijdelijk gedeeld basispalet): marineblauw (`#1A2E5A`) + geel (`#F5B800`).

De mu-plugin `wp-content/mu-plugins/thinking-local.php` injecteert automatisch alle CSS, het SVG-logo (placeholder) en de JS-verbeteringen.

Eigen accent-kleur wordt bepaald tijdens de design-sessie. Volledige tokens: zie `design-allthingslocal/brands/thinking-local/tokens.css`.
