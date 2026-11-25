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
import { BlogPostsSection } from '@/components/sections/BlogPostsSection/BlogPostsSection';
import { assetUrl } from '@/utils/asset';

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

  // Helper to wrap pre-built component blocks in custom section styling if set
  const wrapSection = (sec: PageSection, index: number, children: React.ReactNode) => {
    if (!sec.bg_type || sec.bg_type === 'default') {
      return <React.Fragment key={sec.id || `sec-${index}`}>{children}</React.Fragment>;
    }
    const isEven = index % 2 === 1;
    const style: React.CSSProperties = { position: 'relative' };
    if (sec.padding_y === 'compact') {
      style.paddingTop = '3.5rem';
      style.paddingBottom = '3.5rem';
    } else if (sec.padding_y === 'generous') {
      style.paddingTop = '7.5rem';
      style.paddingBottom = '7.5rem';
    }
    if (sec.bg_type === 'solid') {
      style.backgroundColor = sec.bg_color || (isEven ? '#f0fdf4' : '#ffffff');
    } else if (sec.bg_type === 'gradient') {
      const start = sec.bg_gradient_start || '#094713';
      const end = sec.bg_gradient_end || '#15803d';
      const angle = sec.bg_gradient_angle || '135deg';
      style.background = `linear-gradient(${angle}, ${start} 0%, ${end} 100%)`;
    } else if (sec.bg_type === 'image' || sec.bg_type === 'image_overlay') {
      if (sec.bg_image) {
        style.backgroundImage = `url(${assetUrl(sec.bg_image)})`;
        style.backgroundSize = 'cover';
        style.backgroundPosition = 'center';
      }
    }
    return (
      <div key={sec.id || `sec-${index}`} style={style}>
        {sec.bg_type === 'image_overlay' && (
          <div
            style={{
              position: 'absolute',
              inset: 0,
              backgroundColor: sec.bg_overlay_color || '#000000',
              opacity: (sec.bg_overlay_opacity ?? 70) / 100,
              zIndex: 0,
              pointerEvents: 'none',
            }}
          />
        )}
        <div style={{ position: 'relative', zIndex: 1 }}>
          {children}
        </div>
      </div>
    );
  };

  // Render individual dynamic section based on its type and layout
  const renderSection = (sec: PageSection, index: number) => {
    if (sec.is_active === false) return null;

    switch (sec.type) {
      case 'services_block':
        if (sec.layout === 'sidebar_list') {
          return wrapSection(
            sec,
            index,
            <ServicesSidebarList
              eyebrow={sec.eyebrow || pageData?.services_intro?.eyebrow}
              title={sec.title || pageData?.services_intro?.title}
              subtitle={sec.summary || sec.description || pageData?.services_intro?.subtitle}
              services={pageData?.featured_services}
              isLoading={loading}
              onBookClick={(serviceName) => handleOpenBooking(serviceName)}
            />
          );
        }
        return wrapSection(
          sec,
          index,
          <ServicesGrid4x3
            eyebrow={sec.eyebrow || pageData?.services_intro?.eyebrow}
            title={sec.title || pageData?.services_intro?.title}
            subtitle={sec.summary || sec.description || pageData?.services_intro?.subtitle}
            services={pageData?.featured_services}
            isLoading={loading}
          />
        );

      case 'team_block':
        return wrapSection(
          sec,
          index,
          <DoctorsGrid
            eyebrow={sec.eyebrow}
            title={sec.title}
            subtitle={sec.summary || sec.description}
            clinicians={pageData?.clinicians}
            supportTeam={pageData?.support_team}
            practiceManager={pageData?.practice_manager}
          />
        );

      case 'testimonials_block':
        return pageData?.reviews
          ? wrapSection(
              sec,
              index,
              <TestimonialsSlider
                eyebrow={sec.eyebrow}
                title={sec.title}
                reviewsData={pageData.reviews}
              />
            )
          : null;

      case 'contact_block':
        return pageData?.contact_section
          ? wrapSection(
              sec,
              index,
              <ClinicAddressAndContact
                eyebrow={sec.eyebrow}
                title={sec.title}
                subtitle={sec.summary || sec.description}
                contactData={pageData.contact_section}
              />
            )
          : null;

      case 'charter_block':
        if (pageData?.safety_charter) {
          return wrapSection(
            sec,
            index,
            <SafetyCharterBanner charter={pageData.safety_charter} />
          );
        }
        return <ContentBlockSection key={sec.id || `sec-${index}`} section={sec} index={index} />;

      case 'blog_block':
        return wrapSection(
          sec,
          index,
          <BlogPostsSection
            eyebrow={sec.eyebrow || 'Get the latest news, offers and updates'}
            title={sec.title || 'Latest Dental & Oral Health Articles'}
            subtitle={sec.summary || sec.description || 'Clinical insights, preventive brushing advice, and community health updates.'}
            actionText={sec.cta_text || (sec as unknown as { action_btn_text?: string }).action_btn_text || 'View All'}
            actionUrl={sec.cta_link || (sec as unknown as { action_btn_url?: string }).action_btn_url || '/blog/'}
            gridCols={(sec as unknown as { grid_cols?: number }).grid_cols || 3}
          />
        );

      case 'page_snippet':
      case 'custom_content':
      default:
        return <ContentBlockSection key={sec.id || `sec-${index}`} section={sec} index={index} />;
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
      <HeaderNavBar onBookClick={(treatmentName) => handleOpenBooking(treatmentName)} />

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
