import React from 'react';
import Image from 'next/image';
import { Metadata } from 'next';
import { PageLayout } from '@/components/templates/PageLayout/PageLayout';
import styles from './page.module.scss';
import { Sparkles } from 'lucide-react';

export const metadata: Metadata = {
  title: 'Smile Gallery & Case Studies | Advanced Dental Clinic',
  description:
    'Explore verified before-and-after smile transformations, full mouth implant restorations, porcelain veneers, and clear aligner aesthetic cases.',
  keywords:
    'smile gallery, dental before after, cosmetic dentistry cases, dental implant results, veneer transformations',
};

const CASES = [
  {
    title: 'Full Arch Immediate Implant Smile Restoration',
    category: 'Dental Implants',
    description: 'Patient presented with failing bridge work and severe bone loss. Restored with All-on-4 zirconia arch in 48 hours.',
    image: 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80',
    duration: 'Treatment Time: 2 Visits',
  },
  {
    title: 'Discreet Adult Clear Aligner Orthodontics',
    category: 'Clear Aligners',
    description: 'Moderate anterior crowding and midline discrepancy corrected seamlessly without traditional metal brackets.',
    image: 'https://images.unsplash.com/photo-1598256989800-fe5f95da9787?auto=format&fit=crop&w=800&q=80',
    duration: 'Treatment Time: 9 Months',
  },
  {
    title: 'Handcrafted Porcelain Veneers Smile Makeover',
    category: 'Cosmetic Dentistry',
    description: 'Transforming tetracycline discoloration and worn incisal edges with 8 ultra-thin feldspathic porcelain veneers.',
    image: 'https://images.unsplash.com/photo-1629909615184-74f495363b67?auto=format&fit=crop&w=800&q=80',
    duration: 'Treatment Time: 10 Days',
  },
  {
    title: 'Computer Guided Single Tooth Implant',
    category: 'Dental Implants',
    description: 'Replacement of a fractured central incisor with a custom titanium abutment and color-matched zirconia crown.',
    image: 'https://images.unsplash.com/photo-1606811841689-23dfddce6395?auto=format&fit=crop&w=800&q=80',
    duration: 'Treatment Time: 3 Months',
  },
  {
    title: 'Microscopic Root Canal & Monolithic Zirconia Crown',
    category: 'Restorative Care',
    description: 'Resolution of acute toothache and infected nerve tissue followed by permanent crown restoration in a single visit.',
    image: 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80',
    duration: 'Treatment Time: Single Visit',
  },
  {
    title: 'Aesthetic Gum Contouring & Laser Depigmentation',
    category: 'Periodontics',
    description: 'Gentle diode laser recontouring to balance an uneven gum line and eliminate gummy smile appearance.',
    image: 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=800&q=80',
    duration: 'Treatment Time: 45 Minutes',
  },
];

export default function SmileGalleryPage() {
  const schemaJson = {
    '@context': 'https://schema.org',
    '@type': 'CollectionPage',
    name: 'Advanced Dental Clinic Smile Gallery',
    description: 'Portfolio of smile restorations and clinical transformations.',
  };

  return (
    <PageLayout
      title="Smile Gallery & Case Studies"
      subtitle="Explore real smile transformations achieved through computer-guided dental implants, custom porcelain veneers, and clear aligner orthodontics."
      badge="Proven Clinical Outcomes"
      breadcrumbs={[{ label: 'Patient Resources' }, { label: 'Smile Gallery' }]}
      schemaJson={schemaJson}
    >
      <div className={styles.galleryContainer}>
        <div className={styles.contentWrap}>
          <div className={styles.casesGrid}>
            {CASES.map((item, idx) => (
              <div key={idx} className={styles.caseCard}>
                <div className={styles.imagePair}>
                  <Image
                    src={item.image}
                    alt={item.title}
                    fill
                    sizes="(max-width: 768px) 100vw, 400px"
                  />
                  <span className={styles.badgeTag}>{item.category}</span>
                </div>

                <div className={styles.caseDetails}>
                  <h3>{item.title}</h3>
                  <p>{item.description}</p>

                  <div className={styles.caseMeta}>
                    <span>{item.duration}</span>
                    <Sparkles size={14} />
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
