# AI Instruction Rule 02: Coding Standards & OWASP Security

## Purpose
Establishes the mandatory coding standards, security guardrails, and quality requirements across both the frontend (TypeScript/LESS) and backend (PHP 8.2+ Laravel).

---

### 1. Frontend Standards (React / Next.js + TypeScript)
1. **Strict TypeScript Typing:**
   - Strict mode enabled (`strict: true` in `tsconfig.json`).
   - Disallow `any`. Explicitly declare interfaces and types for all props, API responses, and state objects.
   - Use enums or union types for statuses (e.g., `AppointmentStatus = 'pending' | 'confirmed' | 'cancelled' | 'completed'`).
2. **ESLint & Prettier Compliance:**
   - Clean linting with zero warnings or errors.
   - Consistent formatting: 2 spaces, semi-colons, single quotes where appropriate.
3. **API & Security Layer (Axios Toolkit):**
   - Centralized Axios client (`src/api/client.ts`) with request and response interceptors.
   - Standardized CRUD helpers: `get`, `add`, `edit`, `view`, `update`, `delete`, `action`.
   - Client-side payload encryption/decryption module (`CryptoHelper`) for sensitive payload transport.
   - Secure token handling with automatic session expiry redirection.
4. **Component Design:**
   - One component per file with atomic separation (`Component.tsx`, `Component.module.less`, `types.ts`).
   - Comprehensive inline comments and JSDoc describing component purpose and props.

---

### 2. Backend Standards (PHP 8.2+ Laravel MVC)
1. **PSR-12 Compliance:**
   - Strict adherence to PHP PSR-12 coding style.
   - Strict scalar types enabled (`declare(strict_types=1);`) in all PHP classes.
2. **Mandatory DocBlocks & Comments:**
   - Full PHPDoc comments on all controllers, services, repositories, and models.
   - Explicit parameter types and return type declarations on every method.
3. **Zero Hardcoded Secrets:**
   - All credentials (database, SMTP, WhatsApp API keys, crypto secrets) must load via `.env`.
   - Never commit `.env` or production secrets to Git.
4. **OWASP Top 10 Security Enforcement:**
   * **SQL Injection (SQLi):** Mandatory use of Eloquent ORM or PDO prepared statements with parameter binding. Zero raw SQL concatenations.
   * **Cross-Site Scripting (XSS):** Blade auto-escaping `{{ $var }}` by default. Strict HTML Purifier / sanitization on rich-text CMS inputs.
   * **Cross-Site Request Forgery (CSRF):** Verify CSRF tokens on all web form mutations and use Sanctum / Bearer token authorization for REST APIs.
   * **Session & Cookie Security:** `httponly=true`, `secure=true` (production), `samesite=Lax`, and 30-minute idle session timeouts.
   * **Strict Input Validation:** FormRequest classes validating all incoming payloads (types, lengths, regex, required fields).

---

### 3. Swagger / OpenAPI Documentation
* All `/api/v1/...` endpoints must be annotated with Swagger (`@OA\...`) DocBlocks.
* Swagger JSON/UI must be kept in sync so any developer or tester can execute requests directly via browser under `/api/documentation`.
