/**
 * Acocks Green Dental Practice - Navigation Hierarchy & Menu Data
 * Cleaned to canonical routes: Home (/), About (/about-us), Treatments (/treatments), Contact (/contact)
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
    label: 'About Our Surgery',
    items: [
      {
        label: 'The Practice & Philosophy',
        href: '/about-us',
        description: 'B27 6BH NHS & Private Surgery standards, infection control & ethical patient care.',
      },
      {
        label: 'Meet Our Clinicians',
        href: '/#team',
        description: 'GDC-registered dentists, dental nurses & specialist dental hygienists.',
      },
      {
        label: 'Our Facilities & Surgery',
        href: '/#about',
        description: 'Low-dose digital radiography, modern treatment suites on Warwick Road.',
      },
      {
        label: 'NHS Sexual Safety Charter',
        href: '/#charter',
        description: 'Official signatory committed to patient dignity and zero harassment.',
      },
    ],
  },
  {
    label: 'Treatments & Services',
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
            description: 'Lifetime Swiss-grade titanium & zirconia fixtures',
          },
          {
            label: 'Computer Guided Implant Surgery',
            href: '/treatments/computer-guided-implant-surgery',
            description: 'Sub-millimeter precision 3D surgical guides',
            badge: 'Keyhole',
          },
          {
            label: 'All-on-4 / Same-Day Teeth',
            href: '/treatments/all-on-4-dental-implants',
            description: 'Full-arch fixed teeth in 24 hours',
            badge: 'Popular',
          },
        ],
      },
      {
        category: 'Aesthetic Dentistry & Orthodontics',
        iconName: 'Smile',
        description: 'Aesthetic smile makeovers & aligners',
        items: [
          {
            label: 'Cosmetic Dentistry Overview',
            href: '/treatments/cosmetic-dentistry',
            description: 'Custom aesthetic design & smile rejuvenation',
          },
          {
            label: 'Clear Aligners (Invisalign®)',
            href: '/treatments/clear-aligners',
            description: 'Discreet orthodontic teeth straightening',
            badge: 'No Brackets',
          },
          {
            label: 'Porcelain Veneers',
            href: '/treatments/porcelain-veneers',
            description: 'Ultra-thin handcrafted ceramic veneers',
          },
          {
            label: 'Boutique Teeth Whitening',
            href: '/treatments/teeth-whitening',
            description: 'Up to 8 shades brighter in clinic or at home',
          },
        ],
      },
      {
        category: 'General, Restorative & Emergency',
        iconName: 'Activity',
        description: 'Everyday NHS care, pain relief & restorations',
        items: [
          {
            label: 'General Dentistry & Exams',
            href: '/treatments/general-dentistry',
            description: '14-point oral exams & preventative treatments',
          },
          {
            label: 'Dental Hygiene & Airflow',
            href: '/treatments/general-dentistry#hygiene',
            description: 'Ultrasonic scaling & airflow stain removal',
          },
          {
            label: 'Zirconia Crowns & Ceramic Bridges',
            href: '/treatments/crowns-and-bridges',
            description: 'Monolithic zirconia & E-Max restorations',
          },
          {
            label: 'Painless Root Canal (RCT)',
            href: '/treatments/root-canal-treatment',
            description: 'Rotary endodontics for acute pain relief',
            badge: 'Same Day',
          },
        ],
      },
    ],
  },
  {
    label: 'Patient Resources',
    items: [
      {
        label: 'NHS Fee Bandings & Private Pricing',
        href: '/treatments#pricing',
        description: 'Transparent Band 1, 2, 3 statutory fees and private options.',
      },
      {
        label: 'Verified Patient Reviews',
        href: '/#reviews',
        description: '4.9★ patient satisfaction ratings on Google & NHS Choices.',
      },
      {
        label: 'Surgery Location & Parking',
        href: '/contact',
        description: '1078 Warwick Road, Acocks Green, Birmingham B27 6BH.',
      },
    ],
  },
  {
    label: 'Contact & Location',
    href: '/contact',
  },
];
