// =============================================================================
// CMS Entity Types (Dynamic Data Models - Zero Hardcoded Content)
// =============================================================================

export interface ThemeColors {
  primary: string;
  primary_hover: string;
  secondary: string;
  surface: string;
  surface_muted: string;
  text_primary: string;
  text_secondary: string;
  nhs_blue: string;
  status_error?: string;
  brand_accent_glow?: string;
}

export interface ClinicBranding {
  clinic_name: string;
  tagline: string;
  logo_url: string;
  phone: string;
  whatsapp: string;
  emergency_phone: string;
  emergency_label?: string;
  address: string;
  cqc_status?: string;
  nhs_registered?: boolean;
}

export interface ThemeSettings {
  theme_name: string;
  display_name: string;
  colors: ThemeColors;
  branding: ClinicBranding;
  custom_head_scripts?: string;
  custom_body_scripts?: string;
}

export interface StatItem {
  label: string;
  value: string;
  is_active?: boolean;
}

export interface ClinicalPillar {
  id: string;
  icon: string;
  title: string;
  description: string;
}

export interface ClinicianItem {
  id: number;
  name: string;
  title: string;
  credentials?: string;
  badge?: string;
  avatar: string;
  specialty?: string;
  bio?: string;
}

export interface ServiceItem {
  id: number;
  slug: string;
  title: string;
  category: string;
  badge?: string;
  badge_tags?: string[];
  summary?: string;
  description: string;
  content?: string;
  icon: string;
  feature_image?: string;
  starting_price?: string;
  duration?: string;
  cdt_code?: string;
  display_order?: number;
  is_active?: boolean;
}

export type SectionType =
  | 'services_block'
  | 'team_block'
  | 'testimonials_block'
  | 'charter_block'
  | 'contact_block'
  | 'page_snippet'
  | 'custom_content'
  | 'blog_block';

export interface PageSection {
  id: string;
  type: SectionType;
  category: 'prebuilt' | 'page_snippet' | 'custom_content';
  name?: string;
  page_slug?: string;
  eyebrow?: string;
  title: string;
  summary?: string;
  description?: string;
  layout?: 'thumbnail' | 'sidebar_list';
  feature_image?: string;
  image_position?: 'left' | 'right';
  column_layout?: 'action_bar' | 'two_col_split' | 'full_width';
  cta_text?: string;
  cta_link?: string;
  bg_type?: 'default' | 'solid' | 'gradient' | 'image' | 'image_overlay';
  bg_color?: string;
  bg_gradient_start?: string;
  bg_gradient_end?: string;
  bg_gradient_angle?: string;
  bg_image?: string;
  bg_overlay_color?: string;
  bg_overlay_opacity?: number;
  text_contrast?: 'auto' | 'dark' | 'light';
  padding_y?: 'compact' | 'normal' | 'generous';
  is_active?: boolean;
  order?: number;
}

export interface PatientReview {
  id: number;
  patient_name: string;
  patient_type: string;
  rating: number;
  review_text: string;
  initials?: string;
  verified?: boolean;
}

export interface ReviewsData {
  average_rating: string;
  total_rating_text: string;
  items: PatientReview[];
}

export interface OperatingHours {
  day_range: string;
  hours: string;
}

export interface HomePageData {
  slug: string;
  title: string;
  eyebrow: string;
  headline: string;
  subtitle: string;
  hero: {
    eyebrow?: string;
    headline?: string;
    title?: string;
    headline_highlight?: string;
    highlight_word?: string;
    subtitle?: string;
    cta_primary?: string;
    cta_primary_link?: string;
    cta_secondary?: string;
    cta_secondary_link?: string;
    phone?: string;
    emergency_label?: string;
    stats?: StatItem[];
    hero_image?: string;
    hero_badges?: Array<{ title: string; subtitle: string; icon: string }>;
  };
  services_intro: {
    eyebrow: string;
    title: string;
    subtitle: string;
  };
  featured_services: ServiceItem[];
  about_summary: {
    eyebrow: string;
    title: string;
    paragraph: string;
    pillars: ClinicalPillar[];
    director_note?: {
      name: string;
      title: string;
      initials: string;
    };
  };
  clinicians: ClinicianItem[];
  support_team: Array<{ name: string; role: string }>;
  practice_manager: { name: string; title: string };
  reviews: {
    average_rating: string;
    total_rating_text: string;
    items: PatientReview[];
  };
  safety_charter: {
    title: string;
    description: string;
    contact_person: string;
    download_url: string;
  };
  contact_section: {
    eyebrow: string;
    title: string;
    subtitle: string;
    address: string;
    phone: string;
    email: string;
    hours: OperatingHours[];
    map_url?: string;
    map_image?: string;
  };
  sections?: PageSection[];
}

export interface NavigationMenuItem {
  title: string;
  path: string;
  icon?: string;
  children?: Array<{
    title: string;
    path: string;
    icon?: string;
    description?: string;
  }>;
}

export interface GlobalNavigation {
  header_menu: NavigationMenuItem[];
  quick_links: Array<{ title: string; path: string }>;
  services_links: Array<{ title: string; path: string }>;
  legal_links: Array<{ title: string; path: string }>;
}

export interface AboutPillar {
  icon: string;
  title: string;
  desc: string;
  badge: string;
}

export interface AboutClinicFeature {
  icon: string;
  title: string;
  desc: string;
}

export interface AboutCharterCard {
  icon: string;
  title: string;
  desc: string;
  footer_label?: string;
}

export interface AboutPageData {
  slug: string;
  title: string;
  hero: {
    eyebrow: string;
    headline: string;
    subtitle: string;
    image: string;
    image_caption?: string;
    cta_primary?: string;
    cta_primary_link?: string;
    cta_secondary?: string;
    cta_secondary_link?: string;
    trust_badges?: Array<string | { icon: string; label: string }>;
  };
  why_us: {
    eyebrow: string;
    headline: string;
    subtitle: string;
    pillars: AboutPillar[];
    stats: Array<{ value: string; label: string; desc?: string }>;
  };
  clinics: {
    eyebrow: string;
    headline: string;
    subtitle: string;
    features: AboutClinicFeature[];
    surgery_image: string;
    surgery_title: string;
    surgery_desc: string;
    surgery_badge?: string;
  };
  safety_charter: {
    eyebrow: string;
    headline: string;
    subtitle: string;
    cards: AboutCharterCard[];
    emergency_box: {
      title: string;
      subtitle: string;
      phone: string;
      nhs111?: string;
    };
  };
  clinicians?: ClinicianItem[];
  support_team?: ClinicianItem[];
  reviews?: ReviewsData;
  sections?: PageSection[];
  seo?: {
    meta_title: string;
    meta_description: string;
    keywords?: string;
  };
}
