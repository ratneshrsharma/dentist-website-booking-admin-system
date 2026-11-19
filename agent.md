# AI Agent Operating Guidelines & Project Architecture

## 1. Project Mission & Identity
- **Project:** Advanced Dental Clinic Management Suite & Patient Portal
- **Practice:** Acocks Green Dental Practice (1078 Warwick Road, Acocks Green, Birmingham B27 6BH)
- **Author / Lead Architect:** Ratnesh Sharma (`ratnesh.at.24@gmail.com`)
- **Git Protocol:** Commit and push every micro-task immediately to GitHub under author Ratnesh Sharma.

---

## 2. Zero-Loading Frontend & Component Architecture
The patient-facing Next.js frontend must have **0ms perceived loading time** during client route changes:
1. **Never use blocking full-page loaders on internal navigation:** Remove artificial timeouts (250ms/500ms in preloader). Initial preloader runs once on hard reload or not at all.
2. **Instant Pre-rendered Static HTML (SSG) + Client Hydration:** Pages mount immediately with local fallback data.
3. **Background SWR API Updates:** CMS and theme data sync asynchronously in the background. If data is pending, subtle Tailwind `animate-pulse` skeleton placeholders appear without freezing the page.
4. **Single-Source Reusable Shared Components:**
   - `<Header />`: Global navigation, 9 treatments mega-menu, emergency hotline.
   - `<InnerBanner />`: Standardized inner page header (title, breadcrumbs, subtitle on left, lead clinician on right).
   - `<Breadcrumbs />`: Dynamic hierarchical trail.
   - `<ServicesThumbnailGrid />`: Unified 9-card clinical grid used on Homepage and Treatments Catalog.
   - `<TreatmentCard />`: Individual card with image, category badge, NHS band, bullet points, CTA button.
   - `<PricingMatrixTable />`: NHS Band 1/2/3 & Private comparison matrix.
   - `<ClinicalPillarsGrid />`: 4 clinical reassurance badges (3D scans, phobic care, CQC, emergency).
   - `<ConsultationActionBar />`: Bottom CTA banner (*"Ready to Plan Your Treatment?"*).
   - `<CliniciansList />`: GDC clinician cards.
   - `<PatientFeedbackList />`: 5-star Google & NHS review slider.
   - `<PracticeLocationHours />`: Address, opening hours, parking, triage directions.
   - `<FaqAccordion />`: Collapsible Q&A component.
   - `<Footer />`: Practice footer with CQC rating, NHS links, and sitemap.

---

## 3. The 9 Clinical Treatments (Exact Mega-Menu Alignment)
All 9 treatments must be rendered as full thumbnail cards on both the Homepage and Treatments page:
1. **General Dentistry** (`/treatments/general-dentistry`) - NHS & Private
2. **Hygiene & Airflow Therapy** (`/treatments/general-dentistry#hygiene` or `/treatments/hygiene-airflow`)
3. **Emergency Root Canal** (`/treatments/root-canal-treatment`)
4. **Dental Implants** (`/treatments/dental-implants`)
5. **Crowns & Bridgework** (`/treatments/crowns-and-bridges`)
6. **All-on-4 / Full Arch Implants** (`/treatments/all-on-4-dental-implants`)
7. **Clear Aligners & Invisalign** (`/treatments/clear-aligners`)
8. **Teeth Whitening** (`/treatments/teeth-whitening`)
9. **Porcelain Veneers & Bonding** (`/treatments/porcelain-veneers`)

---

## 4. WordPress-Grade Admin CMS Manager (`/admin/cms-pages`)
1. **Directory Table:**
   - Status Tabs: `All (24) | Published (20) | Drafts (3) | Trash (1)`
   - Row Hover Quick Actions: `Edit | Quick Edit | Move to Trash | View Page ↗`
   - Complete 24-page directory: 9 treatments, 6 core pages, 9 legal/compliance pages.
   - Working search filter, category filter, and pagination.
2. **Slide-Out Editor Drawer (`offcanvas-end`):**
   - 760px right-docked sliding drawer replacing popup modals.
   - Visual Rich Text / WYSIWYG editor for section copy (headings, bold/italic, lists, links, media) requiring zero HTML/CSS knowledge.
   - Modular Section Block Builder: Hero Banner, Services Grid, Clinical Rich Text, Pricing Matrix, FAQs, Bottom CTA.
   - Sticky Publish Box: Status toggle (`Published` vs `Draft`), `Save Draft`, `Preview ↗`, `Update / Publish`.
   - Trash & Restore workflow (soft-delete to Trash, 1-click Restore, or Delete Permanently).

---

## 5. Execution Rules for AI Agents
1. Always read `DAILY_EXECUTION_LOG.md` first before beginning tasks.
2. Maintain `DAILY_EXECUTION_LOG.md` with new entries on top after completing each milestone.
3. Test all API and frontend changes thoroughly before committing.
4. Execute git commits and pushes under **Ratnesh Sharma** (`ratnesh.at.24@gmail.com`).
