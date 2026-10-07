param([int]$Workers = 12, [int]$Capacity = 1)
$dir  = $PSScriptRoot
$php  = Get-ChildItem "$env:APPDATA\Local\lightning-services\php-8.2.29+0" -Recurse -Filter php.exe | Select-Object -First 1 -ExpandProperty FullName
$ext  = Get-ChildItem (Split-Path $php) -Recurse -Directory -Filter ext | Select-Object -First 1 -ExpandProperty FullName
$flags = @('-d',"extension_dir=$ext",'-d','extension=mysqli','-d','extension=mbstring','-d','extension=openssl','-d','extension=curl','-d','mysqli.default_port=10006')

$out = (& $php @flags "$dir\setup.php" $Capacity 2>$null) -join ''
$eid = [int]([regex]::Match($out, 'EID=(\d+)').Groups[1].Value)
"test event id: $eid  capacity: $Capacity  workers: $Workers"
if (-not $eid) { "setup failed: $out"; return }

$go = [double]([DateTimeOffset]::UtcNow.ToUnixTimeMilliseconds() / 1000 + 12)
$procs = 1..$Workers | ForEach-Object {
    Start-Process -FilePath $php -ArgumentList ($flags + @("$dir\worker.php", $eid, $go)) -RedirectStandardOutput "$dir\out$_.txt" -RedirectStandardError "$dir\err$_.txt" -NoNewWindow -PassThru
}
$procs | Wait-Process -Timeout 120
$res = 1..$Workers | ForEach-Object { if (Test-Path "$dir\out$_.txt") { (Get-Content "$dir\out$_.txt" -Raw).Trim() } else { 'NO OUTPUT' } }
"results: " + (($res | Group-Object | ForEach-Object { "$($_.Name) x$($_.Count)" }) -join ', ')
& $php @flags "$dir\count.php" $eid 2>$null
""
& $php @flags "$dir\clean.php" $eid 2>$null
""
