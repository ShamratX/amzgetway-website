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

  // Start same speed, then go faster and faster toward the top
  function scrollToTopAccel() {
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

    var step = 28;      // start speed (steady)
    var maxStep = 120;  // top speed (fast near the top)
    var grow = 1.08;    // accelerate each tick
    var ms = 16;

    // begin immediately
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
      step = Math.min(maxStep, step * grow);
      setPos(Math.max(0, cur - step));
      lockNavbar();
    }, ms);
  }

  function onBackTopClick(e) {
    e.preventDefault();
    e.stopPropagation();
    if (e.stopImmediatePropagation) e.stopImmediatePropagation();
    scrollToTopAccel();
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

Write-Host "Accel scroll on $n pages (start steady, then faster up)"
Write-Host ("ok={0}" -f ([System.IO.File]::ReadAllText((Join-Path $export "index.html")) -match 'scrollToTopAccel'))
