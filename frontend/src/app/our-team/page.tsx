import React from 'react';
import Image from 'next/image';
import Link from 'next/link';
import { Metadata } from 'next';
import { PageLayout } from '@/components/templates/PageLayout/PageLayout';
import styles from './page.module.scss';
import { Award, GraduationCap, ArrowRight } from 'lucide-react';

export const metadata: Metadata = {
  title: 'Our Specialist Clinical Team | Advanced Dental Clinic',
  description:
    'Meet our multidisciplinary team of board-certified dental specialists: implantologists, orthodontists, endodontists, and cosmetic surgeons.',
  keywords:
    'dental specialists, board certified dentists, implant surgeon, orthodontist, endodontist, cosmetic dentist',
};

interface TeamMember {
  name: string;
  role: string;
  credentials: string;
  image: string;
  bio: string;
  experience: string;
  specialty: string;
  fellowships: string;
}

const CLINICAL_TEAM: TeamMember[] = [
  {
    name: 'Dr. Evelyn Vance',
    role: 'Chief Prosthodontist & Implant Surgeon',
    credentials: 'DDS, MS (Prosthodontics), FICOI',
    image: 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=800&q=80',
    bio: 'Specializing in full-arch immediate implant placement, computerized bone augmentation, and complex smile reconstructions with over 15 years of clinical surgical experience.',
    experience: '15+ Years Clinical Practice',
    specialty: 'Computer Guided Dental Implants',
    fellowships: 'Fellow of International Congress of Oral Implantologists',
  },
  {
    name: 'Dr. Marcus Sterling',
    role: 'Lead Specialist Orthodontist',
    credentials: 'DMD, MS (Orthodontics), ABO Certified',
    image: 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=800&q=80',
    bio: 'A certified Diamond Clear Aligner specialist focused on gentle, non-extraction digital orthodontics and aesthetic smile symmetry for adults and teenagers.',
    experience: '12+ Years Orthodontic Experience',
    specialty: 'Clear Aligners & Digital Orthodontics',
    fellowships: 'American Board of Orthodontics Diplomate',
  },
  {
    name: 'Dr. Sophia Reyes',
    role: 'Microscopic Endodontist & Restorative Specialist',
    credentials: 'DDS, Specialist in Endodontology (AEGD)',
    image: 'https://images.unsplash.com/photo-1594824813589-a9a3b68832a8?auto=format&fit=crop&w=800&q=80',
    bio: 'Pioneer in single-visit painless root canal treatments utilizing 25x dental surgical microscopes and biocompatible regenerative endodontics.',
    experience: '11+ Years Endodontics',
    specialty: 'Microscopic Rotary Root Canal Therapy',
    fellowships: 'Member of American Association of Endodontists',
  },
  {
    name: 'Dr. Julian Thorne',
    role: 'Cosmetic Dentist & Digital Smile Architect',
    credentials: 'BDS, AACD Accredited Fellow',
    image: 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=800&q=80',
    bio: 'Renowned for hand-crafted ultra-thin porcelain veneers, composite artistry, and facial aesthetic harmony utilizing 3D Digital Smile Design workflows.',
    experience: '14+ Years Aesthetic Dentistry',
    specialty: 'Handcrafted Porcelain Veneers & DSD',
    fellowships: 'American Academy of Cosmetic Dentistry',
  },
  {
    name: 'Dr. Maya Patel',
    role: 'Periodontal Surgeon & Laser Specialist',
    credentials: 'DMD, MMedSci (Periodontology)',
    image: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=800&q=80',
    bio: 'Expert in regenerative gum therapy, soft tissue microsurgery, and non-invasive dental laser treatments for periodontal health and gummy smile reduction.',
    experience: '10+ Years Periodontics',
    specialty: 'Laser Periodontics & Gum Grafts',
    fellowships: 'American Academy of Periodontology',
  },
  {
    name: 'Dr. Liam Gallagher',
    role: 'Consultant Oral & Maxillofacial Surgeon',
    credentials: 'DDS, MD, FACS (Oral Surgery)',
    image: 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=800&q=80',
    bio: 'Specialist in minimally invasive wisdom teeth extractions, sinus floor elevations, and IV conscious sedation for anxious dental patients.',
    experience: '16+ Years Oral Surgery',
    specialty: 'Impacted Extractions & Sedation Care',
    fellowships: 'Fellow of American College of Surgeons',
  },
];

export default function OurTeamPage() {
  const schemaJson = {
    '@context': 'https://schema.org',
    '@type': 'MedicalOrganization',
    name: 'Advanced Dental Clinic Clinical Team',
    url: 'https://advanced-dental-clinic-demo.vercel.app/our-team',
    member: CLINICAL_TEAM.map((doctor) => ({
      '@type': 'Physician',
      name: doctor.name,
      jobTitle: doctor.role,
      description: doctor.bio,
    })),
  };

  return (
    <PageLayout
      title="Clinical Team & Specialists"
      subtitle="Our multi-disciplinary team brings together board-certified prosthodontists, orthodontists, endodontists, and surgeons dedicated to world-class patient outcomes."
      badge="Meet the Doctors"
      breadcrumbs={[{ label: 'About Us', href: '/about-us' }, { label: 'Our Team' }]}
      schemaJson={schemaJson}
    >
      <div className={styles.teamContainer}>
        <div className={styles.contentWrap}>
          <div className={styles.introBlock}>
            <h2>Comprehensive Specialty Care Under One Roof</h2>
            <p>
              Unlike standard general practices, Advanced Dental Clinic houses specialized clinical departments. Whether you require micro-surgical gum therapy, computer-guided implant surgery, or invisible orthodontics, you are treated by an accredited specialist in that discipline.
            </p>
          </div>

          <div className={styles.teamGrid}>
            {CLINICAL_TEAM.map((doctor, idx) => (
              <div key={idx} className={styles.doctorCard}>
                <div className={styles.doctorImageWrap}>
                  <Image
                    src={doctor.image}
                    alt={doctor.name}
                    fill
                    sizes="(max-width: 768px) 100vw, 400px"
                  />
                  <span className={styles.specialtyBadge}>{doctor.specialty}</span>
                </div>

                <div className={styles.doctorDetails}>
                  <h3>{doctor.name}</h3>
                  <p className={styles.credentials}>{doctor.credentials}</p>
                  <p className={styles.bio}>{doctor.bio}</p>

                  <div className={styles.doctorHighlights}>
                    <div className={styles.highlightItem}>
                      <GraduationCap size={15} />
                      <span>{doctor.fellowships}</span>
                    </div>
                    <div className={styles.highlightItem}>
                      <Award size={15} />
                      <span>{doctor.experience}</span>
                    </div>
                  </div>

                  <Link href="/contact" className={styles.consultCta}>
                    <span>Schedule Consultation</span>
                    <ArrowRight size={14} />
                  </Link>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </PageLayout>
  );
}
