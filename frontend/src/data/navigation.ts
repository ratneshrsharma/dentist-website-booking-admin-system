/**
 * Advanced Dental Clinic - Navigation Hierarchy & Menu Data
 * Modeled on USDental.in Clinical Structure with 4 Treatment Pillars
 */

export interface NavItem {
  label: string;
  href: string;
  description?: string;
  badge?: string;
  iconName?: string;
}

export interface NavCategory {
  category: string;
  description?: string;
  iconName?: string;
  items: NavItem[];
}

export interface NavDropdown {
  label: string;
  href?: string;
  categories?: NavCategory[];
  items?: NavItem[];
}

export const MAIN_NAVIGATION: NavDropdown[] = [
  {
    label: 'Home',
    href: '/',
  },
  {
    label: 'About Us',
    items: [
      {
        label: 'The Practice & Philosophy',
        href: '/about-us',
        description: 'American clinical standards, sterilization protocols & ethical patient care.',
      },
      {
        label: 'Our Specialist Team',
        href: '/our-team',
        description: 'Board-certified prosthodontists, orthodontists, endodontists & surgeons.',
      },
      {
        label: 'Technology & 3D Imaging',
        href: '/technology',
        description: 'Low-dose CBCT 3D X-rays, intraoral scanners, computer guided surgical navigation.',
      },
      {
        label: 'Why Choose Us & Accreditations',
        href: '/why-choose-us',
        description: 'Hospital-grade infection control, zero-pain anesthesia & verified patient outcomes.',
      },
    ],
  },
  {
    label: 'Treatments & Procedures',
    href: '/treatments',
    categories: [
      {
        category: 'Dental Implants & Surgery',
        iconName: 'Sparkles',
        description: 'Permanent tooth replacements & bone regeneration',
        items: [
          {
            label: 'Dental Implants Overview',
            href: '/treatments/dental-implants',
            description: 'Lifetime titanium & zirconia fixtures',
          },
          {
            label: 'Computer Guided Implant Surgery',
            href: '/treatments/computer-guided-implant-surgery',
            description: 'Sub-millimeter precision 3D surgical guides',
            badge: 'Advanced',
          },
          {
            label: 'All-on-4 / All-on-6 Systems',
            href: '/treatments/all-on-4-dental-implants',
            description: 'Full-arch fixed teeth in 24–48 hours',
            badge: 'Popular',
          },
          {
            label: 'Full Mouth Rehabilitation',
            href: '/treatments/full-mouth-rehabilitation',
            description: 'Complete restorative smile reconstruction',
          },
        ],
      },
      {
        category: 'Cosmetic Dentistry & Orthodontics',
        iconName: 'Smile',
        description: 'Aesthetic smile makeovers & aligners',
        items: [
          {
            label: 'Cosmetic Dentistry Overview',
            href: '/treatments/cosmetic-dentistry',
            description: 'Custom aesthetic design & smile rejuvenation',
          },
          {
            label: 'Clear Aligners (Invisible Braces)',
            href: '/treatments/clear-aligners',
            description: 'Discreet orthodontic teeth straightening',
            badge: 'No Metal',
          },
          {
            label: 'Porcelain Veneers & Lumineers',
            href: '/treatments/porcelain-veneers',
            description: 'Ultra-thin handcrafted ceramic veneers',
          },
          {
            label: 'Laser Teeth Whitening',
            href: '/treatments/teeth-whitening',
            description: 'Up to 8 shades brighter in a 45-min session',
          },
          {
            label: 'Aesthetic Bonding & Tooth Gems',
            href: '/treatments/aesthetic-bonding',
            description: 'Seamless chip repair & smile accents',
          },
        ],
      },
      {
        category: 'Gum Care & Periodontics',
        iconName: 'Shield',
        description: 'Advanced periodontal therapy & laser treatments',
        items: [
          {
            label: 'Periodontal Care Overview',
            href: '/treatments/gum-treatments',
            description: 'Early and advanced gum disease treatment',
          },
          {
            label: 'Deep Cleaning & Root Planing',
            href: '/treatments/deep-cleaning-scaling',
            description: 'Ultrasonic calculus removal & root smoothing',
          },
          {
            label: 'Laser Gum Therapy',
            href: '/treatments/laser-gum-treatment',
            description: 'Minimally-invasive bacterial eradication',
            badge: 'Painless',
          },
          {
            label: 'Periodontal Surgery & Grafts',
            href: '/treatments/gum-surgery',
            description: 'Recession repair & pocket reduction surgery',
          },
        ],
      },
      {
        category: 'General & Restorative Care',
        iconName: 'Activity',
        description: 'Everyday dentistry, pain relief & oral health',
        items: [
          {
            label: 'General Dentistry Overview',
            href: '/treatments/general-dentistry',
            description: 'Comprehensive examinations & cleanings',
          },
          {
            label: 'Painless Root Canal (RCT)',
            href: '/treatments/root-canal-treatment',
            description: 'Microscopic rotary endodontics in one visit',
            badge: 'Same Day',
          },
          {
            label: 'Wisdom Tooth Gentle Extraction',
            href: '/treatments/wisdom-tooth-extraction',
            description: 'Impacted third molar removal with sedation',
          },
          {
            label: 'Zirconia Crowns & Ceramic Bridges',
            href: '/treatments/crowns-and-bridges',
            description: 'Metal-free, natural-looking tooth restorations',
          },
          {
            label: 'Composite Fillings & Cavity Repair',
            href: '/treatments/dental-fillings',
            description: 'Durable, tooth-colored aesthetic resin',
          },
          {
            label: 'Custom Dentures & Overdentures',
            href: '/treatments/custom-dentures',
            description: 'Comfortable precision-fit removable dentures',
          },
        ],
      },
    ],
  },
  {
    label: 'Patient Resources',
    items: [
      {
        label: 'First Visit Guide & Triage',
        href: '/first-visit',
        description: 'What to expect on your initial consultation & check-in.',
      },
      {
        label: 'Plans & Insurance Coverage',
        href: '/plans-coverage',
        description: 'In-house membership savings & insurance reimbursement.',
      },
      {
        label: 'Smile Gallery & Case Studies',
        href: '/smile-gallery',
        description: 'Documented before-and-after smile transformations.',
      },
      {
        label: 'Patient FAQs & Dental Advice',
        href: '/patient-faq',
        description: 'Answers to common questions regarding treatment, pain & cost.',
      },
    ],
  },
  {
    label: 'Contact & Clinics',
    href: '/contact',
  },
];
