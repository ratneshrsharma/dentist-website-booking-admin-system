'use client';

import React, { useState, useEffect } from 'react';
import { AcocksGreenTemplate } from '@/components/templates/AcocksGreenTemplate';
import { BookingWizard } from '@/components/organisms/BookingWizard/BookingWizard';
import { WhatsAppHub } from '@/components/ui/WhatsAppHub/WhatsAppHub';
import { BrandPreloader } from '@/components/common/BrandPreloader';
import { ThemeHydrator } from '@/components/common/ThemeHydrator';
import { CodeInjector } from '@/components/common/CodeInjector';
import {
  cmsService,
  CmsPageContent,
  CmsPageSeo,
  GlobalThemeConfig,
  CodeInjectionData,
} from '@/services/cms.service';

export default function HomePage() {
  // Primary Main Theme: Acocks Green Dental Practice (Birmingham B27 6BH NHS & Private Surgery)
  const [bookingOpen, setBookingOpen] = useState(false);
  const [selectedServiceId, setSelectedServiceId] = useState<number | undefined>(undefined);

  // Graceful loading & smooth transition state
  const [mounted, setMounted] = useState(false);

  // Dynamic API state
  const [, setPageData] = useState<CmsPageContent | null>(null);
  const [, setSeoData] = useState<CmsPageSeo | null>(null);
  const [themeData, setThemeData] = useState<GlobalThemeConfig | null>(null);
  const [codeData, setCodeData] = useState<CodeInjectionData | null>(null);

  useEffect(() => {
    setMounted(true);
    if (typeof window !== 'undefined') {
      document.documentElement.setAttribute('data-theme', 'acocks-green');
    }

    let isMounted = true;

    async function hydrateHomePage() {
      try {
        const [content, seo, theme, code] = await Promise.all([
          cmsService.getPageContent('home'),
          cmsService.getPageSeo('home'),
          cmsService.getGlobalTheme(),
          cmsService.getCodeInjection('home'),
        ]);

        if (isMounted) {
          setPageData(content);
          setSeoData(seo);
          setThemeData(theme);
          setCodeData(code);

          // Update Document Title & Meta Description dynamically
          if (seo?.meta_title && typeof document !== 'undefined') {
            document.title = seo.meta_title;
          }
        }
      } catch (err) {
        console.error('[HomePage] API Hydration Error:', err);
      }
    }

    hydrateHomePage();

    return () => {
      isMounted = false;
    };
  }, []);

  const handleOpenBooking = (serviceId?: number) => {
    setSelectedServiceId(serviceId);
    setBookingOpen(true);
  };

  return (
    <>
      {/* 1. Custom Brand Animated Preloader */}
      <BrandPreloader
        isLoading={!mounted}
        clinicName={themeData?.branding?.clinic_name || 'Acocks Green Dental Practice'}
        badge="B27 6BH NHS & Private Surgery"
        message="Connecting Clinical Systems, Theme Tokens & Dynamic CMS..."
      />

      {/* 2. Dynamic Theme Customizer & Custom Code Injector */}
      <ThemeHydrator initialTheme={themeData} />
      <CodeInjector initialCode={codeData} slug="home" />

      {/* 3. Main Theme Template: Acocks Green Dental Practice with Smooth Fade Entrance */}
      <div className={`transition-opacity duration-300 ${mounted ? 'opacity-100' : 'opacity-0'}`}>
        <AcocksGreenTemplate
          onOpenBooking={handleOpenBooking}
          onOpenEmergency={() => handleOpenBooking(1)}
        />
      </div>

      {/* 4. Floating Emergency & Inquiries WhatsApp Hub */}
      <WhatsAppHub onOpenBooking={() => handleOpenBooking()} />

      {/* 5. 5-Step Real-Time Booking Wizard Modal Drawer */}
      <BookingWizard
        isOpen={bookingOpen}
        onClose={() => setBookingOpen(false)}
        preselectedServiceId={selectedServiceId}
      />
    </>
  );
}
