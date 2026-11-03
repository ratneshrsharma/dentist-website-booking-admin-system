import React from 'react';
import Image from 'next/image';
import { Metadata } from 'next';
import { PageLayout } from '@/components/templates/PageLayout/PageLayout';
import { TREATMENTS_REGISTRY, getTreatmentBySlug } from '@/data/treatments';
import styles from './page.module.scss';
import {
  CheckCircle2,
  Clock,
  HeartPulse,
  DollarSign,
  HelpCircle,
  ListOrdered,
  Calendar,
  MessageSquare,
  Phone,
} from 'lucide-react';

interface TreatmentPageProps {
  params: Promise<{ slug: string }>;
}

export async function generateStaticParams() {
  return Object.keys(TREATMENTS_REGISTRY).map((slug) => ({
    slug,
  }));
}

export async function generateMetadata({ params }: TreatmentPageProps): Promise<Metadata> {
  const { slug } = await params;
  const treatment = getTreatmentBySlug(slug);

  return {
    title: treatment.seo.metaTitle,
    description: treatment.seo.metaDescription,
    keywords: treatment.seo.keywords,
    openGraph: {
      title: treatment.seo.metaTitle,
      description: treatment.seo.metaDescription,
      images: [{ url: treatment.heroImage, width: 1200, height: 630, alt: treatment.title }],
      type: 'article',
    },
    twitter: {
      card: 'summary_large_image',
      title: treatment.seo.metaTitle,
      description: treatment.seo.metaDescription,
      images: [treatment.heroImage],
    },
  };
}

export default async function TreatmentDetailPage({ params }: TreatmentPageProps) {
  const { slug } = await params;
  const treatment = getTreatmentBySlug(slug);

  const schemaJson = {
    '@context': 'https://schema.org',
    '@type': 'MedicalProcedure',
    name: treatment.title,
    description: treatment.overview,
    procedureType: 'NoninvasiveProcedure',
    bodyLocation: 'Mouth / Teeth',
    relevantSpecialty: {
      '@type': 'MedicalSpecialty',
      name: treatment.category,
    },
    provider: {
      '@type': 'Dentist',
      name: 'Advanced Dental Clinic',
      telephone: '+1 (800) 555-DENT',
      priceRange: '$$$',
    },
  };

  return (
    <PageLayout
      title={treatment.title}
      subtitle={treatment.subtitle}
      badge={treatment.category}
      breadcrumbs={[
        { label: 'Treatments & Procedures', href: '/treatments' },
        { label: treatment.title },
      ]}
      schemaJson={schemaJson}
    >
      <section className={styles.detailContainer}>
        <div className={styles.contentWrap}>
          {/* Main Column */}
          <div className={styles.mainColumn}>
            {/* Hero Image */}
            <div className={styles.heroImageWrap}>
              <Image
                src={treatment.heroImage}
                alt={treatment.title}
                fill
                priority
                sizes="(max-width: 768px) 100vw, 800px"
              />
            </div>

            {/* Clinical Overview */}
            <div className={styles.overviewSection}>
              <h2 className={styles.sectionHeading}>
                <HeartPulse size={24} /> Clinical Overview & Approach
              </h2>
              <p className={styles.overviewText}>{treatment.overview}</p>
            </div>

            {/* Key Clinical Benefits */}
            <div className={styles.overviewSection}>
              <h3 className={styles.sectionHeading}>Key Clinical Benefits</h3>
              <div className={styles.benefitsGrid}>
                {treatment.benefits.map((benefit, idx) => (
                  <div key={idx} className={styles.benefitCard}>
                    <CheckCircle2 size={18} />
                    <span>{benefit}</span>
                  </div>
                ))}
              </div>
            </div>

            {/* Step-by-Step Procedure Timeline */}
            <div className={styles.timelineWrapper}>
              <h3 className={styles.sectionHeading}>
                <ListOrdered size={24} /> Step-by-Step Treatment Procedure
              </h3>
              <div className={styles.stepsList}>
                {treatment.procedureSteps.map((step) => (
                  <div key={step.step} className={styles.stepItem}>
                    <div className={styles.stepNumber}>{step.step}</div>
                    <div className={styles.stepContent}>
                      <h4>{step.title}</h4>
                      <p>{step.description}</p>
                    </div>
                  </div>
                ))}
              </div>
            </div>

            {/* FAQs */}
            {treatment.faqs.length > 0 && (
              <div className={styles.faqsSection}>
                <h3 className={styles.sectionHeading}>
                  <HelpCircle size={24} /> Frequently Asked Questions
                </h3>
                {treatment.faqs.map((faq, idx) => (
                  <div key={idx} className={styles.faqItem}>
                    <h4>{faq.question}</h4>
                    <p>{faq.answer}</p>
                  </div>
                ))}
              </div>
            )}
          </div>

          {/* Sticky Sidebar */}
          <aside className={styles.sidebarColumn}>
            <div className={styles.quickFactsCard}>
              <h3>Treatment Snapshot</h3>

              <div className={styles.factRow}>
                <Clock size={20} />
                <div className={styles.factMeta}>
                  <small>Procedure Duration</small>
                  <strong>{treatment.duration}</strong>
                </div>
              </div>

              <div className={styles.factRow}>
                <HeartPulse size={20} />
                <div className={styles.factMeta}>
                  <small>Expected Recovery</small>
                  <strong>{treatment.recoveryTime}</strong>
                </div>
              </div>

              <div className={styles.factRow}>
                <DollarSign size={20} />
                <div className={styles.factMeta}>
                  <small>Estimated Investment</small>
                  <strong>{treatment.costEstimate}</strong>
                </div>
              </div>

              <a
                href={`https://wa.me/18005553368?text=${encodeURIComponent(
                  `Hi Advanced Dental Clinic, I would like to book a consultation for ${treatment.title}.`
                )}`}
                target="_blank"
                rel="noopener noreferrer"
                className={styles.whatsappButton}
              >
                <MessageSquare size={16} /> Instant WhatsApp Triage
              </a>

              <a
                href="/contact"
                className={styles.bookButton}
              >
                <Calendar size={18} /> Schedule In-Person Visit
              </a>

              <div className={styles.phoneCallBox}>
                <Phone size={14} /> Questions? Call{' '}
                <a href="tel:+18005553368">+1 (800) 555-DENT</a>
              </div>
            </div>
          </aside>
        </div>
      </section>
    </PageLayout>
  );
}
