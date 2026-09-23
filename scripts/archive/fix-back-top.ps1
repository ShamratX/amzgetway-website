# Fix back-to-top smooth scroll + navbar visibility (SITE PAGES ONLY — never touch binaries)
$ErrorActionPreference = "Stop"
$export = (Resolve-Path (Join-Path $PSScriptRoot "..\..\export\site")).Path

$extraCss = @'
<style id="amz-backtop-fix">
body:not(.amz-scrolled) .main-header { visibility: visible !important; opacity: 1 !important; }
body:not(.amz-scrolled) .main-header.sticky-header { position: relative !important; transform: none !important; top: auto !important; }
#header.tx-header, #header .main-header { visibility: visible !important; }
#back_top { cursor: pointer; z-index: 99999; }
</style>
'@

$extraJs = @'
<script id="amz-backtop-fix-js">
(function () {
  function y() { return window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0; }
  function syncHeader() {
    var top = y();
    var header = document.querySelector(".tx-header");
    var main = document.querySelector(".main-header");
    if (top >= 100) {
      document.body.classList.add("amz-scrolled");
      if (header) header.classList.add("tx-scrolled");
      if (main) main.classList.add("sticky-header");
    } else {
      document.body.classList.remove("amz-scrolled");
      if (header) header.classList.remove("tx-scrolled");
      if (main) {
        main.classList.remove("sticky-header");
        main.style.removeProperty("transform");
        main.style.removeProperty("top");
        main.style.removeProperty("position");
      }
    }
  }
  function smoothToTop(duration) {
    var start = y();
    if (start <= 0) { syncHeader(); return; }
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
      syncHeader();
      if (p < 1) requestAnimationFrame(frame);
      else {
        window.scrollTo(0, 0);
        if (document.documentElement) document.documentElement.scrollTop = 0;
        if (document.body) document.body.scrollTop = 0;
        syncHeader();
        setTimeout(syncHeader, 50);
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
  window.addEventListener("scroll", syncHeader, { passive: true });
  window.addEventListener("load", syncHeader);
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", syncHeader);
  else syncHeader();
})();
</script>
'@

# Only real site pages (never wp-content / binaries)
$pages = New-Object System.Collections.Generic.List[string]
$pages.Add((Join-Path $export "index.html"))
Get-ChildItem -LiteralPath $export -Directory | Where-Object {
  $_.Name -notin @('wp-content','wp-includes','wp-admin')
} | ForEach-Object {
  Get-ChildItem -LiteralPath $_.FullName -Recurse -Filter index.html -File | ForEach-Object { $pages.Add($_.FullName) }
}

$n = 0
foreach ($path in $pages) {
  if (-not (Test-Path -LiteralPath $path)) { continue }
  $raw = [System.IO.File]::ReadAllText($path)
  $orig = $raw
  $raw = [regex]::Replace($raw, '(?s)<style id="amz-backtop-fix">.*?</style>\s*', '')
  $raw = [regex]::Replace($raw, '(?s)<script id="amz-backtop-fix-js">.*?</script>\s*', '')
  if ($raw -match '(?i)</head>') {
    $raw = [regex]::Replace($raw, '(?i)</head>', ($extraCss.Trim() + "`n</head>"), 1)
  }
  if ($raw -match '(?i)</body>') {
    $raw = [regex]::Replace($raw, '(?i)</body>', ($extraJs.Trim() + "`n</body>"), 1)
  } else {
    $raw += "`n" + $extraJs.Trim()
  }
  if ($raw -ne $orig) {
    [System.IO.File]::WriteAllText($path, $raw)
    $n++
  }
}
Write-Host ("Patched {0} site pages only" -f $n)
