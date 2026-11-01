param(
    [ValidatePattern('^[a-z0-9-]+$')][string]$Site = 'gaming-library',
    [ValidateSet('8.4', '8.5')][string]$PhpVersion = '8.4'
)

$ErrorActionPreference = 'Stop'
Set-StrictMode -Version Latest

function Invoke-Checked {
    param([string]$Program, [string[]]$Arguments)
    & $Program @Arguments
    if ($LASTEXITCODE -ne 0) { throw "$Program is gestopt met foutcode $LASTEXITCODE." }
}

Push-Location (Split-Path $PSScriptRoot -Parent)
try {
    foreach ($tool in @('herd', 'npm.cmd')) {
        if (-not (Get-Command $tool -ErrorAction SilentlyContinue)) {
            throw "$tool ontbreekt. Start Herd en open daarna een nieuwe PowerShell-terminal."
        }
    }
    if (-not (Test-Path 'artisan')) { throw 'Dit is geen Laravel-projectmap.' }
    if (Test-Path '.env') {
        $existingEnv = Get-Content '.env' -Raw
        if ($existingEnv -notmatch '(?m)^APP_ENV=["'']?local["'']?\s*$') {
            throw 'Dit script is alleen voor APP_ENV=local. Controleer je .env.'
        }
        if ($existingEnv -match '(?m)^SESSION_SECURE_COOKIE=true\s*$') {
            throw 'Deze HTTP-demo vereist SESSION_SECURE_COOKIE=false in je lokale .env.'
        }
    }

    Invoke-Checked 'herd' @('link', $Site)
    Invoke-Checked 'herd' @('isolate', $PhpVersion)
    Invoke-Checked 'herd' @('php', '-r', 'exit(version_compare(PHP_VERSION, ''8.4.1'', ''>='') ? 0 : 1);')
    Invoke-Checked 'herd' @('composer', 'install', '--no-interaction', '--prefer-dist')
    Invoke-Checked 'herd' @('composer', 'check-platform-reqs')

    if (-not (Test-Path '.env')) { Copy-Item '.env.example' '.env' }
    $backupPath = Join-Path ([IO.Path]::GetTempPath()) ('prg5-env-' + [guid]::NewGuid().ToString() + '.backup')
    Copy-Item '.env' $backupPath
    $envText = Get-Content '.env' -Raw
    $baseUrl = "http://$Site.test"
    if ($envText -match '(?m)^APP_URL=') {
        $envText = [regex]::Replace($envText, '(?m)^APP_URL=.*$', "APP_URL=$baseUrl")
    } else { $envText += "`nAPP_URL=$baseUrl`n" }
    [IO.File]::WriteAllText((Join-Path (Get-Location).Path '.env'), $envText, (New-Object Text.UTF8Encoding($false)))
    if ($envText -match '(?m)^DB_CONNECTION=sqlite\s*$' -and -not (Test-Path 'database/database.sqlite')) {
        New-Item 'database/database.sqlite' -ItemType File | Out-Null
    }
    Invoke-Checked 'herd' @('php', 'artisan', 'config:clear')
    if ($envText -notmatch '(?m)^APP_KEY=base64:[^\s]+') {
        if ($envText -match '(?m)^APP_KEY=\s*$') {
            Invoke-Checked 'herd' @('php', 'artisan', 'key:generate')
        } else { throw 'APP_KEY ontbreekt of heeft een afwijkend formaat; controleer .env.' }
    }

    Invoke-Checked 'herd' @('php', 'artisan', 'migrate', '--no-interaction')
    Invoke-Checked 'herd' @('php', 'artisan', 'db:seed', '--class=ProductSeeder', '--no-interaction')
    Invoke-Checked 'herd' @('php', 'artisan', 'optimize:clear')
    Invoke-Checked 'npm.cmd' @('ci', '--ignore-scripts')
    Invoke-Checked 'npm.cmd' @('run', 'build')
    if (Test-Path 'public/hot') { Remove-Item 'public/hot' }
    Invoke-Checked 'herd' @('php', 'artisan', 'view:cache')
    Invoke-Checked 'herd' @('php', 'artisan', 'test')

    $response = Invoke-WebRequest "$baseUrl/products" -Headers @{ Accept = 'application/json' } -UseBasicParsing
    if ($response.StatusCode -ne 200) { throw 'HTTP-controle van /products mislukt.' }
    $catalog = $response.Content | ConvertFrom-Json
    if (-not ($catalog.PSObject.Properties.Name -contains 'data')) { throw 'Geen verwachte JSON-productlijst ontvangen.' }
    $page = Invoke-WebRequest "$baseUrl/login" -UseBasicParsing
    if ($page.StatusCode -ne 200 -or $page.Content -notmatch 'name="_token"') { throw 'Loginpagina of CSRF-token ontbreekt.' }
    Write-Host "KLAAR: tests, build en HTTP-controles geslaagd. Open $baseUrl"
    Write-Host 'Registreer een account in de browser en gebruik het in de Postman-collectie.'
    Write-Host 'Postman-import: postman/Gaming-Library.postman_collection.json'
    Write-Host "Back-up van .env: $backupPath"
    Start-Process $baseUrl
} finally {
    Pop-Location
}
