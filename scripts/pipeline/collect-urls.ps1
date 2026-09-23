# Collect all public URLs from local WP sitemaps
$ErrorActionPreference = "Stop"
$outDir = Join-Path $PSScriptRoot "..\..\export"
New-Item -ItemType Directory -Force -Path $outDir | Out-Null
$outFile = Join-Path $outDir "url-list.txt"

$sitemaps = @(
  "http://127.0.0.1:8080/page-sitemap.xml",
  "http://127.0.0.1:8080/service-sitemap.xml"
)

$urls = New-Object System.Collections.Generic.HashSet[string]
foreach ($sm in $sitemaps) {
  $xml = (Invoke-WebRequest -Uri $sm -UseBasicParsing -TimeoutSec 60).Content
  foreach ($m in [regex]::Matches($xml, '<loc>(.*?)</loc>')) {
    [void]$urls.Add($m.Groups[1].Value.Trim())
  }
}
# Always include home
[void]$urls.Add("http://127.0.0.1:8080/")

$list = $urls | Sort-Object
$list | Set-Content -LiteralPath $outFile -Encoding UTF8
Write-Host "Wrote $($list.Count) URLs -> $outFile"
$list | ForEach-Object { Write-Host "  $_" }
