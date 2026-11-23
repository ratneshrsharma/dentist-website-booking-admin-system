# AI Instruction Rule 01: Planning & Architecture

## Purpose
This document governs how the AI agent plans, breaks down, and approaches every task within the `01-Dental-SaaS` platform codebase.

---

### 1. Mandatory Micro-Task Planning Workflow
Before writing or modifying any code:
1. **Understand Requirements & Context:**
   - Read `DAILY_DIARY.md` at the project root to know the current project phase, completed tasks, and next steps.
   - Inspect the corresponding UI reference templates in `/html` and content schemas in `ref/JSONs/`.
2. **Decompose into Atomic Micro-Tasks:**
   - Never implement monolithic changes. Break every feature into verifiable micro-tasks:
     * Database migration & seeder.
     * Backend Model, Repository, Service & Controller.
     * Swagger / OpenAPI documentation & validation request.
     * AdminLTE 4 CRUD view and management controls.
     * Frontend atomic components, LESS styles, and API integration.
3. **Present Checklist for Confirmation:**
   - Present the planned micro-tasks and wait/confirm before executing major architecture shifts.

---

### 2. Architectural Boundaries
* **Decoupled Architecture:**
  - **Frontend:** React / Next.js with TypeScript and LESS. Responsible for public website views, client-side caching, SEO hydration, and patient interactions.
  - **Backend:** PHP 8.2+ with Laravel MVC providing a strictly versioned REST API (`/api/v1/...`) and AdminLTE 4 administrative dashboard.
* **Shared Server Compatibility:**
  - Apache / LiteSpeed `.htaccess` multi-routing rules must be preserved.
  - Zero daemon dependency for critical paths on shared hosting (use native PHP-FPM execution, MySQL indexing, and SMTP mail dispatches).
* **White-Label Readiness:**
  - No hardcoded clinic names, addresses, phone numbers, or color hex codes in public UI components.
  - Everything must resolve via the Global Theme and Clinic Configuration APIs (`/api/v1/theme`, `/api/v1/clinic`).

---

### 3. Verification & Quality Gates
Every completed micro-task must satisfy:
* Static type validation (TypeScript strict mode, no `any`).
* PHP syntax and PSR-12 linting (`php -l`).
* Swagger documentation updated for any added or altered endpoint.
* Prepending an updated entry to `DAILY_DIARY.md`.
