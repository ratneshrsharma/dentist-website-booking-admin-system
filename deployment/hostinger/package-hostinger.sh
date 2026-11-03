#!/bin/bash
# ==============================================================================
# Advanced Dental Clinic - Hostinger Deployment Bundler
# Prepares a single clean ZIP archive ready to upload to Hostinger File Manager
# ==============================================================================

set -e

PROJECT_ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
DIST_DIR="$PROJECT_ROOT/deployment/dist"
BUILD_ZIP="$DIST_DIR/advanced_dental_clinic_hostinger.zip"

echo "=== [1/4] Building Next.js 15 Static Frontend Export ==="
cd "$PROJECT_ROOT/frontend"
npm run build

echo "=== [2/4] Preparing Clean Deployment Distribution Folder ==="
rm -rf "$DIST_DIR"
mkdir -p "$DIST_DIR/bundle"

# Copy root .htaccess
cp "$PROJECT_ROOT/.htaccess" "$DIST_DIR/bundle/.htaccess"

# Copy exported static frontend files to root
cp -r "$PROJECT_ROOT/frontend/out/"* "$DIST_DIR/bundle/"

# Copy backend files (excluding vendor and local cache)
mkdir -p "$DIST_DIR/bundle/backend"
cp -r "$PROJECT_ROOT/backend/app" "$DIST_DIR/bundle/backend/"
cp -r "$PROJECT_ROOT/backend/bootstrap" "$DIST_DIR/bundle/backend/"
cp -r "$PROJECT_ROOT/backend/config" "$DIST_DIR/bundle/backend/"
cp -r "$PROJECT_ROOT/backend/database" "$DIST_DIR/bundle/backend/"
cp -r "$PROJECT_ROOT/backend/public" "$DIST_DIR/bundle/backend/"
cp -r "$PROJECT_ROOT/backend/resources" "$DIST_DIR/bundle/backend/"
cp -r "$PROJECT_ROOT/backend/routes" "$DIST_DIR/bundle/backend/"
cp "$PROJECT_ROOT/backend/composer.json" "$DIST_DIR/bundle/backend/"
cp "$PROJECT_ROOT/deployment/hostinger/env.production.example" "$DIST_DIR/bundle/backend/.env"

# Copy database SQL dump for 1-click import
mkdir -p "$DIST_DIR/bundle/database"
cp "$PROJECT_ROOT/deployment/database/advanced_dental_clinic.sql" "$DIST_DIR/bundle/database/"

# Create empty storage structure
mkdir -p "$DIST_DIR/bundle/backend/storage/app/public"
mkdir -p "$DIST_DIR/bundle/backend/storage/framework/cache"
mkdir -p "$DIST_DIR/bundle/backend/storage/framework/sessions"
mkdir -p "$DIST_DIR/bundle/backend/storage/framework/views"
mkdir -p "$DIST_DIR/bundle/backend/storage/logs"

echo "=== [3/4] Creating Production Deployment ZIP Archive ==="
cd "$DIST_DIR/bundle"
zip -r "$BUILD_ZIP" ./* .htaccess

echo "=== [4/4] Package Created Successfully! ==="
echo "Archive location: $BUILD_ZIP"
echo "Ready to upload directly into Hostinger File Manager under public_html/demo/advanced-dental-clinic/"
