# Always-lock navbar (fixed) on static site pages only
$ErrorActionPreference = "Stop"
$export = (Resolve-Path (Join-Path $PSScriptRoot "..\..\export\site")).Path

$lockCss = @'
<style id="amz-navbar-lock">
/* Always-locked navbar */
#header.tx-header {
  position: relative;
  z-index: 10000;
}
#header .main-header,
#h-style-3.main-header,
.main-header.sticky-header {
  position: fixed !important;
  top: 0 !important;
  left: 0 !important;
  right: 0 !important;
  width: 100% !important;
  z-index: 10000 !important;
  transform: none !important;
  visibility: visible !important;
  opacity: 1 !important;
  background-color: #ffffff !important;
  box-shadow: 0 0 10px 0 rgb(0 0 0 / 15%) !important;
}
/* Prefer sticky logo when locked */
#header .main-header .tx_logo { display: none !important; }
#header .main-header .tx_logo.tx_sticky_logo { display: block !important; }
/* Space so page content is not hidden under fixed bar */
body.amz-nav-locked #page,
body.amz-nav-locked .tx-wrapper {
  padding-top: 75px !important;
}
#back_top { cursor: pointer; z-index: 99999; }
</style>
'@

$lockJs = @'
<script id="amz-navbar-lock-js">
(function () {
  function y() {
    return window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
  }

  function lockNavbar() {
    document.body.classList.add("amz-nav-locked", "amz-scrolled");
    var header = document.querySelector(".tx-header");
    var main = document.querySelector(".main-header");
    if (header) header.classList.add("tx-scrolled");
    if (main) {
      main.classList.add("sticky-header");
      main.style.setProperty("position", "fixed", "important");
      main.style.setProperty("top", "0px", "important");
      main.style.setProperty("left", "0px", "important");
      main.style.setProperty("width", "100%", "important");
      main.style.setProperty("transform", "none", "important");
      main.style.setProperty("visibility", "visible", "important");
      main.style.setProperty("opacity", "1", "important");
    }
  }

  function smoothToTop(duration) {
    var start = y();
    if (start <= 0) { lockNavbar(); return; }
    var t0 = null;
    var dur = duration || 550;
    function easeOutCubic(p) { return 1 - Math.pow(1 - p, 3); }
    function frame(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / dur);
      var next = start * (1 - easeOutCubic(p));
      window.scrollTo(0, next);
      if (document.documentElement) document.documentElement.scrollTop = next;
      if (document.body) document.body.scrollTop = next;
      lockNavbar();
      if (p < 1) requestAnimationFrame(frame);
      else {
        window.scrollTo(0, 0);
        if (document.documentElement) document.documentElement.scrollTop = 0;
        if (document.body) document.body.scrollTop = 0;
        lockNavbar();
        setTimeout(lockNavbar, 50);
      }
    }
    requestAnimationFrame(frame);
  }

  document.addEventListener("click", function (e) {
    var btn = e.target && e.target.closest ? e.target.closest("#back_top, a.back_top, div.back_top") : null;
    if (!btn) return;
    e.preventDefault();
    e.stopPropagation();
    if (e.stopImmediatePropagation) e.stopImmediatePropagation();
    smoothToTop(550);
  }, true);

  // Keep locked on scroll / load (never unlock)
  window.addEventListener("scroll", lockNavbar, { passive: true });
  window.addEventListener("load", lockNavbar);
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", lockNavbar);
  } else {
    lockNavbar();
  }
})();
</script>
'@

$pages = New-Object System.Collections.Generic.List[string]
$pages.Add((Join-Path $export "index.html"))
Get-ChildItem -LiteralPath $export -Directory | Where-Object {
  $_.Name -notin @('wp-content','wp-includes','wp-admin')
} | ForEach-Object {
  Get-ChildItem -LiteralPath $_.FullName -Recurse -Filter index.html -File | ForEach-Object { [void]$pages.Add($_.FullName) }
}

$n = 0
foreach ($path in $pages) {
  if (-not (Test-Path -LiteralPath $path)) { continue }
  $raw = [System.IO.File]::ReadAllText($path)
  $orig = $raw

  # Remove older backtop/navbar injects
  $raw = [regex]::Replace($raw, '(?s)<style id="amz-backtop-fix">.*?</style>\s*', '')
  $raw = [regex]::Replace($raw, '(?s)<script id="amz-backtop-fix-js">.*?</script>\s*', '')
  $raw = [regex]::Replace($raw, '(?s)<style id="amz-navbar-lock">.*?</style>\s*', '')
  $raw = [regex]::Replace($raw, '(?s)<script id="amz-navbar-lock-js">.*?</script>\s*', '')

  if ($raw -match '(?i)</head>') {
    $raw = [regex]::Replace($raw, '(?i)</head>', ($lockCss.Trim() + "`n</head>"), 1)
  }
  if ($raw -match '(?i)</body>') {
    $raw = [regex]::Replace($raw, '(?i)</body>', ($lockJs.Trim() + "`n</body>"), 1)
  } else {
    $raw += "`n" + $lockJs.Trim()
  }

  if ($raw -ne $orig) {
    [System.IO.File]::WriteAllText($path, $raw)
    $n++
  }
}

Write-Host ("Navbar locked on {0} site pages" -f $n)
$index = [System.IO.File]::ReadAllText((Join-Path $export "index.html"))
Write-Host ("has_lock_css={0}" -f ($index -match 'amz-navbar-lock'))
Write-Host ("has_lock_js={0}" -f ($index -match 'amz-nav-locked'))
Write-Host ("no_old_unlock={0}" -f (-not ($index -match 'position: relative !important;\s*transform: none !important;\s*top: auto')))
