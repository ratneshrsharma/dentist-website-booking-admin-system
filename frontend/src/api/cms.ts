import { apiClient } from './client';
import { ThemeSettings, HomePageData, ServiceItem, ClinicianItem, GlobalNavigation } from '@/types/cms';
import { assetUrl } from '@/utils/asset';

// Default static fallback from ref/JSONs/home.json & global-theme.json
export const DEFAULT_THEME: ThemeSettings = {
  theme_name: 'acocks-green',
  display_name: 'Acocks Green Dental Practice',
  colors: {
    primary: '#0d631b',
    primary_hover: '#0a4f15',
    secondary: '#45664e',
    surface: '#f2fcf5',
    surface_muted: '#ecf6ef',
    text_primary: '#151d1a',
    text_secondary: '#40493d',
    nhs_blue: '#005eb8',
    status_error: '#ba1a1a',
    brand_accent_glow: '#E8F5E9',
  },
  branding: {
    clinic_name: 'Acocks Green',
    tagline: 'Dental Practice',
    logo_url: assetUrl('/images/acocks-green-logo.png'),
    phone: '+44 121 765 2870',
    whatsapp: '+441217652870',
    emergency_phone: '+44 121 765 2870',
    address: '1078 Warwick Road, Acocks Green, Birmingham B27 6BH',
    cqc_status: 'CQC Regulated Standards',
    nhs_registered: true,
  },
};

export const DEFAULT_NAVIGATION: GlobalNavigation = {
  header_menu: [
    { title: 'Home', path: '/' },
    {
      title: 'Treatments & Services',
      path: '/#services',
      children: [
        { title: 'Routine Dental Examinations', path: '/treatments/routine-examinations', icon: 'dentistry' },
        { title: 'Dental Hygiene & Airflow Polish', path: '/treatments/dental-hygiene-airflow', icon: 'clean_hands' },
        { title: 'White Tooth Fillings (Composite)', path: '/treatments/composite-white-fillings', icon: 'healing' },
        { title: 'Root Canal Therapy (Endodontics)', path: '/treatments/root-canal-therapy', icon: 'vital_signs' },
        { title: 'Dental Crowns & Fixed Bridges', path: '/treatments/crowns-and-bridges', icon: 'crown' },
        { title: 'Invisalign® Clear Aligners', path: '/treatments/invisalign-clear-aligners', icon: 'auto_fix_high' },
        { title: 'Emergency Tooth Extraction', path: '/treatments/tooth-extractions', icon: 'medical_services' },
        { title: 'Same-Day Emergency Relief', path: '/treatments/emergency-relief', icon: 'e911_emergency' },
      ],
    },
    { title: 'Blog', path: '/blog' },
    {
      title: 'About',
      path: '/#about',
      children: [
        { title: 'Why Us', path: '/#about' },
        { title: 'Our Team', path: '/#team' },
        { title: 'Our Clinics', path: '/#contact' },
        { title: 'NHS Safety Charter', path: '/#charter' },
        { title: 'Patient Reviews', path: '/#reviews' },
      ],
    },
    { title: 'Contact', path: '/#contact' },
  ],
  quick_links: [
    { title: 'Routine Dental Examinations', path: '/treatments/routine-examinations' },
    { title: 'Dental Hygiene & Airflow Polish', path: '/treatments/dental-hygiene-airflow' },
    { title: 'White Tooth Fillings (Composite)', path: '/treatments/composite-white-fillings' },
    { title: 'Root Canal Therapy (Endodontics)', path: '/treatments/root-canal-therapy' },
    { title: 'Dental Crowns & Fixed Bridges', path: '/treatments/crowns-and-bridges' },
    { title: 'Invisalign® Clear Aligners', path: '/treatments/invisalign-clear-aligners' },
    { title: 'Emergency Tooth Extraction', path: '/treatments/tooth-extractions' },
    { title: 'Same-Day Emergency Relief', path: '/treatments/emergency-relief' },
  ],
  services_links: [
    { title: 'General Dentistry', path: '/treatments/general-dentistry' },
    { title: 'Hygiene & Cleanings', path: '/treatments/hygiene' },
    { title: 'Invisalign Aligners', path: '/treatments/aesthetic-aligners' },
    { title: 'Emergency Appointments', path: '/contact' },
  ],
  legal_links: [
    { title: 'Privacy Policy', path: '/privacy' },
    { title: 'Cookie Policy', path: '/cookies' },
    { title: 'Accessibility Statement', path: '/accessibility' },
  ],
};

export const DEFAULT_HOME_PAGE: HomePageData = {
  slug: 'home',
  title: 'Home',
  eyebrow: 'NHS & Private Patients Welcomed',
  headline: 'Make your Dental Experience a Lot Brighter',
  subtitle:
    'Welcome to Acocks Green Dental Practice. Delivering gentle, high-standard dental care for patients of all ages across Birmingham B27. From preventive family appointments to transformative aesthetics, our clinical team puts your comfort first.',
  hero: {
    eyebrow: 'NHS & Private Patients Welcomed',
    headline: 'Make your Dental Experience a',
    headline_highlight: 'Lot Brighter',
    title: 'Make your Dental Experience a',
    highlight_word: 'Lot Brighter',
    subtitle:
      'Welcome to Acocks Green Dental Practice. Delivering gentle, high-standard dental care for patients of all ages across Birmingham B27. From preventive family appointments to transformative aesthetics, our clinical team puts your comfort first.',
    cta_primary: 'Book An Appointment',
    cta_primary_link: '#quick-book',
    cta_secondary: 'Emergency Consultation',
    cta_secondary_link: '/contact/#emergency',
    phone: '+44 121 765 2870',
    emergency_label: 'Emergency Triage Line',
    stats: [
      { label: 'Happy Patients', value: '5,000+', is_active: true },
      { label: 'Dentists & Staff', value: '7+', is_active: true },
      { label: 'Years of Trust', value: '20+', is_active: true },
    ],
    hero_image: assetUrl('/images/hero-patient.jpg'),
    hero_badges: [
      { title: 'CQC Regulated Standards', subtitle: 'Fully compliant', icon: 'verified' },
      { title: 'Same-Day Emergency Slots', subtitle: 'Fast pain relief', icon: 'e911_emergency' },
    ],
  },
  services_intro: {
    eyebrow: 'Our Practice Services',
    title: 'Discover Quality Dental Care in Acocks Green',
    subtitle:
      'Personalized clinical dental solutions delivered in modern surgeries with low radiation digital radiography and compassionate pacing.',
  },
  featured_services: [
    {
      id: 1,
      slug: 'general-dentistry',
      title: 'General Dentistry',
      category: 'Preventive',
      badge_tags: ['Preventive', 'NHS / Private'],
      description:
        'Routine dental health examinations, digital diagnostics, high-durability composite white fillings, gentle root canals, and ongoing prevention.',
      icon: 'dentistry',
    },
    {
      id: 2,
      slug: 'hygiene-periodontics',
      title: 'Hygiene & Periodontics',
      category: 'Gum Care',
      badge_tags: ['Gum Care', 'Airflow Polish'],
      description:
        'Deep ultrasonic plaque scaling, stubborn nicotine and coffee stain removal, and periodontal disease therapy led by our dedicated hygienist Claire.',
      icon: 'clean_hands',
    },
    {
      id: 3,
      slug: 'restorative-dentistry',
      title: 'Restorative Dentistry',
      category: 'Restorative',
      badge_tags: ['Restorative', 'Crowns & Bridges'],
      description:
        'Rebuild chewing function and oral harmony with customized ceramic crowns, bridges, durable inlays, and prosthetics designed for longevity.',
      icon: 'vital_signs',
    },
    {
      id: 4,
      slug: 'aesthetic-aligners',
      title: 'Aesthetic & Aligners',
      category: 'Cosmetic',
      badge_tags: ['Cosmetic', 'Invisalign®'],
      description:
        'Transform your smile with professional boutique teeth whitening, handcrafted porcelain veneers, and Invisalign® discreet clear aligner therapy.',
      icon: 'auto_fix_high',
    },
  ],
  about_summary: {
    eyebrow: 'About Our Surgery',
    title: 'We Care For Your Dental Health & Well-being',
    paragraph:
      'Acocks Green Dental Practice is a family-oriented practice dedicated to providing exceptional dental treatments for patients of all ages across Birmingham. Our mission is to promote and maintain optimal dental health, ensuring beautiful and confident smiles that endure for a lifetime.',
    pillars: [
      {
        id: 'nervous_patients',
        icon: 'sentiment_satisfied',
        title: 'Welcoming Nervous & Phobic Patients',
        description:
          'We take extra time to explain every step, provide calm unhurried appointments, and employ gentle numbing techniques for absolute peace of mind.',
      },
      {
        id: 'nhs_flexibility',
        icon: 'health_and_safety',
        title: 'NHS & Private Flexibility',
        description:
          'Transparent treatment costings with no hidden fees. From essential NHS safety-net dentistry to premium private aesthetic aligners.',
      },
    ],
    director_note: {
      name: 'Tarlok Marok',
      title: 'Practice Owner & Lead Director',
      initials: 'TM',
    },
  },
  clinicians: [
    {
      id: 1,
      name: 'Dr. Atandrilla Das',
      title: 'BDS Associate Dental Surgeon',
      badge: 'Associate Dentist',
      avatar: assetUrl('/images/doctor-das.jpg'),
      bio: 'Special interest in comprehensive restorative therapy, minimal-prep restorations, and pediatric patient care.',
    },
    {
      id: 2,
      name: 'Dr. Harjeevan Rai',
      title: 'BDS Dental Surgeon',
      badge: 'Associate Dentist',
      avatar: assetUrl('/images/doctor-rai.jpg'),
      bio: 'Focused on preventive oral health, biomechanical restorations, and gentle pain relief treatments.',
    },
    {
      id: 3,
      name: 'Dr. Nadeem Sohail',
      title: 'BDS Dental Surgeon',
      badge: 'Associate Dentist',
      avatar: assetUrl('/images/doctor-sohail.jpg'),
      bio: 'Experienced in complex endodontics, emergency extractions, and crown & bridge oral rehabilitation.',
    },
    {
      id: 4,
      name: 'Claire',
      title: 'Dental Hygienist',
      badge: 'Dental Hygienist',
      avatar: assetUrl('/images/hygienist-claire.jpg'),
      bio: 'Leading our hygiene suite with deep periodontal therapy, patient brushing coaching, and airflow stain polishing.',
    },
  ],
  support_team: [
    { name: 'Hannah', role: 'Foundation Dentist' },
    { name: 'Niamh', role: 'Foundation Dentist' },
    { name: 'Mulaykah Abdurrahman', role: 'Nurse Apprentice' },
    { name: 'Gabriela Popescu', role: 'Nurse' },
    { name: 'Hamza Ahmad', role: 'Nurse' },
    { name: 'Rukhsana Choudhary', role: 'Nurse' },
    { name: 'Richard Gill', role: 'Nurse' },
    { name: 'Jessica William', role: 'Nurse' },
    { name: 'Jade Walker', role: 'Receptionist' },
  ],
  practice_manager: {
    name: 'Rebecca Solly',
    title: 'Practice Manager',
  },
  reviews: {
    average_rating: '4.9',
    total_rating_text: '4.9 / 5.0 Rating',
    items: [
      {
        id: 1,
        patient_name: 'Vikram Kline',
        patient_type: 'Verified Patient',
        rating: 5,
        review_text:
          '“The best dental care I have ever experienced! Professional, courteous, and friendly staff made me feel like family... would highly recommend to anyone!”',
        initials: 'VK',
        verified: true,
      },
      {
        id: 2,
        patient_name: 'Emelia Hewitt',
        patient_type: 'Family Dental Patient',
        rating: 5,
        review_text:
          '“Always have a great, smooth experience here. The staff and dental nurses are friendly, respectful, caring and courteous of your time. The office is run efficiently.”',
        initials: 'EH',
        verified: true,
      },
      {
        id: 3,
        patient_name: 'Joe Bloggs',
        patient_type: 'Restorative Care Patient',
        rating: 5,
        review_text:
          '“The professionalism and friendliness of the whole team is outstanding. Every visit is like visiting friends. I couldn’t be happier with the results.”',
        initials: 'JB',
        verified: true,
      },
    ],
  },
  safety_charter: {
    title: 'NHS Sexual Safety Charter & Patient Protection',
    description:
      'Acocks Green Dental Practice is strictly committed to providing a safe, respectful environment where every patient, visitor, and staff member feels completely protected and valued. We maintain a zero-tolerance policy towards harassment or inappropriate conduct.',
    contact_person: 'Rebecca Solly (Practice Manager)',
    download_url: 'https://www.acocksgreendentalpractice.co.uk/wp-content/uploads/2026/04/SEXUAL-SAFETY-CHARTER.pdf',
  },
  contact_section: {
    eyebrow: 'Visit Our Surgery',
    title: 'Conveniently Located in Acocks Green',
    subtitle:
      'Situated on Warwick Road with ample nearby roadside parking and direct public transit bus links right at our doorstep.',
    address: '1078 Warwick Road, Acocks Green, Birmingham, B27 6BH',
    phone: '+44 121 765 2870',
    email: 'acocksgreendentalpractice@gmail.com',
    hours: [
      { day_range: 'Monday – Thursday', hours: '8:30 AM – 5:30 PM' },
      { day_range: 'Friday', hours: '8:30 AM – 5:00 PM' },
      { day_range: 'Saturday – Sunday', hours: 'Emergency Triage On-Call' },
    ],
    map_image: assetUrl('/images/surgery-clinic.jpg'),
  },
  sections: [
    {
      id: 'sec_services',
      type: 'services_block',
      category: 'prebuilt',
      name: 'Services Section',
      eyebrow: 'Our Practice Services',
      title: 'Discover Quality Dental Care in Acocks Green',
      summary:
        'Personalized clinical dental solutions delivered in modern surgeries with low radiation digital radiography and compassionate pacing.',
      layout: 'thumbnail',
      column_layout: 'full_width',
      cta_text: 'View All Treatments',
      cta_link: '/treatments',
      is_active: true,
      order: 1,
    },
    {
      id: 'sec_about',
      type: 'page_snippet',
      category: 'page_snippet',
      name: 'About Our Surgery',
      page_slug: 'about-us',
      eyebrow: 'About Acocks Green Practice',
      title: 'Dedicated Dental Professionals Serving Birmingham B27',
      summary:
        'Our clinic was established with a clear mission: provide accessible, respectful, and clinically excellent dentistry.',
      description:
        'At Acocks Green Dental Practice, we believe that visiting the dentist should be a calm, reassuring experience. Our clinic has been trusted by families across South Birmingham for over two decades. From routine checkups to advanced cosmetic aligners, our clinicians pace treatments to your comfort.',
      feature_image: assetUrl('/images/surgery-clinic.jpg'),
      image_position: 'left',
      column_layout: 'two_col_split',
      cta_text: 'Discover Our Surgery Story',
      cta_link: '/about-us',
      is_active: true,
      order: 2,
    },
    {
      id: 'sec_team',
      type: 'team_block',
      category: 'prebuilt',
      name: 'Doctors & Dental Surgeons',
      eyebrow: 'Clinical Team',
      title: 'Dedicated Clinicians & Dental Surgeons',
      summary:
        'Compassionate care delivered by fully registered dental professionals with decades of combined clinical expertise.',
      layout: 'thumbnail',
      column_layout: 'full_width',
      cta_text: 'Meet Full Surgery Team',
      cta_link: '/about-us#team',
      is_active: true,
      order: 3,
    },
    {
      id: 'sec_testimonials',
      type: 'testimonials_block',
      category: 'prebuilt',
      name: 'Patient Testimonials Slider',
      eyebrow: 'Patient Feedback',
      title: 'What Our Patients Say About Us',
      summary: 'Real stories from patients treated at our Acocks Green Birmingham surgery.',
      layout: 'thumbnail',
      column_layout: 'full_width',
      cta_text: 'Leave a Google Review',
      cta_link: 'https://g.page/review',
      is_active: true,
      order: 4,
    },
    {
      id: 'sec_charter',
      type: 'custom_content',
      category: 'custom_content',
      name: 'NHS Sexual Safety Charter',
      eyebrow: 'Official NHS Charter',
      title: 'NHS Sexual Safety Charter Signatory',
      summary:
        'Acocks Green Dental Practice is an official signatory of the NHS Sexual Safety Charter, championing zero tolerance for harassment and fostering a safe, respectful clinical environment.',
      description: 'We are dedicated to safeguarding all staff, patients, and visitors within our clinical facilities.',
      column_layout: 'action_bar',
      cta_text: 'Read Our Safety Standards',
      cta_link: 'https://www.england.nhs.uk/publication/sexual-safety-in-healthcare-charter/',
      is_active: true,
      order: 5,
    },
    {
      id: 'sec_contact',
      type: 'contact_block',
      category: 'prebuilt',
      name: 'Hours & Surgery Location Map',
      eyebrow: 'Practice Location',
      title: 'Visit Our Modern Surgery in Birmingham B27',
      summary: 'Find surgery opening hours, parking information, and telephone reception.',
      layout: 'thumbnail',
      column_layout: 'full_width',
      cta_text: 'Call Reception',
      cta_link: 'tel:+441217652870',
      is_active: true,
      order: 6,
    },
  ],
};

/**
 * Service to fetch CMS data dynamically from Laravel REST API (/api/v1/...)
 * with automatic fallback to verified clinical schemas if the API is offline.
 */
export const CmsService = {
  /**
   * Fetches global theme, brand colors, clinic contacts, and script tags
   */
  getTheme: async (): Promise<ThemeSettings> => {
    try {
      const response = await apiClient.get<ThemeSettings>('/theme');
      if (response && response.success && response.data) {
        return response.data;
      }
    } catch {
      // Backend temporarily offline; use fallback
    }
    return DEFAULT_THEME;
  },

  /**
   * Fetches full dynamic HomePage content payload
   */
  getHomePage: async (): Promise<HomePageData> => {
    try {
      const response = await apiClient.get<HomePageData>('/pages/home');
      if (response && response.success && response.data) {
        return response.data;
      }
    } catch {
      // Backend temporarily offline; use fallback
    }
    return DEFAULT_HOME_PAGE;
  },

  /**
   * Fetches global header and footer navigation menus
   */
  getNavigation: async (): Promise<GlobalNavigation> => {
    try {
      const response = await apiClient.get<GlobalNavigation>('/navigation');
      if (response && response.success && response.data) {
        return response.data;
      }
    } catch {
      // Backend temporarily offline; use fallback
    }
    return DEFAULT_NAVIGATION;
  },

  /**
   * Fetches services list
   */
  getServices: async (): Promise<ServiceItem[]> => {
    try {
      const response = await apiClient.get<ServiceItem[]>('/services');
      if (response && response.success && response.data) {
        return response.data;
      }
    } catch {
      // Backend temporarily offline; use fallback
    }
    return DEFAULT_HOME_PAGE.featured_services;
  },

  /**
   * Fetches clinicians list
   */
  getDoctors: async (): Promise<ClinicianItem[]> => {
    try {
      const response = await apiClient.get<ClinicianItem[]>('/doctors');
      if (response && response.success && response.data) {
        return response.data;
      }
    } catch {
      // Backend temporarily offline; use fallback
    }
    return DEFAULT_HOME_PAGE.clinicians;
  },
};
