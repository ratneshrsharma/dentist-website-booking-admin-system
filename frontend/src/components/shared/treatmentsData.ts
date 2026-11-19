export interface TreatmentItem {
  id: number;
  slug: string;
  href: string;
  category: 'general' | 'hygiene' | 'restorative' | 'implants' | 'orthodontics' | 'cosmetic' | 'emergency';
  categoryGroup: 'general' | 'restorative' | 'cosmetic' | 'emergency';
  categoryLabel: string;
  title: string;
  badge: string;
  badgeClass?: string;
  icon: string;
  image: string;
  description: string;
  features: string[];
  nhsPricing: string;
  privatePricing: string;
  ctaText: string;
  ctaPhone?: boolean;
}

export const CLINICAL_9_TREATMENTS: TreatmentItem[] = [
  {
    id: 1,
    slug: 'general-dentistry',
    href: '/treatments/general-dentistry',
    category: 'general',
    categoryGroup: 'general',
    categoryLabel: 'General Dentistry',
    title: 'General Dentistry & Routine Check-ups',
    badge: 'NHS & Private Available',
    badgeClass: 'bg-primary text-on-primary',
    icon: 'dentistry',
    image: 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&q=80&w=800',
    description:
      'Thorough 14-point oral health checks, ultra-low-dose digital radiographs, periodontal BPE scores, and preventative tooth-coloured composite restorations.',
    features: [
      'Comprehensive 14-Point Oral Health Examination',
      'Low-Dose Digital Bitewing Radiographs',
      'High-Durability Tooth-Coloured Fillings',
      'BPE Periodontal Screening & Gum Score',
    ],
    nhsPricing: 'Band 1 (£26.80)',
    privatePricing: 'From £45.00',
    ctaText: 'View General Dentistry',
  },
  {
    id: 2,
    slug: 'hygiene-airflow',
    href: '/treatments/hygiene-airflow',
    category: 'hygiene',
    categoryGroup: 'general',
    categoryLabel: 'Hygiene & Prevention',
    title: 'Dental Hygiene & Airflow Therapy',
    badge: 'Direct Access Hygienist',
    badgeClass: 'bg-teal-700 text-white',
    icon: 'clean_hands',
    image: 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=800',
    description:
      'Specialist ultrasonic scaling, subgingival debridement, and high-precision Airflow polish therapy to remove stubborn coffee, tea, and tobacco stains.',
    features: [
      'Ultrasonic Plaque & Calculus Debridement',
      'Airflow High-Precision Polish & Stain Removal',
      'Gingivitis & Periodontal Maintenance Protocols',
      'Personalized Interdental Home Care Plans',
    ],
    nhsPricing: 'Band 2 (if clinical)',
    privatePricing: 'From £65.00',
    ctaText: 'Explore Hygiene Services',
  },
  {
    id: 3,
    slug: 'root-canal-treatment',
    href: '/treatments/root-canal-treatment',
    category: 'emergency',
    categoryGroup: 'emergency',
    categoryLabel: 'Emergency & Endodontics',
    title: 'Emergency Root Canal & Pain Relief',
    badge: 'Same-Day Slots Guaranteed',
    badgeClass: 'bg-status-error text-on-error',
    icon: 'medical_services',
    image: 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=800',
    description:
      'Immediate emergency triage for acute pulpitis, severe toothaches, dental trauma, and gentle single-visit rotary endodontic preservation.',
    features: [
      'Priority Same-Day Triage Mon–Fri on +44 121 765 2870',
      'Single-Visit Precision Rotary Endodontics',
      'Electronic Apex Location & Deep Canal Disinfection',
      'Immediate Pain Relief & Temporary Crown Dressing',
    ],
    nhsPricing: 'Band 2 (£73.50)',
    privatePricing: 'From £395.00',
    ctaText: 'Emergency & Root Canal',
    ctaPhone: true,
  },
  {
    id: 4,
    slug: 'dental-implants',
    href: '/treatments/dental-implants',
    category: 'implants',
    categoryGroup: 'restorative',
    categoryLabel: 'Implantology & Surgery',
    title: 'Dental Implants & Titanium Fixtures',
    badge: 'Lifelong Titanium Roots',
    badgeClass: 'bg-indigo-700 text-white',
    icon: 'vital_signs',
    image: 'https://images.unsplash.com/photo-1629909615184-74f495363b67?auto=format&fit=crop&q=80&w=800',
    description:
      'Permanent Swiss-grade titanium tooth root replacement, 3D CBCT guided keyhole surgery, and custom porcelain crowns matching your natural smile.',
    features: [
      '3D CBCT Volumetric Radiology & Nerve Mapping',
      'Sub-Millimeter Computer-Guided Keyhole Placement',
      'Osseointegrated Grade-5 Medical Titanium Fixtures',
      'Bespoke Handcrafted Ceramic Abutments & Crowns',
    ],
    nhsPricing: 'Private Only',
    privatePricing: 'From £1,995.00 (0% APR)',
    ctaText: 'View Implant Options',
  },
  {
    id: 5,
    slug: 'crowns-and-bridges',
    href: '/treatments/crowns-and-bridges',
    category: 'restorative',
    categoryGroup: 'restorative',
    categoryLabel: 'Restorative Care',
    title: 'Crowns & Bridgework Restorations',
    badge: 'High-Durability Zirconia',
    badgeClass: 'bg-secondary text-on-secondary',
    icon: 'architecture',
    image: 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&q=80&w=800',
    description:
      'Rebuilding broken, weakened, or missing teeth with biocompatible, natural-looking porcelain, lithium disilicate (E-Max), and monolithic zirconia prosthetics.',
    features: [
      'Monolithic Zirconia & E-Max Ceramic Formulations',
      'Precision 3D Digital Scans (No Messy Trays)',
      'Multi-Unit Fixed Bridges for Gap Replacement',
      'Occlusal Bite Realignment & Wear Rehabilitation',
    ],
    nhsPricing: 'Band 3 (£319.10)',
    privatePricing: 'From £495.00',
    ctaText: 'Explore Restorations',
  },
  {
    id: 6,
    slug: 'all-on-4-dental-implants',
    href: '/treatments/all-on-4-dental-implants',
    category: 'implants',
    categoryGroup: 'restorative',
    categoryLabel: 'Full Arch Rehabilitation',
    title: 'All-on-4 / Full Arch Implants',
    badge: 'Teeth in a Day Full Arch',
    badgeClass: 'bg-amber-700 text-white',
    icon: 'military_tech',
    image: 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&q=80&w=800',
    description:
      'Transform entirely missing or failing dentition into a fixed, permanent arch of teeth in a single clinical appointment using 4 strategically angled implants.',
    features: [
      'Fixed Provisional Teeth Fitted on Surgery Day',
      'Eliminates Removable Dentures & Palate Coverage',
      'Angled Posterior Implants to Avoid Sinus Grafting',
      '10-Year Structural Implant Integrity Guarantee',
    ],
    nhsPricing: 'Private Only',
    privatePricing: 'From £7,995.00 (0% APR)',
    ctaText: 'All-on-4 Full Arch Guide',
  },
  {
    id: 7,
    slug: 'clear-aligners',
    href: '/treatments/clear-aligners',
    category: 'orthodontics',
    categoryGroup: 'cosmetic',
    categoryLabel: 'Aesthetic Orthodontics',
    title: 'Clear Aligners & Invisalign®',
    badge: 'Invisalign® Smile Simulation',
    badgeClass: 'bg-primary-container text-on-primary',
    icon: 'auto_awesome',
    image: 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&q=80&w=800',
    description:
      'Discreet, removable clear aligners engineered to straighten crooked, crowded, or spaced teeth predictably without metal brackets or wires.',
    features: [
      'Custom 3D ClinCheck Virtual Outcome Simulation',
      'Transparent, Removable & Lifestyle-Friendly',
      'Average Treatment Time 6–12 Months',
      'Complimentary Teeth Whitening with Full Treatment',
    ],
    nhsPricing: 'Private Only',
    privatePricing: 'From £1,495.00 (0% APR)',
    ctaText: 'Explore Clear Aligners',
  },
  {
    id: 8,
    slug: 'teeth-whitening',
    href: '/treatments/teeth-whitening',
    category: 'cosmetic',
    categoryGroup: 'cosmetic',
    categoryLabel: 'Cosmetic Dentistry',
    title: 'Professional Teeth Whitening',
    badge: 'Boutique & Enlighten Gold',
    badgeClass: 'bg-emerald-700 text-white',
    icon: 'stars',
    image: 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&q=80&w=800',
    description:
      'Brighten your smile safely up to 16 shades lighter with UK-certified, dentist-supervised Boutique and Enlighten B1 guaranteed whitening systems.',
    features: [
      'Custom-Moulded Precision Whitening Trays',
      'Desensitizing Potassium Nitrate Formulations',
      'Guaranteed B1 Shade Result with Enlighten System',
      'Long-Lasting Brightness with Home Top-Up Syringes',
    ],
    nhsPricing: 'Private Only',
    privatePricing: 'From £299.00',
    ctaText: 'Teeth Whitening Guide',
  },
  {
    id: 9,
    slug: 'porcelain-veneers',
    href: '/treatments/porcelain-veneers',
    category: 'cosmetic',
    categoryGroup: 'cosmetic',
    categoryLabel: 'Cosmetic Dentistry',
    title: 'Porcelain Veneers & Composite Bonding',
    badge: 'Smile Makeover Artistry',
    badgeClass: 'bg-rose-700 text-white',
    icon: 'brush',
    image: 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&q=80&w=800',
    description:
      'Correct chipped, uneven, discoloured, or gapped teeth with handcrafted ultra-thin porcelain veneers or single-visit minimally invasive composite bonding.',
    features: [
      'Ultra-Thin 0.3mm Hand-Layered Feldspathic Ceramic',
      'Same-Day Composite Edge Bonding with Zero Drilling',
      'Natural Translucency & High Stain Resistance',
      'Digital Smile Design Aesthetic Previews',
    ],
    nhsPricing: 'Private Only',
    privatePricing: 'From £150.00 / tooth',
    ctaText: 'Veneers & Bonding Details',
  },
];
