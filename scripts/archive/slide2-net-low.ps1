$ErrorActionPreference = "Stop"
$export = (Resolve-Path (Join-Path $PSScriptRoot "..\..\export\site")).Path
$net = "/wp-content/uploads/2019/11/net.png"

$pages = New-Object System.Collections.Generic.List[string]
[void]$pages.Add((Join-Path $export "index.html"))
Get-ChildItem -LiteralPath $export -Directory | Where-Object {
  $_.Name -notin @('wp-content','wp-includes','wp-admin')
} | ForEach-Object {
  Get-ChildItem -LiteralPath $_.FullName -Recurse -Filter index.html -File | ForEach-Object {
    [void]$pages.Add($_.FullName)
  }
}

$cssHide = @'
<style id="amz-hide-net-bg">
/* 2nd slide: network bg at low visibility only (not full strength) */
#rev_slider_1_1 rs-slide[data-key="rs-1"] img.rev-slidebg[src*="net.png"],
#rev_slider_1_1 rs-slide[data-key="rs-1"] img.rev-slidebg[data-lazyload*="net.png"],
#rev_slider_1_1 rs-slide[data-key="rs-1"] img[title="net.png"] {
  opacity: 0.22 !important;
  visibility: visible !important;
  display: block !important;
  filter: none !important;
}
/* Keep other slides from showing full net if any leftover */
#rev_slider_1_1 rs-slide:not([data-key="rs-1"]) img.rev-slidebg[src*="net.png"],
#rev_slider_1_1 rs-slide:not([data-key="rs-1"]) img[title="net.png"] {
  opacity: 0 !important;
  visibility: hidden !important;
  display: none !important;
}
</style>
'@

$n = 0
foreach ($path in $pages) {
  $raw = [System.IO.File]::ReadAllText($path)
  if ($raw -notmatch 'data-key="rs-1"') { continue }
  $orig = $raw

  # Replace hide-net block
  $raw = [regex]::Replace($raw, '(?s)<style id="amz-hide-net-bg">.*?</style>', $cssHide.Trim(), 1)

  # Inside rs-1 slide only: put net.png back as slide background
  $raw = [regex]::Replace($raw, '(?s)(<rs-slide[^>]*data-key="rs-1"[^>]*>)(.*?)(</rs-slide>)', {
    param($m)
    $open = $m.Groups[1].Value
    $body = $m.Groups[2].Value
    $close = $m.Groups[3].Value

    $open = $open -replace 'data-thumb="[^"]*"', ('data-thumb="' + $net + '"')
    if ($open -notmatch 'data-thumb=') {
      $open = $open -replace '>$', (' data-thumb="' + $net + '">')
    }

    # Fix rev-slidebg image
    $body = [regex]::Replace($body, '<img([^>]*class="[^"]*rev-slidebg[^"]*"[^>]*)>', {
      param($im)
      $tag = $im.Groups[0].Value
      $tag = [regex]::Replace($tag, 'src="[^"]*"', ('src="' + $net + '"'))
      $tag = [regex]::Replace($tag, 'data-lazyload="[^"]*"', ('data-lazyload="' + $net + '"'))
      $tag = [regex]::Replace($tag, 'title="[^"]*"', 'title="net.png"')
      if ($tag -notmatch 'data-lazyload=') {
        $tag = $tag -replace '>$', (' data-lazyload="' + $net + '">')
      }
      if ($tag -notmatch 'title=') {
        $tag = $tag -replace '>$', ' title="net.png">'
      }
      return $tag
    }, 1)

    return ($open + $body + $close)
  }, 1)

  if ($raw -ne $orig) {
    [System.IO.File]::WriteAllText($path, $raw)
    $n++
  }
}

Write-Host "Updated $n pages"
$chk = [System.IO.File]::ReadAllText((Join-Path $export "index.html"))
$i = 0
[regex]::Matches($chk, '(?is)<rs-slide[^>]+>.*?</rs-slide>') | ForEach-Object {
  $i++
  $s = $_.Value
  $key = if ($s -match 'data-key="([^"]+)"') { $Matches[1] } else { '?' }
  $src = if ($s -match 'rev-slidebg[^>]{0,120}src="([^"]+)"') { $Matches[1] } elseif ($s -match 'src="([^"]+)"[^>]{0,80}rev-slidebg') { $Matches[1] } else {
    if ($s -match 'class="[^"]*rev-slidebg[^"]*"[^>]*src="([^"]+)"') { $Matches[1] } else { '?' }
  }
  # simpler extract
  if ($s -match '<img[^>]*rev-slidebg[^>]*>') {
    $img = $Matches[0]
    $src = if ($img -match 'src="([^"]+)"') { $Matches[1] } else { '?' }
  }
  Write-Host ("Slide {0} {1}: {2}" -f $i, $key, $src)
}
Write-Host ("low_opacity_css={0}" -f ($chk -match 'opacity: 0\.22'))
