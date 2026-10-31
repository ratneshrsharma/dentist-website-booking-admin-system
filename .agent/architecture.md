# DentaFlow Architecture & System Specification

## 1. System Overview
DentaFlow is a turnkey, multi-clinic dental management and patient engagement platform built for commercial deployment on shared Linux servers (Hostinger, GoDaddy). It combines a high-speed static patient portal with a full-featured clinical administration engine.

---

## 2. Dual-Surface Architecture

```text
portfolio/01-Dentist Website +Booking System  + Admin Panle+ Clinik Dashboard/
├── .agent/                                    # Governance, rules, skills, diary
│   ├── rules.md
│   ├── skills-matrix.md
│   ├── architecture.md
│   └── daily-diary.md
├── backend/                                   # Laravel 11.x Enterprise Application
│   ├── app/
│   │   ├── Actions/                           # Single-responsibility domain actions
│   │   ├── DTOs/                              # Readonly Data Transfer Objects
│   │   ├── Enums/                             # PHP 8.2 Backed Enums
│   │   ├── Http/Controllers/Admin/            # Thin Blade controllers (AdminLTE 4)
│   │   ├── Http/Controllers/Api/V1/           # Thin REST controllers (Next.js)
│   │   ├── Http/Requests/                     # Strict Form Requests
│   │   ├── Http/Resources/V1/                 # JSON API Resources
│   │   ├── Models/                            # Eloquent Models with strict casts
│   │   ├── Policies/                          # Authorization policies (RBAC)
│   │   ├── Repositories/                      # Data access abstraction
│   │   └── Services/                          # Core domain algorithms
│   ├── database/migrations/                   # 29 MySQL 8 migrations
│   ├── resources/views/admin/                 # AdminLTE 4 Blade templates
│   └── routes/api.php & web.php               # REST & Web routing
├── frontend/                                  # Next.js 15+ Patient Portal & Booking
│   ├── src/
│   │   ├── app/                               # Next.js App Router pages
│   │   ├── components/                        # Atomic component hierarchy
│   │   ├── styles/                            # SCSS design tokens & mixins (No TW)
│   │   └── types/                             # Strict TypeScript contracts (Zero any)
│   └── next.config.ts                         # Static export ('export')
└── deployment/hostinger/                      # Production packaging
    ├── .htaccess                              # Apache / LiteSpeed rewrite & security engine
    ├── deploy-backend.sh                      # Migration and cache warmup script
    └── deploy-frontend.sh                     # Static asset sync script
```

---

## 3. Database Schema Blueprint (MySQL 8.0+)

1. **`clinics`**: Multi-branch entities (`id`, `name`, `slug`, `code`, `phone`, `email`, `address`, `city`, `timezone`, `is_headquarters`, `is_active`).
2. **`users`**: RBAC accounts (`id`, `clinic_id`, `role`, `first_name`, `last_name`, `email`, `phone`, `password`, `is_active`).
3. **`doctor_profiles`**: Specialized credentials (`id`, `user_id`, `license_number`, `specialization`, `qualifications`, `years_of_experience`, `consultation_fee`).
4. **`doctor_schedules`**: Weekly shift rosters (`id`, `doctor_profile_id`, `clinic_id`, `day_of_week`, `shift_start_time`, `shift_end_time`, `slot_duration_minutes`, `max_parallel_chairs`).
5. **`patient_profiles`**: Electronic Medical Record (`id`, `primary_clinic_id`, `medical_record_number`, `first_name`, `last_name`, `gender`, `date_of_birth`, `phone`, `email`, `allergies`, `systemic_conditions`).
6. **`service_categories` & `services`**: Dental offerings (`id`, `category_id`, `name`, `slug`, `short_description`, `standard_duration_minutes`, `base_cost`, `requires_xray`).
7. **`appointments`**: Bookings (`id`, `booking_reference`, `clinic_id`, `doctor_profile_id`, `patient_profile_id`, `service_id`, `appointment_date`, `start_time`, `end_time`, `status`).
8. **`patient_intakes`**: Questionnaire (`id`, `appointment_id`, `chief_complaint`, `pain_level_1_to_10`, `last_dental_visit_interval`, `digital_signature_hash`).
9. **`patient_documents`**: Secure files (`id`, `patient_profile_id`, `document_type`, `stored_file_path`, `original_filename`, `mime_type`, `file_size_bytes`, `sha256_checksum`).
10. **`dental_charts` & `tooth_records`**: Digital Odontogram (`id`, `dental_chart_id`, `tooth_number`, `condition_code`, `affected_surfaces`, `periodontal_pocket_depths`).
11. **`treatment_plans` & `treatment_procedures`**: Multi-phase care (`id`, `treatment_plan_id`, `service_id`, `tooth_number`, `phase_number`, `estimated_cost`, `actual_cost`, `status`).
12. **`prescriptions` & `prescription_items`**: Medications (`id`, `prescription_id`, `medication_name`, `dosage_form`, `frequency`, `duration_days`).
13. **`invoices`, `invoice_items` & `payments`**: Invoicing (`id`, `invoice_number`, `clinic_id`, `subtotal`, `tax_amount`, `total_amount`, `paid_amount`, `status`).
14. **`inventory_items`, `clinic_stocks` & `stock_movements`**: Supply chain (`id`, `item_code`, `name`, `category`, `unit_of_measure`, `reorder_threshold`, `batch_lot_number`, `current_quantity`, `expiry_date`).
15. **`cms_pages`, `cms_services`, `cms_doctor_profiles`, `cms_reviews`**: Website CMS (`id`, `page_key`, `active_template`, `content_blocks`).
16. **`notification_logs` & `system_audit_logs`**: Integrity auditing (`id`, `user_id`, `action`, `auditable_type`, `auditable_id`, `old_values`, `new_values`).

---

## 4. REST API Contracts (Endpoints)

| Method | Endpoint | Description | Auth |
|---|---|---|---|
| `GET` | `/api/v1/clinics` | Fetch all active clinic branches | Public |
| `GET` | `/api/v1/services` | Fetch dental services grouped by category | Public |
| `GET` | `/api/v1/doctors` | Fetch doctor profiles by clinic and specialty | Public |
| `GET` | `/api/v1/availability` | Calculate available time slots for doctor & date | Public |
| `POST` | `/api/v1/appointments/book` | Submit 5-step booking and intake form | Public (Throttled) |
| `POST` | `/api/v1/documents/upload` | Upload X-ray or patient document | Public (Signed) |
| `GET` | `/api/v1/cms/page/{key}` | Fetch dynamic page CMS blocks & active template | Public |

---

## 5. Website Templates (3 Switchable Visual Systems)

1. **Modern Minimalist (`modern`):**
   - Palette: Clean white (`#FFFFFF`), Soft surgical slate (`#F8FAFC`), Medical teal (`#0EA5E9`), Dark navy (`#0F172A`).
   - Fonts: `Plus Jakarta Sans`, `Inter`.
   - Vibe: Friendly, approachable, family care, gentle dentistry.
2. **Classic Heritage (`classic`):**
   - Palette: Warm ivory (`#FDFBF7`), Hospital navy (`#1E3A8A`), Warm gold (`#D97706`), Muted slate (`#334155`).
   - Fonts: `Playfair Display`, `Lora`.
   - Vibe: Prestigious surgical practice, academic excellence, traditional trust.
3. **Clinical Luxury (`premium`):**
   - Palette: Obsidian black (`#0B0F19`), Champagne metallic gold (`#F59E0B`), Deep emerald (`#059669`), Crisp white (`#F8FAFC`).
   - Fonts: `Outfit`, `Manrope`.
   - Vibe: High-end cosmetic dentistry, smile makeover studio, porcelain veneer and implant boutique.
