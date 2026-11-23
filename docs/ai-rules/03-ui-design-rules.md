# AI Instruction Rule 03: UI Design Rules & LESS Architecture

## Purpose
Guarantees pixel-perfect fidelity to the provided `/html` reference designs, modular LESS styling, and atomic component reusability.

---

### 1. Design Fidelity & Visual Principles
* **Source of Truth:** The HTML templates in `/html` (and `ref/HTML Pages/`) and design tokens in `DESIGN.md` are the strict visual blueprints.
* **Aesthetic Standard:** Corporate Clinical Modern with Tactile Refinement:
  - Clover Green / Medical Teal primary palette with clean white cards and reassuring organic tinting.
  - Generous whitespace, rounded container geometry (`border-radius: 0.75rem` - `1rem`), and subtle drop shadows (`shadow-sm`, `shadow-md`).
  - Clear clinical typography: **Plus Jakarta Sans** for headlines & display; **Work Sans** for legible body copy.
* **Responsive Breakpoints:**
  - Mobile (<640px)
  - Tablet (640px - 1024px)
  - Desktop (>1024px)
  - Large Desktop (>1280px)

---

### 2. LESS Architecture & Component Modularity
1. **LESS Variables & Design Tokens:**
   - Define all color variables, typography scales, container max-widths, and spacing tokens in `src/styles/variables.less`.
   - Provide mixins for buttons, card containers, badge tags, and flex layouts in `src/styles/mixins.less`.
2. **Component-Scoped LESS Modules:**
   - Use CSS Modules (`[Component].module.less`) to prevent global namespace collisions.
   - Example:
     ```less
     @import '@/styles/variables.less';
     @import '@/styles/mixins.less';

     .heroBanner {
       background-color: @surface-container-low;
       padding: @space-xl 0;
       position: relative;
       overflow: hidden;
       
       .headline {
         font-family: @font-display;
         font-size: @font-size-display-hero;
         color: @on-surface;
       }
     }
     ```
3. **Atomic Reusability:**
   - Every UI block must be self-contained and independently renderable:
     * **Atoms:** `Button`, `Badge`, `Icon`, `Input`, `RatingStars`.
     * **Molecules:** `DoctorCard`, `ServiceCard`, `TestimonialCard`, `ContactStrip`, `EmergencyCallout`.
     * **Organisms:** `Header`, `HeroBanner`, `ServicesGrid`, `BookingDrawer`, `Footer`.
     * **Templates & Pages:** `HomePage`, `AboutPage`, `TreatmentsPage`, `BlogPage`, `ContactPage`.
