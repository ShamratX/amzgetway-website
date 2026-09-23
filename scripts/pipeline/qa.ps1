# QA: compare critical signals on static export vs live WP
$ErrorActionPreference = "Continue"
$export = Join-Path (Resolve-Path (Join-Path $PSScriptRoot "..\..")) "export\site"
$report = Join-Path (Resolve-Path (Join-Path $PSScriptRoot "..\..")) "qa\report.txt"
New-Item -ItemType Directory -Force -Path (Split-Path $report) | Out-Null

$checks = @(
  @{ Name = "home"; Path = "index.html"; Markers = @("AMZgetway-Logo","menu-item","rev_slider","GET A PROPOSAL","Grow Your Brand","footer-top","copyright") },
  @{ Name = "about"; Path = "about-us\index.html"; Markers = @("elementor","menu-item") },
  @{ Name = "blog"; Path = "blog\index.html"; Markers = @("elementor","menu-item") }
)

$lines = @()
$lines += "QA $(Get-Date -Format o)"
$lines += "Export: $export"
$fail = 0

# Bad host scan
$bad = Select-String -Path (Join-Path $export "*.html") -Pattern "http://wordpress|https://wordpress|//amzgetway\.com|http://127\.0\.0\.1:8080" -SimpleMatch:$false -ErrorAction SilentlyContinue |
  Select-Object -First 20
if ($bad) {
  $lines += "FAIL: residual absolute hosts in HTML (sample):"
  $bad | ForEach-Object { $lines += "  $($_.Path):$($_.LineNumber)" }
  $fail++
} else {
  $lines += "OK: no residual wordpress/amzgetway/8080 hosts in top-level HTML scan"
}

foreach ($c in $checks) {
  $fp = Join-Path $export $c.Path
  if (-not (Test-Path -LiteralPath $fp)) {
    # wget --adjust-extension sometimes uses about-us.html
    $alt = Join-Path $export ($c.Path -replace '\\index\.html$','.html')
    if (Test-Path -LiteralPath $alt) { $fp = $alt }
  }
  if (-not (Test-Path -LiteralPath $fp)) {
    $lines += "FAIL: missing $($c.Name) file"
    $fail++
    continue
  }
  $html = Get-Content -LiteralPath $fp -Raw
  $missing = @()
  foreach ($m in $c.Markers) {
    if ($html -notmatch [regex]::Escape($m)) { $missing += $m }
  }
  if ($missing.Count) {
    $lines += "FAIL: $($c.Name) missing markers: $($missing -join ', ')"
    $fail++
  } else {
    $lines += "OK: $($c.Name) markers present ($fp)"
  }
}

# Asset existence for logo
$logo = Get-ChildItem -LiteralPath (Join-Path $export "wp-content\uploads") -Recurse -Filter "*AMZgetway-Logo*" -ErrorAction SilentlyContinue | Select-Object -First 3
if ($logo) {
  $lines += "OK: logo files found:"
  $logo | ForEach-Object { $lines += "  $($_.FullName)" }
} else {
  $lines += "FAIL: AMZgetway logo not found under uploads"
  $fail++
}

$fileCount = (Get-ChildItem -LiteralPath $export -Recurse -File -ErrorAction SilentlyContinue | Measure-Object).Count
$mb = [math]::Round(((Get-ChildItem -LiteralPath $export -Recurse -File -ErrorAction SilentlyContinue | Measure-Object Length -Sum).Sum)/1MB,1)
$lines += "Stats: $fileCount files, $mb MB"
$lines += "RESULT: $(if ($fail -eq 0) { 'PASS' } else { "FAIL ($fail)" })"

$lines | Set-Content -LiteralPath $report -Encoding UTF8
$lines | ForEach-Object { Write-Host $_ }
exit $(if ($fail -eq 0) { 0 } else { 1 })

