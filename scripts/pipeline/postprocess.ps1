# Post-process static export for Cloudflare fidelity
$ErrorActionPreference = "Stop"
$export = Resolve-Path (Join-Path $PSScriptRoot "..\..\export\site")

$exts = @("*.html","*.htm","*.css","*.js","*.json","*.svg","*.xml")
Write-Host "Scanning files under $export ..."
$files = Get-ChildItem -LiteralPath $export -Recurse -File -Include $exts -ErrorAction SilentlyContinue
Write-Host "Files to process: $($files.Count)"

$replacements = @(
  @{ From = 'https://www.amzgetway.com'; To = '' },
  @{ From = 'http://www.amzgetway.com'; To = '' },
  @{ From = 'https://amzgetway.com'; To = '' },
  @{ From = 'http://amzgetway.com'; To = '' },
  @{ From = 'https://wordpress'; To = '' },
  @{ From = 'http://wordpress'; To = '' },
  @{ From = 'http://127.0.0.1:8080'; To = '' },
  @{ From = 'https://127.0.0.1:8080'; To = '' },
  @{ From = 'http://localhost:8080'; To = '' },
  @{ From = 'https://localhost:8080'; To = '' },
  @{ From = 'http://host.docker.internal:8080'; To = '' },
  @{ From = 'https:\/\/www.amzgetway.com'; To = '' },
  @{ From = 'http:\/\/www.amzgetway.com'; To = '' },
  @{ From = 'https:\/\/amzgetway.com'; To = '' },
  @{ From = 'http:\/\/amzgetway.com'; To = '' },
  @{ From = 'https:\/\/wordpress'; To = '' },
  @{ From = 'http:\/\/wordpress'; To = '' },
  @{ From = 'https:\/\/127.0.0.1:8080'; To = '' },
  @{ From = 'http:\/\/127.0.0.1:8080'; To = '' },
  @{ From = 'https:\/\/localhost:8080'; To = '' },
  @{ From = 'http:\/\/localhost:8080'; To = '' }
)

$n = 0
foreach ($f in $files) {
  $raw = [System.IO.File]::ReadAllText($f.FullName)
  $orig = $raw
  foreach ($r in $replacements) {
    $raw = $raw.Replace($r.From, $r.To)
  }
  # protocol-relative hosts
  $raw = [regex]::Replace($raw, '(?i)(^|["''=\s(])//(?:www\.)?amzgetway\.com', '$1')
  $raw = [regex]::Replace($raw, '(?i)(^|["''=\s(])//wordpress(?=[/:"''\s]|$)', '$1')
  $raw = [regex]::Replace($raw, '(?i)https?:http://', 'http://')
  # common wget leftover host folders in attrs
  $raw = $raw.Replace('//127.0.0.1:8080', '')

  # Restore emails damaged if host rewrite hit @amzgetway.com
  $raw = $raw.Replace('amzexperts@127.0.0.1:8080', 'amzexperts@amzgetway.com')
  $raw = $raw.Replace('amzsolution@127.0.0.1:8080', 'amzsolution@amzgetway.com')
  $raw = $raw.Replace('amzexperts@127.0.0.1', 'amzexperts@amzgetway.com')
  $raw = $raw.Replace('amzsolution@127.0.0.1', 'amzsolution@amzgetway.com')

  if ($raw -ne $orig) {
    [System.IO.File]::WriteAllText($f.FullName, $raw)
    $n++
  }
}
Write-Host "Rewrote $n files"

# Inject static fidelity CSS/JS into every HTML head
# IMPORTANT: do not force .elementor-invisible visible — that kills scroll animations
$inject = @'
<style id="amz-static-fidelity">
/* Layout only — scroll animations need .elementor-invisible intact */
.container.space-blank,
#page.tx-wrapper.container-fluid {
  max-width: 100% !important;
  width: 100% !important;
  padding-left: 0 !important;
  padding-right: 0 !important;
}
#page > .row { margin-left: 0 !important; margin-right: 0 !important; }
#header .main-header > .container-fluid {
  padding-left: 40px !important;
  padding-right: 40px !important;
}
.elementor-section.elementor-section-full_width,
.rev_slider_wrapper, .rev_slider, .forcefullwidth_wrapper_tp_banner {
  width: 100% !important;
  left: 0 !important;
  max-width: 100% !important;
}
#wpadminbar { display: none !important; }
.amz-anim-fallback .elementor-invisible {
  visibility: visible !important;
  opacity: 1 !important;
}
</style>
<script id="amz-static-fidelity-js">
(function () {
  function swapRevLazy() {
    try {
      document.querySelectorAll("img.rs-lazyload[data-lazyload], img.tp-rs-img[data-lazyload], img.rev-slidebg[data-lazyload]").forEach(function (img) {
        var u = img.getAttribute("data-lazyload");
        if (u && /dummy\.png/i.test(img.getAttribute("src") || "")) img.setAttribute("src", u);
      });
      document.querySelectorAll('img.rev-slidebg[src*="dummy.png"]').forEach(function (img) {
        var lazy = img.getAttribute("data-lazyload");
        if (lazy) img.setAttribute("src", lazy);
      });
    } catch (e) {}
  }
  function redrawRev() {
    try {
      if (window.jQuery && jQuery.fn && jQuery.fn.revolution) {
        jQuery(".rev_slider").each(function () {
          var $s = jQuery(this);
          try { $s.revredraw(); } catch (e1) {}
          try { $s.revrevive(); } catch (e2) {}
        });
      }
      window.dispatchEvent(new Event("resize"));
    } catch (e) {}
  }
  function fallbackStuck() {
    var stuck = document.querySelectorAll(".elementor-invisible");
    if (!stuck.length) return;
    document.documentElement.classList.add("amz-anim-fallback");
    stuck.forEach(function (el) { el.classList.remove("elementor-invisible"); });
  }
  function boot() {
    swapRevLazy();
    setTimeout(swapRevLazy, 50);
    setTimeout(redrawRev, 300);
    setTimeout(redrawRev, 1000);
    setTimeout(fallbackStuck, 2800);
  }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot);
  else boot();
  window.addEventListener("load", function () { swapRevLazy(); setTimeout(redrawRev, 100); });
})();
</script>
'@

$htmlFiles = Get-ChildItem -LiteralPath $export -Recurse -File -Include *.html,*.htm -ErrorAction SilentlyContinue
$hi = 0
foreach ($f in $htmlFiles) {
  $raw = [System.IO.File]::ReadAllText($f.FullName)
  if ($raw -match 'amz-static-fidelity') { continue }
  if ($raw -match '(?i)</head>') {
    $raw = [regex]::Replace($raw, '(?i)</head>', ($inject + "`n</head>"), 1)
    [System.IO.File]::WriteAllText($f.FullName, $raw)
    $hi++
  }
}
Write-Host "Injected fidelity fixes into $hi HTML files"
Write-Host "Post-process done."
