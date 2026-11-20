'use client';

import React from 'react';
import { AcocksGreenHeader } from '@/components/organisms/AcocksGreenHeader';
import { AcocksGreenHero } from '@/components/organisms/AcocksGreenHero';
import { AcocksGreenServices } from '@/components/organisms/AcocksGreenServices';
import { AcocksGreenAbout } from '@/components/organisms/AcocksGreenAbout';
import { AcocksGreenTeam } from '@/components/organisms/AcocksGreenTeam';
import { AcocksGreenReviews } from '@/components/organisms/AcocksGreenReviews';
import { AcocksGreenSafetyCharter } from '@/components/organisms/AcocksGreenSafetyCharter';
import { AcocksGreenContact } from '@/components/organisms/AcocksGreenContact';
import { AcocksGreenFooter } from '@/components/organisms/AcocksGreenFooter';
import { MobileAppNavBar } from '@/components/organisms/MobileAppNavBar';

import { CmsPageContent } from '@/services/cms.service';

interface AcocksGreenTemplateProps {
  content?: CmsPageContent | null;
  onOpenBooking: (serviceId?: number) => void;
  onOpenEmergency: () => void;
}

export const AcocksGreenTemplate: React.FC<AcocksGreenTemplateProps> = ({
  content,
  onOpenBooking,
  onOpenEmergency,
}) => {
  const heroData = content?.hero ? (content.hero as any) : {
    eyebrow: content?.eyebrow,
    headline: content?.headline,
    subtitle: content?.subtitle,
  };

  return (
    <div className="flex flex-col min-h-[100dvh] bg-surface text-on-surface">
      {/* Top Navbar with Acocks Green Medical Practice Theme */}
      <AcocksGreenHeader
        onOpenBooking={() => onOpenBooking()}
        onOpenEmergency={onOpenEmergency}
      />

      <main className="flex-1 pt-28 pb-20 xl:pb-0 bg-surface">
        {/* ========================================================
            PHASE 2: ACOCKS GREEN HERO & STATS SECTION
            ======================================================== */}
        <AcocksGreenHero
          data={heroData}
          onOpenBooking={() => onOpenBooking()}
          onOpenEmergency={onOpenEmergency}
        />

        {/* ========================================================
            PHASE 3: ACOCKS GREEN SERVICES GRID & ABOUT OUR SURGERY
            ======================================================== */}
        <AcocksGreenServices
          data={content?.services as any}
          onOpenBooking={onOpenBooking}
        />

        <AcocksGreenAbout
          content={{
            badge: (content?.about as any)?.badge,
            headline: (content?.about as any)?.headline,
            subtitle: (content?.about as any)?.subtitle,
            director: (content?.director || (content?.about as any)?.director) as any,
            clinical_pillars: content?.clinical_pillars as any,
          }}
          onOpenBooking={onOpenBooking}
        />

        {/* ========================================================
            PHASE 4: ACOCKS GREEN CLINICAL TEAM & NURSING STRIP
            ======================================================== */}
        <AcocksGreenTeam
          data={content?.team as any}
          onOpenBooking={onOpenBooking}
        />

        {/* ========================================================
            PHASE 4: PATIENT REVIEWS & SOCIAL PROOF
            ======================================================== */}
        <AcocksGreenReviews
          data={content?.reviews as any}
        />

        {/* ========================================================
            PHASE 4: NHS SEXUAL SAFETY CHARTER & PATIENT PROTECTION
            ======================================================== */}
        <AcocksGreenSafetyCharter
          data={content?.charter as any}
        />

        {/* ========================================================
            PHASE 5: PRACTICE LOCATION, OPENING HOURS & INTERACTIVE MAP
            ======================================================== */}
        <AcocksGreenContact
          data={(content?.contact || content?.consultation_cta) as any}
          onOpenBooking={() => onOpenBooking()}
        />
      </main>

      {/* Comprehensive Acocks Green NHS & Private Practice Footer */}
      <AcocksGreenFooter
        onOpenBooking={() => onOpenBooking()}
        onOpenEmergency={onOpenEmergency}
      />

      {/* App-like Sticky Mobile Bottom Navigation Bar */}
      <MobileAppNavBar
        onOpenBooking={() => onOpenBooking()}
        onOpenEmergency={onOpenEmergency}
      />
    </div>
  );
};
