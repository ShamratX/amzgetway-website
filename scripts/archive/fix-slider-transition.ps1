$ErrorActionPreference = "Stop"
$export = (Resolve-Path (Join-Path $PSScriptRoot "..\..\export\site")).Path

# Homepage is the main slider; also patch any page with rndany
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
<style id="amz-slider-transition-fix">
/* Prevent dark edges/gaps during RevSlider transitions */
#rev_slider_1_1_wrapper,
#rev_slider_1_1,
#rev_slider_1_1 rs-slides,
#rev_slider_1_1 rs-slide,
#rev_slider_1_1 .slotholder,
#rev_slider_1_1 .tp-bgimg,
#rev_slider_1_1 .slot,
#rev_slider_1_1 .slot__image,
#rev_slider_1_1 .tp-carousel-wrapper,
.rev_slider_wrapper,
.rev_slider {
  background: #ffffff !important;
  background-color: #ffffff !important;
  box-shadow: none !important;
  outline: none !important;
  border: 0 !important;
}
/* Kill dark anti-aliased seams on transformed transition tiles */
#rev_slider_1_1 .slot,
#rev_slider_1_1 .slotwrapper,
#rev_slider_1_1 .tp-revslider-slidesli {
  background-color: #ffffff !important;
  border: 0 !important;
  outline: none !important;
  box-shadow: none !important;
}
</style>
'@

$n = 0
foreach ($path in $pages) {
  $raw = [System.IO.File]::ReadAllText($path)
  if ($raw -notmatch 'rev_slider|rndany') { continue }
  $orig = $raw

  $raw = [regex]::Replace($raw, '(?s)<style id="amz-slider-transition-fix">.*?</style>\s*', '')

  # Replace harsh mosaic transition (causes purple tiles + dark edge) with simple fade
  $raw = $raw.Replace(
    'data-in="prst:rndany;mo:45;moo:none;o:0;x:ran(-100|100);y:(100%);r:ran(-100|100);sx:ran(0|2);sy:ran(0|2);e:power3.out;row:7;col:7;"',
    'data-in="o:0;e:power2.inOut;"'
  )
  $raw = $raw.Replace('data-in="prst:rndany;"', 'data-in="o:0;e:power2.inOut;"')
  $raw = $raw.Replace('data-out="x:100%;"', 'data-out="o:0;e:power2.inOut;"')

  # Ensure wrapper bg stays white (not dark)
  $raw = $raw.Replace('background:#32373c', 'background:#ffffff')
  $raw = $raw.Replace('background-color:#32373c', 'background-color:#ffffff')

  if ($raw -match '(?i)</head>') {
    $raw = [regex]::Replace($raw, '(?i)</head>', ($css.Trim() + "`n</head>"), 1)
  }

  if ($raw -ne $orig) {
    [System.IO.File]::WriteAllText($path, $raw)
    $n++
  }
}

Write-Host "Fixed slider transition on $n pages"
$chk = [System.IO.File]::ReadAllText((Join-Path $export "index.html"))
Write-Host ("rndany_left={0}" -f (([regex]::Matches($chk, 'rndany')).Count))
Write-Host ("fade_in={0}" -f ($chk -match 'o:0;e:power2\.inOut'))
Write-Host ("css={0}" -f ($chk -match 'amz-slider-transition-fix'))
