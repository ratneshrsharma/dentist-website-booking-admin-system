'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import styles from './PageLayout.module.scss';
import { Navbar } from '@/components/organisms/Navbar/Navbar';
import { Footer } from '@/components/organisms/Footer/Footer';
import { BookingWizard } from '@/components/organisms/BookingWizard/BookingWizard';
import { WhatsAppHub } from '@/components/ui/WhatsAppHub/WhatsAppHub';
import { ChevronRight } from 'lucide-react';

export interface BreadcrumbItem {
  label: string;
  href?: string;
}

export interface PageLayoutProps {
  children: React.ReactNode;
  title: string;
  subtitle?: string;
  breadcrumbs?: BreadcrumbItem[];
  badge?: string;
  schemaJson?: Record<string, unknown>;
  customCss?: string;
  customJs?: string;
}

export const PageLayout: React.FC<PageLayoutProps> = ({
  children,
  title,
  subtitle,
  breadcrumbs = [],
  badge,
  schemaJson,
  customCss,
  customJs,
}) => {
  const [bookingOpen, setBookingOpen] = useState(false);

  return (
    <div className={styles.pageWrapper}>
      {/* Dynamic SEO JSON-LD Structured Data Schema */}
      {schemaJson && (
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(schemaJson) }}
        />
      )}

      {/* Per-Page Custom Injected CSS from Admin Panel */}
      {customCss && (
        <style dangerouslySetInnerHTML={{ __html: customCss }} />
      )}

      {/* Main Navbar with Mega-Dropdowns */}
      <Navbar onOpenBooking={() => setBookingOpen(true)} />

      {/* Page Hero Header */}
      <section className={styles.pageHero}>
        <div className={styles.heroContainer}>
          {breadcrumbs.length > 0 && (
            <nav className={styles.breadcrumbNav} aria-label="Breadcrumbs">
              <Link href="/" className={styles.crumbLink}>
                Home
              </Link>
              {breadcrumbs.map((crumb, idx) => (
                <React.Fragment key={idx}>
                  <ChevronRight size={14} className={styles.crumbSep} />
                  {crumb.href ? (
                    <Link href={crumb.href} className={styles.crumbLink}>
                      {crumb.label}
                    </Link>
                  ) : (
                    <span className={styles.crumbActive}>{crumb.label}</span>
                  )}
                </React.Fragment>
              ))}
            </nav>
          )}

          {badge && <span className={styles.heroBadge}>{badge}</span>}
          <h1 className={styles.heroTitle}>{title}</h1>
          {subtitle && <p className={styles.heroSubtitle}>{subtitle}</p>}
        </div>
      </section>

      {/* Page Body */}
      <main className={styles.mainContent}>{children}</main>

      {/* Global Footer */}
      <Footer />

      {/* Floating WhatsApp Action Hub */}
      <WhatsAppHub onOpenBooking={() => setBookingOpen(true)} />

      {/* 5-Step Real-Time Booking Wizard */}
      <BookingWizard isOpen={bookingOpen} onClose={() => setBookingOpen(false)} />

      {/* Per-Page Custom Injected JS (Before Body Close) */}
      {customJs && (
        <script dangerouslySetInnerHTML={{ __html: customJs }} />
      )}
    </div>
  );
};
