import React from 'react';
import Image from 'next/image';
import { Metadata } from 'next';
import { PageLayout } from '@/components/templates/PageLayout/PageLayout';
import styles from './page.module.scss';
import { Cpu, CheckCircle2 } from 'lucide-react';

export const metadata: Metadata = {
  title: 'Advanced Dental Technology & 3D Imaging | Advanced Dental Clinic',
  description:
    'Experience digital dentistry with low-radiation 3D CBCT imaging, intraoral optical scanners, computerized surgical guides, and painless laser dentistry.',
  keywords:
    'dental technology, 3D CBCT scans, intraoral scanners, digital dentistry, dental laser, computer guided surgery',
};

const TECH_EQUIPMENT = [
  {
    badge: '3D Radiographic Precision',
    title: 'Ultra-Low Dose Cone Beam 3D CT (CBCT)',
    description:
      'Unlike conventional 2D flat X-rays, our high-definition 3D CBCT provides a full volumetric rendering of teeth, bone density, sinus cavities, and nerve pathways with up to 80% lower radiation than hospital medical CT scans.',
    image: 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1200&q=80',
    benefits: [
      'Identifies micro-fractures and hidden nerve canals impossible to see on 2D films',
      'Essential for safe, sub-millimeter dental implant placement',
      'Fast 14-second scan with zero claustrophobia',
    ],
  },
  {
    badge: 'Zero-Mess Digital Impressions',
    title: 'Intraoral 3D Optical Scanner (No Gooey Trays)',
    description:
      'Say goodbye to uncomfortable, gag-inducing impression paste. Our handheld intraoral digital scanner captures 6,000 frames per second, generating an exact high-fidelity 3D digital model of your teeth in under two minutes.',
    image: 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=1200&q=80',
    benefits: [
      '100% gag-free, comfortable digital scan experience',
      'Immediate onscreen simulation of your straightened teeth and smile',
      'Instant cloud transfer to master dental labs for rapid crown and aligner turnaround',
    ],
  },
  {
    badge: 'Micro-Invasive Surgical Laser',
    title: 'Dual-Wavelength Dental Soft Tissue Laser',
    description:
      'Our dental lasers allow for painless treatment of gum disease, aesthetic gum recontouring, and oral lesions without scalpels, bleeding, or sutures. The concentrated light beam sterilizes the surgical field instantly and accelerates tissue healing.',
    image: 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=1200&q=80',
    benefits: [
      'Virtually bloodless and stitch-free gum treatments',
      'Significantly reduced post-operative swelling and discomfort',
      'Targets harmful periodontal bacteria without harming healthy gums',
    ],
  },
  {
    badge: 'Microscopic Endodontic Care',
    title: 'High-Magnification Surgical Operating Microscopes',
    description:
      'With up to 25x magnification and shadowless coaxial LED illumination, our surgical microscopes allow our endodontic specialists to see anatomical details invisible to the naked eye, ensuring unprecedented success rates in root canal therapies.',
    image: 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1200&q=80',
    benefits: [
      'Locates calcified or accessory root canals that cause recurrent infections',
      'Preserves maximum healthy tooth enamel through conservative micro-access',
      'Assures complete seal and long-term tooth preservation',
    ],
  },
];

export default function TechnologyPage() {
  const schemaJson = {
    '@context': 'https://schema.org',
    '@type': 'MedicalBusiness',
    name: 'Advanced Dental Clinic Technology Suite',
    description: 'Equipped with 3D CBCT, intraoral scanners, and dental surgical lasers.',
  };

  return (
    <PageLayout
      title="Technology & 3D Imaging"
      subtitle="Invested in state-of-the-art digital dentistry to deliver millimeter-level surgical precision, painless procedures, and exceptional patient comfort."
      badge="Cutting-Edge Infrastructure"
      breadcrumbs={[{ label: 'About Us', href: '/about-us' }, { label: 'Technology' }]}
      schemaJson={schemaJson}
    >
      <div className={styles.techContainer}>
        <div className={styles.contentWrap}>
          <div className={styles.introBlock}>
            <h2>Why Modern Technology Matters for Your Smile</h2>
            <p>
              Digital technology in dentistry is not just about gadgets; it directly translates to less time in the dental chair, zero discomfort, faster healing times, and restorations that fit seamlessly on the very first try.
            </p>
          </div>

          <div className={styles.techList}>
            {TECH_EQUIPMENT.map((tech, idx) => (
              <div
                key={idx}
                className={`${styles.techItem} ${idx % 2 === 1 ? styles.reversed : ''}`}
              >
                <div className={styles.techImageWrap}>
                  <Image
                    src={tech.image}
                    alt={tech.title}
                    fill
                    sizes="(max-width: 768px) 100vw, 600px"
                  />
                </div>

                <div className={styles.techContent}>
                  <span className={styles.techBadge}>
                    <Cpu size={14} /> {tech.badge}
                  </span>
                  <h3>{tech.title}</h3>
                  <p>{tech.description}</p>

                  <div className={styles.techBenefits}>
                    {tech.benefits.map((point, pIdx) => (
                      <div key={pIdx} className={styles.benefitPoint}>
                        <CheckCircle2 size={16} />
                        <span>{point}</span>
                      </div>
                    ))}
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </PageLayout>
  );
}
