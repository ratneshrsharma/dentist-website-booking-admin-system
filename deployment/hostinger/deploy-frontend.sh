#!/bin/bash
# ==============================================================================
# DentaFlow Production Static Frontend Build & Sync Script
# Target: Next.js 15+ Static Export (output: 'export') for Shared Linux Hosting
# ==============================================================================

set -e

echo "=== [1/4] Entering Next.js Frontend Workspace ==="
cd "$(dirname "$0")/../../frontend"

echo "=== [2/4] Installing Clean Frontend Dependencies ==="
npm ci --legacy-peer-deps

echo "=== [3/4] Compiling Static HTML/CSS/JS Export ==="
npm run build

echo "=== [4/4] Verifying Static Output Directory ==="
if [ -d "out" ]; then
    echo "SUCCESS: Static export generated in frontend/out/"
    echo "Total files: $(find out -type f | wc -l)"
else
    echo "ERROR: Static export directory frontend/out/ not found!"
    exit 1
fi

echo "=== DentaFlow Frontend Export Ready for Shared Hosting Upload ==="
