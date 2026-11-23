# REST API Specification (v1)

## Overview
All endpoints are prefixed with `/api/v1` and return standardized JSON responses:
```json
{
  "success": true,
  "data": {},
  "message": "Operation successful",
  "meta": {}
}
```

## Swagger / OpenAPI
Interactive Swagger UI is accessible at `/api/documentation` locally on XAMPP.

## Key Endpoint Groups
* `/api/v1/theme` — Global theme settings, branding, colors, contact details
* `/api/v1/pages/{slug}` — Dynamic page CMS payloads
* `/api/v1/services` — Treatment categories, pricing, CDT codes, procedures
* `/api/v1/doctors` — Clinician bios, specialties, availability schedules
* `/api/v1/availability/slots` — Real-time booking slot query
* `/api/v1/appointments` — Patient booking intake and cancellation
* `/api/v1/blog` — Dental blog articles, categories, single posts
