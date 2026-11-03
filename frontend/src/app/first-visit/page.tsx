import React from 'react';
import { Metadata } from 'next';
import { PageLayout } from '@/components/templates/PageLayout/PageLayout';
import styles from './page.module.scss';
import { CheckCircle2 } from 'lucide-react';

export const metadata: Metadata = {
  title: 'First Visit Guide & Patient Triage | Advanced Dental Clinic',
  description:
    'Everything you need to know for your first visit: what to bring, digital check-in, 3D imaging diagnosis, and personalized consultation.',
  keywords:
    'first dental visit, new patient guide, dental check in, what to expect dentist, dental triage',
};

const VISIT_STEPS = [
  {
    step: 1,
    title: 'Paperless Digital Check-In',
    desc: 'Complete your medical and dental history online before your appointment, or use our sterile in-clinic check-in tablets in under 3 minutes.',
  },
  {
    step: 2,
    title: 'Comfortable Diagnostic 3D Imaging',
    desc: 'We capture ultra-low radiation digital radiographs and optional 3D CBCT scans to evaluate teeth, roots, and bone health without discomfort.',
  },
  {
    step: 3,
    title: 'Comprehensive Clinical & Oral Cancer Exam',
    desc: 'Your specialist performs a gentle, thorough examination of teeth, gums, jaw joints, bite mechanics, and soft tissues.',
  },
  {
    step: 4,
    title: 'Intraoral Camera Co-Diagnosis & Plan',
    desc: 'We display high-definition intraoral images on chairside monitors so you see exactly what we see, followed by a transparent, unpressured treatment roadmap.',
  },
];

const WHAT_TO_BRING = [
  'Government-issued photo identification card',
  'Dental insurance card (if utilizing PPO insurance benefits)',
  'List of current medications and medical conditions',
  'Any previous dental X-rays taken within the last 6 months (optional)',
];

export default function FirstVisitPage() {
  const schemaJson = {
    '@context': 'https://schema.org',
    '@type': 'WebPage',
    name: 'New Patient First Visit Guide',
    description: 'Guidelines and workflow for first-time dental patients.',
  };

  return (
    <PageLayout
      title="First Visit Guide & Patient Triage"
      subtitle="We understand visiting a new dental practice can be intimidating. Here is an exact step-by-step preview of what you can expect."
      badge="Welcome New Patients"
      breadcrumbs={[{ label: 'Patient Resources' }, { label: 'First Visit Guide' }]}
      schemaJson={schemaJson}
    >
      <div className={styles.firstVisitContainer}>
        <div className={styles.contentWrap}>
          <div className={styles.introCard}>
            <h2>A Relaxing, Judgment-Free Dental Experience</h2>
            <p>
              Whether it has been 6 months or 6 years since your last dental visit, our team is here to support you without judgment. We focus on listening to your goals, relieving any immediate discomfort, and helping you achieve a healthy smile at your own pace.
            </p>
          </div>

          {/* Steps */}
          <div className={styles.stepsTimeline}>
            {VISIT_STEPS.map((st) => (
              <div key={st.step} className={styles.stepRow}>
                <div className={styles.stepCircle}>{st.step}</div>
                <div className={styles.stepCard}>
                  <h3>{st.title}</h3>
                  <p>{st.desc}</p>
                </div>
              </div>
            ))}
          </div>

          {/* What to Bring */}
          <div className={styles.introCard}>
            <h2>What to Bring to Your First Appointment</h2>
            <div className={styles.checklistGrid}>
              {WHAT_TO_BRING.map((item, idx) => (
                <div key={idx} className={styles.checkItem}>
                  <CheckCircle2 size={18} />
                  <span>{item}</span>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </PageLayout>
  );
}
