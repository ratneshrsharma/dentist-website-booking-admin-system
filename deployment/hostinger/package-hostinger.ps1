# ==============================================================================
# Advanced Dental Clinic - Hostinger Deployment Bundler (PowerShell Windows)
# Prepares a single clean ZIP archive ready to upload to Hostinger File Manager
# ==============================================================================

$ErrorActionPreference = "Stop"

$scriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$projectRoot = Resolve-Path "$scriptDir/../.."
$distDir = "$projectRoot/deployment/dist"
$bundleDir = "$distDir/bundle"
$zipPath = "$distDir/advanced_dental_clinic_hostinger.zip"

Write-Host "=== [1/4] Building Next.js 15 Static Frontend Export ===" -ForegroundColor Cyan
Set-Location "$projectRoot/frontend"
npm run build

Write-Host "=== [2/4] Preparing Clean Deployment Distribution Folder ===" -ForegroundColor Cyan
if (Test-Path $distDir) {
    Remove-Item -Recurse -Force $distDir
}
New-Item -ItemType Directory -Force -Path $bundleDir | Out-Null

# Copy root .htaccess
Copy-Item "$projectRoot/.htaccess" -Destination "$bundleDir/.htaccess"

# Copy exported static frontend files to root of bundle
Copy-Item "$projectRoot/frontend/out/*" -Destination "$bundleDir" -Recurse

# Copy backend files (excluding vendor and cache)
$backendTarget = "$bundleDir/backend"
New-Item -ItemType Directory -Force -Path $backendTarget | Out-Null

Copy-Item "$projectRoot/backend/app" -Destination "$backendTarget/app" -Recurse
Copy-Item "$projectRoot/backend/bootstrap" -Destination "$backendTarget/bootstrap" -Recurse
Copy-Item "$projectRoot/backend/config" -Destination "$backendTarget/config" -Recurse
Copy-Item "$projectRoot/backend/database" -Destination "$backendTarget/database" -Recurse
Copy-Item "$projectRoot/backend/public" -Destination "$backendTarget/public" -Recurse
Copy-Item "$projectRoot/backend/resources" -Destination "$backendTarget/resources" -Recurse
Copy-Item "$projectRoot/backend/routes" -Destination "$backendTarget/routes" -Recurse
Copy-Item "$projectRoot/backend/composer.json" -Destination "$backendTarget/composer.json"

# Production .env pre-configured with u499464314_advanceddental
Copy-Item "$projectRoot/deployment/hostinger/env.production.example" -Destination "$backendTarget/.env"

# Database SQL dump for 1-click import
$dbTarget = "$bundleDir/database"
New-Item -ItemType Directory -Force -Path $dbTarget | Out-Null
Copy-Item "$projectRoot/deployment/database/advanced_dental_clinic.sql" -Destination "$dbTarget/advanced_dental_clinic.sql"

# Create empty storage folders
New-Item -ItemType Directory -Force -Path "$backendTarget/storage/app/public" | Out-Null
New-Item -ItemType Directory -Force -Path "$backendTarget/storage/framework/cache" | Out-Null
New-Item -ItemType Directory -Force -Path "$backendTarget/storage/framework/sessions" | Out-Null
New-Item -ItemType Directory -Force -Path "$backendTarget/storage/framework/views" | Out-Null
New-Item -ItemType Directory -Force -Path "$backendTarget/storage/logs" | Out-Null

Write-Host "=== [3/4] Creating Production Deployment ZIP Archive ===" -ForegroundColor Cyan
Set-Location $bundleDir
Compress-Archive -Path ".\*" -DestinationPath $zipPath -Force

Write-Host "=== [4/4] Package Created Successfully! ===" -ForegroundColor Green
Write-Host "Archive location: $zipPath"
Write-Host "Size: $((Get-Item $zipPath).Length / 1MB | ForEach-Object { '{0:N2} MB' -f $_ })"
Write-Host "Ready to upload directly into Hostinger File Manager under public_html/demo/advanced-dental-clinic/"
