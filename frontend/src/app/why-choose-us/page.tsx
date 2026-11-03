import React from 'react';
import { Metadata } from 'next';
import { PageLayout } from '@/components/templates/PageLayout/PageLayout';
import styles from './page.module.scss';
import {
  ShieldCheck,
  Award,
  Sparkles,
  HeartHandshake,
  Clock,
  DollarSign,
  CheckCircle,
} from 'lucide-react';

export const metadata: Metadata = {
  title: 'Why Choose Us & Accreditations | Advanced Dental Clinic',
  description:
    'Discover why thousands of patients trust Advanced Dental Clinic: zero-pain computerized anesthesia, hospital-grade sterilization, transparent pricing, and board-certified specialists.',
  keywords:
    'why choose our dental clinic, accredited dental clinic, zero pain dentist, transparent dental pricing, hospital sterilization',
};

const PILLARS = [
  {
    icon: ShieldCheck,
    title: 'Hospital-Grade Sterilization Protocols',
    desc: 'CDC and OSHA compliant 6-step biological sterilization monitoring with Class-B vacuum autoclaves, HEPA air filtration, and single-use sealed kits.',
  },
  {
    icon: Sparkles,
    title: 'Zero-Pain Computerized Anesthesia',
    desc: 'Say goodbye to painful dental injections. Our computerized syringe delivers microscopic droplets at physiologic speed, ensuring you feel zero pinch.',
  },
  {
    icon: Award,
    title: 'Board-Certified Multi-Specialist Team',
    desc: 'Our clinicians are internationally trained fellows in implantology, orthodontics, and restorative dentistry with over 15 years average surgical experience.',
  },
  {
    icon: DollarSign,
    title: '100% Upfront Transparent Pricing',
    desc: 'No surprise bills or hidden fees. We provide an itemized written estimate and payment plan before starting any clinical procedure.',
  },
  {
    icon: Clock,
    title: 'Prompt On-Time Appointments',
    desc: 'We value your schedule. With digital intake and optimized scheduling, our average in-office waiting time is under 7 minutes.',
  },
  {
    icon: HeartHandshake,
    title: 'Lifetime Dental Restorations Warranty',
    desc: 'We stand behind our clinical craftsmanship with written warranty coverage on dental implants, zirconia crowns, and porcelain veneers.',
  },
];

const ACCREDITATIONS = [
  'American Dental Association (ADA) Guidelines',
  'International Congress of Oral Implantologists (ICOI)',
  'American Academy of Cosmetic Dentistry (AACD)',
  'OSHA Hospital-Grade Infection Control Certified',
  'Joint Commission International (JCI) Quality Protocols',
  'ISO 9001:2015 Clinical Quality Management',
];

export default function WhyChooseUsPage() {
  const schemaJson = {
    '@context': 'https://schema.org',
    '@type': 'Dentist',
    name: 'Advanced Dental Clinic',
    description: 'Accredited multi-specialty dental clinic delivering American standards of dental care.',
    award: ACCREDITATIONS,
  };

  return (
    <PageLayout
      title="Why Choose Advanced Dental Clinic"
      subtitle="Combining world-class clinical expertise, advanced digital dentistry, and uncompromising patient comfort standards."
      badge="The Clinical Difference"
      breadcrumbs={[{ label: 'About Us', href: '/about-us' }, { label: 'Why Choose Us' }]}
      schemaJson={schemaJson}
    >
      <div className={styles.pageContainer}>
        <div className={styles.contentWrap}>
          {/* 6 Key Pillars */}
          <div className={styles.pillarsGrid}>
            {PILLARS.map((pillar, idx) => {
              const IconComp = pillar.icon;
              return (
                <div key={idx} className={styles.pillarCard}>
                  <div className={styles.iconCircle}>
                    <IconComp size={24} />
                  </div>
                  <h3>{pillar.title}</h3>
                  <p>{pillar.desc}</p>
                </div>
              );
            })}
          </div>

          {/* Accreditations Banner */}
          <div className={styles.accreditationsBanner}>
            <h3>Certified Clinical Accreditations & Standards</h3>
            <div className={styles.badgesList}>
              {ACCREDITATIONS.map((badge, idx) => (
                <div key={idx} className={styles.badgePill}>
                  <CheckCircle size={16} />
                  <span>{badge}</span>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </PageLayout>
  );
}
