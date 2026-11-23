# Frontend Engineering Documentation

## Architecture
* **Framework:** React / Next.js with TypeScript
* **Styling:** LESS + Modular CSS (`*.module.less`)
* **API Communication:** Global Axios Toolkit (`src/api/client.ts`) with payload crypto module
* **Design System:** Corporate Clinical Modern adhering strictly to `/html` reference templates.

## Structure
* `components/`: Atomic UI components (Layout, Banners, Grids, Cards, Navigation)
* `styles/`: Variables, mixins, global typography, and reset sheets
* `api/`: Standardized CRUD helper services (`get`, `add`, `edit`, `view`, `update`, `delete`, `action`)
* `types/`: Strict TypeScript interface models for all entities
