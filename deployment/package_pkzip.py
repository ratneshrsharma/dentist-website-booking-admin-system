import os
import zipfile
import shutil

ROOT_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), '..'))
DIST_BUNDLE = os.path.join(ROOT_DIR, 'deployment', 'dist', 'bundle')
DIST_ZIP = os.path.join(ROOT_DIR, 'deployment', 'dist', 'advanced_dental_clinic_hostinger.zip')
ROOT_ZIP_FULL = os.path.join(ROOT_DIR, 'advanced_dental_clinic_hostinger.zip')
ROOT_ZIP_UPDATE = os.path.join(ROOT_DIR, 'update-booking-drawer-and-api.zip')

print(f"Packaging from Project Root: {ROOT_DIR}")

# 1. Sync updated files into deployment/dist/bundle
bundle_backend = os.path.join(DIST_BUNDLE, 'backend')
os.makedirs(os.path.join(bundle_backend, 'resources', 'views', 'layouts'), exist_ok=True)
os.makedirs(os.path.join(bundle_backend, 'resources', 'views', 'admin', 'billing'), exist_ok=True)
os.makedirs(os.path.join(bundle_backend, 'app'), exist_ok=True)
os.makedirs(os.path.join(bundle_backend, 'routes'), exist_ok=True)

shutil.copy2(os.path.join(ROOT_DIR, '.htaccess'), os.path.join(DIST_BUNDLE, '.htaccess'))
shutil.copy2(os.path.join(ROOT_DIR, 'backend', 'resources', 'views', 'layouts', 'admin.blade.php'),
             os.path.join(bundle_backend, 'resources', 'views', 'layouts', 'admin.blade.php'))
shutil.copy2(os.path.join(ROOT_DIR, 'backend', 'resources', 'views', 'admin', 'billing', 'invoice.blade.php'),
             os.path.join(bundle_backend, 'resources', 'views', 'admin', 'billing', 'invoice.blade.php'))
shutil.copy2(os.path.join(ROOT_DIR, 'backend', 'resources', 'views', 'admin', 'billing', 'index.blade.php'),
             os.path.join(bundle_backend, 'resources', 'views', 'admin', 'billing', 'index.blade.php'))
shutil.copy2(os.path.join(ROOT_DIR, 'backend', 'app', 'StandaloneRunner.php'),
             os.path.join(bundle_backend, 'app', 'StandaloneRunner.php'))
shutil.copy2(os.path.join(ROOT_DIR, 'backend', 'routes', 'web.php'),
             os.path.join(bundle_backend, 'routes', 'web.php'))

# 2. Build Full PKZIP Archive
print("Building Full PKZIP archive...")
if os.path.exists(DIST_ZIP):
    os.remove(DIST_ZIP)

with zipfile.ZipFile(DIST_ZIP, 'w', compression=zipfile.ZIP_DEFLATED, compresslevel=6) as zipf:
    for root, dirs, files in os.walk(DIST_BUNDLE):
        for file in files:
            file_path = os.path.join(root, file)
            arcname = os.path.relpath(file_path, DIST_BUNDLE)
            zipf.write(file_path, arcname)

shutil.copy2(DIST_ZIP, ROOT_ZIP_FULL)
print(f"Full PKZIP created at: {DIST_ZIP} ({os.path.getsize(DIST_ZIP) // 1024} KB)")
print(f"Mirrored to root: {ROOT_ZIP_FULL}")

# 3. Build Update-Only PKZIP Archive (backend + .htaccess)
print("Building Incremental Update PKZIP archive...")
if os.path.exists(ROOT_ZIP_UPDATE):
    os.remove(ROOT_ZIP_UPDATE)

with zipfile.ZipFile(ROOT_ZIP_UPDATE, 'w', compression=zipfile.ZIP_DEFLATED, compresslevel=6) as zipf:
    # Add root .htaccess
    zipf.write(os.path.join(ROOT_DIR, '.htaccess'), '.htaccess')
    # Add backend
    for root, dirs, files in os.walk(bundle_backend):
        for file in files:
            file_path = os.path.join(root, file)
            arcname = os.path.relpath(file_path, DIST_BUNDLE)
            zipf.write(file_path, arcname)

print(f"Incremental PKZIP created at: {ROOT_ZIP_UPDATE} ({os.path.getsize(ROOT_ZIP_UPDATE) // 1024} KB)")
print("Done! Both archives are standard Deflate PKZIP format compliant with Hostinger.")
