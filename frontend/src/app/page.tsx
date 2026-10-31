'use client';

import React, { useState } from 'react';
import styles from './page.module.scss';
import { Navbar } from '@/components/organisms/Navbar/Navbar';
import { Footer } from '@/components/organisms/Footer/Footer';
import { BookingWizard } from '@/components/organisms/BookingWizard/BookingWizard';
import { WhatsAppHub } from '@/components/ui/WhatsAppHub/WhatsAppHub';
import { Button } from '@/components/ui/Button/Button';
import { Badge } from '@/components/ui/Badge/Badge';
import {
  Calendar,
  Sparkles,
  Star,
  ArrowRight,
  CheckCircle2,
  ChevronDown,
  Stethoscope,
  PhoneCall,
  Sliders,
} from 'lucide-react';

export default function HomePage() {
  const [bookingOpen, setBookingOpen] = useState(false);
  const [selectedServiceId, setSelectedServiceId] = useState<number | undefined>(undefined);

  // Before & After Makeover Slider State (0 to 100 percent)
  const [sliderPosition, setSliderPosition] = useState<number>(50);

  // WaaS Pricing Toggle: Annual vs Monthly Rental
  const [billingPeriod, setBillingPeriod] = useState<'monthly' | 'annual'>('monthly');

  // FAQ Accordion Active Index
  const [openFaq, setOpenFaq] = useState<number | null>(0);

  const handleOpenBooking = (serviceId?: number) => {
    setSelectedServiceId(serviceId);
    setBookingOpen(true);
  };

  return (
    <div className={styles.pageWrapper}>
      {/* Top Navbar with Instant Theme Switcher */}
      <Navbar onOpenBooking={() => handleOpenBooking()} />

      <main className={styles.mainContent}>
        {/* ========================================================
            HERO SECTION: 3-Second Value Proposition & Doctor Spotlight
            ======================================================== */}
        <section className={styles.heroSection}>
          <div className={styles.heroContainer}>
            <div className={styles.heroContent}>
              <div className={styles.badgeRow}>
                <Badge variant="primary" size="md" icon={<Sparkles size={14} />}>
                  Precision Digital Dentistry & Prosthodontics
                </Badge>
                <div className={styles.ratingSnippet}>
                  <div className={styles.stars}>
                    {[...Array(5)].map((_, i) => (
                      <Star key={i} size={13} fill="#F59E0B" color="#F59E0B" />
                    ))}
                  </div>
                  <span><strong>4.98/5</strong> (2,450+ Patient Reviews)</span>
                </div>
              </div>

              <h1 className={styles.heroHeadline}>
                Pain-Free Restorations.
                <span className={styles.gradientText}> Confident Smiles</span> for Life.
              </h1>

              <p className={styles.heroSubheadline}>
                Experience the next standard in gentle, precision dental care. From single-visit 3D dental implants and Invisalign clear aligners to porcelain smile makeovers across 3 state-of-the-art metropolitan clinics.
              </p>

              <div className={styles.heroCtaGroup}>
                <Button
                  variant="primary"
                  size="lg"
                  icon={<Calendar size={18} />}
                  onClick={() => handleOpenBooking()}
                >
                  Schedule 3D Oral Scan & Consultation
                </Button>
                <Button
                  variant="outline"
                  size="lg"
                  icon={<PhoneCall size={18} />}
                  onClick={() => (window.location.href = 'tel:+919904379260')}
                >
                  Emergency Care: +91 99043 79260
                </Button>
              </div>

              {/* Authority & Trust Metrics */}
              <div className={styles.trustGrid}>
                <div className={styles.trustItem}>
                  <strong>15,000+</strong>
                  <span>Successful Implants & Makeovers</span>
                </div>
                <div className={styles.trustDivider} />
                <div className={styles.trustItem}>
                  <strong>Board-Certified</strong>
                  <span>Prosthodontists & Specialists</span>
                </div>
                <div className={styles.trustDivider} />
                <div className={styles.trustItem}>
                  <strong>3 Clinics</strong>
                  <span>Full-Service Digital Diagnostic Labs</span>
                </div>
              </div>
            </div>

            {/* Hero Visual Spotlight: Board-Certified Doctor Card */}
            <div className={styles.heroVisual}>
              <div className={styles.doctorSpotlightCard}>
                <div className={styles.cardHeader}>
                  <Badge variant="success" size="sm">Available Today</Badge>
                  <span className={styles.chairStatus}>2 Openings Left</span>
                </div>

                <div className={styles.doctorGraphic}>
                  <div className={styles.doctorAvatarBox}>
                    <Stethoscope size={56} className={styles.doctorIcon} />
                  </div>
                  <div className={styles.doctorCredentials}>
                    <h3>Dr. Alexander Vance, DDS, FACP</h3>
                    <p className={styles.doctorTitle}>Clinical Director & Board-Certified Prosthodontist</p>
                    <span className={styles.doctorMeta}>Harvard Dental Medicine | 16+ Years Clinical Mastery</span>
                  </div>
                </div>

                <div className={styles.doctorHighlights}>
                  <div className={styles.highlightPill}>
                    <CheckCircle2 size={14} color="#0D9488" />
                    <span>Computer-Guided Implantology</span>
                  </div>
                  <div className={styles.highlightPill}>
                    <CheckCircle2 size={14} color="#0D9488" />
                    <span>IV Sedation & Sleep Dentistry</span>
                  </div>
                  <div className={styles.highlightPill}>
                    <CheckCircle2 size={14} color="#0D9488" />
                    <span>Custom Micro-Layered Veneers</span>
                  </div>
                </div>

                <Button
                  variant="primary"
                  fullWidth
                  size="md"
                  icon={<Calendar size={16} />}
                  onClick={() => handleOpenBooking(2)}
                >
                  Book with Dr. Vance
                </Button>
              </div>
            </div>
          </div>
        </section>

        {/* ========================================================
            SERVICES & TREATMENTS BREAKDOWN (NasrTech REA Spec)
            ======================================================== */}
        <section id="services" className={styles.servicesSection}>
          <div className={styles.container}>
            <div className={styles.sectionTitleCenter}>
              <Badge variant="primary" size="md">Specialized Dental Services</Badge>
              <h2>Comprehensive Restorative & Cosmetic Treatments</h2>
              <p>Every procedure is engineered with digital precision, pain minimization, and lasting clinical longevity.</p>
            </div>

            <div className={styles.servicesGrid}>
              {[
                {
                  id: 1,
                  title: 'Comprehensive Diagnostic Exam',
                  cat: 'Preventive Care',
                  desc: 'High-resolution digital panoramic X-rays, 3D intraoral optical scanning, periodontal probe mapping, and oral cancer screening.',
                  duration: '45 mins',
                  price: '$89',
                  badge: 'Essential',
                },
                {
                  id: 2,
                  title: 'Guided Dental Implants (All-on-4)',
                  cat: 'Implantology',
                  desc: 'Computer-guided titanium implant fixture placement with surgical guide stent and same-day provisional screw-retained crown.',
                  duration: '90 mins',
                  price: '$1,850',
                  badge: 'Lifetime Warranty',
                },
                {
                  id: 3,
                  title: 'Invisalign Clear Aligners',
                  cat: 'Orthodontics',
                  desc: 'Discreet, custom-milled thermoplastic orthodontic aligners for teeth straightening, gap closure, and bite realignment.',
                  duration: '30 mins',
                  price: '$3,200',
                  badge: 'Top Choice',
                },
                {
                  id: 4,
                  title: 'Porcelain Veneers & Makeovers',
                  cat: 'Cosmetic',
                  desc: 'Ultra-thin hand-crafted ceramic shells bonded to facial tooth surfaces to transform discoloration, gaps, and chips.',
                  duration: '60 mins',
                  price: '$950',
                  badge: 'Natural Aesthetics',
                },
                {
                  id: 5,
                  title: 'Microscopic Endodontics (Root Canal)',
                  cat: 'Endodontics',
                  desc: 'Gentle rotary canal disinfection under high-magnification surgical microscope with 3D biocompatible obturation.',
                  duration: '75 mins',
                  price: '$650',
                  badge: 'Pain-Free',
                },
                {
                  id: 6,
                  title: 'Emergency Dental Trauma & Relief',
                  cat: '24/7 Emergency',
                  desc: 'Immediate clinical intervention for severe acute toothache, crown fractures, dental abscesses, or facial trauma.',
                  duration: '45 mins',
                  price: '$150',
                  badge: 'Immediate Standby',
                  isEmergency: true,
                },
              ].map((service) => (
                <div
                  key={service.id}
                  className={`${styles.serviceCard} ${service.isEmergency ? styles.emergencyCard : ''}`}
                >
                  <div className={styles.serviceHeader}>
                    <span className={styles.serviceCategory}>{service.cat}</span>
                    <Badge variant={service.isEmergency ? 'emergency' : 'primary'} size="sm">
                      {service.badge}
                    </Badge>
                  </div>
                  <h3>{service.title}</h3>
                  <p>{service.desc}</p>
                  <div className={styles.serviceFooter}>
                    <div className={styles.servicePricing}>
                      <span className={styles.priceLabel}>Starting from</span>
                      <span className={styles.priceValue}>{service.price}</span>
                    </div>
                    <Button
                      variant={service.isEmergency ? 'emergency' : 'primary'}
                      size="sm"
                      icon={<ArrowRight size={14} />}
                      onClick={() => handleOpenBooking(service.id)}
                    >
                      Book Slot
                    </Button>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* ========================================================
            BEFORE & AFTER SMILE MAKEOVER SLIDER (Interactive)
            ======================================================== */}
        <section id="makeover" className={styles.makeoverSection}>
          <div className={styles.container}>
            <div className={styles.makeoverGrid}>
              <div className={styles.makeoverText}>
                <Badge variant="accent" size="md">Clinical Visual Proof</Badge>
                <h2>Interactive Smile Transformations</h2>
                <p>
                  Drag the slider to compare pre-operative tooth discoloration and misalignment against our custom porcelain veneer restorations.
                </p>

                <div className={styles.transformationDetails}>
                  <div className={styles.detailRow}>
                    <CheckCircle2 size={16} color="#0D9488" />
                    <div>
                      <strong>Patient Case #3482: 8 Upper Porcelain Veneers</strong>
                      <p>Corrected severe tetracycline staining and enamel micro-fractures in 2 visits.</p>
                    </div>
                  </div>
                  <div className={styles.detailRow}>
                    <CheckCircle2 size={16} color="#0D9488" />
                    <div>
                      <strong>Zero Pain Sedation Protocol</strong>
                      <p>Full restorative treatment performed under nitrous oxide conscious sedation.</p>
                    </div>
                  </div>
                </div>

                <Button
                  variant="primary"
                  size="md"
                  icon={<Calendar size={16} />}
                  onClick={() => handleOpenBooking(4)}
                >
                  Schedule Smile Consultation
                </Button>
              </div>

              {/* Interactive Comparison Slider */}
              <div className={styles.sliderContainer}>
                <div className={styles.sliderWrapper}>
                  {/* Before (Underneath) */}
                  <div className={styles.beforeFrame}>
                    <div className={styles.simulatedSmileBefore}>
                      <span className={styles.tag}>BEFORE TREATMENT</span>
                      <p className={styles.clinicalNotes}>Discoloration, Enamel Erosion, Misalignment</p>
                    </div>
                  </div>

                  {/* After (Clipped over top) */}
                  <div
                    className={styles.afterFrame}
                    style={{ clipPath: `inset(0 0 0 ${sliderPosition}%)` }}
                  >
                    <div className={styles.simulatedSmileAfter}>
                      <span className={styles.tag}>AFTER CLINICAL MAKEOVER</span>
                      <p className={styles.clinicalNotes}>Custom Hand-Layered E-Max Porcelain Veneers</p>
                    </div>
                  </div>

                  {/* Draggable Divider Line */}
                  <div
                    className={styles.sliderDivider}
                    style={{ left: `${sliderPosition}%` }}
                  >
                    <div className={styles.sliderHandle}>
                      <Sliders size={16} />
                    </div>
                  </div>

                  <input
                    type="range"
                    min="0"
                    max="100"
                    value={sliderPosition}
                    className={styles.rangeOverlay}
                    onChange={(e) => setSliderPosition(Number(e.target.value))}
                    aria-label="Drag before and after transformation slider"
                  />
                </div>
                <span className={styles.sliderHint}>&larr; Drag slider left and right to inspect result &rarr;</span>
              </div>
            </div>
          </div>
        </section>

        {/* ========================================================
            DOCTORS & SPECIALISTS TEAM SECTION
            ======================================================== */}
        <section id="doctors" className={styles.doctorsSection}>
          <div className={styles.container}>
            <div className={styles.sectionTitleCenter}>
              <Badge variant="primary" size="md">Master Clinical Specialists</Badge>
              <h2>Meet Our Attending Dental Team</h2>
              <p>Multidisciplinary specialists collaborating to deliver exceptional oral healthcare under one roof.</p>
            </div>

            <div className={styles.doctorsGrid}>
              {[
                {
                  id: 1,
                  name: 'Dr. Alexander Vance, DDS, FACP',
                  role: 'Clinical Director & Prosthodontist',
                  school: 'Harvard School of Dental Medicine',
                  exp: '16+ Years Experience',
                  skills: ['Implantology', 'Full-Mouth Rehabilitation', 'All-on-4'],
                },
                {
                  id: 2,
                  name: 'Dr. Elena Rostova, DMD, MS',
                  role: 'Chief Orthodontist & Dentofacial Orthopedics',
                  school: 'Columbia University College of Dental Medicine',
                  exp: '12+ Years Experience',
                  skills: ['Invisalign Diamond Provider', 'Surgical Orthodontics', 'Lingual Braces'],
                },
                {
                  id: 3,
                  name: 'Dr. Marcus Chen, DDS',
                  role: 'Endodontist & Microsurgeon',
                  school: 'Penn Dental Medicine',
                  exp: '10+ Years Experience',
                  skills: ['Microscopic Root Canal', 'Apicoectomy', 'Trauma Management'],
                },
              ].map((doc) => (
                <div key={doc.id} className={styles.doctorCard}>
                  <div className={styles.docAvatarHeader}>
                    <div className={styles.avatarCircle}>
                      <Stethoscope size={36} />
                    </div>
                    <Badge variant="primary" size="sm">{doc.exp}</Badge>
                  </div>
                  <h3>{doc.name}</h3>
                  <span className={styles.docRole}>{doc.role}</span>
                  <p className={styles.docSchool}>{doc.school}</p>
                  <div className={styles.skillPills}>
                    {doc.skills.map((s, idx) => (
                      <span key={idx} className={styles.skillPill}>{s}</span>
                    ))}
                  </div>
                  <Button
                    variant="outline"
                    fullWidth
                    size="sm"
                    icon={<Calendar size={14} />}
                    onClick={() => handleOpenBooking()}
                  >
                    View Available Slots
                  </Button>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* ========================================================
            WAAS PRICING & MEMBERSHIP CALCULATOR (/ux-ui-max-pro)
            ======================================================== */}
        <section id="pricing" className={styles.pricingSection}>
          <div className={styles.container}>
            <div className={styles.sectionTitleCenter}>
              <Badge variant="accent" size="md">Transparent Patient Economics</Badge>
              <h2>Dental Membership & Care Plans</h2>
              <p>No insurance? No problem. Receive comprehensive preventative care and 20% off all procedures.</p>

              {/* Billing Cycle Switcher */}
              <div className={styles.pricingToggleGroup}>
                <button
                  type="button"
                  className={`${styles.toggleBtn} ${billingPeriod === 'monthly' ? styles.active : ''}`}
                  onClick={() => setBillingPeriod('monthly')}
                >
                  Monthly Plan ($39/mo)
                </button>
                <button
                  type="button"
                  className={`${styles.toggleBtn} ${billingPeriod === 'annual' ? styles.active : ''}`}
                  onClick={() => setBillingPeriod('annual')}
                >
                  Annual (Save 15% - $399/yr)
                </button>
              </div>
            </div>

            <div className={styles.pricingCardsGrid}>
              <div className={styles.pricingCard}>
                <span className={styles.planBadge}>Individual Care</span>
                <h3>Essential Dental Care</h3>
                <div className={styles.priceRow}>
                  <span className={styles.currency}>$</span>
                  <strong className={styles.amount}>{billingPeriod === 'monthly' ? '39' : '33'}</strong>
                  <span className={styles.period}>/month</span>
                </div>
                <p className={styles.planSub}>Ideal for adults seeking regular preventative oral maintenance.</p>
                <ul className={styles.featureList}>
                  <li><CheckCircle2 size={16} /> 2 Professional Cleanings & Exams per year</li>
                  <li><CheckCircle2 size={16} /> Annual Digital 3D Panoramic X-Ray Scan</li>
                  <li><CheckCircle2 size={16} /> 1 Emergency Exam with X-Ray included</li>
                  <li><CheckCircle2 size={16} /> 20% Discount on Fillings, Implants & Veneers</li>
                </ul>
                <Button variant="outline" fullWidth size="md" onClick={() => handleOpenBooking()}>
                  Enroll in Essential
                </Button>
              </div>

              <div className={`${styles.pricingCard} ${styles.popularCard}`}>
                <div className={styles.popularRibbon}>Most Popular Plan</div>
                <span className={styles.planBadge}>Family & Cosmetic</span>
                <h3>Complete VIP Care</h3>
                <div className={styles.priceRow}>
                  <span className={styles.currency}>$</span>
                  <strong className={styles.amount}>{billingPeriod === 'monthly' ? '79' : '67'}</strong>
                  <span className={styles.period}>/month</span>
                </div>
                <p className={styles.planSub}>Comprehensive coverage for cosmetic whitening and dental restorative work.</p>
                <ul className={styles.featureList}>
                  <li><CheckCircle2 size={16} /> 4 Deep Cleanings & Periodontal Checks</li>
                  <li><CheckCircle2 size={16} /> Complimentary Annual In-Office Teeth Whitening</li>
                  <li><CheckCircle2 size={16} /> 24/7 Priority Emergency Access (Zero Wait)</li>
                  <li><CheckCircle2 size={16} /> 25% Discount on Aligners & Dental Implants</li>
                  <li><CheckCircle2 size={16} /> Free Oral Sedation for All Surgical Visits</li>
                </ul>
                <Button variant="primary" fullWidth size="md" onClick={() => handleOpenBooking()}>
                  Enroll in Complete VIP
                </Button>
              </div>
            </div>
          </div>
        </section>

        {/* ========================================================
            VERIFIED PATIENT REVIEWS & SOCIAL PROOF
            ======================================================== */}
        <section id="reviews" className={styles.reviewsSection}>
          <div className={styles.container}>
            <div className={styles.sectionTitleCenter}>
              <Badge variant="primary" size="md">Verified Patient Testimonials</Badge>
              <h2>Real Experiences, Transformed Lives</h2>
              <p>Read authenticated reviews from patients treated across our 3 clinic locations.</p>
            </div>

            <div className={styles.reviewsGrid}>
              {[
                {
                  author: 'Sarah Jenkins',
                  location: 'Metro Dental HQ',
                  review: 'Dr. Vance transformed my confidence with 6 front veneers. The entire appointment was completely pain-free, and the 3D intraoral scan made the process so fast and comfortable.',
                  procedure: 'Porcelain Veneers & Makeover',
                  stars: 5,
                },
                {
                  author: 'Michael Rodriguez',
                  location: 'Downtown Smiles',
                  review: 'I suffered a dental emergency on a Saturday evening. The 24/7 WhatsApp hub got me in within 45 minutes, and they relieved my acute pain immediately. Truly lifesavers!',
                  procedure: 'Emergency Trauma Relief',
                  stars: 5,
                },
                {
                  author: 'Emily Watson',
                  location: 'Westside Pediatric & Family',
                  review: 'The staff are so warm and compassionate. I completed my Invisalign treatment in just 8 months. Transparent pricing with no surprise charges.',
                  procedure: 'Invisalign Clear Aligners',
                  stars: 5,
                },
              ].map((rev, idx) => (
                <div key={idx} className={styles.reviewCard}>
                  <div className={styles.reviewStars}>
                    {[...Array(rev.stars)].map((_, i) => (
                      <Star key={i} size={15} fill="#F59E0B" color="#F59E0B" />
                    ))}
                  </div>
                  <p className={styles.reviewBody}>&ldquo;{rev.review}&rdquo;</p>
                  <div className={styles.reviewAuthor}>
                    <strong>{rev.author}</strong>
                    <span>{rev.procedure} • {rev.location}</span>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* ========================================================
            CLINICAL FAQ ACCORDION
            ======================================================== */}
        <section id="faq" className={styles.faqSection}>
          <div className={styles.containerNarrow}>
            <div className={styles.sectionTitleCenter}>
              <Badge variant="primary" size="md">Patient Guidelines</Badge>
              <h2>Frequently Asked Clinical Questions</h2>
              <p>Everything you need to know about scheduling, dental anxiety, and insurance coverage.</p>
            </div>

            <div className={styles.faqList}>
              {[
                {
                  q: 'Are your dental implant and restoration procedures pain-free?',
                  a: 'Yes. We utilize computerized local anesthetic delivery (The Wand) alongside optional nitrous oxide or oral conscious sedation. Patients report feeling gentle pressure without discomfort.',
                },
                {
                  q: 'How does real-time online appointment scheduling work?',
                  a: 'Our booking wizard directly queries live doctor shift rosters and chair availability. Once you pick an opening, it is held instantly and you receive immediate SMS and WhatsApp confirmations.',
                },
                {
                  q: 'Do you accept dental insurance and financing plans?',
                  a: 'We accept all major PPO insurance networks and provide direct claim billing. We also offer 0% interest financing for up to 24 months through CareCredit and our in-house Dental Membership plan.',
                },
                {
                  q: 'What should I do in an acute dental emergency?',
                  a: 'Call our 24/7 Emergency Line immediately at (555) 019-2830 or use our WhatsApp Support Hub. Emergency patients receive priority immediate seating across our 3 branches.',
                },
              ].map((faq, idx) => (
                <div
                  key={idx}
                  className={`${styles.faqItem} ${openFaq === idx ? styles.open : ''}`}
                >
                  <button
                    type="button"
                    className={styles.faqQuestion}
                    onClick={() => setOpenFaq(openFaq === idx ? null : idx)}
                    aria-expanded={openFaq === idx}
                  >
                    <span>{faq.q}</span>
                    <ChevronDown size={18} className={styles.chevron} />
                  </button>
                  {openFaq === idx && (
                    <div className={styles.faqAnswer}>
                      <p>{faq.a}</p>
                    </div>
                  )}
                </div>
              ))}
            </div>
          </div>
        </section>
      </main>

      {/* Comprehensive Footer */}
      <Footer />

      {/* High-Conversion Floating WhatsApp Hub */}
      <WhatsAppHub onOpenBooking={() => handleOpenBooking()} />

      {/* 5-Step Real-Time Booking Wizard Modal */}
      <BookingWizard
        isOpen={bookingOpen}
        onClose={() => setBookingOpen(false)}
        preselectedServiceId={selectedServiceId}
      />
    </div>
  );
}
