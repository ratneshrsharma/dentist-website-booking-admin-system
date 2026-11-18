'use client';

import React, { useState, useEffect } from 'react';
import {
  AcocksGreenTreatmentDetailTemplate,
  TreatmentDetailData,
} from '@/components/templates/AcocksGreenTreatmentDetailTemplate';
import { BrandPreloader } from '@/components/common/BrandPreloader';
import { ThemeHydrator } from '@/components/common/ThemeHydrator';
import { CodeInjector } from '@/components/common/CodeInjector';
import {
  cmsService,
  CmsPageSeo,
  GlobalThemeConfig,
  CodeInjectionData,
} from '@/services/cms.service';

interface TreatmentDetailClientProps {
  slug: string;
  initialData?: TreatmentDetailData;
}

export const TreatmentDetailClient: React.FC<TreatmentDetailClientProps> = ({
  slug,
  initialData,
}) => {
  const [loading, setLoading] = useState(true);
  const [pageData, setPageData] = useState<TreatmentDetailData | null>(initialData || null);
  const [, setSeoData] = useState<CmsPageSeo | null>(null);
  const [, setThemeData] = useState<GlobalThemeConfig | null>(null);
  const [, setCodeData] = useState<CodeInjectionData | null>(null);

  useEffect(() => {
    let isMounted = true;

    async function hydrateTreatmentDetail() {
      try {
        const [content, seo, theme, code] = await Promise.all([
          cmsService.getPageContent(slug),
          cmsService.getPageSeo(slug),
          cmsService.getGlobalTheme(),
          cmsService.getCodeInjection(slug),
        ]);

        if (isMounted) {
          if (content && typeof content === 'object') {
            setPageData((prev) => ({
              ...prev,
              ...(content as unknown as TreatmentDetailData),
            }));
          }
          setSeoData(seo);
          setThemeData(theme);
          setCodeData(code);

          // Update Document Title dynamically
          if (seo?.meta_title && typeof document !== 'undefined') {
            document.title = seo.meta_title;
          }
        }
      } catch (err) {
        console.warn(`[TreatmentDetailClient] CMS API hydration for '${slug}' fell back to local dataset:`, err);
      } finally {
        if (isMounted) {
          // Allow theme tokens and layout to stabilize smoothly
          setTimeout(() => {
            setLoading(false);
          }, 250);
        }
      }
    }

    hydrateTreatmentDetail();

    return () => {
      isMounted = false;
    };
  }, [slug]);

  // Default General Dentistry fallback content
  const fallbackData: TreatmentDetailData = {
    slug: slug,
    title: 'General Dentistry & Routine Dental Check-ups in Birmingham',
    eyebrow: 'CORE HEALTHCARE & PREVENTATIVE CARE',
    subtitle:
      'Comprehensive oral examinations, gentle precision care, low-dose digital radiographs, and bespoke preventative care to safeguard your smile for life. Available under NHS dental bands and private pathways.',
    badge: 'B27 6BH NHS & Private Surgery',
    phone: '+44 121 765 2870',
    breadcrumbs: ['Home', 'Treatments & Services', 'General Dentistry & Routine Check-ups'],
    feature_badges: [
      { icon: 'verified', text: 'NHS & Private Available' },
      { icon: 'schedule', text: 'Same-Day Emergency Relief' },
      { icon: 'radiology', text: 'Digital Low-Dose Radiography' },
      { icon: 'favorite', text: 'Gentle Phobic-Friendly Care' },
    ],
    hero_image:
      'https://images.unsplash.com/photo-1629909615184-74f495363b67?auto=format&fit=crop&q=80&w=1200',
    hero_badge: {
      title: 'Gentle Dental Check • Digital Precision X-Rays',
      subtitle: 'NHS Standard & Comprehensive Private',
    },
    what_includes: {
      eyebrow: 'CLINICAL PRECISION',
      title: 'What Happens During Your 14-Point Dental Check-Up?',
      subtitle:
        'Our thorough 30-minute examinations evaluate teeth, gums, jaw joints, bite dynamics, and soft tissues for early detection and peace of mind. We believe proactive care prevents complex future procedures.',
      diagnostic_cards: [
        {
          number: '01',
          icon: 'health_and_safety',
          title: 'Oral Health & Cancer Screening',
          badge: 'Soft Tissue & Lymph Nodes',
          description:
            'Every routine check-up includes a systematic physical and visual screening of your tongue, cheeks, palate, and throat tissues to detect any early mucosal changes or precancerous abnormalities long before symptoms develop.',
          checklist: [
            'Comprehensive oral mucosal inspection',
            'TMJ & jaw alignment assessment',
            'Bite & occlusal wear pattern check',
          ],
        },
        {
          number: '02',
          icon: 'radiology',
          title: 'Low-Dose Digital X-Rays & Imaging',
          badge: 'Instant Chairside Clarity',
          description:
            'When clinically justified, we capture ultra-low-radiation digital bitewing radiographs. These reveal hidden interdental decay, root health, bone density levels, and pathology beneath existing restorations without uncomfortable physical film plates.',
          checklist: [
            'Up to 90% reduced radiation exposure',
            'Instant chairside monitor review',
            'Early hidden decay detection',
          ],
        },
        {
          number: '03',
          icon: 'cleaning_services',
          title: 'Preventative Scale, Polish & Gum Triage',
          badge: 'Basic Periodontal Examination',
          description:
            'We map your Basic Periodontal Examination (BPE) scores across all six sextants to identify early gingivitis or subgingival calculus. If indicated under Band 1, a basic preventative scale is performed to preserve gum attachment.',
          checklist: [
            '6-point BPE periodontal scoring',
            'Plaque and calculus removal',
            'Personalized flossing advice',
          ],
        },
      ],
      nervous_patient_banner: {
        icon: 'favorite',
        title: 'New Patient or Nervous Visitor?',
        description:
          'Our gentle Birmingham clinicians take extra time to explain every step, ensuring painless, relaxed examinations.',
        cta_text: 'Register as a New Patient',
        cta_link: '#quick-book',
      },
    },
    procedures: {
      eyebrow: 'RESTORATIVE & PREVENTATIVE SERVICES',
      title: 'Complete Everyday Dental Solutions Under One Roof',
      subtitle:
        'From preventative maintenance and discreet composite repairs to emergency toothache triage, we provide gentle, long-lasting clinical care tailored to your exact smile goals.',
      items: [
        {
          number: '01',
          icon: 'dental_services',
          title: 'Tooth-Coloured Composite Fillings',
          duration: '30-45 mins',
          description:
            'Mercury-free, biomimetic resin composite restorations that blend seamlessly with your natural tooth shade, restoring strength and durability after decay.',
          link_text: 'Explore Restorations',
          link_href: '/treatments/restorative',
        },
        {
          number: '02',
          icon: 'water_drop',
          title: 'Dental Hygiene & Periodontal Care',
          duration: '30 mins',
          description:
            'Deep ultrasonic scaling, stubborn stain removal with gentle airflow polishing, and personalized homecare instruction to reverse bleeding gums and eliminate halitosis.',
          link_text: 'View Hygiene Services',
          link_href: '/treatments/hygiene',
        },
        {
          number: '03',
          icon: 'verified_user',
          title: 'Fissure Sealants & Fluoride Varnishes',
          duration: '15-20 mins',
          description:
            'Preventative micro-coatings for children and decay-prone adults that seal deep biting grooves against food trap bacteria, paired with clinical-strength fluoride varnishes.',
          link_text: 'Learn About Prevention',
          link_href: '/treatments/prevention',
        },
        {
          number: '04',
          icon: 'emergency',
          title: 'Emergency Relief & Extractions',
          duration: 'Same-Day Priority',
          description:
            'Rapid pain relief for severe pulpitis, cracked teeth, or painful wisdom teeth. When a tooth cannot be saved, we perform gentle, atraumatic extractions.',
          link_text: 'Emergency Dental Help',
          link_href: '/treatments/emergency',
        },
      ],
    },
    pricing: {
      eyebrow: 'TRANSPARENT COSTS',
      title: 'Clear Pricing: NHS Bands & Private Options',
      subtitle:
        'We believe in honest, predictable clinical care with zero hidden costs. Choose between standard NHS tiered bandings or our enhanced private restorative treatments.',
      cards: [
        {
          badge: 'NHS Fee Band 1',
          title: 'NHS Dental Examination',
          price: '£26.80',
          price_note: 'fixed statutory fee',
          popular: false,
          features: [
            'Clinical diagnosis and consultation',
            'Full soft tissue cancer screening',
            'Diagnostic digital X-rays (if clinically indicated)',
            'Basic scale & polish (if clinically required)',
            'Personalized oral health prevention advice',
          ],
          cta_text: 'Book NHS Appointment',
          cta_type: 'nhs',
        },
        {
          badge: 'Most Popular Choice',
          title: 'Private Comprehensive Check',
          price: '£55.00',
          price_note: 'all inclusive',
          popular: true,
          features: [
            'Extended 30-minute consultation time',
            'Digital intraoral photographic tour',
            'All diagnostic bitewing radiographs included',
            'Written bespoke treatment roadmap',
            'Zero NHS waiting list / flexible appointment times',
          ],
          cta_text: 'Book Private Check-up',
          cta_type: 'private',
        },
        {
          badge: 'Enhanced Preventative Pack',
          title: 'Routine Check + Airflow Hygiene',
          price: '£110.00',
          price_note: 'save £10 combined',
          popular: false,
          features: [
            'Everything included in Private Comprehensive Check',
            '30-minute thorough dental hygiene therapy',
            'Subgingival ultrasonic plaque removal',
            'High-gloss polishing and stain removal',
            'Direct priority booking access',
          ],
          cta_text: 'Book Combined Care',
          cta_type: 'combined',
        },
      ],
      comparison_table: {
        title: 'NHS vs Private: Key Differences at a Glance',
        headers: ['Feature / Pathway', 'NHS Dental Care', 'Private Dental Care'],
        rows: [
          {
            feature: 'Availability & Waiting Times',
            nhs: 'Subject to NHS capacity & fixed appointment slots',
            private: 'Priority bookings, early morning & evening availability',
          },
          {
            feature: 'Materials & Aesthetics',
            nhs: 'Standard amalgam fillings on posterior molars',
            private: 'Natural tooth-coloured composite & aesthetic ceramics throughout',
          },
          {
            feature: 'Appointment Duration',
            nhs: 'Standard clinical appointment length (15-20 mins)',
            private: 'Extended 30-45 minute appointments with full intraoral tour',
          },
          {
            feature: 'Emergency Booking',
            nhs: 'Limited daily triage slots during core surgery hours',
            private: 'Same-day priority emergency appointments guaranteed',
          },
        ],
      },
    },
    faqs: {
      eyebrow: 'CLINICAL REASSURANCE',
      title: 'Frequently Asked Questions About Routine Check-ups',
      subtitle:
        'Clear answers to common questions about dental examinations, NHS fees, and patient comfort.',
      items: [
        {
          question: 'How often should I attend for a routine dental check-up?',
          answer:
            'For most healthy adult patients, the standard clinical recommendation is every 6 months. However, depending on your individual gum health, decay history, or lifestyle factors (such as smoking or diabetes), your dentist may recommend an interval between 3 and 12 months in accordance with NICE guidelines.',
        },
        {
          question: 'Are digital dental X-rays safe?',
          answer:
            'Yes, absolutely. Our Acocks Green surgery uses state-of-the-art digital dental radiography, which produces up to 90% less radiation than conventional physical dental film. A standard set of dental bitewing X-rays exposes you to less radiation than a standard 2-hour commercial flight.',
        },
        {
          question: 'Who is eligible for free NHS dental treatment?',
          answer:
            'Under NHS regulations, dental treatment is free if, when treatment starts, you are under 18 (or under 19 and in full-time education), pregnant or have had a baby in the last 12 months, or hold a qualifying valid exemption certificate such as Income Support or Universal Credit.',
        },
        {
          question: 'What should I do if I feel nervous or dental phobic?',
          answer:
            'Please let our friendly team know when booking or upon arrival! Our dentists are exceptionally gentle and experienced with dental anxiety. We will happily arrange an introductory consultation where no treatment is performed, agree on a "stop signal" during examination, and explain every step in plain language.',
        },
        {
          question: 'Can I combine NHS check-ups with private cosmetic treatments?',
          answer:
            'Yes, this is very common. You can receive your routine check-up and clinically necessary care under standard NHS bandings, while choosing private aesthetic options—such as tooth-coloured white fillings on back teeth, airflow stain removal, or clear aligner orthodontics—on a private basis.',
        },
      ],
    },
    consultation_cta: {
      eyebrow: 'SEAMLESS SCHEDULING',
      title: 'Reserve Your Routine Check-Up Today',
      subtitle:
        'Join thousands of satisfied Birmingham families enjoying gentle, trusted dental care on Warwick Road. Book your appointment online or call our friendly team.',
      phone: '+44 121 765 2870',
      address: '1078 Warwick Road, Acocks Green, Birmingham B27 6BH',
      hours: 'Mon–Fri: 8:30am – 5:30pm',
      cta_primary: 'Book Appointment Online',
      cta_secondary: 'Call Reception: 0121 765 2870',
      reassurance_badges: [
        'Confidential & GDPR Compliant',
        'No Obligation Assessment',
        'GDC Registered Dentists',
      ],
    },
  };

  const activeData: TreatmentDetailData = {
    ...fallbackData,
    ...(pageData || {}),
  };

  return (
    <>
      {/* 1. Clinic Brand Preloader for smooth seamless load */}
      <BrandPreloader isLoading={loading} message="Loading Clinical Systems..." />

      {/* 2. Global CSS Custom Variables Token Hydrator */}
      <ThemeHydrator />

      {/* 3. Dual-Scope Custom Code Injector (GTM, Scripts, Per-Page CSS) */}
      <CodeInjector slug={slug} />

      {/* 4. Full Acocks Green Treatment Detail Template */}
      <div
        className={`transition-opacity duration-500 ${
          loading ? 'opacity-0 pointer-events-none' : 'opacity-100 pointer-events-auto'
        }`}
      >
        <AcocksGreenTreatmentDetailTemplate data={activeData} />
      </div>
    </>
  );
};
