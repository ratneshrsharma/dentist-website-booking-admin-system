# 🦷 Advanced Dental Clinic — Digital Dental Practice & Multi-Clinic Management Ecosystem

[![License: Commercial](https://img.shields.io/badge/License-Commercial%20License-0D9488.svg)](#-commercial-licensing--rental-waas)
[![Next.js 15](https://img.shields.io/badge/Frontend-Next.js%2015%20App%20Router-000000.svg?logo=nextdotjs)](https://nextjs.org/)
[![Laravel 11](https://img.shields.io/badge/Backend-Laravel%2011.x%20API-FF2D20.svg?logo=laravel)](https://laravel.com/)
[![AdminLTE 4](https://img.shields.io/badge/Admin%20Panel-AdminLTE%204%20(Bootstrap%205)-0D6EFD.svg)](https://adminlte.io/)
[![TypeScript Strict](https://img.shields.io/badge/TypeScript-Strict%20(Zero%20Any)-3178C6.svg?logo=typescript)](https://www.typescriptlang.org/)
[![PHP Strict](https://img.shields.io/badge/PHP-8.2%2B%20(declare(strict__types=1))-777BB4.svg?logo=php)](https://www.php.net/)
[![OWASP Top 10](https://img.shields.io/badge/Security-OWASP%20Hardened-10B981.svg)](#-enterprise-security--owasp-hardening)

### 🌐 Live Interactive Demos

| Surface | Live Link | Environment & Features |
| :--- | :--- | :--- |
| **🚀 Patient Portal & Booking Wizard** | [**Launch Patient Portal Demo**](https://advanced-dental-clinic-demo.vercel.app/) | Vercel Edge Global CDN • Next.js 15 • 5-Step Booking Wizard • 3 Theme Switchers • Live Slot Calculation • Smile Makeover Comparison |
| **💼 Full-Stack System (Production)** | [**https://demo.ratneshsharma.com/advanced-dental-clinic**](https://demo.ratneshsharma.com/advanced-dental-clinic) | Hostinger Shared Linux • Full-Stack Co-location • Laravel 11 REST API • AdminLTE 4 EMR • 32-Tooth SVG Odontogram • MySQL 8 Multi-Clinic |

> **A commercial-grade digital healthcare platform engineered for modern dental practices, multi-location dental chains, and dental organizations.** Combines an ultra-fast patient marketing portal with switchable design templates, a real-time 5-step appointment booking wizard, an AdminLTE 4 clinical management suite with an interactive 32-tooth SVG Odontogram, and centralized multi-branch logistics.

---

## ⚡ The 4 Core Integrated Modules

```
┌──────────────────────────────────────────────────────────────────────────────────┐
│                   Advanced Dental Clinic Ecosystem Architecture                  │
├───────────────────────┬───────────────────────┬──────────────────────────────────┤
│ 1. Patient Portal     │ 2. Real-Time Booking  │ 3. Central Clinical Admin (EMR)  │
│ • Next.js 15 SSG      │ • Live Slot Engine    │ • AdminLTE 4 + Bootstrap 5 Blade │
│ • 3 Design Themes     │ • 5-Step Wizard       │ • FullCalendar 6 Scheduling      │
│ • Smile Makeovers     │ • Medical Triage      │ • Interactive 32-Tooth SVG Chart │
│ • WhatsApp Hub        │ • DICOM / X-Ray Drops │ • Itemized POS Billing & Plans   │
├───────────────────────┴───────────────────────┴──────────────────────────────────┤
│ 4. Multi-Clinic Dashboard: Branch KPIs, Staff Allocation, Dental Inventory       │
└──────────────────────────────────────────────────────────────────────────────────┘
```

### 1. Patient-Facing Website & Marketing Portal
- **3 Instant Switchable Design Templates:**
  - **Modern Minimalist (Confident Doctor):** High-converting architectural layout with sans-serif typography, trust proofing, and clinical authority.
  - **Classic Heritage:** Navy and ivory palette with editorial serif styling for established, traditional practices.
  - **Clinical Luxury:** Obsidian dark mode with champagne gold accents for high-end cosmetic and veneer clinics.
- **Interactive Smile Makeover Slider:** Real-time before/after comparison slider highlighting cosmetic veneers, Invisalign, and full-mouth rehabilitations.
- **Doctor Specialist Showcase:** Detailed credentials, board certifications (ADA / FACP), years of experience, and real-time consultation booking triggers.
- **1-Click WhatsApp Clinical Hub:** Floating triage button providing instant patient chat, emergency trauma hotline routing, and fast booking links.

### 2. 5-Step Online Booking & Medical Intake Wizard
- **Real-Time Concurrency Engine:** Algorithmic slot generation intersecting doctor shift rosters, chair capacities, and procedure durations to completely eliminate double bookings.
- **Digital Pre-Consultation Intake:** Collects chief complaints, pre-existing systemic conditions (diabetes, cardiac conditions), drug allergies (penicillin, latex), and an interactive **1-to-10 pain scale slider**.
- **Diagnostic Upload Dropzone:** Drag-and-drop secure uploader for smartphone smile photos, panoramic OPG, and dental X-rays with SHA-256 integrity verification.
- **Automated Alerts:** Dispatches instant WhatsApp confirmation reminders and downloads `.ics` calendar invites for patient convenience.

### 3. Central Admin Panel & Patient EMR (AdminLTE 4)
- **Interactive SVG 32-Tooth Odontogram:** Native clinical dental chart mapping adult dentition (teeth 1–32) with five anatomical surfaces per tooth (`Mesial`, `Distal`, `Occlusal`, `Buccal`, `Lingual`). Surface conditions (`decay`, `filled`, `crown`, `implant`, `missing`, `rct`) automatically generate staged clinical treatment plans.
- **FullCalendar 6 Resource Scheduler:** Drag-and-drop appointment scheduling with real-time doctor and chair filtering, status color-coding, and walk-in intake modals.
- **Digital Prescriptions & Invoicing:** Automated itemized receipts, sales tax calculation, partial/full payment tracking, and multi-tender POS settlement.
- **Role-Based Access Control (RBAC):** Granular permissions for Super Admin, Clinic Admin, Doctor, Receptionist, Billing Specialist, and Website CMS Manager.

### 4. Multi-Clinic Management Dashboard
- **Centralized Multi-Branch Monitoring:** Executive overview tracking patient volume, chair occupancy rates, and revenue across all regional branches.
- **Cross-Branch Staff Allocation:** Dynamic doctor scheduling, weekly shift rosters, and cross-clinic coverage.
- **Dental Material Inventory:** Batch and lot tracking, expiry date alerts, procedure material deductions, and inter-branch stock transfer logging.

---

## 🛠️ Technology Stack & Architectural Standards

| Layer | Technologies & Architectural Choices | Quality Guarantees |
| :--- | :--- | :--- |
| **Frontend** | Next.js 15 (App Router), TypeScript, SCSS Tokens (`_variables.scss`, `_mixins.scss`), Lucide Icons | **Zero `any` tolerance**, BEM naming, **Zero Tailwind bloated utility classes**, sub-second static export (`output: 'export'`). |
| **Backend API** | PHP 8.2+, Laravel 11.x, MySQL 8.0, Composer | **`declare(strict_types=1);` in 100% of files**, thin controllers, single-responsibility Actions, typed DTOs, Form Requests, and Eloquent Repositories. |
| **Admin Panel** | AdminLTE 4, Bootstrap 5, FullCalendar 6, Native Inline SVG Odontogram | Responsive, accessible, keyboard navigable, zero bloated third-party client dependencies. |
| **Hosting Target** | Apache / LiteSpeed Shared Linux Hosting (Hostinger, GoDaddy, cPanel, Cloudways) | Custom production `.htaccess` routing `/api/v1/` and `/admin/` to Laravel while serving `/` from static Next.js export. |

---

## 🔒 Enterprise Security & OWASP Hardening

Built from the ground up to comply with healthcare security standards and protect Protected Health Information (PHI):

1. **SQL Injection Defense:** Zero raw string queries. All database operations strictly employ Laravel's Eloquent ORM with PDO prepared statements and parameter binding.
2. **Cross-Site Scripting (XSS) & CSRF:** Strict input sanitization in Form Requests, Content Security Policy (CSP), automatic Blade escaping, and token verification.
3. **Multi-Tiered Rate Limiting:**
   - Public API endpoints protected with `throttle:60,1` (60 requests/min).
   - Booking submission protected with `throttle:10,1` (10 requests/min) to prevent brute-force automated slot exhaustion.
4. **Diagnostic File Security:** MIME-type inspection, file extension whitelisting (`.jpg`, `.jpeg`, `.png`, `.pdf`, `.dcm`), random filename hashing, and file execution blocking in upload directories.
5. **Immutable Audit Trails:** Dedicated `system_audit_logs` tracking every administrative action, appointment modification, and patient record access with IP address and user agent records.
6. **Hardened HTTP Response Headers:** Production `.htaccess` automatically applies:
   - `X-Content-Type-Options: nosniff`
   - `X-Frame-Options: SAMEORIGIN`
   - `X-XSS-Protection: "1; mode=block"`
   - `Strict-Transport-Security: max-age=31536000; includeSubDomains`

---

## 📁 Repository Directory Structure

```text
├── backend/                           # Laravel 11.x Enterprise Core & AdminLTE 4
│   ├── app/
│   │   ├── Actions/Appointments/      # Single-responsibility transactional actions (Create, Reschedule, Cancel)
│   │   ├── DTOs/                      # Readonly typed Data Transfer Objects
│   │   ├── Enums/                     # PHP 8.2 backed enums (UserRole, AppointmentStatus, ToothCondition)
│   │   ├── Http/Controllers/Api/V1/   # Thin REST API controllers
│   │   ├── Http/Requests/             # Form Requests with OWASP input sanitization
│   │   ├── Http/Resources/V1/         # Standardized API response transformations
│   │   ├── Models/                    # 24 Eloquent models with typed casts and relationships
│   │   └── Services/                  # BookingAvailabilityService, OdontogramEngineService, BillingCalculationService
│   ├── database/
│   │   ├── migrations/                # 15 MySQL 8 migrations (Clinics, Users, EMR, Billing, Inventory)
│   │   └── seeders/                   # Production-ready demo seeders
│   ├── resources/views/               # AdminLTE 4 Blade panels (Dashboard, Calendar, EMR Odontogram)
│   └── routes/                        # api.php (rate-limited REST) and web.php (AdminLTE routes)
│
├── frontend/                          # Next.js 15+ Patient Marketing Portal & Booking App
│   ├── src/
│   │   ├── app/                       # App Router (layout.tsx, page.tsx)
│   │   ├── components/                # Atomic UI library, Navbar, Footer, BookingWizard (5 steps)
│   │   ├── lib/api-client.ts          # Typed API client with offline fallback mock data
│   │   ├── styles/                    # Centralized SCSS tokens (_variables.scss, _mixins.scss, globals.scss)
│   │   └── types/                     # Strict TypeScript interfaces (Zero any)
│   └── next.config.ts                 # Configured for static HTML export (output: 'export')
│
├── deployment/hostinger/              # Shared Hosting Production Assets
│   ├── .htaccess                      # Dual-surface routing, HTTPS redirect, Gzip, and OWASP headers
│   ├── deploy-backend.sh              # Backend migration and optimization script
│   └── deploy-frontend.sh             # Frontend static sync script
│
├── .agent/                            # Development Governance & Daily Diary
│   ├── architecture-rules.md          # 3-Persona engineering guidelines (Architect, Developer, QA)
│   └── daily-diary.md                 # Daily execution log across all development milestones
│
└── QA-SECURITY-REPORT.md              # Independent QA, security audit, and compliance verification
```

---

## 💼 Commercial Licensing & Rental (WaaS)

This platform is engineered by **Ratnesh Sharma**, Senior Full-Stack Architect & Engineering Team Lead (19+ years experience), and is available under flexible commercial terms:

### 1. Full Source Code License (Outright Buy)
- Full ownership of the source code (Next.js frontend + Laravel backend + AdminLTE admin + MySQL migrations).
- Unrestricted commercial license for single or multi-practice deployment.
- Complete documentation, architectural diagrams, and deployment guides.
- White-labeling rights to rebrand and customize for your dental clients.

### 2. Website as a Service (WaaS) Monthly Rental
- **Fully Managed Rental:** **$49 / month** per clinic location.
- **Includes:** High-speed cloud hosting, SSL certificates, automated daily off-site backups, doctor/treatment content updates, and software security patches.
- **ROI Formula:** A single new patient booking pays for over 6 months of the software subscription.

### 3. Custom Engineering & Integration Contracts
- Bespoke EHR/PMS integrations (Dentrix, Curve Dental, Eaglesoft).
- Custom payment gateway integration (Stripe, Square, PayPal, Razorpay).
- Regional language and currency localization.

---

## 📞 Inquiries & Contact

For commercial licensing, live demonstrations, or technical customization inquiries:

- **Developer & Architect:** Ratnesh Sharma
- **Portfolio & Website:** [https://ratneshsharma.com/](https://ratneshsharma.com/)
- **Email:** [ratnesh.at.24@gmail.com](mailto:ratnesh.at.24@gmail.com)
- **GitHub:** [@ratneshrsharma](https://github.com/ratneshrsharma)
- **WhatsApp:** [+91 99043 79260 (Direct Chat)](https://wa.me/919904379260?text=Hello%20Ratnesh,%20I%20am%20interested%20in%20the%20Advanced%20Dental%20Clinic%20System)

---

*© 2026 Ratnesh Sharma. All rights reserved. Built with clinical precision and enterprise clean code architecture.*
