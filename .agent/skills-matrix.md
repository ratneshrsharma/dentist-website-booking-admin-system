# Skills & Plugins Matrix: Agent Assignment & Operational Workflow

This matrix defines the 17 specialized engineering and design skills incorporated into the Advanced Dental Clinic project. Each skill is mapped to its primary **Agent Persona**, its concrete **Project Application**, and its **Activation Trigger**.

---

## Persona Overview

- **Architect Agent (System Governance & Technical Direction):** Responsible for high-level system design, schema integrity, DTO contracts, API design, security threat modeling, and code standards.
- **Developer Agent (Modular & Clean Implementation):** Responsible for authoring strictly-typed, DRY, and modular code across the Laravel backend, AdminLTE admin panel, and Next.js frontend.
- **QA & Reviewer Agent (Security, Style & Visual Verification):** Responsible for pre-commit verification, OWASP penetration simulation, PHPStan/ESLint audits, visual polish, and automated browser testing.

---

## 17 Skills Inventory & Agent Mapping

| # | Skill / Plugin | Primary Agent Persona | Secondary Persona | Project Domain & Application |
|---|----------------|-----------------------|-------------------|------------------------------|
| **1** | **Onyx** | Developer Agent | Architect Agent | **Clinical AI & Patient Triage:** Powers the AI-driven pre-consultation chatbot on the patient site and clinical SOP search in the admin panel using clinic knowledge documents. |
| **2** | **Scrapling** | Architect Agent | Developer Agent | **Market & Clinical Research:** Scrapes benchmark dental pricing data, procedure duration standards, and regional market fees to generate realistic database seeders. |
| **3** | **Impeccable (UI Polish)** | QA & Reviewer Agent | Developer Agent | **Automated Interface Polish:** Performs single-command UI audits to rectify spacing anomalies, typography scales, and alignment inconsistencies across all templates. |
| **4** | **Ponytail** | Architect Agent | Developer Agent | **Senior Pair Architect:** Enforces Clean Architecture in Laravel, thin controllers, single-responsibility Actions, strict typing (`declare(strict_types=1);`), and SOLID design. |
| **5** | **Last 30 Days** | Architect Agent | Developer Agent | **Industry Trends Intelligence:** Discovers the latest 30-day patient UX innovations (contactless check-in, WhatsApp one-tap workflows) to maintain product competitiveness. |
| **6** | **Humanizer** | Developer Agent | Architect Agent | **Empathetic Patient Copy:** Converts technical dental terminology into warm, reassuring, bedside-manner copy for patient intake, FAQs, and WhatsApp reminder templates. |
| **7** | **Diagram Design** | Architect Agent | QA & Reviewer Agent | **System Architecture Diagrams:** Generates interactive Mermaid / SVG blueprints for multi-clinic workflows, odontogram state machines, and MySQL ER schemas. |
| **8** | **REA** | Architect Agent | Developer Agent | **Clinical Software Deconstruction:** Reverse-engineers commercial dental EMR workflows (Dentrix, Curve Dental) to ensure clinical parity in tooth charting and invoicing. |
| **9** | **UI UX Pro Max** | Developer Agent | QA & Reviewer Agent | **Atomic Design System:** Builds the core atomic SCSS design tokens, responsive grid layouts, and accessible component hierarchies for the 3 switchable website themes. |
| **10** | **Hallmark** | Developer Agent | Architect Agent | **Anti-AI Cliché Art Direction:** Eliminates sterile AI tropes (generic blue gradients, cheesy stock photos) by implementing bespoke typography, authentic textures, and clinical elegance. |
| **11** | **transitions.dev** | Developer Agent | QA & Reviewer Agent | **Seamless Page & Wizard Transitions:** Implements smooth Framer Motion and CSS view-transitions between booking steps (Step 1 through 5) and view switches. |
| **12** | **Impeccable (Design Gate)** | QA & Reviewer Agent | Developer Agent | **Pre-Flight Design QA:** Validates responsive breakpoints (320px to 2560px), focus rings, modal backdrops, and z-index hierarchies before code is marked ready for commit. |
| **13** | **Playwright CLI** | QA & Reviewer Agent | Developer Agent | **Automated E2E Testing:** Executes end-to-end automated browser tests for the 5-step booking wizard, AdminLTE drag-and-drop calendar, and odontogram tooth clicks. |
| **14** | **GSAP Skills** | Developer Agent | QA & Reviewer Agent | **High-Performance Micro-Animations:** Drives before/after cosmetic smile comparison sliders, headline timeline reveals, interactive tooth chart glows, and stat counters. |
| **15** | **React Bits** | Developer Agent | Architect Agent | **Animated UI Component Library:** Provides reusable interactive React micro-components (magnetic buttons, animated testimonials, review sliders, accordion FAQs). |
| **16** | **designlang** | Architect Agent | Developer Agent | **Design Token Harmonization:** Defines and synchronizes the design language tokens between Next.js SCSS (`_variables.scss`) and AdminLTE 4 Bootstrap 5 variables. |
| **17** | **Taste Skill** | Architect Agent | QA & Reviewer Agent | **Executive Aesthetic Governance:** Conducts browser screenshot checks to verify editorial restraint, visual hierarchy, luxury color harmony, and commercial appeal. |

---

## Persona Assignment Breakdown

### 🏛️ Architect Agent
- **Core Skills:** `Ponytail`, `Diagram Design`, `REA`, `designlang`, `Last 30 Days`, `Scrapling`, `Taste Skill`.
- **Primary Duties:**
  1. Break down user requests into micro-tasks and atomic git commits.
  2. Enforce strict PHP typing (`declare(strict_types=1);`), DTO contracts, and OWASP Top 10 security safeguards.
  3. Formulate data architecture, database schema, and REST API contracts.
  4. Review design language tokens and system integration boundaries.

### 💻 Developer Agent
- **Core Skills:** `Onyx`, `UI UX Pro Max`, `Hallmark`, `transitions.dev`, `GSAP Skills`, `React Bits`, `Humanizer`.
- **Primary Duties:**
  1. Author clean, modular, and DRY code in Laravel 11 and Next.js 15.
  2. Implement atomic SCSS components with zero Tailwind class pollution.
  3. Build the 5-step real-time booking wizard, interactive SVG odontogram, and FullCalendar scheduler.
  4. Write empathetic patient copy and seed authentic dental practice data.

### 🛡️ QA & Reviewer Agent
- **Core Skills:** `Impeccable (UI Polish)`, `Impeccable (Design Gate)`, `Playwright CLI`, `Taste Skill`, `Diagram Design`.
- **Primary Duties:**
  1. Run automated and manual penetration checks (SQLi, XSS, CSRF, Secure Uploads).
  2. Execute static analysis (PHPStan Level 8, ESLint strict, TypeScript `tsc --noEmit`).
  3. Inspect responsive layout fidelity across mobile, tablet, and desktop viewports.
  4. Compile the mandatory **QA & Security Report** before marking any micro-task complete.
