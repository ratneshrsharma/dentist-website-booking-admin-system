# ==============================================================================
# Advanced Dental Clinic - 1-Click SSH/SCP Deployment to Hostinger
# Target: u499464314@147.93.99.237 (Port 65002)
# ==============================================================================

$SSH_USER = "u499464314"
$SSH_HOST = "147.93.99.237"
$SSH_PORT = "65002"
$REMOTE_PATH = "~/public_html/demo/advanced-dental-clinic"

$scriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$projectRoot = Resolve-Path "$scriptDir/../.."
$zipPath = "$projectRoot/deployment/dist/advanced_dental_clinic_hostinger.zip"

if (-not (Test-Path $zipPath)) {
    Write-Host "Deployment package not found. Building now..." -ForegroundColor Yellow
    & "$scriptDir/package-hostinger.ps1"
}

Write-Host "==========================================================" -ForegroundColor Cyan
Write-Host "Deploying Advanced Dental Clinic to Hostinger via SSH/SCP" -ForegroundColor Cyan
Write-Host "Host: $SSH_HOST | Port: $SSH_PORT | User: $SSH_USER" -ForegroundColor Cyan
Write-Host "Target: $REMOTE_PATH" -ForegroundColor Cyan
Write-Host "==========================================================" -ForegroundColor Cyan

Write-Host "`n[1/3] Uploading ZIP package ($((Get-Item $zipPath).Length / 1MB | ForEach-Object { '{0:N2} MB' -f $_ })) via SCP..." -ForegroundColor Green
scp -P $SSH_PORT $zipPath "${SSH_USER}@${SSH_HOST}:~/advanced_dental_clinic_hostinger.zip"

if ($LASTEXITCODE -ne 0) {
    Write-Host "SCP Upload failed. Please check your SSH password/key." -ForegroundColor Red
    exit 1
}

Write-Host "`n[2/3] Extracting package and setting permissions on Hostinger..." -ForegroundColor Green
$remoteCommands = @"
mkdir -p $REMOTE_PATH
unzip -o ~/advanced_dental_clinic_hostinger.zip -d $REMOTE_PATH/
rm -f ~/advanced_dental_clinic_hostinger.zip
chmod -R 755 $REMOTE_PATH
chmod -R 775 $REMOTE_PATH/backend/storage $REMOTE_PATH/backend/bootstrap/cache 2>/dev/null || true
echo 'Extraction and permissions completed successfully!'
"@

ssh -p $SSH_PORT "${SSH_USER}@${SSH_HOST}" $remoteCommands

Write-Host "`n[3/3] Next Step: Import Database on Hostinger" -ForegroundColor Yellow
Write-Host "SSH into server with: ssh -p $SSH_PORT ${SSH_USER}@${SSH_HOST}" -ForegroundColor Cyan
Write-Host "Then run:" -ForegroundColor Cyan
Write-Host "mysql -u u499464314_dental_user -p u499464314_advanceddental < $REMOTE_PATH/database/advanced_dental_clinic.sql" -ForegroundColor White
Write-Host "`nDeployment complete! Visit: https://demo.ratneshsharma.com/advanced-dental-clinic/" -ForegroundColor Green
