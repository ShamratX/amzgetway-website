$ErrorActionPreference = "Stop"
$export = (Resolve-Path (Join-Path $PSScriptRoot "..\..\export\site")).Path
$hexBg = "/wp-content/uploads/2019/11/grow-bg.png"

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
<style id="amz-hex-bg">
/* Soft hexagon pattern like Grow Your Traffic slide */
#rev_slider_1_1_wrapper,
#rev_slider_1_1,
#rev_slider_1_1 rs-slides,
#rev_slider_1_1 rs-slide {
  background-color: #ffffff !important;
}
#rev_slider_1_1 .rev-slidebg,
#rev_slider_1_1 img.rev-slidebg {
  background-repeat: repeat !important;
  background-position: center center !important;
  background-size: auto !important;
  opacity: 1 !important;
  visibility: visible !important;
  display: block !important;
}
</style>
'@

$n = 0
foreach ($path in $pages) {
  $raw = [System.IO.File]::ReadAllText($path)
  if ($raw -notmatch 'rev_slider_1_1|Increase Your Sales') { continue }
  $orig = $raw

  $raw = [regex]::Replace($raw, '(?s)<style id="amz-hex-bg">.*?</style>\s*', '')
  # Keep hide-net rules but allow grow-bg
  # Put grow-bg back on the former net slide (empty lazyload / transparent gif)
  $raw = $raw -replace 'data-thumb=""', ('data-thumb="' + $hexBg + '"')

  # Fix empty data-lazyload on rev-slidebg (sales slide)
  $raw = [regex]::Replace(
    $raw,
    '(<img[^>]*class="[^"]*rev-slidebg[^"]*"[^>]*?)src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"([^>]*?)data-lazyload=""',
    ('$1src="' + $hexBg + '"$2data-lazyload="' + $hexBg + '"')
  )
  $raw = [regex]::Replace(
    $raw,
    '(<img[^>]*class="[^"]*rev-slidebg[^"]*"[^>]*?)data-lazyload=""([^>]*?)src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"',
    ('$1data-lazyload="' + $hexBg + '"$2src="' + $hexBg + '"')
  )

  # Any remaining empty slidebg lazyload near title net.png
  $raw = $raw.Replace('title="net.png"', 'title="grow-bg.png"')
  $raw = [regex]::Replace(
    $raw,
    'title="grow-bg\.png"([^>]*?)data-lazyload=""',
    ('title="grow-bg.png"$1data-lazyload="' + $hexBg + '"')
  )
  $raw = [regex]::Replace(
    $raw,
    'src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"([^>]*title="grow-bg\.png")',
    ('src="' + $hexBg + '"$1')
  )
  $raw = [regex]::Replace(
    $raw,
    '(title="grow-bg\.png"[^>]*?)src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"',
    ('$1src="' + $hexBg + '"')
  )

  if ($raw -match '(?i)</head>') {
    $raw = [regex]::Replace($raw, '(?i)</head>', ($css.Trim() + "`n</head>"), 1)
  }

  if ($raw -ne $orig) {
    [System.IO.File]::WriteAllText($path, $raw)
    $n++
  }
}

Write-Host "Applied hex background on $n pages"
$chk = [System.IO.File]::ReadAllText((Join-Path $export "index.html"))
Write-Host ("grow-bg slidebgs={0}" -f (([regex]::Matches($chk, 'rev-slidebg[^>]+grow-bg\.png|grow-bg\.png[^>]+rev-slidebg')).Count))
Write-Host ("transparent_gif_left={0}" -f (([regex]::Matches($chk, 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP')).Count))
Write-Host ("empty_lazyload={0}" -f (([regex]::Matches($chk, 'data-lazyload=""')).Count))

# Show both slides bg now
[regex]::Matches($chk, '(?is)<rs-slide[^>]+>.*?</rs-slide>') | ForEach-Object {
  $s = $_.Value
  $label = if ($s -match 'Increase Your Sales') { 'Sales' } elseif ($s -match 'Grow Your') { 'Traffic' } else { 'Other' }
  $src = if ($s -match 'rev-slidebg[^>]+src="([^"]+)"') { $Matches[1] } elseif ($s -match 'src="([^"]+)"[^>]*rev-slidebg') { $Matches[1] } else { '?' }
  $lazy = if ($s -match 'data-lazyload="([^"]*)"') { $Matches[1] } else { '?' }
  Write-Host ("{0}: src={1} lazy={2}" -f $label, $src, $lazy)
}
