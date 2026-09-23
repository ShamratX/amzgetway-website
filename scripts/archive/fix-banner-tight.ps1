$path = Join-Path $PSScriptRoot "..\..\export\site\index.html"
$path = (Resolve-Path -LiteralPath $path).Path
$utf8 = New-Object System.Text.UTF8Encoding $false
$raw = $utf8.GetString([System.IO.File]::ReadAllBytes($path))

function Set-LayerAttr([string]$html, [string]$id, [string]$attr, [string]$value) {
  $pattern = '(id="' + [regex]::Escape($id) + '"[\s\S]*?)(' + [regex]::Escape($attr) + '=")([^"]*)(")'
  return [regex]::Replace($html, $pattern, ('${1}${2}' + $value + '${4}'), 1)
}

# Tight stack — desktop, notebook, tablet, mobile (keep RS animations via data-frame_*)
# Title
$raw = Set-LayerAttr $raw 'slider-1-slide-2-layer-1' 'data-xy' 'xo:22px,30px,20px,16px;y:t,t,t,t;yo:90px,80px,40px,36px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-2-layer-1' 'data-dim' 'w:681px,549px,720px,420px;'
# Paragraph close under title
$raw = Set-LayerAttr $raw 'slider-1-slide-2-layer-21' 'data-xy' 'xo:20px,30px,20px,16px;y:t,t,t,t;yo:160px,145px,105px,95px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-2-layer-21' 'data-dim' 'w:631px,428px,700px,400px;'
# Button under paragraph (inside canvas)
$raw = Set-LayerAttr $raw 'slider-1-slide-2-layer-20' 'data-xy' 'xo:18px,31px,20px,16px;y:t,t,t,t;yo:250px,230px,185px,175px;'

$raw = Set-LayerAttr $raw 'slider-1-slide-1-layer-1' 'data-xy' 'xo:23px,30px,20px,16px;y:t,t,t,t;yo:80px,75px,40px,36px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-1-layer-1' 'data-dim' 'w:681px,549px,720px,420px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-1-layer-21' 'data-xy' 'xo:20px,30px,20px,16px;y:t,t,t,t;yo:170px,160px,115px,105px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-1-layer-21' 'data-dim' 'w:631px,428px,700px,400px;'
$raw = Set-LayerAttr $raw 'slider-1-slide-1-layer-20' 'data-xy' 'xo:21px,31px,20px,16px;y:t,t,t,t;yo:270px,255px,210px,200px;'

# Canvas tall enough for button + entrance animation travel
$raw = [regex]::Replace(
  $raw,
  "setREVStartSize\(\{c: 'rev_slider_1_1',rl:\[1240,1024,778,480\],el:\[[^\]]+\],gw:\[1440,1024,778,480\],gh:\[[^\]]+\],type:'standard',justify:'',layout:'fullwidth',mh:""[^""]+""\}\);",
  "setREVStartSize({c: 'rev_slider_1_1',rl:[1240,1024,778,480],el:[560,520,380,340],gw:[1440,1024,778,480],gh:[560,520,380,340],type:'standard',justify:'',layout:'fullwidth',mh:""340""});"
)
$raw = $raw.Replace('gridheight:"560,520,400,340"', 'gridheight:"560,520,380,340"')
$raw = $raw.Replace('gridheight:"600,600,600,600"', 'gridheight:"560,520,380,340"')

Write-Host "s2 title:" ([regex]::Match($raw, 'id="slider-1-slide-2-layer-1"[\s\S]{0,350}data-xy="([^"]+)"').Groups[1].Value)
Write-Host "s2 btn:" ([regex]::Match($raw, 'id="slider-1-slide-2-layer-20"[\s\S]{0,350}data-xy="([^"]+)"').Groups[1].Value)
Write-Host "el:" ([regex]::Match($raw, 'el:\[([^\]]+)\]').Groups[1].Value)

[System.IO.File]::WriteAllBytes($path, $utf8.GetBytes($raw))
Write-Host saved
