import React from 'react';
import Link from 'next/link';
import { Metadata } from 'next';
import { PageLayout } from '@/components/templates/PageLayout/PageLayout';
import { MAIN_NAVIGATION } from '@/data/navigation';
import styles from './page.module.scss';
import { Sparkles, ArrowRight, ShieldCheck } from 'lucide-react';

export const metadata: Metadata = {
  title: 'Treatments & Clinical Specialties | Advanced Dental Clinic',
  description:
    'Explore our comprehensive range of US-standard dental treatments including computer guided implants, clear aligners, painless root canals, and cosmetic smile makeovers.',
  keywords:
    'dental treatments, dental implants, cosmetic dentistry, root canal, teeth whitening, clear aligners',
  openGraph: {
    title: 'Treatments & Clinical Specialties | Advanced Dental Clinic',
    description:
      'US-standard dental care with computer-guided surgical precision, digital dentistry, and painless treatment protocols.',
    url: 'https://advanced-dental-clinic-demo.vercel.app/treatments',
    siteName: 'Advanced Dental Clinic',
    type: 'website',
  },
};

export default function TreatmentsPage() {
  const treatmentsNav = MAIN_NAVIGATION.find((n) => n.label === 'Treatments & Procedures');
  const categories = treatmentsNav?.categories || [];

  const schemaJson = {
    '@context': 'https://schema.org',
    '@type': 'MedicalBusiness',
    name: 'Advanced Dental Clinic',
    url: 'https://advanced-dental-clinic-demo.vercel.app/treatments',
    description: 'Comprehensive dental specialties and restorative treatments.',
    department: categories.map((cat) => ({
      '@type': 'MedicalSpecialty',
      name: cat.category,
      description: cat.description,
    })),
  };

  return (
    <PageLayout
      title="Dental Treatments & Procedures"
      subtitle="Explore our full spectrum of specialized dental solutions, from computer-guided implants to painless restorative care."
      badge="Comprehensive Clinical Care"
      breadcrumbs={[{ label: 'Treatments & Procedures' }]}
      schemaJson={schemaJson}
    >
      <section className={styles.sectionContainer}>
        <div className={styles.contentWrap}>
          {categories.map((cat, idx) => (
            <div key={idx} className={styles.categoryBlock}>
              <div className={styles.categoryHeader}>
                <div className={styles.badgeRow}>
                  <span className={styles.categoryNumber}>Pillar 0{idx + 1}</span>
                  <span className={styles.clinicalTrustBadge}>
                    <ShieldCheck size={14} /> Certified American Clinical Protocol
                  </span>
                </div>
                <h2>{cat.category}</h2>
                {cat.description && <p>{cat.description}</p>}
              </div>

              <div className={styles.treatmentCardsGrid}>
                {cat.items.map((treatment) => (
                  <Link key={treatment.href} href={treatment.href} className={styles.treatmentCard}>
                    <div className={styles.cardHeader}>
                      <div className={styles.iconCircle}>
                        <Sparkles size={18} />
                      </div>
                      {treatment.badge && (
                        <span className={styles.cardBadge}>{treatment.badge}</span>
                      )}
                    </div>
                    <h3>{treatment.label}</h3>
                    <p>{treatment.description}</p>
                    <div className={styles.cardAction}>
                      <span>Explore Procedure & Costs</span>
                      <ArrowRight size={14} />
                    </div>
                  </Link>
                ))}
              </div>
            </div>
          ))}
        </div>
      </section>
    </PageLayout>
  );
}
