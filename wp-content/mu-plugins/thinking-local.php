<?php
/**
 * Thinking Local — WordPress mu-plugin
 * wp-content/mu-plugins/thinking-local.php
 *
 * Logo is een placeholder bar-chart SVG tot het definitieve logo ontworpen is.
 * Vervang hl_svg_logo() zodra logo-assets beschikbaar zijn in design-allthingslocal.
 */

// ── Logo: bar chart SVG lockup (placeholder) ──
add_filter('kadence_custom_logo', 'tl_svg_logo', 99, 2);
function tl_svg_logo($html, $blog_id) {
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 44" height="44" width="40" fill="none" aria-hidden="true" style="flex:none">
  <rect x="2"  y="32" width="10" height="10" rx="2" fill="#F5B800"/>
  <rect x="15" y="22" width="10" height="20" rx="2" fill="#1A2E5A"/>
  <rect x="28" y="10" width="10" height="32" rx="2" fill="#1A2E5A"/>
  <polyline points="7,32 20,22 33,10" fill="none" stroke="#F5B800" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
  <circle cx="33" cy="10" r="3.5" fill="#F5B800"/>
  <circle cx="20" cy="22" r="2.5" fill="#F5B800"/>
  <circle cx="7"  cy="32" r="2"   fill="#F5B800"/>
</svg>
<span style="display:flex;flex-direction:column;line-height:1;gap:5px;padding-left:4px">
  <span style="font-family:\'Inter\',system-ui,sans-serif;font-weight:800;font-size:21px;letter-spacing:-.02em;color:#1A2E5A;line-height:1">Thinking</span>
  <span style="font-family:\'Inter\',system-ui,sans-serif;font-weight:800;font-size:17px;letter-spacing:-.02em;background:#F5B800;color:#1A2E5A;padding:2px 8px;display:inline-block;line-height:1.3">Local</span>
</span>';
}

// ── CSS + JS (priority 999 = na alle Kadence inline styles) ──
add_action('wp_head', function() { ?>
<style>
/* ── Header ── */
#masthead,
#masthead .kadence-sticky-header.item-is-fixed,
#masthead .kadence-sticky-header.item-is-fixed > .site-header-row-container-inner,
#masthead .site-header-inner-wrap,
.site-header { background:#ffffff!important; border-bottom:1px solid #e5e7eb!important; }

#masthead { transition:box-shadow .25s ease, border-color .25s ease; }
#masthead.tl-scrolled { box-shadow:0 2px 20px rgba(26,46,90,.12)!important; border-bottom-color:#1A2E5A!important; }
#masthead.tl-scrolled .site-branding svg { height:36px!important; width:32px!important; }

/* ── Logo lockup ── */
.site-branding .brand { display:flex!important; align-items:center!important; gap:10px!important; text-decoration:none!important; }
.site-branding .site-title { display:none!important; }

/* ── Nav ── */
#site-navigation a, .main-navigation a {
  color:#1A2E5A!important; font-family:'Inter',system-ui,sans-serif!important;
  font-weight:600!important; font-size:15px!important; text-decoration:none!important;
}
#site-navigation a:hover, .main-navigation a:hover { color:#F5B800!important; background:transparent!important; }
.current-menu-item > a, .current_page_item > a { color:#F5B800!important; }

/* ── Sticky hamburger op desktop bij scrollen ── */
.tl-burger-btn {
  display:none; align-items:center; gap:8px;
  background:#F5B800; color:#1A2E5A; border:2px solid #1A2E5A;
  box-shadow:3px 3px 0 0 #1A2E5A; padding:8px 14px;
  font-family:'Inter',system-ui,sans-serif; font-weight:700; font-size:14px;
  cursor:pointer; transition:transform .15s, box-shadow .15s;
}
.tl-burger-btn:hover { transform:translate(-1px,-1px); box-shadow:4px 4px 0 0 #1A2E5A; }
.tl-burger-btn svg { pointer-events:none; }
@media(min-width:1025px) {
  #masthead.tl-scrolled #site-navigation {
    opacity:0; pointer-events:none; transform:translateY(-6px);
    transition:opacity .2s ease, transform .2s ease;
  }
  #masthead:not(.tl-scrolled) #site-navigation {
    opacity:1; pointer-events:auto; transform:none;
    transition:opacity .2s ease, transform .2s ease;
  }
  #masthead.tl-scrolled .tl-burger-btn { display:flex; }
}

/* ── Knoppen ── */
a.tl-btn-y, a.tl-btn-y:visited                     { color:#1A2E5A!important; }
a.tl-btn-y:hover, a.tl-btn-y:focus                  { color:#1A2E5A!important; background:#c99700!important; transform:translate(-2px,-2px); box-shadow:5px 5px 0 0 #1A2E5A!important; }
a.tl-btn-o, a.tl-btn-o:visited                     { color:#1A2E5A!important; }
a.tl-btn-o:hover, a.tl-btn-o:focus                  { color:#ffffff!important; background:#1A2E5A!important; }
a.tl-btn-d, a.tl-btn-d:visited                     { color:#ffffff!important; }
a.tl-btn-d:hover, a.tl-btn-d:focus                  { color:#ffffff!important; background:#111e3a!important; transform:translate(-1px,-1px); }

/* ── Platform cards (AutoBA, AI Agent, BMS Portal) ── */
.tl-platform-card {
  border-top:3px solid #F5B800;
  transition:background .18s ease, transform .18s ease, box-shadow .18s ease;
}
.tl-platform-card:hover { background:#F9FAFB; transform:translateY(-3px); box-shadow:0 8px 24px rgba(26,46,90,.1); }

/* ── Technologie stack labels ── */
.tl-stack-tag {
  display:inline-block;
  background:#1A2E5A; color:#ffffff;
  font-family:'Inter',system-ui,sans-serif; font-size:12px; font-weight:600;
  padding:3px 10px; border-radius:3px; letter-spacing:.02em;
}
.tl-stack-tag.accent { background:#F5B800; color:#1A2E5A; }

/* ── Klantcases ── */
.tl-case {
  border-left:4px solid #F5B800!important;
  transition:border-left-color .18s, box-shadow .18s;
}
.tl-case:hover { border-left-color:#1A2E5A!important; box-shadow:0 4px 20px rgba(26,46,90,.1)!important; }

/* ── Statistieken / metrics blokken ── */
.tl-stat { border-bottom:3px solid #F5B800; padding-bottom:12px; }
.tl-stat-num {
  font-family:'Inter',system-ui,sans-serif;
  font-size:48px!important; font-weight:800!important;
  color:#1A2E5A!important; line-height:1!important;
}
.tl-stat-label { color:#4B5563!important; font-size:14px!important; }

/* ── Sectieheader met gele onderlijn ── */
.tl-sh::after {
  content:''; display:block;
  width:40px; height:3px;
  background:#F5B800;
  margin-top:12px;
}

/* ── USP lijst ── */
.tl-usps {
  border-left:4px solid #F5B800!important;
  box-shadow:4px 4px 0 0 #F5B800!important;
}
.tl-usps li::before { color:#F5B800!important; }

/* ── CTA balk ── */
.tl-cta { position:relative; overflow:hidden; }
.tl-cta::before {
  content:''; position:absolute;
  top:0; left:0; bottom:0; width:5px;
  background:#F5B800;
}
.tl-cta-in { padding-left:28px!important; }
.tl-btn-d { box-shadow:4px 4px 0 0 #F5B800!important; }

/* ── Footer ── */
.tl-footer { padding:24px!important; }
.tl-footer-in { padding:0!important; }

/* ── Bar chart animatie (hero of sectie decoratie) ── */
@keyframes tl-bar-rise {
  from { transform:scaleY(0); transform-origin:bottom; opacity:0; }
  to   { transform:scaleY(1); transform-origin:bottom; opacity:1; }
}
.tl-bar   { animation:tl-bar-rise .55s cubic-bezier(.2,.8,.3,1) both; }
.tl-bar-2 { animation:tl-bar-rise .55s cubic-bezier(.2,.8,.3,1) .18s both; }
.tl-bar-3 { animation:tl-bar-rise .55s cubic-bezier(.2,.8,.3,1) .36s both; }

/* ── Colophon weg (backup CSS) ── */
footer#colophon, .kadence-credit, .footer-html-inner { display:none!important; }

/* ── Geen standaard WP padding op fullwidth page ── */
.entry-content, .site-main { padding:0!important; margin:0!important; }
.kadence-hero-wrap, .entry-hero-container-inner { display:none!important; }
</style>

<script>
(function(){
  var h = document.getElementById('masthead');
  if (h) {
    /* Voeg hamburger-knop toe in header-right */
    var btn = document.createElement('button');
    btn.className = 'tl-burger-btn';
    btn.setAttribute('aria-label', 'Menu');
    btn.setAttribute('aria-expanded', 'false');
    btn.innerHTML = '<svg width="18" height="13" viewBox="0 0 18 13" fill="none">' +
      '<path d="M0 1h18M0 6.5h18M0 12h18" stroke="#1A2E5A" stroke-width="2" stroke-linecap="round"/>' +
      '</svg>Menu';
    var headerRight = h.querySelector('.site-header-main-section-right');
    if (headerRight) headerRight.appendChild(btn);

    /* Burger opent Kadence mobile drawer */
    var drawer = document.getElementById('mobile-drawer');
    btn.addEventListener('click', function() {
      if (drawer) {
        drawer.classList.toggle('active');
        document.body.classList.toggle('showing-popup-drawer-from-right');
        btn.setAttribute('aria-expanded', drawer.classList.contains('active') ? 'true' : 'false');
      }
    });

    /* Scroll handler: shadow + hamburger zichtbaar */
    var scrolled = false;
    window.addEventListener('scroll', function() {
      var past = window.scrollY > 80;
      if (past !== scrolled) {
        scrolled = past;
        h.classList.toggle('tl-scrolled', past);
      }
    }, {passive:true});
  }

  /* ── Bar chart herstart animatie bij scroll in ── */
  document.addEventListener('DOMContentLoaded', function() {
    var charts = document.querySelectorAll('.tl-chart-anim');
    if (!charts.length || !('IntersectionObserver' in window)) return;
    var obs = new IntersectionObserver(function(entries) {
      entries.forEach(function(e) {
        if (!e.isIntersecting) return;
        obs.unobserve(e.target);
        e.target.style.display = 'none';
        void e.target.offsetWidth;
        e.target.style.display = '';
        setTimeout(function() { obs.observe(e.target); }, 2000);
      });
    }, {threshold:0.25});
    charts.forEach(function(c) { obs.observe(c); });
  });
})();
</script>
<?php }, 999);

// ── Colophon verwijderen via output buffer ──
add_action('get_footer', function() { ob_start(); }, 1);
add_action('wp_footer', function() {
    $out = ob_get_clean();
    $out = preg_replace('/<footer[^>]*id=["\']colophon["\'][^>]*>.*?<\/footer>\s*<!--\s*#colophon\s*-->/is', '', $out);
    echo $out;
}, 1);

// ── SVG uploads toestaan ──
add_filter('upload_mimes', function($m) { $m['svg'] = 'image/svg+xml'; return $m; });
add_filter('wp_check_filetype_and_ext', function($d, $f, $fn, $m) {
    if (strtolower(pathinfo($fn, PATHINFO_EXTENSION)) === 'svg') {
        $d['type'] = 'image/svg+xml'; $d['ext'] = 'svg';
    }
    return $d;
}, 10, 4);
