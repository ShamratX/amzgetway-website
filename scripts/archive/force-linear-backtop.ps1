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
  var scrolling = false;
  var timer = null;

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

  function killThemeScroll() {
    try {
      if (window.jQuery) {
        window.jQuery("html, body").stop(true, true);
        window.jQuery("#back_top").off("click");
      }
    } catch (e) {}
  }

  // Constant speed: fixed px every frame (no easing)
  function smoothToTop() {
    if (scrolling) return;
    killThemeScroll();
    var cur = y();
    if (cur <= 0) { lockNavbar(); return; }
    scrolling = true;
    var stepPx = 48; // constant pixels per tick
    var everyMs = 16; // ~60fps → ~3000px/s steady
    if (timer) clearInterval(timer);
    timer = setInterval(function () {
      cur = y();
      if (cur <= 0) {
        clearInterval(timer);
        timer = null;
        scrolling = false;
        window.scrollTo(0, 0);
        lockNavbar();
        return;
      }
      var next = cur - stepPx;
      if (next < 0) next = 0;
      window.scrollTo(0, next);
      if (document.documentElement) document.documentElement.scrollTop = next;
      if (document.body) document.body.scrollTop = next;
      lockNavbar();
    }, everyMs);
  }

  function onBackTopClick(e) {
    e.preventDefault();
    e.stopPropagation();
    if (e.stopImmediatePropagation) e.stopImmediatePropagation();
    smoothToTop();
    return false;
  }

  function bindBackTop() {
    killThemeScroll();
    var el = document.getElementById("back_top");
    if (!el) return;
    // Replace node to drop any leftover jQuery handlers
    var neo = el.cloneNode(true);
    el.parentNode.replaceChild(neo, el);
    neo.addEventListener("click", onBackTopClick, true);
  }

  document.documentElement.style.scrollBehavior = "auto";
  if (document.body) document.body.style.scrollBehavior = "auto";

  document.addEventListener("click", function (e) {
    var btn = e.target && e.target.closest ? e.target.closest("#back_top") : null;
    if (!btn) return;
    onBackTopClick(e);
  }, true);

  window.addEventListener("scroll", lockNavbar, { passive: true });

  function boot() {
    lockNavbar();
    bindBackTop();
    // After theme jQuery ready, unbind again
    setTimeout(bindBackTop, 100);
    setTimeout(bindBackTop, 600);
    setTimeout(killThemeScroll, 800);
  }

  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot);
  else boot();
  window.addEventListener("load", function () {
    lockNavbar();
    bindBackTop();
    killThemeScroll();
  });
})();
</script>
'@

# Also cache-bust main.js reference so browsers load patched file
$n = 0
foreach ($path in $pages) {
  $raw = [System.IO.File]::ReadAllText($path)
  if ($raw -notmatch 'amz-navbar-lock-js') { continue }
  $updated = [regex]::Replace($raw, '(?s)<script id="amz-navbar-lock-js">.*?</script>', $newJs.Trim(), 1)
  # cache bust theme main
  $updated = $updated -replace 'themes/avas/assets/js/main\.min\.js\?ver=[^"'']+', 'themes/avas/assets/js/main.min.js?ver=amz-linear1'
  $updated = $updated -replace 'themes/avas/assets/js/main\.js\?ver=[^"'']+', 'themes/avas/assets/js/main.js?ver=amz-linear1'
  if ($updated -ne $raw) {
    [System.IO.File]::WriteAllText($path, $updated)
    $n++
  }
}

Write-Host "Patched $n pages + theme main.js (no jQuery animate)"
$chk = [System.IO.File]::ReadAllText((Join-Path $export "index.html"))
Write-Host ("stepPx={0}" -f ($chk -match 'stepPx'))
Write-Host ("clone_bind={0}" -f ($chk -match 'cloneNode'))
Write-Host ("theme_animate_gone={0}" -f (-not ([System.IO.File]::ReadAllText((Join-Path $export "wp-content\themes\avas\assets\js\main.min.js")) -match 'animate\(\{scrollTop')))
