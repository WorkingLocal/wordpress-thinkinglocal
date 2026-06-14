# How-to — WordPress Thinking Local

## Cache leegmaken

```bash
docker exec <container> wp cache flush --allow-root
docker exec <container> wp elementor flush-css --allow-root
```

## WP-CLI commando's uitvoeren

```bash
docker exec <container> wp <commando> --allow-root
```

## Container naam opzoeken

```bash
docker ps | grep wordpress
```

## Logs bekijken

```bash
docker logs <container> --tail=50
```

## Database backup

```bash
docker exec <container> wp db export /var/www/html/backup-$(date +%Y%m%d).sql --allow-root
docker cp <container>:/var/www/html/backup-$(date +%Y%m%d).sql ./
```

## WordPress bijwerken

Gebeurt via het WP-dashboard (Beheer → Updates) of via:
```bash
docker exec <container> wp core update --allow-root
docker exec <container> wp plugin update --all --allow-root
```
