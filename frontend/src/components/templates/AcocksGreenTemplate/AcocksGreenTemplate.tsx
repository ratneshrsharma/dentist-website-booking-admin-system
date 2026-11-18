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

interface AcocksGreenTemplateProps {
  onOpenBooking: (serviceId?: number) => void;
  onOpenEmergency: () => void;
}

export const AcocksGreenTemplate: React.FC<AcocksGreenTemplateProps> = ({
  onOpenBooking,
  onOpenEmergency,
}) => {
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
          onOpenBooking={() => onOpenBooking()}
          onOpenEmergency={onOpenEmergency}
        />

        {/* ========================================================
            PHASE 3: ACOCKS GREEN SERVICES GRID & ABOUT OUR SURGERY
            ======================================================== */}
        <AcocksGreenServices onOpenBooking={onOpenBooking} />

        <AcocksGreenAbout onOpenBooking={onOpenBooking} />

        {/* ========================================================
            PHASE 4: ACOCKS GREEN CLINICAL TEAM & NURSING STRIP
            ======================================================== */}
        <AcocksGreenTeam onOpenBooking={onOpenBooking} />

        {/* ========================================================
            PHASE 4: PATIENT REVIEWS & SOCIAL PROOF
            ======================================================== */}
        <AcocksGreenReviews />

        {/* ========================================================
            PHASE 4: NHS SEXUAL SAFETY CHARTER & PATIENT PROTECTION
            ======================================================== */}
        <AcocksGreenSafetyCharter />

        {/* ========================================================
            PHASE 5: PRACTICE LOCATION, OPENING HOURS & INTERACTIVE MAP
            ======================================================== */}
        <AcocksGreenContact onOpenBooking={() => onOpenBooking()} />
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
