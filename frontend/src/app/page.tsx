'use client';

import React, { useEffect, useState } from 'react';
import { HomePageData, PageSection } from '@/types/cms';
import { CmsService, DEFAULT_HOME_PAGE } from '@/api/cms';

// Atomic & Reusable Layout Components
import { HeaderTopBar } from '@/components/layout/HeaderTopBar/HeaderTopBar';
import { HeaderNavBar } from '@/components/layout/HeaderNavBar/HeaderNavBar';
import { Footer } from '@/components/layout/Footer/Footer';
import { MobileAppNavBar } from '@/components/layout/MobileAppNavBar/MobileAppNavBar';

// Banners & Selectors
import { HeroBanner } from '@/components/banners/HeroBanner/HeroBanner';
import { BookingQuickBar } from '@/components/banners/BookingQuickBar/BookingQuickBar';

// Content Sections & Dynamic Blocks
import { ServicesGrid4x3 } from '@/components/sections/ServicesGrid4x3/ServicesGrid4x3';
import { ServicesSidebarList } from '@/components/sections/ServicesSidebarList/ServicesSidebarList';
import { AboutOurTeam } from '@/components/sections/AboutOurTeam/AboutOurTeam';
import { DoctorsGrid } from '@/components/sections/DoctorsGrid/DoctorsGrid';
import { TestimonialsSlider } from '@/components/sections/TestimonialsSlider/TestimonialsSlider';
import { SafetyCharterBanner } from '@/components/sections/SafetyCharterBanner/SafetyCharterBanner';
import { ClinicAddressAndContact } from '@/components/sections/ClinicAddressAndContact/ClinicAddressAndContact';
import { ContentBlockSection } from '@/components/sections/ContentBlockSection/ContentBlockSection';

// Interactive Booking Modal
import { BookingModal } from '@/components/common/BookingModal/BookingModal';

export default function HomePage() {
  const [pageData, setPageData] = useState<HomePageData>(DEFAULT_HOME_PAGE);
  const [loading, setLoading] = useState(false);
  const [isBookingOpen, setIsBookingOpen] = useState(false);
  const [bookingPref, setBookingPref] = useState<{ treatment: string; date: string }>({
    treatment: 'Routine Dental Examination',
    date: '',
  });

  useEffect(() => {
    async function loadData() {
      try {
        const data = await CmsService.getHomePage();
        setPageData(data);
      } catch (err) {
        console.error('Failed to load homepage CMS data:', err);
      } finally {
        setLoading(false);
      }
    }
    loadData();
  }, []);

  const handleOpenBooking = (initialTreatment?: string, initialDate?: string) => {
    if (initialTreatment || initialDate) {
      setBookingPref({
        treatment: initialTreatment || 'Routine Dental Examination',
        date: initialDate || '',
      });
    }
    setIsBookingOpen(true);
  };

  // Render individual dynamic section based on its type and layout
  const renderSection = (sec: PageSection, index: number) => {
    if (sec.is_active === false) return null;

    switch (sec.type) {
      case 'services_block':
        if (sec.layout === 'sidebar_list') {
          return (
            <ServicesSidebarList
              key={sec.id || `sec-${index}`}
              eyebrow={sec.eyebrow || pageData?.services_intro?.eyebrow}
              title={sec.title || pageData?.services_intro?.title}
              subtitle={sec.summary || sec.description || pageData?.services_intro?.subtitle}
              services={pageData?.featured_services}
              isLoading={loading}
              onBookClick={(serviceName) => handleOpenBooking(serviceName)}
            />
          );
        }
        return (
          <ServicesGrid4x3
            key={sec.id || `sec-${index}`}
            eyebrow={sec.eyebrow || pageData?.services_intro?.eyebrow}
            title={sec.title || pageData?.services_intro?.title}
            subtitle={sec.summary || sec.description || pageData?.services_intro?.subtitle}
            services={pageData?.featured_services}
            isLoading={loading}
          />
        );

      case 'team_block':
        return (
          <DoctorsGrid
            key={sec.id || `sec-${index}`}
            eyebrow={sec.eyebrow}
            title={sec.title}
            subtitle={sec.summary || sec.description}
            clinicians={pageData?.clinicians}
            supportTeam={pageData?.support_team}
            practiceManager={pageData?.practice_manager}
          />
        );

      case 'testimonials_block':
        return pageData?.reviews ? (
          <TestimonialsSlider
            key={sec.id || `sec-${index}`}
            eyebrow={sec.eyebrow}
            title={sec.title}
            reviewsData={pageData.reviews}
          />
        ) : null;

      case 'contact_block':
        return pageData?.contact_section ? (
          <ClinicAddressAndContact
            key={sec.id || `sec-${index}`}
            eyebrow={sec.eyebrow}
            title={sec.title}
            subtitle={sec.summary || sec.description}
            contactData={pageData.contact_section}
          />
        ) : null;

      case 'charter_block':
        if (pageData?.safety_charter) {
          return (
            <SafetyCharterBanner
              key={sec.id || `sec-${index}`}
              charter={pageData.safety_charter}
            />
          );
        }
        return <ContentBlockSection key={sec.id || `sec-${index}`} section={sec} />;

      case 'page_snippet':
      case 'custom_content':
      default:
        return <ContentBlockSection key={sec.id || `sec-${index}`} section={sec} />;
    }
  };

  const activeSections =
    pageData?.sections && pageData.sections.length > 0
      ? [...pageData.sections].sort(
          (a, b) => (Number(a.order) || 0) - (Number(b.order) || 0)
        )
      : null;

  return (
    <div style={{ display: 'flex', flexDirection: 'column', minHeight: '100vh' }}>
      {/* 1. Header Top Contact Bar */}
      <HeaderTopBar />

      {/* 2. Main Sticky Navigation with Booking Action */}
      <HeaderNavBar onBookClick={() => handleOpenBooking()} />

      <main style={{ flex: 1 }}>
        {/* 3. Hero Banner with Clinical Stats */}
        {pageData?.hero && (
          <HeroBanner
            hero={pageData.hero}
            onBookClick={() => handleOpenBooking()}
          />
        )}

        {/* 4. Overlapping Decare-Style Appointment Bar */}
        <BookingQuickBar
          onSearchSlots={({ treatment, date }) => {
            handleOpenBooking(treatment, date);
          }}
        />

        {/* 5. Dynamic Page Sections Composition */}
        {activeSections ? (
          activeSections.map((sec, idx) => renderSection(sec, idx))
        ) : (
          <>
            <ServicesGrid4x3
              eyebrow={pageData?.services_intro?.eyebrow}
              title={pageData?.services_intro?.title}
              subtitle={pageData?.services_intro?.subtitle}
              services={pageData?.featured_services}
              isLoading={loading}
            />
            {pageData?.about_summary && (
              <AboutOurTeam about={pageData.about_summary} />
            )}
            <DoctorsGrid
              clinicians={pageData?.clinicians}
              supportTeam={pageData?.support_team}
              practiceManager={pageData?.practice_manager}
            />
            {pageData?.reviews && (
              <TestimonialsSlider reviewsData={pageData.reviews} />
            )}
            {pageData?.safety_charter && (
              <SafetyCharterBanner charter={pageData.safety_charter} />
            )}
            {pageData?.contact_section && (
              <ClinicAddressAndContact contactData={pageData.contact_section} />
            )}
          </>
        )}
      </main>

      {/* Practice Global Footer */}
      <Footer />

      {/* Native Mobile & iPad App Fixed Bottom Navigation */}
      <MobileAppNavBar onBookClick={() => handleOpenBooking()} />

      {/* Interactive Booking Drawer Modal */}
      <BookingModal
        isOpen={isBookingOpen}
        onClose={() => setIsBookingOpen(false)}
        initialTreatment={bookingPref.treatment}
        initialDate={bookingPref.date}
      />
    </div>
  );
}
