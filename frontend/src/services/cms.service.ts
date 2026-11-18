/**
 * Advanced Dental Clinic - Headless CMS & Dynamic Customization Service Layer
 * Powered by Axios: Connects Next.js patient-facing pages directly to Laravel / StandaloneRunner APIs.
 */

import { httpClient, ApiResponse } from '@/lib/http-client';

export interface CmsCategoryItem {
  id: string;
  name: string;
  count: number;
}

export interface CmsTreatmentService {
  id: string;
  title: string;
  category: string;
  badge?: string;
  badge_color?: string;
  description: string;
  nhs_available: boolean;
  nhs_band?: string;
  starting_price?: string;
  duration?: string;
  icon?: string;
  slug: string;
  details?: {
    clinical_approach?: string;
    who_is_it_for?: string;
    materials?: string;
    technology?: string;
    cqc_assurance?: string;
    what_to_expect?: string[];
  };
}

export interface CmsPricingItem {
  band?: string;
  service?: string;
  price?: string;
  includes?: string;
  ideal_for?: string;
}

export interface CmsPricingMatrix {
  nhs_description?: string;
  private_description?: string;
  nhs: CmsPricingItem[];
  private: CmsPricingItem[];
}

export interface CmsClinicalPillar {
  title: string;
  subtitle: string;
  description: string;
  icon: string;
}

export interface CmsConsultationCta {
  eyebrow?: string;
  headline: string;
  description: string;
  phone: string;
  phone_raw?: string;
  online_booking_url?: string;
  emergency_note?: string;
}

export interface CmsPageContent {
  slug: string;
  title: string;
  eyebrow?: string;
  subtitle: string;
  badge?: string;
  breadcrumbs?: string[];
  category?: string;
  categories?: CmsCategoryItem[];
  services?: CmsTreatmentService[];
  pricing_matrix?: CmsPricingMatrix;
  pillars?: CmsClinicalPillar[];
  consultation_cta?: CmsConsultationCta;
  faqs?: Array<{ question: string; answer: string }>;
  [key: string]: unknown;
}

export interface CmsPageSeo {
  slug?: string;
  meta_title: string;
  meta_description: string;
  keywords?: string[] | string;
  canonical_url: string;
  og_title?: string;
  og_description?: string;
  og_image?: string;
  twitter_card?: string;
  robots?: string;
  schema_json?: Record<string, unknown> | null;
}

export interface GlobalThemeColors {
  primary: string;
  primary_hover: string;
  secondary: string;
  secondary_hover?: string;
  accent: string;
  surface: string;
  surface_muted: string;
  surface_dark?: string;
  text_primary: string;
  text_secondary?: string;
  text_muted: string;
  border: string;
  border_light?: string;
  nhs_blue?: string;
  [key: string]: string | undefined;
}

export interface GlobalThemeTypography {
  font_family_heading: string;
  font_family_body: string;
  font_family_serif?: string;
  google_fonts_url?: string;
}

export interface GlobalThemeBranding {
  clinic_name: string;
  tagline: string;
  logo_url: string;
  phone: string;
  whatsapp: string;
  address: string;
}

export interface GlobalThemeConfig {
  theme_name: string;
  display_name?: string;
  colors: GlobalThemeColors;
  typography: GlobalThemeTypography;
  branding: GlobalThemeBranding;
  tokens?: Record<string, string>;
}

export interface CodeInjectionScope {
  custom_css?: string;
  head_scripts?: string;
  body_scripts?: string;
}

export interface CodeInjectionData {
  slug: string;
  common: CodeInjectionScope;
  page: CodeInjectionScope;
  merged: CodeInjectionScope;
}

// Fallback Defaults for Offline / Resilient SSR Rendering
export const DEFAULT_THEME_CONFIG: GlobalThemeConfig = {
  theme_name: 'acocks-green',
  display_name: 'Acocks Green Dental Practice (Primary British Healthcare Theme)',
  colors: {
    primary: '#005f73',
    primary_hover: '#004352',
    secondary: '#0a9396',
    secondary_hover: '#005f73',
    accent: '#ee9b00',
    surface: '#ffffff',
    surface_muted: '#f4f6f8',
    surface_dark: '#101d24',
    text_primary: '#001e28',
    text_secondary: '#3a5a68',
    text_muted: '#6b828d',
    border: '#e2e8f0',
    border_light: '#edf2f7',
    nhs_blue: '#005eb8',
  },
  typography: {
    font_family_heading: "'Plus Jakarta Sans', sans-serif",
    font_family_body: "'Plus Jakarta Sans', sans-serif",
    font_family_serif: "'Playfair Display', serif",
    google_fonts_url:
      'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Work+Sans:wght@400;500;600&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap',
  },
  branding: {
    clinic_name: 'Acocks Green Dental Practice',
    tagline: 'NHS & Private Family Dental Surgery Birmingham B27',
    logo_url: '/images/acocks-green-logo.png',
    phone: '+44 121 765 2870',
    whatsapp: '+919904379260',
    address: '1078 Warwick Road, Acocks Green, Birmingham B27 6BH',
  },
};

export const DEFAULT_SEO_CONFIG: Record<string, CmsPageSeo> = {
  treatments: {
    slug: 'treatments',
    meta_title: 'NHS & Private Dental Treatments | Acocks Green Practice Birmingham',
    meta_description:
      'Explore evidence-based dental treatments in Acocks Green B27. From Band 1-3 NHS dentistry to Invisalign, ceramic veneers, implants & emergency triage. Book online.',
    keywords: [
      'NHS Dentist Birmingham',
      'Acocks Green Dental Practice',
      'Dental Implants Birmingham',
      'Invisalign Acocks Green',
      'Emergency Dentist B27',
      'Root Canal Birmingham',
    ],
    canonical_url: 'https://acocksgreendentalpractice.co.uk/treatments',
    og_title: 'NHS & Private Dental Treatments | Acocks Green Dental Practice',
    og_description:
      'Comprehensive NHS & Private dental treatments in Birmingham B27. Modern surgery with 0% finance and emergency care.',
    og_image: '/images/surgery-clinic.jpg',
    twitter_card: 'summary_large_image',
    robots: 'index, follow',
  },
  home: {
    slug: 'home',
    meta_title: 'Acocks Green Dental Practice | NHS & Private Family Dental Surgery Birmingham B27',
    meta_description:
      'Welcoming NHS & private dental patients across Birmingham B27. Board-certified dentists, emergency triage, hygiene, restorative dentistry, cosmetic veneers & clear aligners.',
    keywords: ['Acocks Green Dental Practice', 'Dentist Birmingham B27', 'NHS Dentist Birmingham'],
    canonical_url: 'https://acocksgreendentalpractice.co.uk/',
    og_title: 'Acocks Green Dental Practice Birmingham',
    og_description: 'NHS & Private Family Dental Care on Warwick Road, Acocks Green B27 6BH.',
    og_image: '/images/hero-patient.jpg',
    twitter_card: 'summary_large_image',
    robots: 'index, follow',
  },
};

export const DEFAULT_CODE_INJECTION: CodeInjectionData = {
  slug: 'treatments',
  common: {
    custom_css: '/* Sitewide Common CSS */\n:root { --font-heading: "Plus Jakarta Sans", sans-serif; }',
    head_scripts: '<!-- Global Sitewide Head Scripts (e.g., GTM / GA4 placeholder) -->',
    body_scripts: '<!-- Global Sitewide Body Scripts (e.g., WhatsApp Widget placeholder) -->',
  },
  page: {
    custom_css: '/* Page-specific Treatments CSS */',
    head_scripts: '<!-- Page-specific Treatments Head Scripts -->',
    body_scripts: '<!-- Page-specific Treatments Body Scripts -->',
  },
  merged: {
    custom_css: '',
    head_scripts: '',
    body_scripts: '',
  },
};

/**
 * Headless CMS Client Service
 */
export const cmsService = {
  /**
   * Endpoint 1: Fetch full page section content by slug
   */
  async getPageContent(slug: string): Promise<CmsPageContent> {
    const cleanSlug = (slug || 'home').replace(/^\/+/, '');
    try {
      const response = await httpClient.get<ApiResponse<CmsPageContent>>(`/cms/pages/${cleanSlug}`);
      if (response.data && response.data.success && response.data.data) {
        return response.data.data;
      }
      throw new Error(`Invalid response structure for page: ${cleanSlug}`);
    } catch (err) {
      console.warn(`[cmsService.getPageContent] Falling back to default data for '${cleanSlug}':`, err);
      // Return structured default for treatments or home
      if (cleanSlug === 'treatments') {
        return {
          slug: 'treatments',
          title: 'Treatments & Services',
          eyebrow: 'Evidence-Based Dental Excellence',
          subtitle:
            'From routine NHS prevention to advanced private smile rehabilitation, explore our comprehensive range of clinical dental treatments in Acocks Green, Birmingham.',
          badge: 'B27 6BH Dental Surgery',
          breadcrumbs: ['Home', 'Treatments & Services'],
          categories: [
            { id: 'all', name: 'All Treatments', count: 6 },
            { id: 'nhs', name: 'NHS Dentistry', count: 3 },
            { id: 'implants', name: 'Dental Implants', count: 2 },
            { id: 'orthodontics', name: 'Invisalign & Aligners', count: 2 },
            { id: 'cosmetic', name: 'Cosmetic Dentistry', count: 2 },
            { id: 'hygiene', name: 'Hygiene & Periodontics', count: 2 },
            { id: 'emergency', name: 'Emergency Care', count: 1 },
          ],
        };
      }
      return {
        slug: cleanSlug,
        title: cleanSlug.charAt(0).toUpperCase() + cleanSlug.slice(1),
        subtitle: 'Advanced Dental Care in Acocks Green Birmingham',
      };
    }
  },

  /**
   * Endpoint 2: Fetch Yoast-style SEO metadata, OpenGraph & schema by slug
   */
  async getPageSeo(slug: string): Promise<CmsPageSeo> {
    const cleanSlug = (slug || 'home').replace(/^\/+/, '');
    try {
      const response = await httpClient.get<ApiResponse<CmsPageSeo>>(`/cms/seo/${cleanSlug}`);
      if (response.data && response.data.success && response.data.data) {
        return response.data.data;
      }
      throw new Error(`Invalid response structure for SEO: ${cleanSlug}`);
    } catch (err) {
      console.warn(`[cmsService.getPageSeo] Using default SEO for '${cleanSlug}':`, err);
      return (
        DEFAULT_SEO_CONFIG[cleanSlug] || {
          slug: cleanSlug,
          meta_title: `${cleanSlug} | Acocks Green Dental Practice Birmingham`,
          meta_description: 'Acocks Green Dental Practice NHS and Private Family Dentistry Birmingham B27.',
          canonical_url: `https://acocksgreendentalpractice.co.uk/${cleanSlug}`,
          og_image: '/images/acocks-green-logo.png',
        }
      );
    }
  },

  /**
   * Endpoint 3: Fetch active global theme tokens, colors, typography and branding
   */
  async getGlobalTheme(): Promise<GlobalThemeConfig> {
    try {
      const response = await httpClient.get<ApiResponse<GlobalThemeConfig>>('/theme/global');
      if (response.data && response.data.success && response.data.data) {
        return response.data.data;
      }
      throw new Error('Invalid theme response structure');
    } catch (err) {
      console.warn('[cmsService.getGlobalTheme] Using default theme config:', err);
      return DEFAULT_THEME_CONFIG;
    }
  },

  /**
   * Endpoint 4: Fetch Dual-Scope Custom Code Injection (Common + Page-Specific)
   */
  async getCodeInjection(slug: string): Promise<CodeInjectionData> {
    const cleanSlug = (slug || 'home').replace(/^\/+/, '');
    try {
      const response = await httpClient.get<ApiResponse<CodeInjectionData>>(`/cms/code-injection/${cleanSlug}`);
      if (response.data && response.data.success && response.data.data) {
        return response.data.data;
      }
      throw new Error(`Invalid code injection response structure for '${cleanSlug}'`);
    } catch (err) {
      console.warn(`[cmsService.getCodeInjection] Using default code injection for '${cleanSlug}':`, err);
      return {
        ...DEFAULT_CODE_INJECTION,
        slug: cleanSlug,
      };
    }
  },
};
