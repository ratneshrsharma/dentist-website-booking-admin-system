#!/bin/bash
# ==============================================================================
# Advanced Dental Clinic - 1-Click SSH/SCP Deployment to Hostinger (Bash)
# Target: u499464314@147.93.99.237 (Port 65002)
# ==============================================================================

set -e

SSH_USER="u499464314"
SSH_HOST="147.93.99.237"
SSH_PORT="65002"
REMOTE_PATH="public_html/demo/advanced-dental-clinic"

PROJECT_ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
ZIP_PATH="$PROJECT_ROOT/deployment/dist/advanced_dental_clinic_hostinger.zip"

if [ ! -f "$ZIP_PATH" ]; then
    echo "Deployment package not found. Building now..."
    bash "$PROJECT_ROOT/deployment/hostinger/package-hostinger.sh"
fi

echo "=========================================================="
echo "Deploying Advanced Dental Clinic to Hostinger via SSH/SCP"
echo "Host: $SSH_HOST | Port: $SSH_PORT | User: $SSH_USER"
echo "Target: ~/$REMOTE_PATH"
echo "=========================================================="

echo ""
echo "[1/3] Uploading ZIP package via SCP..."
scp -P "$SSH_PORT" "$ZIP_PATH" "${SSH_USER}@${SSH_HOST}:~/advanced_dental_clinic_hostinger.zip"

echo ""
echo "[2/3] Extracting package and setting permissions on Hostinger..."
ssh -p "$SSH_PORT" "${SSH_USER}@${SSH_HOST}" << 'EOF'
mkdir -p ~/public_html/demo/advanced-dental-clinic
unzip -o ~/advanced_dental_clinic_hostinger.zip -d ~/public_html/demo/advanced-dental-clinic/
rm -f ~/advanced_dental_clinic_hostinger.zip
chmod -R 755 ~/public_html/demo/advanced-dental-clinic
chmod -R 775 ~/public_html/demo/advanced-dental-clinic/backend/storage ~/public_html/demo/advanced-dental-clinic/backend/bootstrap/cache 2>/dev/null || true
echo "Extraction and permissions setup completed successfully!"
EOF

echo ""
echo "[3/3] Next Step: Import Database on Hostinger"
echo "SSH into server with: ssh -p $SSH_PORT ${SSH_USER}@${SSH_HOST}"
echo "Then execute:"
echo "mysql -u u499464314_dental_user -p u499464314_advanceddental < ~/public_html/demo/advanced-dental-clinic/database/advanced_dental_clinic.sql"
echo ""
echo "Deployment complete! Visit: https://demo.ratneshsharma.com/advanced-dental-clinic/"
