# Fix static fidelity: restore scroll animations, keep layout, reduce banner flash
$ErrorActionPreference = "Stop"
$export = Resolve-Path (Join-Path $PSScriptRoot "..\..\export\site")

$newInject = @'
<style id="amz-static-fidelity">
/* Layout only — do NOT force .elementor-invisible visible (kills scroll animations) */
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
/* After timeout, .amz-anim-fallback reveals stuck invisible sections only */
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
        if (u && /dummy\.png/i.test(img.getAttribute("src") || "")) {
          img.setAttribute("src", u);
        }
      });
      // also title-based slide backgrounds that only have dummy src
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
    // Only if Elementor left sections invisible after animations should have run
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
    // Give Elementor scroll animations ~2.8s, then unstick leftovers
    setTimeout(fallbackStuck, 2800);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", boot);
  } else {
    boot();
  }
  window.addEventListener("load", function () {
    swapRevLazy();
    setTimeout(redrawRev, 100);
  });
})();
</script>
'@

$htmlFiles = Get-ChildItem -LiteralPath $export -Recurse -File -Include *.html,*.htm
$n = 0
foreach ($f in $htmlFiles) {
  $raw = [System.IO.File]::ReadAllText($f.FullName)
  $orig = $raw

  if ($raw -match '(?s)<style id="amz-static-fidelity">.*?</style>\s*<script id="amz-static-fidelity-js">.*?</script>') {
    $raw = [regex]::Replace($raw, '(?s)<style id="amz-static-fidelity">.*?</style>\s*<script id="amz-static-fidelity-js">.*?</script>', $newInject.Trim(), 1)
  } elseif ($raw -match '(?s)<style id="amz-static-fidelity">.*?</style>') {
    $raw = [regex]::Replace($raw, '(?s)<style id="amz-static-fidelity">.*?</style>(?:\s*<script id="amz-static-fidelity-js">.*?</script>)?', $newInject.Trim(), 1)
  } elseif ($raw -match '(?i)</head>') {
    $raw = [regex]::Replace($raw, '(?i)</head>', ($newInject.Trim() + "`n</head>"), 1)
  }

  # Progressive: replace dummy.png src with data-lazyload URL when present (reduce banner flash)
  $raw = [regex]::Replace($raw,
    'src="[^"]*dummy\.png"([^>]*data-lazyload="([^"]+)")',
    { param($m) 'src="' + $m.Groups[2].Value + '"' + $m.Groups[1].Value })
  # also when data-lazyload appears before src
  $raw = [regex]::Replace($raw,
    '(data-lazyload="([^"]+)"[^>]*)src="[^"]*dummy\.png"',
    { param($m) $m.Groups[1].Value + 'src="' + $m.Groups[2].Value + '"' })

  if ($raw -ne $orig) {
    [System.IO.File]::WriteAllText($f.FullName, $raw)
    $n++
  }
}

Write-Host "Updated $n HTML files"

# Verify home inject no longer forces elementor-invisible
$home = Get-Content (Join-Path $export "index.html") -Raw
$bad = $home -match '(?s)amz-static-fidelity">.*?\.elementor-invisible,\s*\.elementor-element\.elementor-invisible'
$hasFallback = $home -match 'amz-anim-fallback'
$dummyLeft = ([regex]::Matches($home, 'src="[^"]*dummy\.png"')).Count
$lazyOk = ([regex]::Matches($home, 'data-lazyload=')).Count
Write-Host "still_has_force_visible_rule=$bad"
Write-Host "has_fallback_class_logic=$hasFallback"
Write-Host "dummy_src_remaining=$dummyLeft lazyload_attrs=$lazyOk"
