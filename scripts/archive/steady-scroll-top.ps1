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

  function setPos(v) {
    window.scrollTo(0, v);
    document.documentElement.scrollTop = v;
    document.body.scrollTop = v;
  }

  // Plain constant-speed scroll (no ease / no delay / no fancy animation)
  function scrollToTopSteady() {
    try {
      if (window.jQuery) {
        window.jQuery("html, body").stop(true, true);
        window.jQuery("#back_top").off("click");
      }
    } catch (e) {}

    document.documentElement.style.scrollBehavior = "auto";
    if (document.body) document.body.style.scrollBehavior = "auto";

    if (timer) {
      clearInterval(timer);
      timer = null;
    }

    var cur = y();
    if (cur <= 0) {
      lockNavbar();
      return;
    }

    // Steady ~2500px per second
    var step = 42;
    var ms = 16;

    // Start immediately on this click (no waiting)
    cur = Math.max(0, cur - step);
    setPos(cur);
    lockNavbar();

    timer = setInterval(function () {
      cur = y();
      if (cur <= 0) {
        clearInterval(timer);
        timer = null;
        setPos(0);
        lockNavbar();
        return;
      }
      setPos(Math.max(0, cur - step));
      lockNavbar();
    }, ms);
  }

  function onBackTopClick(e) {
    e.preventDefault();
    e.stopPropagation();
    if (e.stopImmediatePropagation) e.stopImmediatePropagation();
    scrollToTopSteady();
    return false;
  }

  function bindBackTop() {
    var el = document.getElementById("back_top");
    if (!el) return;
    try {
      if (window.jQuery) window.jQuery("#back_top").off("click");
    } catch (e) {}
    var neo = el.cloneNode(true);
    el.parentNode.replaceChild(neo, el);
    neo.addEventListener("click", onBackTopClick, true);
  }

  document.documentElement.style.scrollBehavior = "auto";

  document.addEventListener("click", function (e) {
    var btn = e.target && e.target.closest ? e.target.closest("#back_top") : null;
    if (!btn) return;
    onBackTopClick(e);
  }, true);

  window.addEventListener("scroll", lockNavbar, { passive: true });

  function boot() {
    lockNavbar();
    bindBackTop();
    setTimeout(bindBackTop, 200);
  }

  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot);
  else boot();
  window.addEventListener("load", function () {
    lockNavbar();
    bindBackTop();
  });
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

Write-Host "Steady scroll (no animation easing) on $n pages"
$chk = [System.IO.File]::ReadAllText((Join-Path $export "index.html"))
Write-Host ("has_steady={0}" -f ($chk -match 'scrollToTopSteady'))
Write-Host ("starts_immediate={0}" -f ($chk -match 'Start immediately'))
