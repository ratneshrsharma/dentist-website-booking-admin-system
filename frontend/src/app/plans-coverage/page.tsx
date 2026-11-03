import React from 'react';
import Link from 'next/link';
import { Metadata } from 'next';
import { PageLayout } from '@/components/templates/PageLayout/PageLayout';
import styles from './page.module.scss';
import { Check } from 'lucide-react';

export const metadata: Metadata = {
  title: 'Dental Membership Plans & Insurance Coverage | Advanced Dental Clinic',
  description:
    'Affordable in-house dental savings plans with no deductibles, zero waiting periods, and comprehensive PPO insurance filing assistance.',
  keywords:
    'dental membership plans, dental insurance, affordable dental care, dental savings plan, PPO dental insurance',
};

const PLANS = [
  {
    name: 'Individual Preventive Plan',
    desc: 'Ideal for proactive individuals seeking complete annual preventive care.',
    price: '$299',
    period: '/ year',
    popular: false,
    features: [
      '2 Comprehensive Dental Examinations per year',
      '2 Professional Ultrasonic Cleanings & Polishes',
      'Full Set of Digital Low-Dose X-Rays',
      '1 Emergency Dental Exam & Radiograph',
      '15% Off All Restorative Treatments (Fillings, Crowns, RCT)',
      'Zero Waiting Periods & No Annual Maximums',
    ],
  },
  {
    name: 'Comprehensive Smile Plan',
    desc: 'Our most popular plan for adults requiring restorative or cosmetic attention.',
    price: '$449',
    period: '/ year',
    popular: true,
    features: [
      '2 Comprehensive Exams & Oral Cancer Screenings',
      '2 Professional Cleanings & Fluoride Varnishes',
      'All Required Intraoral Digital X-Rays & 3D Scan',
      '2 Free Emergency Consultations per year',
      '20% Off Implants, Veneers, Crowns & Clear Aligners',
      'Free At-Home Whitening Maintenance Kit ($150 value)',
    ],
  },
  {
    name: 'Family Wellness Membership',
    desc: 'Covering 2 adults and up to 2 children with comprehensive dental protection.',
    price: '$799',
    period: '/ year',
    popular: false,
    features: [
      'Full preventive care for 4 family members',
      'Pediatric dental exams, cleanings & fluoride varnish',
      '20% Discount on Orthodontics & Clear Aligners',
      'Priority emergency booking within 2 hours',
      'No insurance paperwork, pre-authorizations or denials',
      '10% Family loyalty discount on renewals',
    ],
  },
];

export default function PlansCoveragePage() {
  const schemaJson = {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: 'Advanced Dental Clinic Membership Plans',
    description: 'In-house dental savings membership plans with no waiting periods.',
  };

  return (
    <PageLayout
      title="Dental Membership Plans & Insurance"
      subtitle="Accessible, predictable dental care with transparent yearly savings plans, zero insurance waiting periods, and no annual maximum limits."
      badge="Transparent Financial Options"
      breadcrumbs={[{ label: 'Patient Resources' }, { label: 'Plans & Coverage' }]}
      schemaJson={schemaJson}
    >
      <div className={styles.plansContainer}>
        <div className={styles.contentWrap}>
          {/* Membership Tiers */}
          <div className={styles.pricingGrid}>
            {PLANS.map((plan, idx) => (
              <div
                key={idx}
                className={`${styles.pricingCard} ${plan.popular ? styles.featured : ''}`}
              >
                {plan.popular && <span className={styles.popularBadge}>Most Popular</span>}
                <h3>{plan.name}</h3>
                <p>{plan.desc}</p>

                <div className={styles.priceDisplay}>
                  <span className={styles.amount}>{plan.price}</span>
                  <span className={styles.period}>{plan.period}</span>
                </div>

                <ul className={styles.featureList}>
                  {plan.features.map((feat, fIdx) => (
                    <li key={fIdx}>
                      <Check size={16} />
                      <span>{feat}</span>
                    </li>
                  ))}
                </ul>

                <Link href="/contact" className={styles.selectPlanBtn}>
                  Enroll in Plan
                </Link>
              </div>
            ))}
          </div>

          {/* Insurance Information Box */}
          <div className={styles.insuranceSection}>
            <h3>Insurance Coordination & Claims Processing</h3>
            <p>
              We gladly accept all major dental PPO insurance plans including Delta Dental, Cigna, MetLife, Aetna, Guardian, and Humana. Our dedicated insurance coordinators handle all claims submission, pre-determinations, and benefit optimization on your behalf to ensure you receive maximum allowable reimbursement.
            </p>
          </div>
        </div>
      </div>
    </PageLayout>
  );
}
