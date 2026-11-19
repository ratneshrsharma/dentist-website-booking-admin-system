'use client';

import React, { useState, useEffect } from 'react';
import { AcocksGreenHeader } from '@/components/organisms/AcocksGreenHeader/AcocksGreenHeader';
import { AcocksGreenFooter } from '@/components/organisms/AcocksGreenFooter/AcocksGreenFooter';
import { BookingWizard } from '@/components/organisms/BookingWizard/BookingWizard';
import { WhatsAppHub } from '@/components/ui/WhatsAppHub/WhatsAppHub';
import { MobileAppNavBar } from '@/components/organisms/MobileAppNavBar';
import { BrandPreloader } from '@/components/common/BrandPreloader';
import { ThemeHydrator } from '@/components/common/ThemeHydrator';
import { CodeInjector } from '@/components/common/CodeInjector';
import {
  InnerBanner,
  ServicesThumbnailGrid,
  PricingMatrixTable,
  ClinicalPillarsGrid,
  ConsultationActionBar,
  PracticeLocationHours,
} from '@/components/shared';
import {
  cmsService,
  CmsPageContent,
  CmsPageSeo,
  GlobalThemeConfig,
  CodeInjectionData,
} from '@/services/cms.service';

interface NhsBandItem {
  band: string;
  desc: string;
  price: string;
  isUrgent?: boolean;
}

interface PrivatePriceItem {
  service: string;
  desc: string;
  price: string;
  prefix?: string;
}

export default function TreatmentsPage() {
  const [bookingOpen, setBookingOpen] = useState(false);
  const [selectedServiceId, setSelectedServiceId] = useState<number | undefined>(undefined);

  // 0ms Loading strategy: false by default for instant SSG rendering
  const loading = false;

  // Dynamic API state
  const [pageData, setPageData] = useState<CmsPageContent | null>(null);
  const [, setSeoData] = useState<CmsPageSeo | null>(null);
  const [themeData, setThemeData] = useState<GlobalThemeConfig | null>(null);
  const [codeData, setCodeData] = useState<CodeInjectionData | null>(null);

  // Parallel Axios API Data Hydration
  useEffect(() => {
    let isMounted = true;

    async function hydratePage() {
      try {
        const [content, seo, theme, code] = await Promise.all([
          cmsService.getPageContent('treatments'),
          cmsService.getPageSeo('treatments'),
          cmsService.getGlobalTheme(),
          cmsService.getCodeInjection('treatments'),
        ]);

        if (isMounted) {
          setPageData(content);
          setSeoData(seo);
          setThemeData(theme);
          setCodeData(code);

          if (seo?.meta_title && typeof document !== 'undefined') {
            document.title = seo.meta_title;
          }
        }
      } catch (err) {
        console.error('[TreatmentsPage] API Hydration Error:', err);
      }
    }

    hydratePage();

    return () => {
      isMounted = false;
    };
  }, []);

  const handleOpenBooking = (serviceId?: number) => {
    setSelectedServiceId(serviceId);
    setBookingOpen(true);
  };

  const defaultNhsBands: NhsBandItem[] = [
    { band: 'Band 1 Treatment', desc: 'Check-up, digital x-rays, basic polish & diagnosis', price: '£26.80' },
    { band: 'Band 2 Treatment', desc: 'Fillings, root canal therapy & tooth extractions', price: '£73.50' },
    { band: 'Band 3 Treatment', desc: 'Complex crowns, precision bridges & full/partial dentures', price: '£319.10' },
    { band: 'Urgent Care Band', desc: 'Immediate emergency relief, triage & temporary dressing', price: '£26.80', isUrgent: true },
  ];

  const defaultPrivateOptions: PrivatePriceItem[] = [
    { service: 'Hygiene Airflow Polish', desc: '30-min intensive ultrasonic scale & air polish stain removal', price: '£65.00', prefix: 'From' },
    { service: 'Boutique Teeth Whitening', desc: 'Customized take-home whitening trays with high-strength gel', price: '£299.00', prefix: 'From' },
    { service: 'Composite Bonding', desc: 'Micro-layer aesthetic sculpting per tooth with zero drilling', price: '£150.00', prefix: 'Per Tooth' },
    { service: 'Invisalign® Clear Consultation', desc: 'Full 3D digital scan & computerized treatment smile simulator', price: 'Complimentary', prefix: '' },
  ];

  return (
    <>
      <BrandPreloader
        isLoading={loading}
        clinicName={themeData?.branding?.clinic_name || 'Acocks Green Dental Practice'}
        badge={pageData?.badge || 'B27 6BH NHS & Private Surgery'}
        message="Synchronizing Clinical Catalog..."
      />

      <ThemeHydrator initialTheme={themeData} />
      <CodeInjector initialCode={codeData} slug="treatments" />

      <AcocksGreenHeader
        onOpenBooking={() => handleOpenBooking()}
        onOpenEmergency={() => handleOpenBooking(3)}
      />

      <main className="min-h-screen pt-28 pb-24 xl:pb-0 bg-surface text-on-surface">
        {/* Inner Banner with Breadcrumb & Lead Clinician */}
        <InnerBanner
          title={pageData?.title || 'Comprehensive Dental Care & Specialized Treatments'}
          subtitle={
            pageData?.subtitle ||
            'From essential routine NHS care to advanced cosmetic smile makeovers and restorative procedures in Acocks Green, Birmingham. Delivered with gentle compassion and state-of-the-art diagnostics.'
          }
          eyebrow={pageData?.eyebrow || 'OUR 9 CLINICAL PROCEDURES & SERVICES'}
          breadcrumbs={[{ label: 'Treatments & Services' }]}
        />

        {/* Unified 9 Treatments Thumbnail Grid */}
        <ServicesThumbnailGrid
          onOpenBooking={handleOpenBooking}
          isLoading={false}
          headline="Explore All 9 Clinical Treatments & Fee Schedules"
          eyebrow="COMPLETE PRACTICE CATALOGUE"
          subtitle="All 9 specialist dental procedures offered at 1078 Warwick Road, Birmingham B27 6BH."
        />

        {/* Pricing Matrix Table */}
        <PricingMatrixTable
          nhsBands={defaultNhsBands}
          privateOptions={defaultPrivateOptions}
          onOpenBooking={() => handleOpenBooking()}
        />

        {/* Clinical Pillars Grid */}
        <ClinicalPillarsGrid />

        {/* Practice Location & Hours */}
        <PracticeLocationHours onOpenBooking={() => handleOpenBooking()} />

        {/* Consultation Action Bar */}
        <ConsultationActionBar
          headline="Ready to Plan Your Treatment?"
          description="Book a consultation at our Warwick Road surgery or speak directly with our reception team."
          onOpenBooking={() => handleOpenBooking()}
        />
      </main>

      <AcocksGreenFooter
        onOpenBooking={() => handleOpenBooking()}
        onOpenEmergency={() => handleOpenBooking(3)}
      />

      <MobileAppNavBar
        onOpenBooking={() => handleOpenBooking()}
        onOpenEmergency={() => handleOpenBooking(3)}
      />

      <WhatsAppHub onOpenBooking={() => handleOpenBooking()} />

      <BookingWizard
        isOpen={bookingOpen}
        onClose={() => setBookingOpen(false)}
        preselectedServiceId={selectedServiceId}
      />
    </>
  );
}
