#!/bin/bash
# ==============================================================================
# Advanced Dental Clinic Production Shared Hosting Backend Deployment Script
# Target: Linux Shared Hosting (Hostinger / GoDaddy) with PHP 8.2+ & MySQL 8.0
# ==============================================================================

set -e

echo "=== [1/5] Initializing Advanced Dental Clinic Backend Deployment ==="
cd "$(dirname "$0")/../../backend"

echo "=== [2/5] Installing Production Composer Dependencies ==="
composer install --no-dev --optimize-autoloader --no-interaction

echo "=== [3/5] Running MySQL 8 Database Migrations ==="
php artisan migrate --force

echo "=== [4/5] Optimizing Laravel Configuration & Routes ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== [5/5] Creating Storage Symlink & Permissions ==="
php artisan storage:link || true
chmod -R 775 storage bootstrap/cache

echo "=== Advanced Dental Clinic Backend Deployment Complete! ==="
