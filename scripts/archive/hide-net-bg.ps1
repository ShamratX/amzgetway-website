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

$css = @'
<style id="amz-hide-net-bg">
/* Remove big network/mesh draw background from hero slider */
img.rev-slidebg[src*="net.png"],
img.rev-slidebg[data-lazyload*="net.png"],
img.tp-rs-img[src*="net.png"],
img[title="net.png"],
.rev_slider img[src*="/net.png"] {
  opacity: 0 !important;
  visibility: hidden !important;
  display: none !important;
}
rs-slide[data-thumb*="net.png"] .rev-slidebg,
rs-slide[data-thumb*="net.png"] {
  background: #f5f6f8 !important;
  background-image: none !important;
}
</style>
'@

$n = 0
foreach ($path in $pages) {
  $raw = [System.IO.File]::ReadAllText($path)
  if ($raw -notmatch 'net\.png') {
    # still strip old inject if re-run
  }
  $orig = $raw
  $raw = [regex]::Replace($raw, '(?s)<style id="amz-hide-net-bg">.*?</style>\s*', '')

  # Soft-replace slide background image refs so mesh never loads
  # Keep other net.png mentions untouched if any (thumbnails only used as data-thumb - clear those too for consistency)
  $raw = $raw -replace 'src="/wp-content/uploads/2019/11/net\.png"', 'src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"'
  $raw = $raw -replace 'data-lazyload="/wp-content/uploads/2019/11/net\.png"', 'data-lazyload=""'
  $raw = $raw -replace 'data-thumb="/wp-content/uploads/2019/11/net\.png"', 'data-thumb=""'

  if ($raw -match '(?i)</head>') {
    $raw = [regex]::Replace($raw, '(?i)</head>', ($css.Trim() + "`n</head>"), 1)
  }

  if ($raw -ne $orig) {
    [System.IO.File]::WriteAllText($path, $raw)
    $n++
  }
}

Write-Host "Removed net mesh background on $n pages"
$chk = [System.IO.File]::ReadAllText((Join-Path $export "index.html"))
Write-Host ("css={0}" -f ($chk -match 'amz-hide-net-bg'))
Write-Host ("net_src_left={0}" -f (([regex]::Matches($chk, 'src="[^"]*net\.png"')).Count))
Write-Host ("transparent_bg={0}" -f ($chk -match 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP'))
