'use client';

import React, { useEffect, useState } from 'react';
import { HomePageData } from '@/types/cms';
import { CmsService } from '@/api/cms';

// Atomic & Reusable Layout Components
import { HeaderTopBar } from '@/components/layout/HeaderTopBar/HeaderTopBar';
import { HeaderNavBar } from '@/components/layout/HeaderNavBar/HeaderNavBar';
import { Footer } from '@/components/layout/Footer/Footer';

// Banners & Selectors
import { HeroBanner } from '@/components/banners/HeroBanner/HeroBanner';
import { BookingQuickBar } from '@/components/banners/BookingQuickBar/BookingQuickBar';

// Content Sections
import { ServicesGrid4x3 } from '@/components/sections/ServicesGrid4x3/ServicesGrid4x3';
import { AboutOurTeam } from '@/components/sections/AboutOurTeam/AboutOurTeam';
import { DoctorsGrid } from '@/components/sections/DoctorsGrid/DoctorsGrid';
import { TestimonialsSlider } from '@/components/sections/TestimonialsSlider/TestimonialsSlider';
import { SafetyCharterBanner } from '@/components/sections/SafetyCharterBanner/SafetyCharterBanner';
import { ClinicAddressAndContact } from '@/components/sections/ClinicAddressAndContact/ClinicAddressAndContact';

// Interactive Booking Modal
import { BookingModal } from '@/components/common/BookingModal/BookingModal';

export default function HomePage() {
  const [pageData, setPageData] = useState<HomePageData | null>(null);
  const [loading, setLoading] = useState(true);
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

        {/* 5. Categorized Practice Services Grid */}
        <ServicesGrid4x3
          eyebrow={pageData?.services_intro?.eyebrow}
          title={pageData?.services_intro?.title}
          subtitle={pageData?.services_intro?.subtitle}
          services={pageData?.featured_services}
          isLoading={loading}
        />

        {/* 6. About Surgery & Compassionate Care Story */}
        {pageData?.about_summary && (
          <AboutOurTeam about={pageData.about_summary} />
        )}

        {/* 7. Dedicated Clinicians & Dental Surgeons */}
        <DoctorsGrid
          clinicians={pageData?.clinicians}
          supportTeam={pageData?.support_team}
          practiceManager={pageData?.practice_manager}
        />

        {/* 8. Patient Feedback & Google Reviews */}
        {pageData?.reviews && (
          <TestimonialsSlider reviewsData={pageData.reviews} />
        )}

        {/* 9. NHS Sexual Safety Charter Banner */}
        {pageData?.safety_charter && (
          <SafetyCharterBanner charter={pageData.safety_charter} />
        )}

        {/* 10. Clinic Opening Hours & Map Preview */}
        {pageData?.contact_section && (
          <ClinicAddressAndContact contactData={pageData.contact_section} />
        )}
      </main>

      {/* 11. Practice Global Footer */}
      <Footer />

      {/* 12. Interactive Booking Drawer Modal */}
      <BookingModal
        isOpen={isBookingOpen}
        onClose={() => setIsBookingOpen(false)}
        initialTreatment={bookingPref.treatment}
        initialDate={bookingPref.date}
      />
    </div>
  );
}
