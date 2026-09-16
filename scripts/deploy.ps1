# Deploys SMEvolve to Hostinger:
#   1. builds production assets locally (unless -SkipBuild)
#   2. uploads the gitignored public/build to the server and fixes permissions
#   3. pulls the latest committed code on the server
#   4. clears/re-caches Laravel config + views
#
# Run from anywhere:
#   pwsh scripts/deploy.ps1           # full deploy
#   pwsh scripts/deploy.ps1 -SkipBuild
#   pwsh scripts/deploy.ps1 -AppDir Laravel-Website

param(
    [string]$AppDir = "Laravel-Website",
    [string]$SshUserHost = "u226366554@uk-fast-web2073.main-hosting.eu",
    [int]$SshPort = 65002,
    [string]$SshKey = "$HOME\.ssh\smevolve_hostinger_ed25519",
    [string]$RemoteApp = "/home/u226366554/domains/smevolve.tech/smevolve/Laravel-Website",
    [string]$RemotePhp = "/opt/alt/php84/usr/bin/php",
    [switch]$SkipBuild
)

$ErrorActionPreference = "Stop"

$RepoRoot = Split-Path -Parent $PSScriptRoot
$App = Join-Path $RepoRoot $AppDir
$Build = Join-Path $App "public\build"

if (-not (Test-Path -LiteralPath $App)) {
    throw "App path not found: $App"
}

if (-not (Test-Path -LiteralPath $SshKey)) {
    throw "SSH key not found: $SshKey"
}

# 1. Build production assets locally.
if (-not $SkipBuild) {
    Write-Host "==> Building production assets..." -ForegroundColor Cyan
    Push-Location $App
    try {
        npm run build
        if ($LASTEXITCODE -ne 0) { throw "npm run build failed (exit $LASTEXITCODE)" }
    } finally {
        Pop-Location
    }
}

if (-not (Test-Path -LiteralPath $Build)) {
    throw "Missing build directory: $Build (run without -SkipBuild?)"
}

# 2. Upload public/build to a staging dir, then atomically swap it in on the
#    server (gitignored locally, so this is the only way it reaches the server).
#    The swap also prunes any stale hashed chunks from older builds.
Write-Host "==> Uploading public/build to $RemoteApp/public/build.staging ..." -ForegroundColor Cyan
& scp -i $SshKey -P "$SshPort" -r "$Build" "${SshUserHost}:$RemoteApp/public/build.staging"
if ($LASTEXITCODE -ne 0) { throw "scp failed (exit $LASTEXITCODE)" }

Write-Host "==> Swapping build + setting permissions + pulling code + refreshing Laravel caches..." -ForegroundColor Cyan
$remote = @(
    "cd '$RemoteApp'",
    "rm -rf public/build.old",
    "mv public/build public/build.old",
    "mv public/build.staging public/build",
    "rm -rf public/build.old",
    "chmod -R 755 public/build",
    "find public/build -type f -exec chmod 644 {} +",
    "git pull --ff-only",
    "$RemotePhp artisan config:clear",
    "$RemotePhp artisan config:cache",
    "$RemotePhp artisan view:clear",
    "$RemotePhp artisan view:cache",
    "echo DEPLOY_OK"
) -join " && "

& ssh -i $SshKey -p "$SshPort" ${SshUserHost} $remote
if ($LASTEXITCODE -ne 0) { throw "Remote deploy steps failed (exit $LASTEXITCODE)" }

Write-Host ""
Write-Host "Deploy complete. Verify at https://smevolve.tech" -ForegroundColor Green