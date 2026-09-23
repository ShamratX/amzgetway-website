# Fresh static mirror: download all pages + sync full assets from fixed WP
$ErrorActionPreference = "Stop"
$root = (Resolve-Path (Join-Path $PSScriptRoot "..\..")).Path
$export = Join-Path $root "export\site"
$urlList = Join-Path $root "export\url-list.txt"
$wpSite = "D:\Amzgetway Backup\amzgetway-local\site"
$baseHost = "http://127.0.0.1:8080"

if (-not (Test-Path -LiteralPath $urlList)) {
  throw "Missing $urlList - run 01-collect-urls.ps1 first"
}

if (Test-Path -LiteralPath $export) {
  Write-Host "Cleaning old export: $export"
  Remove-Item -LiteralPath $export -Recurse -Force
}
New-Item -ItemType Directory -Force -Path $export | Out-Null

function Save-Page([string]$url) {
  $u = [Uri]$url
  $path = [Uri]::UnescapeDataString($u.AbsolutePath)
  if ($path -eq "/" -or $path -eq "") {
    $dest = Join-Path $export "index.html"
  } else {
    $trim = $path.TrimEnd("/")
    $dir = Join-Path $export ($trim.TrimStart("/").Replace("/", [IO.Path]::DirectorySeparatorChar))
    New-Item -ItemType Directory -Force -Path $dir | Out-Null
    $dest = Join-Path $dir "index.html"
  }
  try {
    $resp = Invoke-WebRequest -Uri $url -UseBasicParsing -TimeoutSec 90
    # Prefer raw bytes as UTF8 text
    [System.IO.File]::WriteAllText($dest, $resp.Content, [System.Text.UTF8Encoding]::new($false))
    return @{ Ok = $true; Dest = $dest; Len = $resp.Content.Length; Code = [int]$resp.StatusCode }
  } catch {
    return @{ Ok = $false; Dest = $dest; Error = $_.Exception.Message }
  }
}

Write-Host "=== Phase A: download HTML pages ==="
$urls = Get-Content -LiteralPath $urlList | Where-Object { $_ -and $_.Trim() }
$ok = 0; $bad = 0
foreach ($url in $urls) {
  $r = Save-Page $url.Trim()
  if ($r.Ok) {
    $ok++
    Write-Host "OK $($r.Code) $($r.Len) -> $($r.Dest)"
  } else {
    $bad++
    Write-Host "FAIL $url :: $($r.Error)"
  }
}
Write-Host "Pages: ok=$ok fail=$bad"

Write-Host "=== Phase B: sync uploads + theme + critical plugins ==="
$pairs = @(
  @{ Src = "$wpSite\wp-content\uploads"; Dst = "$export\wp-content\uploads" },
  @{ Src = "$wpSite\wp-content\themes";  Dst = "$export\wp-content\themes" },
  @{ Src = "$wpSite\wp-content\plugins\revslider"; Dst = "$export\wp-content\plugins\revslider" },
  @{ Src = "$wpSite\wp-content\plugins\elementor"; Dst = "$export\wp-content\plugins\elementor" },
  @{ Src = "$wpSite\wp-content\plugins\elementor-pro"; Dst = "$export\wp-content\plugins\elementor-pro" },
  @{ Src = "$wpSite\wp-content\plugins\contact-form-7"; Dst = "$export\wp-content\plugins\contact-form-7" },
  @{ Src = "$wpSite\wp-content\plugins\avas-core"; Dst = "$export\wp-content\plugins\avas-core" },
  @{ Src = "$wpSite\wp-content\plugins\tawkto-live-chat"; Dst = "$export\wp-content\plugins\tawkto-live-chat" },
  @{ Src = "$wpSite\wp-content\plugins\wordpress-seo"; Dst = "$export\wp-content\plugins\wordpress-seo" },
  @{ Src = "$wpSite\wp-includes\css"; Dst = "$export\wp-includes\css" },
  @{ Src = "$wpSite\wp-includes\js"; Dst = "$export\wp-includes\js" },
  @{ Src = "$wpSite\wp-includes\fonts"; Dst = "$export\wp-includes\fonts" },
  @{ Src = "$wpSite\wp-content\uploads\elementor"; Dst = "$export\wp-content\uploads\elementor" }
)

# Also copy any plugins that appear referenced (avas / tx)
Get-ChildItem -LiteralPath "$wpSite\wp-content\plugins" -Directory -ErrorAction SilentlyContinue |
  Where-Object { $_.Name -match 'avas|avs|tx-|header|footer|elementor|revslider|contact-form|tawk|seo|litespeed|wp-rocket' } |
  ForEach-Object {
    $pairs += @{ Src = $_.FullName; Dst = (Join-Path $export "wp-content\plugins\$($_.Name)") }
  }

# Deduplicate by Dst
$seen = @{}
$unique = @()
foreach ($p in $pairs) {
  if (-not $seen.ContainsKey($p.Dst)) { $seen[$p.Dst] = $true; $unique += $p }
}

foreach ($p in $unique) {
  if (-not (Test-Path -LiteralPath $p.Src)) {
    Write-Host "SKIP missing: $($p.Src)"
    continue
  }
  New-Item -ItemType Directory -Force -Path $p.Dst | Out-Null
  Write-Host "Sync $($p.Src)"
  & robocopy $p.Src $p.Dst /E /NFL /NDL /NJH /NJS /nc /ns /np | Out-Null
  if ($LASTEXITCODE -ge 8) { throw "robocopy failed $($p.Src) code $LASTEXITCODE" }
}

# Copy favicon / root assets if present
foreach ($f in @("favicon.ico","robots.txt")) {
  $src = Join-Path $wpSite $f
  if (Test-Path -LiteralPath $src) {
    Copy-Item -LiteralPath $src -Destination (Join-Path $export $f) -Force
  }
}

$files = (Get-ChildItem -LiteralPath $export -Recurse -File -ErrorAction SilentlyContinue | Measure-Object).Count
$mb = [math]::Round(((Get-ChildItem -LiteralPath $export -Recurse -File -ErrorAction SilentlyContinue | Measure-Object Length -Sum).Sum)/1MB,1)
Write-Host ("Mirror complete -> {0} ({1} files, {2} MB)" -f $export, $files, $mb)
if ($bad -gt 0) { exit 2 }
