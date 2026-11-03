import React from 'react';
import Image from 'next/image';
import { Metadata } from 'next';
import { PageLayout } from '@/components/templates/PageLayout/PageLayout';
import styles from './page.module.scss';
import { ShieldCheck, HeartHandshake, Microscope } from 'lucide-react';

export const metadata: Metadata = {
  title: 'About Our Practice & Clinical Philosophy | Advanced Dental Clinic',
  description:
    'Discover our patient-first clinical philosophy, hospital-grade sterilization protocols, and multi-specialty dental expertise modeled on American dental benchmarks.',
  keywords:
    'dental clinic about us, dental philosophy, sterile dental facility, multi-specialty dentistry, American dental standards',
};

export default function AboutUsPage() {
  const schemaJson = {
    '@context': 'https://schema.org',
    '@type': 'Dentist',
    name: 'Advanced Dental Clinic',
    description: 'Premier multi-specialty dental practice delivering American standard dental care.',
    foundingDate: '2008',
    telephone: '+1 (800) 555-DENT',
  };

  return (
    <PageLayout
      title="The Practice & Philosophy"
      subtitle="Founded on clinical excellence, ethical dentistry, and compassionate patient care with hospital-grade American sterilization standards."
      badge="About Advanced Dental Clinic"
      breadcrumbs={[{ label: 'About Us', href: '/about-us' }, { label: 'The Practice & Philosophy' }]}
      schemaJson={schemaJson}
    >
      <div className={styles.aboutContainer}>
        <div className={styles.contentWrap}>
          {/* Section 1: Intro Story */}
          <section className={styles.twoColSection}>
            <div className={styles.textContent}>
              <h2>Redefining Modern Dentistry Through Compassion & Precision</h2>
              <p>
                At Advanced Dental Clinic, we believe dental visits should be empowering, painless, and completely transparent. Founded over 16 years ago, our practice has grown into a premier multi-specialty dental center providing comprehensive care under one roof.
              </p>
              <p>
                From routine preventive hygiene to complex full-mouth implant rehabilitations, our team integrates cutting-edge digital diagnostics with individualized patient comfort protocols to ensure your smile receives the highest level of care.
              </p>
            </div>
            <div className={styles.imageWrap}>
              <Image
                src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1200&q=80"
                alt="Modern clinical operatory suite"
                fill
                priority
                sizes="(max-width: 768px) 100vw, 600px"
              />
            </div>
          </section>

          {/* Stats Bar */}
          <div className={styles.statsGrid}>
            <div className={styles.statItem}>
              <span className={styles.statValue}>18,500+</span>
              <span className={styles.statLabel}>Happy Smiles Restored</span>
            </div>
            <div className={styles.statItem}>
              <span className={styles.statValue}>16+</span>
              <span className={styles.statLabel}>Years of Clinical Excellence</span>
            </div>
            <div className={styles.statItem}>
              <span className={styles.statValue}>99.4%</span>
              <span className={styles.statLabel}>Patient Satisfaction Score</span>
            </div>
            <div className={styles.statItem}>
              <span className={styles.statValue}>Zero-Pain</span>
              <span className={styles.statLabel}>Computerized Anesthesia Protocol</span>
            </div>
          </div>

          {/* Section 2: Clinical Ethics & Safety */}
          <section className={`${styles.twoColSection} ${styles.reversed}`}>
            <div className={styles.textContent}>
              <h2>Strict American Hospital-Grade Sterilization (OSHA & CDC Certified)</h2>
              <p>
                Patient safety is our uncompromised top priority. Our sterilization facility features Class-B medical autoclaves, negative-pressure operatory air filtration, and strict single-use disposables wherever feasible.
              </p>
              <p>
                Every reusable instrument undergoes a 6-stage biological monitoring sterilization process sealed in color-changing indicator pouches, opened exclusively in front of the patient.
              </p>
            </div>
            <div className={styles.imageWrap}>
              <Image
                src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=1200&q=80"
                alt="Sterile surgical clinical equipment"
                fill
                sizes="(max-width: 768px) 100vw, 600px"
              />
            </div>
          </section>

          {/* Core Values */}
          <section>
            <div className={styles.valuesGrid}>
              <div className={styles.valueCard}>
                <div className={styles.iconCircle}>
                  <ShieldCheck size={24} />
                </div>
                <h3>Ethical & Honest Diagnosis</h3>
                <p>
                  We treat only what is clinically necessary. With intraoral cameras, we show you exactly what we see before formulating any treatment plan.
                </p>
              </div>

              <div className={styles.valueCard}>
                <div className={styles.iconCircle}>
                  <HeartHandshake size={24} />
                </div>
                <h3>Compassionate Anxiety-Free Care</h3>
                <p>
                  Dental anxiety is real, and we respect your comfort. We offer soothing amenities, warm blankets, noise-canceling headphones, and gentle sedation options.
                </p>
              </div>

              <div className={styles.valueCard}>
                <div className={styles.iconCircle}>
                  <Microscope size={24} />
                </div>
                <h3>Digital First Dentistry</h3>
                <p>
                  From low-dose 3D CBCT scanners to digital intraoral impressions, we eliminate uncomfortable physical molds and deliver millimeter-level accuracy.
                </p>
              </div>
            </div>
          </section>
        </div>
      </div>
    </PageLayout>
  );
}
