# Hostinger Shared Hosting Deployment Guide & Priority Plan
## Brand: Advanced Dental Clinic
### Target URL: `https://demo.ratneshsharma.com/advanced-dental-clinic/`
### Architecture: Dual-Surface (Next.js 15 Static Frontend + Laravel 11 REST API & AdminLTE 4 Blade)

---

## 📋 Executive Deployment Summary

| Component | Target Location on Hostinger | Runtime / Engine | Access URL |
| :--- | :--- | :--- | :--- |
| **Patient Website** | `public_html/demo/advanced-dental-clinic/` | Static HTML/CSS/JS (Next.js 15) | `https://demo.ratneshsharma.com/advanced-dental-clinic/` |
| **AdminLTE Portal** | `public_html/demo/advanced-dental-clinic/backend/` | PHP 8.2+ / Laravel 11 Blade | `https://demo.ratneshsharma.com/advanced-dental-clinic/admin/dashboard` |
| **REST APIs** | `public_html/demo/advanced-dental-clinic/backend/public/` | Laravel 11 REST API | `https://demo.ratneshsharma.com/advanced-dental-clinic/api/v1/...` |
| **Database** | Hostinger MySQL Server (`127.0.0.1:3306`) | MySQL 8.0+ | Managed via Hostinger phpMyAdmin |

---

## 🎯 Step-by-Step Priority Deployment Checklist

### Priority 1: Create Hostinger MySQL Database & 1-Click Import (Estimated: 3 mins)
1. Log in to your **Hostinger hPanel** (`hpanel.hostinger.com`).
2. Navigate to **Databases** → **MySQL Databases**.
3. Confirmed Database Details:
   - **Database Name:** `u499464314_advanceddental`
   - **Database Username:** `u499464314_dental_user`
4. Click **Enter phpMyAdmin** next to `u499464314_advanceddental`.
5. In phpMyAdmin, click the **Import** tab on the top menu.
6. Click **Choose File** and select:
   `deployment/database/advanced_dental_clinic.sql`
7. Click **Import** at the bottom.
   - *Result:* All tables (`clinics`, `users`, `doctor_profiles`, `service_categories`, `cms_treatments`, `theme_settings`, `seo_metadata`, `seo_redirects`) will be created and pre-seeded with American clinical standards and default admin logins.

---

### Priority 2: Prepare Target Directory in Hostinger File Manager (Estimated: 2 mins)
1. In hPanel, go to **Files** → **File Manager**.
2. Open the domain root: `public_html/`.
3. Create the directory path:
   `public_html/demo/advanced-dental-clinic/`
4. This directory will host both the patient-facing Next.js frontend and the secure backend.

---

### Priority 3: Upload Website & Backend Files (Estimated: 5 mins)
You have two fast upload methods:

#### Method A: 1-Click ZIP Upload (Recommended via File Manager)
1. Run the packaging command locally:
   ```bash
   bash deployment/hostinger/package-hostinger.sh
   ```
2. Upload the generated `deployment/dist/advanced_dental_clinic_hostinger.zip` to:
   `public_html/demo/advanced-dental-clinic/`
3. Right-click the `.zip` file in Hostinger File Manager and choose **Extract**.
4. Ensure the `.htaccess` and `index.html` sit directly inside `public_html/demo/advanced-dental-clinic/`.

#### Method B: Git Deployment via Hostinger Git Tool
1. In hPanel, navigate to **Advanced** → **Git**.
2. Repository URL: `https://github.com/ratneshrsharma/dentist-website-booking-admin-system.git`
3. Branch: `main`
4. Directory: `/public_html/demo/advanced-dental-clinic/`
5. Click **Create** & **Deploy**.

---

### Priority 4: Configure Backend `.env` on Hostinger (Estimated: 2 mins)
1. In Hostinger File Manager, navigate to:
   `public_html/demo/advanced-dental-clinic/backend/`
2. Open or create `.env` (using `deployment/hostinger/env.production.example` as a template).
3. Fill in your Hostinger database and domain details:
   ```env
   APP_NAME="Advanced Dental Clinic"
   APP_ENV=production
   APP_KEY=base64:eU8QWzJ8R9L1sK3V5X7Z9eM3C5P7S9U1W3Y5A7C9E1G3I5K7M9O1Q=
   APP_DEBUG=false
   APP_URL=https://demo.ratneshsharma.com/advanced-dental-clinic

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=u499464314_advanceddental
   DB_USERNAME=u499464314_dental_user
   DB_PASSWORD=YourActualHostingerDatabasePassword

   SESSION_DRIVER=file
   CACHE_STORE=file

   # Hostinger SMTP
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.hostinger.com
   MAIL_PORT=465
   MAIL_USERNAME=appointments@demo.ratneshsharma.com
   MAIL_PASSWORD=YourEmailPassword
   MAIL_ENCRYPTION=ssl
   MAIL_FROM_ADDRESS="appointments@demo.ratneshsharma.com"
   MAIL_FROM_NAME="Advanced Dental Clinic"
   ```
4. Save the file.

---

### Priority 5: Verify Hostinger PHP Version & Storage Permissions (Estimated: 2 mins)
1. In hPanel, go to **Advanced** → **PHP Configuration**.
2. Ensure PHP Version is set to **PHP 8.2** or **PHP 8.3**.
3. Enable essential extensions (already active by default on Hostinger):
   - `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `curl`, `bcmath`, `fileinfo`.
4. In File Manager, ensure the following folders have write permissions (`775` or `755`):
   - `backend/storage/`
   - `backend/storage/framework/`
   - `backend/storage/logs/`
   - `backend/bootstrap/cache/`

---

### Priority 6: Verify LiteSpeed/Apache `.htaccess` Dual-Routing (Estimated: 2 mins)
Ensure the root `.htaccess` inside `public_html/demo/advanced-dental-clinic/.htaccess` is active.

```apache
# Dual-Surface LiteSpeed/Apache Routing
RewriteEngine On

# 1. API routes direct to Laravel public index
RewriteRule ^api/(.*)$ backend/public/index.php [L,QSA]

# 2. Admin routes direct to Laravel AdminLTE
RewriteRule ^admin/(.*)$ backend/public/index.php [L,QSA]

# 3. Static files direct from frontend/out
RewriteCond %{DOCUMENT_ROOT}/frontend/out/$1 -f
RewriteRule ^(.*)$ frontend/out/$1 [L]

RewriteCond %{DOCUMENT_ROOT}/frontend/out/$1/index.html -f
RewriteRule ^(.*)/?$ frontend/out/$1/index.html [L]
```

---

### Priority 7: Setup Automated Cron Jobs in Hostinger (Estimated: 2 mins)
For appointment reminders, automated status updates, and session pruning:
1. In hPanel, go to **Advanced** → **Cron Jobs**.
2. Select **Custom**.
3. Schedule: `* * * * *` (Every minute).
4. Command:
   ```bash
   /usr/bin/php /home/u123456789/public_html/demo/advanced-dental-clinic/backend/artisan schedule:run >> /dev/null 2>&1
   ```

---

### Priority 8: Post-Deployment Smoke Testing Checklist
Once the site is live, test the following URLs:

1. **Patient Multi-Page Website:**
   - Home: `https://demo.ratneshsharma.com/advanced-dental-clinic/`
   - Treatments: `https://demo.ratneshsharma.com/advanced-dental-clinic/treatments/`
   - Dynamic Procedure: `https://demo.ratneshsharma.com/advanced-dental-clinic/treatments/dental-implants/`
   - About Us: `https://demo.ratneshsharma.com/advanced-dental-clinic/about-us/`
   - Our Team: `https://demo.ratneshsharma.com/advanced-dental-clinic/our-team/`
   - Contact: `https://demo.ratneshsharma.com/advanced-dental-clinic/contact/`

2. **AdminLTE 4 Portal:**
   - URL: `https://demo.ratneshsharma.com/advanced-dental-clinic/admin/dashboard`
   - Default Super Admin: `admin@demo.ratneshsharma.com` / `AdminPassword123!`
   - Theme Customizer: `https://demo.ratneshsharma.com/advanced-dental-clinic/admin/theme-customizer`
   - Yoast SEO & Scripts: `https://demo.ratneshsharma.com/advanced-dental-clinic/admin/seo-manager`
   - 301 Redirects: `https://demo.ratneshsharma.com/advanced-dental-clinic/admin/seo-redirects`

3. **REST API Health:**
   - Health Ping: `https://demo.ratneshsharma.com/advanced-dental-clinic/api/v1/ping`
   - Treatments API: `https://demo.ratneshsharma.com/advanced-dental-clinic/api/v1/cms/treatments`
   - Theme Settings API: `https://demo.ratneshsharma.com/advanced-dental-clinic/api/v1/theme/settings`

---

### Priority 9: Reminder Trigger (WhatsApp & Email Notifications)
*As requested, once the website is uploaded to the shared server and verified through the above smoke tests, we will proceed to implement the **Dual WhatsApp & Email notifications for clinic staff and patients**!*
