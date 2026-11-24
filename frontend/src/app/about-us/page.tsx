'use client';

import React, { useEffect, useState } from 'react';
import Link from 'next/link';
import Image from 'next/image';
import styles from './about.module.css';
import { AboutPageData } from '@/types/cms';
import { CmsService, DEFAULT_ABOUT_PAGE } from '@/api/cms';
import { assetUrl } from '@/utils/asset';

// Layout & Reusable Elements
import { HeaderTopBar } from '@/components/layout/HeaderTopBar/HeaderTopBar';
import { HeaderNavBar } from '@/components/layout/HeaderNavBar/HeaderNavBar';
import { Footer } from '@/components/layout/Footer/Footer';
import { MobileAppNavBar } from '@/components/layout/MobileAppNavBar/MobileAppNavBar';
import { BookingModal } from '@/components/common/BookingModal/BookingModal';

export default function AboutPage() {
  const [data, setData] = useState<AboutPageData>(DEFAULT_ABOUT_PAGE);
  const [isBookingOpen, setIsBookingOpen] = useState(false);
  const [bookingTreatment, setBookingTreatment] = useState('Routine Dental Examination');

  useEffect(() => {
    async function loadAboutData() {
      try {
        const res = await CmsService.getAboutPage();
        if (res) {
          setData(res);
        }
      } catch (err) {
        console.warn('Failed to load about page from CMS API; using defaults:', err);
      }
    }
    loadAboutData();
  }, []);

  const handleOpenBooking = (treatment?: string) => {
    if (treatment) setBookingTreatment(treatment);
    setIsBookingOpen(true);
  };

  const hero = data.hero || DEFAULT_ABOUT_PAGE.hero;
  const whyUs = data.why_us || DEFAULT_ABOUT_PAGE.why_us;
  const clinics = data.clinics || DEFAULT_ABOUT_PAGE.clinics;
  const charter = data.safety_charter || DEFAULT_ABOUT_PAGE.safety_charter;

  // Curated team members (from API or defaults matching the design template)
  const defaultTeam = [
    {
      name: 'Dr. Sarah Jenkins',
      title: 'Principal Dentist',
      credentials: 'BDS (Birm) MJDF RCS (Eng)',
      gdc: '178234',
      avatar: '/images/doctor-1.jpg',
      specialisms: 'General Dentistry, Invisalign Orthodontics, Smile Rehabilitation',
      quote: '“Our philosophy is built around gentle listening and preventing future dental issues before they start.”',
    },
    {
      name: 'Dr. Tariq Mahmood',
      title: 'Associate Dentist',
      credentials: 'BDS (Hons) MSc Restorative (Manc)',
      gdc: '219485',
      avatar: '/images/doctor-2.jpg',
      specialisms: 'Endodontics (Root Canal), Aesthetic Crowns, Minimally Invasive Fillings',
      quote: '“Delivering pain-free treatments with hospital-grade diagnostics and clinical precision.”',
    },
    {
      name: 'Claire Hughes',
      title: 'Lead Dental Hygienist',
      credentials: 'BSc (Hons) Hygiene & Therapy',
      gdc: '254109',
      avatar: '/images/doctor-3.jpg',
      specialisms: 'Airflow Stain Removal, Periodontal Health, Preventive Care',
      quote: '“Empowering patients with personalized home care regimens that keep gums healthy for life.”',
    },
    {
      name: 'Priya Sharma',
      title: 'Senior Nurse & Care Coordinator',
      credentials: 'NEBDN Dip Dental Nursing',
      gdc: '289412',
      avatar: '/images/doctor-4.jpg',
      specialisms: 'Nervous Patient Support, Infection Prevention & CQC Compliance',
      quote: '“Ensuring every patient feels welcomed, relaxed, and fully cared for from the moment they walk through our door.”',
    },
  ];

  return (
    <div style={{ display: 'flex', flexDirection: 'column', minHeight: '100vh' }}>
      {/* 1. Header Utility Bar */}
      <HeaderTopBar />

      {/* 2. Main Sticky Navigation with Booking Action */}
      <HeaderNavBar onBookClick={(trt) => handleOpenBooking(trt)} />

      <main className={styles.main}>
        {/* ================================================================ */}
        {/* HERO BANNER SECTION                                              */}
        {/* ================================================================ */}
        <section className={styles.heroSection}>
          <div className={styles.container}>
            <nav aria-label="Breadcrumb" className={styles.breadcrumb}>
              <Link href="/">Home</Link>
              <span className="material-symbols-outlined text-[14px]">
                chevron_right
              </span>
              <span className={styles.current}>About Us</span>
            </nav>

            <div className={styles.heroGrid}>
              <div className={styles.heroContent}>
                <span className={styles.eyebrow}>{hero.eyebrow}</span>
                <h1 className={styles.headline}>{hero.headline}</h1>
                <p className={styles.subtitle}>{hero.subtitle}</p>

                {/* 4 Trust Badges */}
                <div className={styles.trustBadgesRow}>
                  <div className={styles.badgeCard}>
                    <span className="material-symbols-outlined">local_hospital</span>
                    <span>NHS & Private</span>
                  </div>
                  <div className={styles.badgeCard}>
                    <span className="material-symbols-outlined">verified_user</span>
                    <span>CQC Regulated</span>
                  </div>
                  <div className={styles.badgeCard}>
                    <span className="material-symbols-outlined">workspace_premium</span>
                    <span>BDA Member</span>
                  </div>
                  <div className={styles.badgeCard}>
                    <span className="material-symbols-outlined">military_tech</span>
                    <span>Award-Winning</span>
                  </div>
                </div>

                {/* Actions */}
                <div className={styles.heroActions}>
                  <a href="#our-team" className={styles.primaryCta}>
                    <span className="material-symbols-outlined text-[18px]">
                      groups
                    </span>
                    <span>Meet Our Team</span>
                  </a>
                  <a href="tel:+441217652870" className={styles.secondaryCta}>
                    <span className="material-symbols-outlined text-[18px]">
                      call
                    </span>
                    <span>0121 765 2870</span>
                  </a>
                </div>
              </div>

              {/* Right Hero Image Card */}
              <div className={styles.heroImageFrame}>
                <div className={styles.imageWrapper}>
                  <Image
                    src={assetUrl(hero.image || '/images/acocks-green-team.jpg')}
                    alt="Clinical team at Acocks Green Dental Practice"
                    fill
                    priority
                  />
                </div>
                <div className={styles.captionBox}>
                  <div className={styles.captionIcon}>
                    <span className="material-symbols-outlined">dentistry</span>
                  </div>
                  <span className={styles.captionText}>
                    {hero.image_caption || 'Principal Clinicians & Care Team — Warwick Road'}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* ================================================================ */}
        {/* 1. SECTION: WHY US (id="why-us")                                  */}
        {/* ================================================================ */}
        <section className={styles.whyUsSection} id="why-us">
          <div className={styles.container}>
            <div className={styles.sectionHeader}>
              <span className={styles.eyebrow}>{whyUs.eyebrow}</span>
              <h2>{whyUs.headline}</h2>
              <p>{whyUs.subtitle}</p>
            </div>

            {/* 4 Pillars Grid */}
            <div className={styles.pillarsGrid}>
              {whyUs.pillars.map((pillar, idx) => (
                <div key={idx} className={styles.pillarCard}>
                  <div>
                    <div className={styles.pillarIcon}>
                      <span className="material-symbols-outlined">
                        {pillar.icon}
                      </span>
                    </div>
                    <h3>{pillar.title}</h3>
                    <p>{pillar.desc}</p>
                  </div>
                  <div className={styles.pillarBadge}>
                    <span className="material-symbols-outlined">
                      check_circle
                    </span>
                    <span>{pillar.badge}</span>
                  </div>
                </div>
              ))}
            </div>

            {/* Stats Banner */}
            <div className={styles.statsBanner}>
              <div className={styles.statsGrid}>
                {whyUs.stats.map((st, idx) => (
                  <div key={idx} className={styles.statItem}>
                    <div className={styles.statNumber}>{st.value}</div>
                    <div className={styles.statLabel}>{st.label}</div>
                    {st.desc && <div className={styles.statDesc}>{st.desc}</div>}
                  </div>
                ))}
              </div>
            </div>
          </div>
        </section>

        {/* ================================================================ */}
        {/* 2. SECTION: OUR TEAM (id="our-team")                              */}
        {/* ================================================================ */}
        <section className={styles.teamSection} id="our-team">
          <div className={styles.container}>
            <div className={styles.sectionHeader}>
              <span className={styles.eyebrow}>Meet Our Experienced Clinicians</span>
              <h2>GDC-Registered Dentists, Hygienists & Dental Nurses</h2>
              <p>
                Every clinician at Acocks Green Dental Practice shares a commitment to gentle clinical precision, continuous professional learning, and friendly patient care.
              </p>
            </div>

            <div className={styles.teamGrid}>
              {defaultTeam.map((member, idx) => (
                <div key={idx} className={styles.teamCard}>
                  <div className={styles.avatarFrame}>
                    <Image
                      src={assetUrl(member.avatar)}
                      alt={`${member.name} - ${member.title}`}
                      fill
                    />
                    <div className={styles.gdcPill}>GDC: {member.gdc}</div>
                  </div>
                  <div className={styles.teamInfo}>
                    <div>
                      <h3>{member.name}</h3>
                      <div className={styles.credentials}>{member.credentials}</div>
                      <div className={styles.roleTitle}>{member.title}</div>
                      <div className={styles.specialismsBox}>
                        <strong>Clinical Specialisms:</strong>
                        <span>{member.specialisms}</span>
                      </div>
                    </div>
                    <blockquote>{member.quote}</blockquote>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* ================================================================ */}
        {/* 3. SECTION: OUR CLINICS (id="our-clinics")                        */}
        {/* ================================================================ */}
        <section className={styles.clinicsSection} id="our-clinics">
          <div className={styles.container}>
            <div className={styles.sectionHeader}>
              <span className={styles.eyebrow}>{clinics.eyebrow}</span>
              <h2>{clinics.headline}</h2>
              <p>{clinics.subtitle}</p>
            </div>

            <div className={styles.clinicsGrid}>
              {/* Feature Cards Column */}
              <div className={styles.featureList}>
                {clinics.features.map((feat, idx) => (
                  <div key={idx} className={styles.featureCard}>
                    <div className={styles.featureIcon}>
                      <span className="material-symbols-outlined">
                        {feat.icon}
                      </span>
                    </div>
                    <div>
                      <h4>{feat.title}</h4>
                      <p>{feat.desc}</p>
                    </div>
                  </div>
                ))}
              </div>

              {/* Right Surgery Image Card */}
              <div className={styles.surgeryPhotoCard}>
                <div className={styles.surgeryImageWrapper}>
                  <Image
                    src={assetUrl(clinics.surgery_image || '/images/surgery-clinic.jpg')}
                    alt={clinics.surgery_title}
                    fill
                  />
                </div>
                <div className={styles.surgeryFooter}>
                  <div>
                    <h4>{clinics.surgery_title}</h4>
                    <p>{clinics.surgery_desc}</p>
                  </div>
                  <span className={styles.activePill}>
                    <span className={styles.dot} />
                    Active Clinical Suite
                  </span>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* ================================================================ */}
        {/* 4. SECTION: NHS SAFETY CHARTER (id="nhs-charter")                  */}
        {/* ================================================================ */}
        <section className={styles.charterSection} id="nhs-charter">
          <div className={styles.container}>
            <div className={styles.sectionHeader}>
              <span className={styles.eyebrow}>{charter.eyebrow}</span>
              <h2>{charter.headline}</h2>
              <p>{charter.subtitle}</p>
            </div>

            <div className={styles.charterCardsGrid}>
              {charter.cards.map((card, idx) => (
                <div key={idx} className={styles.charterCard}>
                  <div>
                    <div className={styles.charterIcon}>
                      <span className="material-symbols-outlined">
                        {card.icon}
                      </span>
                    </div>
                    <h3>{card.title}</h3>
                    <p>{card.desc}</p>
                  </div>
                  {card.footer_label && (
                    <div className={styles.charterFooter}>
                      <span>{card.footer_label}</span>
                      <span className="material-symbols-outlined text-[18px]">
                        verified_user
                      </span>
                    </div>
                  )}
                </div>
              ))}
            </div>

            {/* Out-of-Hours Support Reassurance Banner */}
            <div className={styles.outOfHoursBox}>
              <div className={styles.outOfHoursContent}>
                <div className={styles.emergencyIcon}>
                  <span className="material-symbols-outlined">emergency</span>
                </div>
                <div>
                  <h4>{charter.emergency_box?.title || 'Emergency & Out-of-Hours Dental Support'}</h4>
                  <p>
                    {charter.emergency_box?.subtitle || 'Experiencing severe dental pain, bleeding, or facial trauma outside regular practice hours?'}
                  </p>
                </div>
              </div>
              <div className={styles.outOfHoursActions}>
                <a
                  href={`tel:${(charter.emergency_box?.phone || '+44 121 765 2870').replace(/\s+/g, '')}`}
                  className={styles.primaryCta}
                >
                  <span className="material-symbols-outlined text-[18px]">call</span>
                  <span>Call Practice: {charter.emergency_box?.phone || '0121 765 2870'}</span>
                </a>
                <a
                  href="tel:111"
                  className={styles.secondaryCta}
                  style={{ border: '1px solid #cbd5e1', color: '#1e293b' }}
                >
                  <span>NHS 111</span>
                </a>
              </div>
            </div>
          </div>
        </section>

        {/* ================================================================ */}
        {/* 5. SECTION: PATIENT REVIEWS (id="patient-reviews")                */}
        {/* ================================================================ */}
        <section className={styles.reviewsSection} id="patient-reviews">
          <div className={styles.container}>
            <div className={styles.reviewsHeaderRow}>
              <div className={styles.sectionHeader} style={{ marginBottom: 0 }}>
                <span className={styles.eyebrow}>Real Stories From Birmingham Patients</span>
                <h2>What Our Patients Say About Us</h2>
                <p>
                  Read honest feedback from patients across Acocks Green, Solihull, Hall Green, and South Birmingham who trust us with their smiles.
                </p>
              </div>

              {/* 4.9 Stars Aggregate Badge */}
              <div className={styles.ratingSummaryBadge}>
                <div className={styles.starsBox}>
                  <div className={styles.stars}>
                    {[...Array(5)].map((_, i) => (
                      <span key={i} className="material-symbols-outlined text-[20px]">
                        star
                      </span>
                    ))}
                  </div>
                  <p>340+ Verified Reviews</p>
                </div>
                <div className={styles.scoreCol}>
                  <div className={styles.scoreNumber}>4.9</div>
                  <div className={styles.scoreText}>out of 5 Stars</div>
                </div>
              </div>
            </div>

            {/* 3 Review Cards */}
            <div className={styles.reviewsGrid}>
              <div className={styles.reviewCard}>
                <div>
                  <div className={styles.reviewStarsRow}>
                    <div className={styles.stars}>
                      {[...Array(5)].map((_, i) => (
                        <span key={i} className="material-symbols-outlined text-[18px]">
                          star
                        </span>
                      ))}
                    </div>
                    <span className={styles.verifiedPill}>
                      <span className="material-symbols-outlined">check</span>
                      Verified Patient
                    </span>
                  </div>
                  <p className={styles.reviewBody}>
                    “I hadn't visited a dentist in nearly six years due to extreme dental anxiety. Dr. Jenkins and Priya were so calm, unhurried, and understanding. I felt zero pain during my routine checkup and cleaning.”
                  </p>
                </div>
                <div className={styles.authorInfo}>
                  <div className={styles.authorName}>David M.</div>
                  <div className={styles.authorRole}>Acocks Green Resident • 4-year Patient</div>
                </div>
              </div>

              <div className={styles.reviewCard}>
                <div>
                  <div className={styles.reviewStarsRow}>
                    <div className={styles.stars}>
                      {[...Array(5)].map((_, i) => (
                        <span key={i} className="material-symbols-outlined text-[18px]">
                          star
                        </span>
                      ))}
                    </div>
                    <span className={styles.verifiedPill}>
                      <span className="material-symbols-outlined">check</span>
                      Verified Patient
                    </span>
                  </div>
                  <p className={styles.reviewBody}>
                    “Booking was seamless, and the clinic at 1078 Warwick Road has dedicated parking right outside. Claire the hygienist completely transformed my smile with Airflow. Fantastic practice!”
                  </p>
                </div>
                <div className={styles.authorInfo}>
                  <div className={styles.authorName}>Helen T.</div>
                  <div className={styles.authorRole}>Solihull • Hygiene & Airflow Patient</div>
                </div>
              </div>

              <div className={styles.reviewCard}>
                <div>
                  <div className={styles.reviewStarsRow}>
                    <div className={styles.stars}>
                      {[...Array(5)].map((_, i) => (
                        <span key={i} className="material-symbols-outlined text-[18px]">
                          star
                        </span>
                      ))}
                    </div>
                    <span className={styles.verifiedPill}>
                      <span className="material-symbols-outlined">check</span>
                      Verified Patient
                    </span>
                  </div>
                  <p className={styles.reviewBody}>
                    “Had an excruciating broken molar on a Friday afternoon. They fit me in within 2 hours, explained all the NHS vs private options clearly, and relieved the pain immediately.”
                  </p>
                </div>
                <div className={styles.authorInfo}>
                  <div className={styles.authorName}>Marcus P.</div>
                  <div className={styles.authorRole}>Hall Green • Emergency Patient</div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>

      {/* Practice Global Footer */}
      <Footer />

      {/* Mobile Bottom Navigation */}
      <MobileAppNavBar onBookClick={() => handleOpenBooking()} />

      {/* Booking Drawer Modal */}
      <BookingModal
        isOpen={isBookingOpen}
        onClose={() => setIsBookingOpen(false)}
        initialTreatment={bookingTreatment}
      />
    </div>
  );
}
