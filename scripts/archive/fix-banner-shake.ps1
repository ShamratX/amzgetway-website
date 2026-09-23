# Stop full-page banner shake on reload (static export only)
$ErrorActionPreference = "Stop"
$export = Resolve-Path (Join-Path $PSScriptRoot "..\..\export\site")

$newInject = @'
<style id="amz-static-fidelity">
/* Layout: full-bleed without stretch jump */
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
/* Stabilize banner / stretched sections so they do NOT slide-shake into place on reload */
.elementor-section.elementor-section-full_width,
.elementor-section.elementor-section-stretched,
.rev_slider_wrapper,
.rev_slider,
.forcefullwidth_wrapper_tp_banner {
  width: 100% !important;
  max-width: 100% !important;
  left: 0 !important;
  right: 0 !important;
  margin-left: 0 !important;
  margin-right: 0 !important;
  transition: none !important;
}
/* Hero banner section: no transform/position settle animation */
.elementor-element-bfae6c4,
.elementor-element-bfae6c4.elementor-section-stretched,
.elementor-element-bfae6c4 .rev_slider_wrapper,
.elementor-element-bfae6c4 .forcefullwidth_wrapper_tp_banner,
.elementor-element-bfae6c4 .rev_slider {
  transform: none !important;
  -webkit-transform: none !important;
  left: 0 !important;
  width: 100% !important;
  max-width: 100% !important;
  transition: none !important;
  animation: none !important;
}
#wpadminbar { display: none !important; }
.amz-anim-fallback .elementor-invisible {
  visibility: visible !important;
  opacity: 1 !important;
}
/* Kill headShake on any full-bleed section (looks like page/banner shaking) */
.elementor-section-stretched.animated.headShake,
.elementor-section-full_width.animated.headShake,
.elementor-element-1f6ce22 {
  animation: none !important;
  -webkit-animation: none !important;
}
</style>
<script id="amz-static-fidelity-js">
(function () {
  function pinFullBleed() {
    try {
      document.querySelectorAll(".elementor-section-stretched, .elementor-section-full_width, .forcefullwidth_wrapper_tp_banner, .rev_slider_wrapper").forEach(function (el) {
        el.style.setProperty("left", "0px", "important");
        el.style.setProperty("width", "100%", "important");
        el.style.setProperty("max-width", "100%", "important");
        el.style.setProperty("margin-left", "0px", "important");
        el.style.setProperty("transform", "none", "important");
        el.style.setProperty("transition", "none", "important");
      });
    } catch (e) {}
  }

  function swapRevLazy() {
    try {
      document.querySelectorAll("img[data-lazyload]").forEach(function (img) {
        var u = img.getAttribute("data-lazyload");
        if (!u) return;
        if (/dummy\.png/i.test(img.getAttribute("src") || "")) img.setAttribute("src", u);
      });
    } catch (e) {}
  }

  function stripHeadShake() {
    try {
      document.querySelectorAll('[data-settings*="headShake"]').forEach(function (el) {
        var s = el.getAttribute("data-settings") || "";
        el.setAttribute("data-settings", s.replace(/headShake/g, "none"));
        el.classList.remove("headShake", "animated");
      });
    } catch (e) {}
  }

  function fallbackStuck() {
    var stuck = document.querySelectorAll(".elementor-invisible");
    if (!stuck.length) return;
    document.documentElement.classList.add("amz-anim-fallback");
    stuck.forEach(function (el) { el.classList.remove("elementor-invisible"); });
  }

  function boot() {
    stripHeadShake();
    swapRevLazy();
    pinFullBleed();
    // Pin a few times while Elementor/RevSlider init — no resize/revredraw (those cause shake)
    setTimeout(pinFullBleed, 0);
    setTimeout(pinFullBleed, 150);
    setTimeout(pinFullBleed, 500);
    setTimeout(fallbackStuck, 2800);
  }

  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot);
  else boot();
  window.addEventListener("load", function () {
    swapRevLazy();
    pinFullBleed();
  });
})();
</script>
'@

$htmlFiles = @(Get-ChildItem -LiteralPath $export -Recurse -File -Include *.html,*.htm)
$n = 0
foreach ($f in $htmlFiles) {
  $raw = [System.IO.File]::ReadAllText($f.FullName)
  $orig = $raw

  if ($raw -match '(?s)<style id="amz-static-fidelity">.*?</style>\s*<script id="amz-static-fidelity-js">.*?</script>') {
    $raw = [regex]::Replace($raw, '(?s)<style id="amz-static-fidelity">.*?</style>\s*<script id="amz-static-fidelity-js">.*?</script>', $newInject.Trim(), 1)
  } elseif ($raw -match '(?s)<style id="amz-static-fidelity">.*?</style>') {
    $raw = [regex]::Replace($raw, '(?s)<style id="amz-static-fidelity">.*?</style>(?:\s*<script id="amz-static-fidelity-js">.*?</script>)?', $newInject.Trim(), 1)
  }

  # Permanently remove headShake entrance on stretched sections (homepage banner-area shake)
  $raw = $raw.Replace('&quot;animation&quot;:&quot;headShake&quot;', '&quot;animation&quot;:&quot;none&quot;')
  $raw = $raw.Replace('"animation":"headShake"', '"animation":"none"')

  if ($raw -ne $orig) {
    [System.IO.File]::WriteAllText($f.FullName, $raw)
    $n++
  }
}

Write-Host ("Updated {0} HTML files (banner shake fix)" -f $n)

# Verify homepage
$idxPath = Join-Path $export "index.html"
$index = [System.IO.File]::ReadAllText($idxPath)
Write-Host ("headShake_left={0}" -f (($index -split 'headShake').Count - 1))
Write-Host ("has_no_redraw={0}" -f (-not ($index -match 'revredraw')))
Write-Host ("has_stable_banner_css={0}" -f ($index -match 'elementor-element-bfae6c4'))
Write-Host ("has_stretch_guard={0}" -f ($index -match 'pinFullBleed'))
