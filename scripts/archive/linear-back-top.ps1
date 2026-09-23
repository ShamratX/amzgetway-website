$ErrorActionPreference = "Stop"
$export = (Resolve-Path (Join-Path $PSScriptRoot "..\..\export\site")).Path

$pages = New-Object System.Collections.Generic.List[string]
[void]$pages.Add((Join-Path $export "index.html"))
Get-ChildItem -LiteralPath $export -Directory | Where-Object {
  $_.Name -notin @('wp-content','wp-includes','wp-admin')
} | ForEach-Object {
  Get-ChildItem -LiteralPath $_.FullName -Recurse -Filter index.html -File | ForEach-Object {
    [void]$pages.Add($_.FullName)
  }
}

$newJs = @'
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

  // Constant linear speed (~1800 px/sec) — same speed the whole way
  function smoothToTop() {
    var start = y();
    if (start <= 0) { lockNavbar(); return; }
    var pxPerMs = 1.8;
    var dur = Math.max(300, start / pxPerMs);
    var t0 = null;
    function frame(ts) {
      if (t0 === null) t0 = ts;
      var p = Math.min(1, (ts - t0) / dur);
      var next = start * (1 - p);
      window.scrollTo(0, next);
      if (document.documentElement) document.documentElement.scrollTop = next;
      if (document.body) document.body.scrollTop = next;
      lockNavbar();
      if (p < 1) {
        requestAnimationFrame(frame);
      } else {
        window.scrollTo(0, 0);
        if (document.documentElement) document.documentElement.scrollTop = 0;
        if (document.body) document.body.scrollTop = 0;
        lockNavbar();
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
    try {
      if (window.jQuery) {
        window.jQuery("html,body").stop(true, false);
      }
    } catch (err) {}
    smoothToTop();
  }, true);

  window.addEventListener("scroll", lockNavbar, { passive: true });
  window.addEventListener("load", lockNavbar);
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", lockNavbar);
  else lockNavbar();
})();
</script>
'@

$n = 0
foreach ($path in $pages) {
  $raw = [System.IO.File]::ReadAllText($path)
  if ($raw -notmatch 'amz-navbar-lock-js') { continue }
  $updated = [regex]::Replace($raw, '(?s)<script id="amz-navbar-lock-js">.*?</script>', $newJs.Trim(), 1)
  if ($updated -ne $raw) {
    [System.IO.File]::WriteAllText($path, $updated)
    $n++
  }
}

Write-Host "Updated $n pages to linear back-to-top speed"
$chk = [System.IO.File]::ReadAllText((Join-Path $export "index.html"))
Write-Host ("has_pxPerMs={0}" -f ($chk -match 'pxPerMs'))
Write-Host ("has_jquery_stop={0}" -f ($chk -match 'html,body"\)\.stop'))
