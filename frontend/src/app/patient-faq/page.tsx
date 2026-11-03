import React from 'react';
import Link from 'next/link';
import { Metadata } from 'next';
import { PageLayout } from '@/components/templates/PageLayout/PageLayout';
import styles from './page.module.scss';
import { ArrowRight } from 'lucide-react';

export const metadata: Metadata = {
  title: 'Patient FAQs & Dental Advice | Advanced Dental Clinic',
  description:
    'Find detailed answers to common patient questions regarding pain management, dental implant longevity, root canal recovery, clear aligner wear, and insurance coverage.',
  keywords:
    'dental FAQs, dentist questions, is root canal painful, dental implant recovery, clear aligner FAQs, dental insurance',
};

const FAQ_SECTIONS = [
  {
    category: 'General & Anxiety-Free Care',
    items: [
      {
        question: 'Will my dental procedure hurt?',
        answer:
          'No. We utilize computerized local anesthesia delivery systems, topical numbing gels, and optional conscious sedation. Most of our patients report feeling virtually nothing during procedures.',
      },
      {
        question: 'How often do I realistically need to visit the dentist?',
        answer:
          'The American Dental Association recommends a professional cleaning and examination every six months. Patients with active gum disease or orthodontic appliances may benefit from 3-to-4 month recall intervals.',
      },
    ],
  },
  {
    category: 'Dental Implants & Restorative Treatments',
    items: [
      {
        question: 'How long do dental implants last?',
        answer:
          'With proper home hygiene and bi-annual dental check-ups, dental implants are designed to last a lifetime, boasting a documented long-term clinical success rate exceeding 95%.',
      },
      {
        question: 'Can I get dental implants if I have bone loss?',
        answer:
          'Yes. Using 3D CBCT scans, we can evaluate your bone density. In cases of bone deficiency, we perform gentle bone grafting, sinus lifts, or utilize All-on-4 tilted implant protocols.',
      },
    ],
  },
  {
    category: 'Cosmetic Dentistry & Clear Aligners',
    items: [
      {
        question: 'How many hours per day do I have to wear clear aligners?',
        answer:
          'For optimal orthodontic results and predictable tooth movement, clear aligner trays must be worn between 20 and 22 hours per day, removing them only to eat, drink hot beverages, and brush.',
      },
      {
        question: 'Do porcelain veneers ruin your natural teeth?',
        answer:
          'No. Modern ultra-thin porcelain veneers require only conservative microscopic enamel contouring (often 0.3mm to 0.5mm), leaving the core tooth structure intact and healthy.',
      },
    ],
  },
  {
    category: 'Insurance, Payments & Warranty',
    items: [
      {
        question: 'Do you accept dental insurance?',
        answer:
          'Yes. We accept and file claims with all major PPO dental insurance providers. Our financial coordinators perform complimentary insurance benefit verifications prior to treatment.',
      },
      {
        question: 'What if I do not have dental insurance?',
        answer:
          'We offer an In-House Dental Savings Membership Plan that includes cleanings, exams, X-rays, and 20% discounts on all restorative and cosmetic treatments with zero waiting periods.',
      },
    ],
  },
];

export default function PatientFaqPage() {
  const schemaJson = {
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: FAQ_SECTIONS.flatMap((sec) =>
      sec.items.map((item) => ({
        '@type': 'Question',
        name: item.question,
        acceptedAnswer: {
          '@type': 'Answer',
          text: item.answer,
        },
      }))
    ),
  };

  return (
    <PageLayout
      title="Patient FAQs & Dental Advice"
      subtitle="Clear, honest answers to the most common questions our clinical team receives regarding procedures, discomfort, recovery, and payment options."
      badge="Knowledge Base"
      breadcrumbs={[{ label: 'Patient Resources' }, { label: 'Patient FAQs' }]}
      schemaJson={schemaJson}
    >
      <div className={styles.faqContainer}>
        <div className={styles.contentWrap}>
          {FAQ_SECTIONS.map((section, sIdx) => (
            <div key={sIdx} className={styles.categoryBlock}>
              <h2>{section.category}</h2>
              {section.items.map((faq, fIdx) => (
                <div key={fIdx} className={styles.faqItem}>
                  <h3>{faq.question}</h3>
                  <p>{faq.answer}</p>
                </div>
              ))}
            </div>
          ))}

          {/* CTA Box */}
          <div className={styles.ctaBox}>
            <h3>Have a Question Not Answered Here?</h3>
            <p>
              Our clinical triage coordinators are available to answer your questions or review your treatment options.
            </p>
            <Link href="/contact" className={styles.ctaBtn}>
              <span>Contact Clinical Team</span>
              <ArrowRight size={16} />
            </Link>
          </div>
        </div>
      </div>
    </PageLayout>
  );
}
