'use client';

import React, { useEffect, useState } from 'react';
import Link from 'next/link';
import Image from 'next/image';
import styles from './about.module.css';
import { AboutPageData, PageSection } from '@/types/cms';
import { CmsService, DEFAULT_ABOUT_PAGE } from '@/api/cms';
import { assetUrl } from '@/utils/asset';

// Layout & Reusable Elements
import { HeaderTopBar } from '@/components/layout/HeaderTopBar/HeaderTopBar';
import { HeaderNavBar } from '@/components/layout/HeaderNavBar/HeaderNavBar';
import { Footer } from '@/components/layout/Footer/Footer';
import { MobileAppNavBar } from '@/components/layout/MobileAppNavBar/MobileAppNavBar';
import { BookingModal } from '@/components/common/BookingModal/BookingModal';
import { ContentBlockSection } from '@/components/sections/ContentBlockSection/ContentBlockSection';
import { ServicesGrid4x3 } from '@/components/sections/ServicesGrid4x3/ServicesGrid4x3';
import { ClinicAddressAndContact } from '@/components/sections/ClinicAddressAndContact/ClinicAddressAndContact';

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
          if (res.seo?.meta_title) {
            document.title = res.seo.meta_title;
          }
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

  // Curated team members (from API or defaults with uploaded clinician photos)
  const defaultTeam = [
    {
      name: 'Dr. Atandrilla Das',
      title: 'Lead Associate Dentist',
      credentials: 'BDS Associate Dental Surgeon',
      gdc: '178234',
      avatar: '/uploads/about-us/doctor-das.jpg',
      specialisms: 'Restorative Dentistry, Invisalign Orthodontics, Pediatric Care',
      quote: 'â€œOur philosophy is built around gentle listening and preventing future dental issues before they start.â€',
    },
    {
      name: 'Dr. Harjeevan Rai',
      title: 'Associate Dentist',
      credentials: 'BDS Dental Surgeon',
      gdc: '219485',
      avatar: '/uploads/about-us/doctor-rai.jpg',
      specialisms: 'Preventive Care, Biomechanical Restorations, Minimally Invasive Fillings',
      quote: 'â€œDelivering pain-free treatments with hospital-grade diagnostics and clinical precision.â€',
    },
    {
      name: 'Dr. Nadeem Sohail',
      title: 'Associate Dentist',
      credentials: 'BDS Dental Surgeon',
      gdc: '254109',
      avatar: '/uploads/about-us/doctor-sohail.jpg',
      specialisms: 'Endodontics (Root Canal), Oral Surgery Extractions, Crowns & Bridges',
      quote: 'â€œEmpowering patients with personalized treatment plans and calm chairside reassurance.â€',
    },
    {
      name: 'Claire',
      title: 'Dental Hygienist',
      credentials: 'BSc (Hons) Hygiene & Therapy',
      gdc: '289412',
      avatar: '/uploads/about-us/hygienist-claire.jpg',
      specialisms: 'Periodontal Therapy, Airflow Stain Polishing, Preventive Gum Care',
      quote: 'â€œEnsuring every patient feels welcomed, relaxed, and fully cared for from the moment they walk through our door.â€',
    },
  ];

  const teamMembers = (data.clinicians && data.clinicians.length > 0)
    ? data.clinicians.map((c, idx) => ({
        name: c.name,
        title: c.badge || c.title || 'Dental Clinician',
        credentials: c.title || 'BDS Dental Surgeon',
        gdc: defaultTeam[idx]?.gdc || '20419' + idx,
        avatar: c.avatar || defaultTeam[idx]?.avatar || '/uploads/about-us/doctor-das.jpg',
        specialisms: c.bio || defaultTeam[idx]?.specialisms || '',
        quote: defaultTeam[idx]?.quote || 'â€œCommitted to gentle, patient-first dental care.â€',
      }))
    : defaultTeam;

  const aboutSections: PageSection[] =
    data.sections && data.sections.length > 0
      ? [...data.sections].sort((a, b) => (a.order ?? 0) - (b.order ?? 0))
      : [
          {
            id: 'sec_about_why_us',
            type: 'why_us_block',
            category: 'prebuilt',
            name: 'Why Us & Ethos Pillars',
            eyebrow: whyUs.eyebrow,
            title: whyUs.headline,
            summary: whyUs.subtitle,
            is_active: true,
            order: 1,
          },
          {
            id: 'sec_about_team',
            type: 'team_block',
            category: 'prebuilt',
            name: 'Our Clinical Team',
            eyebrow: 'Meet Our Experienced Clinicians',
            title: 'GDC-Registered Dentists, Hygienists & Dental Nurses',
            summary:
              'Every clinician at Acocks Green Dental Practice shares a commitment to gentle clinical precision, continuous professional learning, and friendly patient care.',
            is_active: true,
            order: 2,
          },
          {
            id: 'sec_about_clinics',
            type: 'clinics_block',
            category: 'prebuilt',
            name: 'Our Clinics & Amenities',
            eyebrow: clinics.eyebrow,
            title: clinics.headline,
            summary: clinics.subtitle,
            is_active: true,
            order: 3,
          },
          {
            id: 'sec_about_charter',
            type: 'safety_charter_cards',
            category: 'prebuilt',
            name: 'NHS Safety Charter & CQC Standards',
            eyebrow: charter.eyebrow,
            title: charter.headline,
            summary: charter.subtitle,
            is_active: true,
            order: 4,
          },
          {
            id: 'sec_about_reviews',
            type: 'testimonials_block',
            category: 'prebuilt',
            name: 'Patient Reviews',
            eyebrow: 'Real Stories From Birmingham Patients',
            title: 'What Our Patients Say About Us',
            summary:
              'Read honest feedback from patients across Acocks Green, Solihull, Hall Green, and South Birmingham who trust us with their smiles.',
            is_active: true,
            order: 5,
          },
        ];

  const getCustomBgStyle = (sec: PageSection): React.CSSProperties => {
    const s: React.CSSProperties = {};
    if (sec.bg_type === 'solid' && sec.bg_color) {
      s.backgroundColor = sec.bg_color;
    } else if (sec.bg_type === 'gradient') {
      s.background = `linear-gradient(${sec.bg_gradient_angle || '135deg'}, ${sec.bg_gradient_start || '#094713'}, ${sec.bg_gradient_end || '#15803d'})`;
    } else if ((sec.bg_type === 'image' || sec.bg_type === 'image_overlay') && sec.bg_image) {
      s.backgroundImage = `url(${assetUrl(sec.bg_image)})`;
      s.backgroundSize = 'cover';
      s.backgroundPosition = 'center';
    }
    if (sec.text_contrast === 'light') {
      s.color = '#ffffff';
    }
    return s;
  };

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
                <span className={styles.eyebrow} dangerouslySetInnerHTML={{ __html: hero.eyebrow || '' }} />
                <h1 className={styles.headline} dangerouslySetInnerHTML={{ __html: hero.headline || '' }} />
                <p className={styles.subtitle} dangerouslySetInnerHTML={{ __html: hero.subtitle || '' }} />

                {/* Trust Badges (Editable in CMS) */}
                <div
                  className={styles.trustBadgesRow}
                  style={{ '--grid-cols': (hero as any).trust_badges_cols || 4 } as React.CSSProperties}
                >
                  {(hero.trust_badges && hero.trust_badges.length > 0
                    ? hero.trust_badges
                    : [
                        { icon: 'local_hospital', label: 'NHS & Private' },
                        { icon: 'verified_user', label: 'CQC Regulated' },
                        { icon: 'workspace_premium', label: 'BDA Member' },
                        { icon: 'military_tech', label: 'Award-Winning' },
                      ]
                  ).map((tb, bIdx) => {
                    const icon = typeof tb === 'string' ? 'verified_user' : tb.icon || 'verified_user';
                    const label = typeof tb === 'string' ? tb : tb.label;
                    return (
                      <div key={bIdx} className={styles.badgeCard}>
                        <span className="material-symbols-outlined">{icon}</span>
                        <span>{label}</span>
                      </div>
                    );
                  })}
                </div>

                {/* Actions (Editable in CMS) */}
                <div className={styles.heroActions}>
                  <a href={hero.cta_primary_link || '#our-team'} className={styles.primaryCta}>
                    <span className="material-symbols-outlined text-[18px]">groups</span>
                    <span>{hero.cta_primary || 'Meet Our Team'}</span>
                  </a>
                  <a href={hero.cta_secondary_link || 'tel:+441217652870'} className={styles.secondaryCta}>
                    <span className="material-symbols-outlined text-[18px]">call</span>
                    <span>{hero.cta_secondary || '0121 765 2870'}</span>
                  </a>
                </div>
              </div>

              {/* Right Hero Image Card */}
              <div className={styles.heroImageFrame}>
                <div className={styles.imageWrapper}>
                  <Image
                    src={assetUrl(hero.image || '/uploads/about-us/about-team.jpg')}
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
                    {hero.image_caption || 'Principal Clinicians & Care Team â€” Warwick Road'}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* ================================================================ */}
        {/* DYNAMIC PAGE SECTIONS FROM CMS                                   */}
        {/* ================================================================ */}
        {aboutSections.map((sec, idx) => {
          if (sec.is_active === false) return null;
          const customBg = getCustomBgStyle(sec);

          if (sec.type === 'why_us_block') {
            return (
              <section className={styles.whyUsSection} id="why-us" key={sec.id || idx} style={customBg}>
                <div className={styles.container}>
                  <div className={styles.sectionHeader}>
                    <span className={styles.eyebrow} dangerouslySetInnerHTML={{ __html: sec.eyebrow || whyUs.eyebrow || '' }} />
                    <h2 dangerouslySetInnerHTML={{ __html: sec.title || whyUs.headline || '' }} />
                    <p dangerouslySetInnerHTML={{ __html: sec.summary || whyUs.subtitle || '' }} />
                  </div>

                  {/* Pillars Grid */}
                  <div
                    className={styles.pillarsGrid}
                    style={{ '--grid-cols': (whyUs as any).pillars_cols || 4 } as React.CSSProperties}
                  >
                    {whyUs.pillars.map((pillar, pIdx) => (
                      <div key={pIdx} className={styles.pillarCard}>
                        <div>
                          <div className={styles.pillarIcon}>
                            <span className="material-symbols-outlined">{pillar.icon}</span>
                          </div>
                          <h3 dangerouslySetInnerHTML={{ __html: pillar.title || '' }} />
                          <p dangerouslySetInnerHTML={{ __html: pillar.desc || '' }} />
                        </div>
                        <div className={styles.pillarBadge}>
                          <span className="material-symbols-outlined">check_circle</span>
                          <span>{pillar.badge}</span>
                        </div>
                      </div>
                    ))}
                  </div>

                  {/* Stats Banner */}
                  <div className={styles.statsBanner}>
                    <div
                      className={styles.statsGrid}
                      style={{ '--grid-cols': (whyUs as any).stats_cols || 4 } as React.CSSProperties}
                    >
                      {whyUs.stats.map((st, sIdx) => (
                        <div key={sIdx} className={styles.statItem}>
                          <div className={styles.statNumber}>{st.value}</div>
                          <div className={styles.statLabel}>{st.label}</div>
                          {st.desc && <div className={styles.statDesc}>{st.desc}</div>}
                        </div>
                      ))}
                    </div>
                  </div>
                </div>
              </section>
            );
          }

          if (sec.type === 'team_block') {
            return (
              <section className={styles.teamSection} id="our-team" key={sec.id || idx} style={customBg}>
                <div className={styles.container}>
                  <div className={styles.sectionHeader}>
                    <span className={styles.eyebrow} dangerouslySetInnerHTML={{ __html: sec.eyebrow || 'Meet Our Experienced Clinicians' }} />
                    <h2 dangerouslySetInnerHTML={{ __html: sec.title || 'GDC-Registered Dentists, Hygienists & Dental Nurses' }} />
                    <p dangerouslySetInnerHTML={{ __html: sec.summary || 'Every clinician at Acocks Green Dental Practice shares a commitment to gentle clinical precision, continuous professional learning, and friendly patient care.' }} />
                  </div>

                  <div className={styles.teamGrid}>
                    {teamMembers.map((member, mIdx) => (
                      <div key={mIdx} className={styles.teamCard}>
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
            );
          }

          if (sec.type === 'clinics_block') {
            return (
              <section className={styles.clinicsSection} id="our-clinics" key={sec.id || idx} style={customBg}>
                <div className={styles.container}>
                  <div className={styles.sectionHeader}>
                    <span className={styles.eyebrow} dangerouslySetInnerHTML={{ __html: sec.eyebrow || clinics.eyebrow || '' }} />
                    <h2 dangerouslySetInnerHTML={{ __html: sec.title || clinics.headline || '' }} />
                    <p dangerouslySetInnerHTML={{ __html: sec.summary || clinics.subtitle || '' }} />
                  </div>

                  <div className={styles.clinicsGrid}>
                    <div
                      className={styles.featureList}
                      style={{ '--grid-cols': (clinics as any).features_cols || 1 } as React.CSSProperties}
                    >
                      {clinics.features.map((feat, fIdx) => (
                        <div key={fIdx} className={styles.featureCard}>
                          <div className={styles.featureIcon}>
                            <span className="material-symbols-outlined">{feat.icon}</span>
                          </div>
                          <div>
                            <h4 dangerouslySetInnerHTML={{ __html: feat.title || '' }} />
                            <p dangerouslySetInnerHTML={{ __html: feat.desc || '' }} />
                          </div>
                        </div>
                      ))}
                    </div>

                    <div className={styles.surgeryPhotoCard}>
                      <div className={styles.surgeryImageWrapper}>
                        <Image
                          src={assetUrl(clinics.surgery_image || '/uploads/about-us/surgery-clinic.jpg')}
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
                          {clinics.surgery_badge || 'Active Clinical Suite'}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            );
          }

          if (sec.type === 'safety_charter_cards') {
            return (
              <section className={styles.charterSection} id="nhs-charter" key={sec.id || idx} style={customBg}>
                <div className={styles.container}>
                  <div className={styles.sectionHeader}>
                    <span className={styles.eyebrow} dangerouslySetInnerHTML={{ __html: sec.eyebrow || charter.eyebrow || '' }} />
                    <h2 dangerouslySetInnerHTML={{ __html: sec.title || charter.headline || '' }} />
                    <p dangerouslySetInnerHTML={{ __html: sec.summary || charter.subtitle || '' }} />
                  </div>

                  <div
                    className={styles.charterCardsGrid}
                    style={{ '--grid-cols': (charter as any).cards_cols || 3 } as React.CSSProperties}
                  >
                    {charter.cards.map((card, cIdx) => (
                      <div key={cIdx} className={styles.charterCard}>
                        <div>
                          <div className={styles.charterIcon}>
                            <span className="material-symbols-outlined">{card.icon}</span>
                          </div>
                          <h3 dangerouslySetInnerHTML={{ __html: card.title || '' }} />
                          <p dangerouslySetInnerHTML={{ __html: card.desc || '' }} />
                        </div>
                        {card.footer_label && (
                          <div className={styles.charterFooter}>
                            <span>{card.footer_label}</span>
                            <span className="material-symbols-outlined">verified_user</span>
                          </div>
                        )}
                      </div>
                    ))}
                  </div>

                  <div className={styles.outOfHoursBox}>
                    <div className={styles.outOfHoursContent}>
                      <div className={styles.emergencyIcon}>
                        <span className="material-symbols-outlined">emergency</span>
                      </div>
                      <div>
                        <h4>{charter.emergency_box?.title || 'Emergency & Out-of-Hours Dental Support'}</h4>
                        <p>{charter.emergency_box?.subtitle || 'Experiencing severe dental pain, bleeding, or facial trauma outside regular practice hours?'}</p>
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
                        href={`tel:${charter.emergency_box?.nhs111 || '111'}`}
                        className={styles.secondaryCta}
                        style={{ border: '1px solid #cbd5e1', color: '#1e293b' }}
                      >
                        <span>NHS {charter.emergency_box?.nhs111 || '111'}</span>
                      </a>
                    </div>
                  </div>
                </div>
              </section>
            );
          }

          if (sec.type === 'testimonials_block') {
            return (
              <section className={styles.reviewsSection} id="patient-reviews" key={sec.id || idx} style={customBg}>
                <div className={styles.container}>
                  <div className={styles.reviewsHeaderRow}>
                    <div className={styles.sectionHeader} style={{ marginBottom: 0 }}>
                      <span className={styles.eyebrow} dangerouslySetInnerHTML={{ __html: sec.eyebrow || 'Real Stories From Birmingham Patients' }} />
                      <h2 dangerouslySetInnerHTML={{ __html: sec.title || 'What Our Patients Say About Us' }} />
                      <p dangerouslySetInnerHTML={{ __html: sec.summary || 'Read honest feedback from patients across Acocks Green, Solihull, Hall Green, and South Birmingham who trust us with their smiles.' }} />
                    </div>

                    <div className={styles.ratingSummaryBadge}>
                      <div className={styles.starsBox}>
                        <div className={styles.stars}>
                          {[...Array(5)].map((_, i) => (
                            <span key={i} className="material-symbols-outlined text-[20px]">star</span>
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

                  <div className={styles.reviewsGrid}>
                    <div className={styles.reviewCard}>
                      <div>
                        <div className={styles.reviewStarsRow}>
                          <div className={styles.stars}>
                            {[...Array(5)].map((_, i) => (
                              <span key={i} className="material-symbols-outlined text-[18px]">star</span>
                            ))}
                          </div>
                          <span className={styles.verifiedPill}>
                            <span className="material-symbols-outlined">check</span>
                            Verified Patient
                          </span>
                        </div>
                        <p className={styles.reviewBody}>
                          “I hadn&apos;t visited a dentist in nearly six years due to extreme dental anxiety. Dr. Das and the team were so calm, unhurried, and understanding. I felt zero pain during my routine checkup and cleaning.”
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
                              <span key={i} className="material-symbols-outlined text-[18px]">star</span>
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
                              <span key={i} className="material-symbols-outlined text-[18px]">star</span>
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
            );
          }

          if (sec.type === 'services_block') {
            return (
              <ServicesGrid4x3
                key={sec.id || idx}
                eyebrow={sec.eyebrow}
                title={sec.title}
                subtitle={sec.summary}
              />
            );
          }

          if (sec.type === 'contact_block') {
            return (
              <ClinicAddressAndContact
                key={sec.id || idx}
                eyebrow={sec.eyebrow}
                title={sec.title}
                subtitle={sec.summary}
              />
            );
          }

          return <ContentBlockSection key={sec.id || idx} section={sec} index={idx} />;
        })}
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

