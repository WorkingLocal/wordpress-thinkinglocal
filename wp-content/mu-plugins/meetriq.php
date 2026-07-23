<?php
/**
 * Meetriq — WordPress mu-plugin v3
 * Fixes: DOMContentLoaded scope, wp_kses SVG, Kadence whitespace
 */

// ── Fonts ──────────────────────────────────────────────────────────────────
add_action('wp_head', function() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    echo '<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">';
}, 1);

// ── Favicon ─────────────────────────────────────────────────────────────────
add_action('wp_head', function() {
    echo '<link rel="icon" type="image/svg+xml" href="' . MQ_ASSETS_URL . 'favicon-meetriq.svg">';
    echo '<link rel="icon" type="image/png" sizes="32x32" href="' . MQ_ASSETS_URL . 'favicon-32.png">';
    echo '<link rel="icon" type="image/png" sizes="16x16" href="' . MQ_ASSETS_URL . 'favicon-16.png">';
    echo '<link rel="apple-touch-icon" sizes="180x180" href="' . MQ_ASSETS_URL . 'favicon-180.png">';
    echo '<link rel="icon" type="image/png" sizes="512x512" href="' . MQ_ASSETS_URL . 'favicon-512.png">';
}, 1);

// ── Logo: geanimeerd inline SVG ────────────────────────────────────────────
// Kadence wraps de logo-output al in <a class="brand"> — geen eigen <a> returneren
add_filter('kadence_custom_logo', 'mq_svg_logo', 99, 2);
function mq_svg_logo($html, $blog_id) {
    return
    '<div style="width:34px;height:34px;background:#0B2545;border:2px solid #0B0B0B;border-radius:8px;box-shadow:3px 3px 0 0 #0B0B0B;display:flex;align-items:center;justify-content:center;flex:none">' .
    '<svg viewBox="0 0 60 58" style="width:22px;height:21px;display:block" fill="none" aria-label="Meetriq logo">' .
    '<g transform="translate(-33,-34)">' .
    /* SMIL-animaties (native SVG, geen JS/CSS vereist, cross-browser betrouwbaar) */
    '<rect x="39" y="82" width="11.5" height="0" rx="2.5" fill="#FFD400">' .
    '<animate attributeName="height" from="0" to="19" dur=".35s" begin=".1s" fill="freeze"/>' .
    '<animate attributeName="y" from="82" to="63" dur=".35s" begin=".1s" fill="freeze"/>' .
    '</rect>' .
    '<rect x="54" y="82" width="11.5" height="0" rx="2.5" fill="#FFD400">' .
    '<animate attributeName="height" from="0" to="29" dur=".35s" begin=".22s" fill="freeze"/>' .
    '<animate attributeName="y" from="82" to="53" dur=".35s" begin=".22s" fill="freeze"/>' .
    '</rect>' .
    '<rect x="69" y="82" width="11.5" height="0" rx="2.5" fill="#FFD400">' .
    '<animate attributeName="height" from="0" to="41" dur=".35s" begin=".34s" fill="freeze"/>' .
    '<animate attributeName="y" from="82" to="41" dur=".35s" begin=".34s" fill="freeze"/>' .
    '</rect>' .
    /* Baseline: lengte = 48 SVG user units (M36→H84) */
    '<path d="M36 87 H84" stroke="#FFD400" stroke-width="3" stroke-linecap="round" stroke-dasharray="48" stroke-dashoffset="48">' .
    '<animate attributeName="stroke-dashoffset" from="48" to="0" dur=".4s" begin="0s" fill="freeze"/>' .
    '</path>' .
    /* Trendlijn: lengte ≈ 79 SVG user units (berekend per segment) */
    '<path d="M38 78 L48 61 L58 74 L70 51 L84 43" stroke="#2FD9C8" stroke-width="3.5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="79" stroke-dashoffset="79">' .
    '<animate attributeName="stroke-dashoffset" from="79" to="0" dur=".8s" begin=".55s" fill="freeze"/>' .
    '</path>' .
    '<circle cx="48" cy="61" r="2.3" fill="#2FD9C8" opacity="0">' .
    '<animate attributeName="opacity" from="0" to="1" dur=".2s" begin=".75s" fill="freeze"/>' .
    '</circle>' .
    '<circle cx="58" cy="74" r="2.3" fill="#2FD9C8" opacity="0">' .
    '<animate attributeName="opacity" from="0" to="1" dur=".2s" begin=".95s" fill="freeze"/>' .
    '</circle>' .
    '<circle cx="70" cy="51" r="2.3" fill="#2FD9C8" opacity="0">' .
    '<animate attributeName="opacity" from="0" to="1" dur=".2s" begin="1.15s" fill="freeze"/>' .
    '</circle>' .
    '<circle cx="84" cy="43" r="6" fill="#2FD9C8" stroke="#0B2545" stroke-width="2" opacity="0">' .
    '<animate attributeName="opacity" from="0" to="1" dur=".35s" begin="1.35s" fill="freeze"/>' .
    '</circle>' .
    '</g></svg>' .
    '</div>' .
    '<div style="display:flex;flex-direction:column;justify-content:space-between;height:34px;box-sizing:border-box;padding:1px 0">' .
    '<span style="font:900 20px/1 \'Archivo\',sans-serif;letter-spacing:-.02em;color:#0B0B0B">Meetriq</span>' .
    '<span style="font:600 10.5px/1 \'JetBrains Mono\',monospace;letter-spacing:.12em;text-transform:uppercase;color:#0F766E">Decision Studio</span>' .
    '</div>';
}

// ── wp_kses: SVG-attributen toestaan in post-content ──────────────────────
add_filter('wp_kses_allowed_html', function($allowed, $context) {
    if ($context !== 'post') return $allowed;
    $svg_attrs = [
        'class' => true, 'style' => true, 'id' => true,
        'xmlns' => true, 'viewbox' => true, 'width' => true, 'height' => true,
        'fill' => true, 'stroke' => true, 'stroke-width' => true,
        'stroke-linecap' => true, 'stroke-linejoin' => true,
        'stroke-dasharray' => true, 'stroke-dashoffset' => true,
        'x' => true, 'y' => true, 'rx' => true, 'ry' => true,
        'cx' => true, 'cy' => true, 'r' => true, 'd' => true,
        'transform' => true, 'transform-origin' => true,
        'aria-label' => true, 'aria-hidden' => true,
        'preserveaspectratio' => true,
    ];
    /* SMIL animate-element toestaan (voor logo-animaties in post-content) */
    $svg_attrs['attributename'] = true;
    $svg_attrs['from']          = true;
    $svg_attrs['to']            = true;
    $svg_attrs['dur']           = true;
    $svg_attrs['begin']         = true;
    $svg_attrs['calcmode']      = true;
    $svg_attrs['keysplines']    = true;
    $svg_attrs['keytimes']      = true;
    $svg_attrs['repeatcount']   = true;
    $svg_attrs['values']        = true;
    foreach (['svg','g','rect','path','circle','line','polyline','polygon','ellipse','defs','use','animate'] as $tag) {
        $allowed[$tag] = $svg_attrs;
    }
    return $allowed;
}, 10, 2);

// ── wpautop uitschakelen op alle pagina's (voorkomt <p>/<br> injectie in de handgebouwde grid/flex-layouts) ──
add_action('template_redirect', function() {
    if (is_page()) remove_filter('the_content', 'wpautop');
});

// ── CSS + JS ───────────────────────────────────────────────────────────────
add_action('wp_head', function() { ?>
<style>
/* ── Kadence structuur volledig neullen ── */
.entry-hero,.entry-hero-container,.kadence-hero-wrap,
.entry-hero-container-inner,.entry-header-wrap,.entry-header{
  display:none!important;height:0!important;
  margin:0!important;padding:0!important;
}
.content-bg{background:transparent!important;padding:0!important}
.content-area{margin:0!important;padding:0!important}
.entry-content-wrap,.entry-content,.site-main,
#inner-wrap,#primary,#wrapper{
  padding:0!important;margin:0!important;
  max-width:none!important;background:transparent!important;
}
/* #page kan padding-top hebben in Kadence → witte balk boven content */
#page.site-content,div#page{padding:0!important;margin:0!important;background:transparent!important}
.entry-content>*,.entry-content.single-content>*{
  margin-top:0!important;margin-bottom:0!important;
}
article.entry{
  padding:0!important;margin:0!important;
  box-shadow:none!important;border-radius:0!important;
  background:transparent!important;
}
body{background:#FAF7F0!important;margin:0}
#wrapper.site{background:transparent!important}

/* ── Header ── */
#masthead{
  position:sticky!important;top:0!important;z-index:100!important;
  background:rgba(250,247,240,.88)!important;
  border-bottom:1px solid #E6E2D6!important;
  backdrop-filter:blur(8px)!important;
  -webkit-backdrop-filter:blur(8px)!important;
  transition:box-shadow .2s ease-out!important;
}
#masthead.mq-scrolled{box-shadow:0 2px 16px rgba(11,11,11,.10)!important}
.site-main-header-inner-wrap{
  height:64px!important;min-height:64px!important;
  align-items:center!important;box-sizing:border-box!important;
}
.site-header-row.site-header-row-has-sides{
  justify-content:space-between!important;
  width:100%!important;align-items:center!important;
}
.site-branding .site-title{display:none!important}
.site-title-wrap,.site-title-wrap *{display:none!important}
.site-branding a.brand{
  display:flex!important;flex-direction:row!important;
  align-items:center!important;gap:11px!important;
  text-decoration:none!important;color:inherit!important;
}

/* ── Nav ── */
#site-navigation a,.main-navigation a{
  font:500 14px/1 'Archivo',sans-serif!important;
  color:#0B0B0B!important;text-decoration:none!important;
  padding:8px 12px!important;border-radius:4px!important;
  transition:background .15s ease-out!important;
}
#site-navigation a:hover,.main-navigation a:hover{background:#F2EFE6!important}

/* ── Nav CTA ── */
/* Specifiteit (1,2,1) > Kadence's #site-navigation a:hover (1,1,1) — anders wint hun background */
#site-navigation .mq-nav-cta>a,
#site-navigation .mq-nav-cta>a:visited,
.main-navigation .mq-nav-cta>a,
.main-navigation .mq-nav-cta>a:visited{
  background:#FFD400!important;color:#0B0B0B!important;
  border:2px solid #0B0B0B!important;border-radius:4px!important;
  box-shadow:2px 2px 0 0 #0B0B0B!important;
  padding:8px 12px!important;
  font:800 13px/1 'Archivo',sans-serif!important;letter-spacing:-.01em!important;
  text-decoration:none!important;
  transition:transform .12s ease-out,box-shadow .12s ease-out!important;
}
#site-navigation .mq-nav-cta>a:hover,
.main-navigation .mq-nav-cta>a:hover{
  background:#FFD400!important;
  transform:translate(-2px,-2px)!important;
  box-shadow:4px 4px 0 0 #0B0B0B!important;
}
#site-navigation .mq-nav-cta>a:active,
.main-navigation .mq-nav-cta>a:active{
  background:#FFD400!important;
  transform:translate(2px,2px)!important;
  box-shadow:1px 1px 0 0 #0B0B0B!important;
}

/* ── Logo animatie volledig via JS requestAnimationFrame ── */
/* CSS-animatie op SVG-rects (clip-path/transform-box) is onbetrouwbaar cross-browser.
   stroke-dasharray in CSS-px klopt niet bij verschillende SVG display-groottes.
   Alles wordt nu aangestuurd via mqAnimSvg() in de <script> hieronder. */

/* ── Knoppen groot ── */
a.mq-btn-y,a.mq-btn-y:visited,a.mq-btn-cta,a.mq-btn-cta:visited{
  display:inline-flex;align-items:center;gap:8px;
  background:#FFD400;color:#0B0B0B;
  border:2px solid #0B0B0B;border-radius:4px;
  box-shadow:4px 4px 0 0 #2FD9C8;
  padding:16px 22px;
  font:800 16px/1 'Archivo',sans-serif;letter-spacing:-.01em;
  text-decoration:none;
  transition:background .15s ease-out,transform .12s ease-out,box-shadow .12s ease-out;
}
a.mq-btn-y:hover,a.mq-btn-cta:hover{
  background:#EBC400!important;color:#0B0B0B!important;
  transform:translate(-2px,-2px);box-shadow:6px 6px 0 0 #2FD9C8!important;
}
a.mq-btn-y:active,a.mq-btn-cta:active{transform:translate(2px,2px)!important;box-shadow:1px 1px 0 0 #2FD9C8!important}

/* ── Ghost ── */
a.mq-btn-ghost,a.mq-btn-ghost:visited{
  display:inline-flex;align-items:center;gap:8px;
  background:transparent;color:#FAF7F0;
  border:2px solid #FAF7F0;border-radius:4px;
  padding:16px 22px;
  font:800 16px/1 'Archivo',sans-serif;letter-spacing:-.01em;
  text-decoration:none;
  transition:background .15s ease-out,transform .12s ease-out;
}
a.mq-btn-ghost:hover{background:#133A66!important;color:#FAF7F0!important;transform:translate(-2px,-2px)}
a.mq-btn-ghost:active{transform:translate(2px,2px)!important}

/* ── Eyebrows ── */
.mq-eyebrow{font:600 12px/1 'JetBrains Mono',monospace!important;letter-spacing:.12em!important;text-transform:uppercase!important;color:#0F766E!important}
.mq-eyebrow-cyan{font:600 12px/1 'JetBrains Mono',monospace!important;letter-spacing:.12em!important;text-transform:uppercase!important;color:#2FD9C8!important}
.mq-stamp{background:#FFD400;color:#0B0B0B;padding:0 12px;border:2px solid #0B0B0B;white-space:nowrap;display:inline}

/* ── Hero ── */
.mq-hero{background:#0B2545;color:#FAF7F0;padding:96px 32px}
@media(max-width:640px){.mq-hero{padding:64px 16px}}
.mq-hero-grid{max-width:1240px;margin:0 auto;display:grid;grid-template-columns:1.2fr 1fr;gap:64px;align-items:center}
@media(max-width:900px){.mq-hero-grid{grid-template-columns:1fr;gap:40px}}
.mq-hero-logo-block{display:flex;justify-content:center}
@media(max-width:900px){.mq-hero-logo-block{display:none}}

.mq-hero-logo-sq{
  width:200px;height:200px;
  background:#0B2545;border:2px solid #0B0B0B;border-radius:28px;
  box-shadow:8px 8px 0 0 #2FD9C8;
  display:flex;align-items:center;justify-content:center;
  transform:rotate(-2deg);transition:transform .2s ease-out;
}
.mq-hero-logo-sq:hover{transform:rotate(0deg)}

/* ── Voor wie ── */
.mq-voor-wie{padding:64px 32px;border-bottom:1px solid #E6E2D6;background:#FAF7F0}
@media(max-width:640px){.mq-voor-wie{padding:48px 16px}}
.mq-voor-wie-grid{max-width:1240px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:24px}
@media(max-width:900px){.mq-voor-wie-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:480px){.mq-voor-wie-grid{grid-template-columns:1fr}}
.mq-voor-wie-item{display:flex;flex-direction:column;gap:8px}
.mq-voor-wie-dot{width:10px;height:10px;background:#FFD400;border:2px solid #0B0B0B;flex:none}
.mq-voor-wie-title{font:700 16px/1.2 'Archivo',sans-serif;color:#0B0B0B}
.mq-voor-wie-text{font:400 14px/1.5 'Archivo',sans-serif;color:#5A5854}

/* ── Diensten ── */
.mq-diensten{padding:96px 32px;border-bottom:1px solid #E6E2D6;background:#FAF7F0}
@media(max-width:640px){.mq-diensten{padding:64px 16px}}
.mq-diensten-header{display:flex;flex-direction:column;gap:10px;margin-bottom:40px}
.mq-diensten-grid{max-width:1240px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
@media(max-width:1024px){.mq-diensten-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:480px){.mq-diensten-grid{grid-template-columns:1fr}}

/* ── Kaarten ── */
.mq-card{
  border:2px solid #0B0B0B;background:#FAF7F0;
  box-shadow:4px 4px 0 0 #0B0B0B;padding:24px 22px;
  display:flex;flex-direction:column;gap:12px;
  transition:box-shadow .15s ease-out,transform .15s ease-out;
}
.mq-card:hover{box-shadow:7px 7px 0 0 #0B0B0B;transform:translate(-3px,-3px)}
.mq-card-num{font:700 12px/1 'JetBrains Mono',monospace;color:#0F766E}
.mq-card-title{font:800 19px/1.15 'Archivo',sans-serif;color:#0B0B0B}
.mq-card-text{font:400 13.5px/1.55 'Archivo',sans-serif;color:#3A3835;flex:1}
.mq-card-price{font:600 13px/1 'JetBrains Mono',monospace;color:#0B0B0B;border-top:1px solid #E6E2D6;padding-top:12px;margin-top:auto}

/* ── Aanpak ── */
.mq-aanpak{padding:96px 32px;background:#F2EFE6;border-bottom:1px solid #E6E2D6}
@media(max-width:640px){.mq-aanpak{padding:64px 16px}}
.mq-aanpak-grid{max-width:1240px;margin:0 auto;display:grid;grid-template-columns:1fr 1.4fr;gap:64px;align-items:start}
@media(max-width:900px){.mq-aanpak-grid{grid-template-columns:1fr;gap:40px}}

.mq-word{display:inline-block;padding:0 8px;border:2px solid transparent;transition:background .15s ease-out,border-color .15s ease-out}
.mq-word.is-active{background:#FFD400;border-color:#0B0B0B}

.mq-step{
  display:grid;grid-template-columns:64px 1fr;gap:20px;
  padding:22px 12px;margin:0 -12px;
  border-top:2px solid #0B0B0B;cursor:default;
  transition:background .15s ease-out;
}
.mq-step:hover{background:#EAE6DA}
.mq-step-num{font:700 20px/1 'JetBrains Mono',monospace;color:#0F766E;transition:color .15s ease-out}
.mq-step:hover .mq-step-num{color:#0B0B0B}
.mq-step-title{font:800 19px/1.2 'Archivo',sans-serif;color:#0B0B0B;margin-bottom:6px}
.mq-step-text{font:400 14.5px/1.55 'Archivo',sans-serif;color:#3A3835}

/* ── CTA ── */
.mq-cta-section{padding:96px 32px;background:#0B2545}
@media(max-width:640px){.mq-cta-section{padding:64px 16px}}
.mq-cta-inner{max-width:820px;margin:0 auto;display:flex;flex-direction:column;align-items:center;gap:24px;text-align:center}

/* ── Footer ── */
.mq-footer{background:#0B0B0B;color:#B7B4AD;padding:40px 32px}
.mq-footer-inner{max-width:1240px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}
.mq-footer-lockup{display:flex;align-items:center;gap:10px}

/* ── Decision Cloud ── */
.mq-dc-hero{background:#06122A;color:#FAF7F0;padding:96px 32px}
@media(max-width:640px){.mq-dc-hero{padding:64px 16px}}
.mq-tile-grid{max-width:1240px;margin:40px auto 0;display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px}
.mq-tile{background:#0B2545;border:2px solid #0B0B0B;box-shadow:4px 4px 0 0 #0B0B0B;padding:24px;display:flex;flex-direction:column;gap:16px;transition:transform .18s ease-out,box-shadow .18s ease-out}
.mq-tile:hover{transform:translateY(-3px);box-shadow:6px 6px 0 0 #0B0B0B}
.mq-tile-icon{width:48px;height:48px;display:flex;align-items:center;justify-content:center}
.mq-tile-layer{font:600 10px/1 'JetBrains Mono',monospace;letter-spacing:.12em;text-transform:uppercase;color:#2FD9C8}
.mq-tile-name{font:800 17px/1.2 'Archivo',sans-serif;color:#FAF7F0}
.mq-tile-sub{font:500 11px/1 'JetBrains Mono',monospace;letter-spacing:.08em;text-transform:uppercase;color:#6FA0CF}
.mq-tile-desc{font:400 13.5px/1.55 'Archivo',sans-serif;color:#D7E5F2}
.mq-tile-bullets{list-style:none;margin:4px 0 0;padding:0;flex:1;display:flex;flex-direction:column;gap:7px}
.mq-tile-bullets li{font:400 13px/1.45 'Archivo',sans-serif;color:#D7E5F2;padding-left:18px;position:relative}
.mq-tile-bullets li::before{content:'→';position:absolute;left:0;top:0;color:#2FD9C8;font-size:11px;line-height:1.6}
.mq-tile-link{display:inline-flex;align-items:center;gap:4px;margin-top:12px;font:700 12px/1 'Archivo',sans-serif;letter-spacing:.03em;color:#FFD400;text-decoration:none;border-bottom:1.5px solid rgba(255,212,0,.3);padding-bottom:2px;transition:border-color .15s,color .15s;align-self:flex-start}
.mq-tile-link:hover{border-bottom-color:#FFD400;color:#fff}
.mq-layer-label{font:700 11px/1 'JetBrains Mono',monospace;letter-spacing:.12em;text-transform:uppercase;color:#0F766E;max-width:1240px;margin:40px auto 16px}

/* Cloud hero: tegels poppen één voor één binnen */
@keyframes mq-tile-in{0%{transform:scale(0)}70%{transform:scale(1.12)}100%{transform:scale(1)}}
.mq-hero-tile{transform:scale(0);animation:mq-tile-in .3s ease-out forwards}
.mq-hero-master{transform:scale(0);animation:mq-tile-in .4s ease-out 1.5s forwards}

/* Pijplijn: datapakket reist over de vijf stappen */
@keyframes mq-travel{
  0%{left:0%;opacity:0} 4%{opacity:1}
  18%{left:20%} 24%{left:20%} 38%{left:40%} 44%{left:40%}
  58%{left:60%} 64%{left:60%} 78%{left:80%} 84%{left:80%}
  96%{left:calc(100% - 14px);opacity:1} 100%{left:calc(100% - 14px);opacity:0}
}
@keyframes mq-stamp{0%,88%{background:#FFF;color:#0F766E;transform:none}92%{background:#FFD400;color:#0B0B0B;transform:translate(1px,1px)}100%{background:#FFF;color:#0F766E;transform:none}}
@keyframes mq-lightup{0%,100%{background:transparent}50%{background:#FFF6CC}}
.mq-track{position:relative;height:14px;margin:0 1px}
.mq-track::before{content:'';position:absolute;left:0;right:0;top:6px;height:2px;background:#E6E2D6}
.mq-packet{position:absolute;top:1px;width:12px;height:12px;background:#2FD9C8;border:2px solid #0B0B0B;box-sizing:border-box;animation:mq-travel 8s linear infinite}
.mq-flowstep{animation:mq-lightup 8s linear infinite}
.mq-flowstep:nth-child(1){animation-delay:-3.5s}
.mq-flowstep:nth-child(2){animation-delay:-2.26s}
.mq-flowstep:nth-child(3){animation-delay:-0.66s}
.mq-flowstep:nth-child(4){animation-delay:-7.06s}
.mq-flowstep:nth-child(5){animation-delay:-5.46s}
.mq-stampnum{animation:mq-stamp 8s linear infinite}
.mq-flowstep:nth-child(1) .mq-stampnum{animation-delay:-7.16s}
.mq-flowstep:nth-child(2) .mq-stampnum{animation-delay:-5.92s}
.mq-flowstep:nth-child(3) .mq-stampnum{animation-delay:-4.32s}
.mq-flowstep:nth-child(4) .mq-stampnum{animation-delay:-2.72s}
.mq-flowstep:nth-child(5) .mq-stampnum{animation-delay:-1.12s}

/* Modulekaart in "de twaalf werken"-grid */
.mq-mod{transition:box-shadow .15s ease-out,transform .15s ease-out}
.mq-mod:hover{box-shadow:7px 7px 0 0 #0B0B0B!important;transform:translate(-3px,-3px)}

/* DC Filosofie banner */
.mq-dc-filosofie{background:#FAF7F0;border-bottom:2px solid #E8E4DA;padding:48px 32px}
.mq-dc-filosofie-inner{max-width:1240px;margin:0 auto;display:grid;grid-template-columns:minmax(0,220px) 1fr;gap:16px 48px;align-items:start}
@media(max-width:700px){.mq-dc-filosofie-inner{grid-template-columns:1fr;gap:14px}}
.mq-dc-filosofie-stamp{font:900 16px/1.25 'Archivo',sans-serif;letter-spacing:-.01em;color:#0B2545;padding:16px 18px;border:2px solid #0B0B0B;box-shadow:3px 3px 0 0 #FFD400}

/* Component-pagina's */
.mq-cp-hero{background:#06122A;padding:80px 32px 72px;color:#FAF7F0}
.mq-cp-hero-inner{max-width:1240px;margin:0 auto}
.mq-cp-breadcrumb{font:500 10px/1 'JetBrains Mono',monospace;letter-spacing:.12em;text-transform:uppercase;color:#6FA0CF;margin-bottom:24px;display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.mq-cp-breadcrumb a{color:#6FA0CF;text-decoration:none}
.mq-cp-breadcrumb a:hover{color:#2FD9C8}
.mq-cp-tool-tag{display:inline-block;font:600 10px/1 'JetBrains Mono',monospace;letter-spacing:.1em;text-transform:uppercase;color:#6FA0CF;background:rgba(111,160,207,.12);border:1px solid rgba(111,160,207,.3);padding:5px 10px;margin-bottom:18px}
.mq-cp-content{background:#FAF7F0;padding:64px 32px}
.mq-cp-content-inner{max-width:1240px;margin:0 auto}
.mq-cp-intro{font:400 17.5px/1.65 'Archivo',sans-serif;color:#2A2826;max-width:62ch;margin:0 0 40px;padding-left:18px;border-left:3px solid #FFD400}
.mq-cp-section-label{font:700 10px/1 'JetBrains Mono',monospace;letter-spacing:.12em;text-transform:uppercase;color:#0F766E;margin-bottom:14px}
.mq-cp-features{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:14px;margin-bottom:48px}
.mq-cp-feature{background:#fff;border:2px solid #0B0B0B;box-shadow:3px 3px 0 0 #0B0B0B;padding:18px 20px}
.mq-cp-feature-title{font:700 14px/1.2 'Archivo',sans-serif;color:#0B0B0B;margin-bottom:5px}
.mq-cp-feature-text{font:400 13px/1.5 'Archivo',sans-serif;color:#5A5854}
.mq-cp-process{margin:0;border-top:2px solid #0B0B0B}
.mq-cp-step{display:grid;grid-template-columns:52px 1fr;gap:0 16px;padding:20px 0;border-bottom:1px solid #E8E4DA;align-items:start}
.mq-cp-step:last-child{border-bottom:none}
.mq-cp-step-num{font:900 32px/1 'Archivo',sans-serif;color:#FFD400}
.mq-cp-step-title{font:700 15px/1.3 'Archivo',sans-serif;color:#0B0B0B;margin:0 0 4px}
.mq-cp-step-text{font:400 13.5px/1.55 'Archivo',sans-serif;color:#5A5854;margin:0}

/* ── Browser-chroom (mockup-vensters) ── */
.mq-chrome{border-radius:10px;overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.35),0 0 0 1px rgba(0,0,0,.1);display:flex;flex-direction:column;background:#35363a;max-width:100%}
.mq-chrome-bar{display:flex;align-items:center;height:44px;background:#202124;padding:0 14px;gap:8px;flex:none}
.mq-chrome-dot{width:12px;height:12px;border-radius:50%}
.mq-chrome-dot-r{background:#ff5f57}
.mq-chrome-dot-y{background:#febc2e}
.mq-chrome-dot-g{background:#28c840}
.mq-chrome-toolbar{height:40px;background:#35363a;display:flex;align-items:center;padding:0 10px;flex:none}
.mq-chrome-url{flex:1;height:30px;border-radius:15px;background:#282a2d;display:flex;align-items:center;gap:8px;padding:0 14px;font:13px system-ui,sans-serif;color:#e8eaed}
.mq-chrome-url-dot{width:10px;height:10px;border-radius:50%;background:#9aa0a6;opacity:.5;flex:none}
.mq-chrome-body{flex:1;overflow:auto;background:#fff}

/* ── Tabs (Semantics-mockup, Dashboard-pagina) ── */
.mq-tabpanel{display:none}
.mq-tabpanel.is-active{display:block}
.mq-tab{cursor:pointer}

/* ── Dashboard-pagina: sidebar-nav + tool-chips ── */
.mq-dash-nav{font:500 13.5px 'Archivo',sans-serif;color:#D7E5F2;padding:10px 24px;border-left:3px solid transparent;cursor:pointer}
.mq-dash-nav:hover{background:#133A66}
.mq-dash-nav.is-active{font-weight:700;color:#FAF7F0;border-left-color:#FFD400;background:#0E2C52}
.mq-dash-chip{font:600 13px 'Archivo',sans-serif;color:#D7E5F2;border:2px solid #133A66;padding:9px 18px;cursor:pointer;display:inline-block}
.mq-dash-chip:hover{border-color:#2E5D8F}
.mq-dash-chip.is-active{font-weight:700;color:#0B0B0B;background:#FFD400;border-color:#0B0B0B;box-shadow:3px 3px 0 0 #0B0B0B}

/* ── Insights-mockup: drill-down ── */
.mq-drill-overlay{position:absolute;inset:0;background:rgba(6,18,42,.55);z-index:40;display:none}
.mq-drill-overlay.is-active{display:block}
.mq-drill-panel{display:none}
.mq-drill-panel.is-active{display:flex}
.mq-week-bar{cursor:pointer;transition:opacity .12s ease-out}
.mq-week-bar:hover{opacity:.8}

/* ── Flow Engine-mockup: "LOOPT"-node pulseert ── */
@keyframes mq-pulse{0%,100%{box-shadow:0 0 0 0 rgba(47,217,200,.7)}60%{box-shadow:0 0 0 8px rgba(47,217,200,0)}}
.mq-run{animation:mq-pulse 1.6s ease-out infinite}

/* ── Focus ── */
a:focus-visible,button:focus-visible{outline:2px solid #0F766E;outline-offset:2px}

/* ── Reduced motion ── */
@media(prefers-reduced-motion:reduce){
  /* SVG-animatie wordt afgehandeld door JS (controleert prefers-reduced-motion) */
  .mq-hero-logo-sq,.mq-btn-y,.mq-btn-ghost,.mq-btn-cta,
  .mq-nav-cta>a,.mq-card,.mq-tile,.mq-step,.mq-step-num,.mq-word,.mq-mod{transition:none!important}
  .mq-hero-tile,.mq-hero-master{animation:none!important;transform:scale(1)!important}
  .mq-packet,.mq-flowstep,.mq-stampnum{animation:none!important}
  .mq-packet{display:none!important}
  .mq-run{animation:none!important}
}
</style>

<script>
/* Header-logo: animatie via SMIL (native SVG, ingebakken in de PHP-output).
   Hero-logo: animatie via JS setInterval (bars + paden + cirkels).
   Scroll, smooth-scroll, Aanpak-hover: standaard events. */
(function() {
  document.addEventListener('DOMContentLoaded', function() {

    /* Hero-logo: animatie via SMIL ingebakken in post-content (zie eval-file mq-hero-smil.php).
       Geen JS-animatie nodig — SMIL start automatisch zodra de SVG gerenderd is. */

    /* ── Header scroll-schaduw ── */
    var masthead = document.getElementById('masthead');
    if (masthead) {
      var sc = false;
      window.addEventListener('scroll', function() {
        var p = window.scrollY > 60;
        if (p !== sc) { sc = p; masthead.classList.toggle('mq-scrolled', p); }
      }, {passive: true});
    }

    /* ── Smooth scroll ── */
    document.addEventListener('click', function(e) {
      var a = e.target.closest('a[href^="#"]');
      if (!a) return;
      var id = a.getAttribute('href').slice(1);
      if (!id) return;
      var el = document.getElementById(id);
      if (el) { e.preventDefault(); el.scrollIntoView({behavior: 'smooth', block: 'start'}); }
    });

    /* ── Aanpak: gekoppelde hover woord ↔ stap ── */
    var words = document.querySelectorAll('.mq-word');
    var steps = document.querySelectorAll('.mq-step');
    if (words.length && steps.length) {
      steps.forEach(function(step, i) {
        step.addEventListener('mouseenter', function() {
          words.forEach(function(w, j) { w.classList.toggle('is-active', j === i); });
        });
        step.addEventListener('mouseleave', function() {
          words.forEach(function(w) { w.classList.remove('is-active'); });
        });
      });
    }

    /* ── Generieke tabs (Semantics-mockup, Dashboard-pagina) ── */
    document.addEventListener('click', function(e) {
      var tab = e.target.closest('.mq-tab');
      if (!tab) return;
      var group = tab.closest('[data-mq-tabs]');
      if (!group) return;
      var name = tab.getAttribute('data-mq-tab');
      group.querySelectorAll('.mq-tab').forEach(function(t) {
        t.classList.toggle('is-active', t === tab);
      });
      group.querySelectorAll('.mq-tabpanel').forEach(function(p) {
        p.classList.toggle('is-active', p.getAttribute('data-mq-panel') === name);
      });
    });

    /* ── Insights-mockup: donker/licht-toggle ── */
    var mqThemes = {
      dark:  {'--bg':'#06122A','--panel':'#0B2545','--line':'#133A66','--text':'#FAF7F0','--muted':'#6FA0CF','--faint':'#2E5D8F','--chip':'#133A66'},
      light: {'--bg':'#F2EFE6','--panel':'#FFFFFF','--line':'#E6E2D6','--text':'#0B0B0B','--muted':'#7C7A75','--faint':'#B7B4AD','--chip':'#C9C4B5'}
    };
    document.addEventListener('click', function(e) {
      var btn = e.target.closest('.mq-theme-btn');
      if (!btn) return;
      var mock = btn.closest('.mq-insights-mock');
      if (!mock) return;
      var mode = btn.getAttribute('data-mq-theme-btn');
      var vars = mqThemes[mode];
      if (!vars) return;
      Object.keys(vars).forEach(function(k) { mock.style.setProperty(k, vars[k]); });
      mock.setAttribute('data-mq-theme', mode);
      mock.querySelectorAll('.mq-theme-btn').forEach(function(b) {
        b.classList.toggle('is-active', b === btn);
      });
      mock.querySelectorAll('[data-mq-theme-color]').forEach(function(el) {
        var pair = el.getAttribute('data-mq-theme-color').split('|');
        el.style.color = mode === 'dark' ? pair[0] : pair[1];
      });
      mock.querySelectorAll('[data-mq-theme-shadow]').forEach(function(el) {
        var pair = el.getAttribute('data-mq-theme-shadow').split('|');
        el.style.boxShadow = '4px 4px 0 0 ' + (mode === 'dark' ? pair[0] : pair[1]);
      });
    });

    /* ── Insights-mockup: drill-down (klik op weekstaaf) ── */
    document.addEventListener('click', function(e) {
      var bar = e.target.closest('[data-mq-week-tickets]');
      if (bar) {
        var mock = bar.closest('.mq-insights-mock');
        if (!mock) return;
        var overlay = mock.querySelector('[data-mq-drill-overlay]');
        var panel = mock.querySelector('[data-mq-drill-panel]');
        if (!overlay || !panel) return;
        var label = bar.getAttribute('data-mq-week-label') || '';
        var titleEl = panel.querySelector('[data-mq-drill-title]');
        if (titleEl) titleEl.textContent = 'Onderliggende rijen · omzet ' + label;
        var rowsEl = panel.querySelector('[data-mq-drill-rows]');
        if (rowsEl) {
          var tickets = bar.getAttribute('data-mq-week-tickets').split(';').filter(Boolean);
          rowsEl.innerHTML = tickets.map(function(t) {
            var f = t.split('|');
            return '<div style="display:grid;grid-template-columns:1fr 1.4fr 1fr 1fr;font:400 12px \'Archivo\',sans-serif;color:var(--text,#FAF7F0);border-bottom:1px solid var(--line,#133A66);padding:4px 0">' +
              '<span style="font-family:\'JetBrains Mono\',monospace;font-size:10.5px;color:var(--muted,#6FA0CF)">' + f[0] + '</span>' +
              '<span>' + f[1] + '</span><span>' + f[2] + '</span>' +
              '<span style="text-align:right;font-family:\'JetBrains Mono\',monospace;font-size:10.5px">' + f[3] + '</span></div>';
          }).join('');
        }
        overlay.classList.add('is-active');
        panel.classList.add('is-active');
        return;
      }
      var closeEl = e.target.closest('[data-mq-drill-close], [data-mq-drill-overlay]');
      if (closeEl) {
        var mockClose = closeEl.closest('.mq-insights-mock');
        if (!mockClose) return;
        var ov = mockClose.querySelector('[data-mq-drill-overlay]');
        var pn = mockClose.querySelector('[data-mq-drill-panel]');
        if (ov) ov.classList.remove('is-active');
        if (pn) pn.classList.remove('is-active');
      }
    });

    /* ── Dashboard-pagina: tool-kiezer (Exploratie-tab) ── */
    document.addEventListener('click', function(e) {
      var chip = e.target.closest('[data-mq-tool]');
      if (!chip) return;
      var wrap = chip.closest('[data-mq-tool-group]');
      if (!wrap) return;
      wrap.querySelectorAll('[data-mq-tool]').forEach(function(c) {
        c.classList.toggle('is-active', c === chip);
      });
      var target = document.querySelector(wrap.getAttribute('data-mq-tool-group'));
      if (!target) return;
      ['name', 'sub', 'desc', 'branding', 'fit'].forEach(function(key) {
        var out = target.querySelector('[data-mq-tool-' + key + ']');
        if (out) out.textContent = chip.getAttribute('data-mq-' + key) || '';
      });
    });

    /* ── Generieke wegklikbare melding (Semantics-mockup: "Wat is een KPI?") ── */
    document.addEventListener('click', function(e) {
      var closeBtn = e.target.closest('[data-mq-dismiss]');
      if (!closeBtn) return;
      var box = closeBtn.closest('.mq-dismissible');
      if (box) box.style.display = 'none';
    });

  });
})();
</script>
<?php }, 999);

// ── Colophon verwijderen ───────────────────────────────────────────────────
add_action('get_footer', function() { ob_start(); }, 1);
add_action('wp_footer', function() {
    $out = ob_get_clean();
    $out = preg_replace('/<footer[^>]*id=["\']colophon["\'][^>]*>.*?<\/footer>\s*<!--\s*#colophon\s*-->/is', '', $out);
    echo $out;
}, 1);

// ── SVG uploads ───────────────────────────────────────────────────────────
add_filter('upload_mimes', function($m) { $m['svg'] = 'image/svg+xml'; return $m; });
add_filter('wp_check_filetype_and_ext', function($d, $f, $fn, $m) {
    if (strtolower(pathinfo($fn, PATHINFO_EXTENSION)) === 'svg') {
        $d['type'] = 'image/svg+xml'; $d['ext'] = 'svg';
    }
    return $d;
}, 10, 4);

// ── Assets URL ───────────────────────────────────────────────────────────
add_action('init', function() {
    if (!defined('MQ_ASSETS_URL')) define('MQ_ASSETS_URL', content_url('/meetriq-assets/'));
});
