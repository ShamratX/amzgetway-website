$path = Join-Path $PSScriptRoot "..\..\export\site\index.html"
$path = (Resolve-Path -LiteralPath $path).Path
$utf8 = New-Object System.Text.UTF8Encoding $false
$raw = $utf8.GetString([System.IO.File]::ReadAllBytes($path))

# 1) Slider heights
$raw = [regex]::Replace(
  $raw,
  "setREVStartSize\(\{c: 'rev_slider_1_1',rl:\[1240,1024,778,480\],el:\[[^\]]+\],gw:\[1440,1024,778,480\],gh:\[[^\]]+\],type:'standard',justify:'',layout:'fullwidth',mh:""[^""]+""\}\);",
  "setREVStartSize({c: 'rev_slider_1_1',rl:[1240,1024,778,480],el:[560,520,400,340],gw:[1440,1024,778,480],gh:[560,520,400,340],type:'standard',justify:'',layout:'fullwidth',mh:""340""});"
)
Write-Host "size ok:" ($raw -match 'el:\[560,520,400,340\]')

# 2) Layer xy/dim by id via regex
function Set-LayerAttr([string]$html, [string]$id, [string]$attr, [string]$value) {
  $pattern = '(id="' + [regex]::Escape($id) + '"[\s\S]*?)(' + [regex]::Escape($attr) + '=")([^"]*)(")'
  return [regex]::Replace($html, $pattern, ('${1}${2}' + $value + '${4}'), 1)
}

# Slide 2 - Grow Your Brand
$raw = Set-LayerAttr $raw 'slider-1-slide-2-layer-1' 'data-xy' 'xo:22px,30px,24px,20px;y:t,t,t,t;yo:120px,110px,56px,48px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-2-layer-1' 'data-dim' 'w:681px,549px,700px,400px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-2-layer-20' 'data-xy' 'xo:18px,31px,24px,20px;y:t,t,t,t;yo:280px,250px,190px,170px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-2-layer-21' 'data-xy' 'xo:20px,30px,24px,20px;y:t,t,t,t;yo:210px,190px,130px,110px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-2-layer-21' 'data-dim' 'w:631px,428px,680px,360px;'

# Slide 1 - Increase Sales
$raw = Set-LayerAttr $raw 'slider-1-slide-1-layer-1' 'data-xy' 'xo:23px,30px,24px,20px;y:t,t,t,t;yo:100px,95px,56px,48px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-1-layer-1' 'data-dim' 'w:681px,549px,700px,400px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-1-layer-20' 'data-xy' 'xo:21px,31px,24px,20px;y:t,t,t,t;yo:300px,280px,220px,200px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-1-layer-21' 'data-xy' 'xo:20px,30px,24px,20px;y:t,t,t,t;yo:200px,185px,130px,110px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-1-layer-21' 'data-dim' 'w:631px,428px,680px,360px;'

$raw = $raw.Replace('gridheight:"600,600,600,600"', 'gridheight:"560,520,400,340"')

Write-Host "slide2 title xy:" ([regex]::Match($raw, 'id="slider-1-slide-2-layer-1"[\s\S]{0,400}data-xy="([^"]+)"').Groups[1].Value)
Write-Host "slide1 title xy:" ([regex]::Match($raw, 'id="slider-1-slide-1-layer-1"[\s\S]{0,400}data-xy="([^"]+)"').Groups[1].Value)
Write-Host "gridheight:" ([regex]::Match($raw, 'gridheight:"([^"]+)"').Groups[1].Value)

[System.IO.File]::WriteAllBytes($path, $utf8.GetBytes($raw))
Write-Host "saved"
