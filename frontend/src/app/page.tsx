'use client';

import React, { useState } from 'react';
import styles from './page.module.scss';
import { AcocksGreenHeader } from '@/components/organisms/AcocksGreenHeader';
import { AcocksGreenHero } from '@/components/organisms/AcocksGreenHero';
import { AcocksGreenServices } from '@/components/organisms/AcocksGreenServices';
import { AcocksGreenAbout } from '@/components/organisms/AcocksGreenAbout';
import { Footer } from '@/components/organisms/Footer/Footer';
import { BookingWizard } from '@/components/organisms/BookingWizard/BookingWizard';
import { WhatsAppHub } from '@/components/ui/WhatsAppHub/WhatsAppHub';
import { Button } from '@/components/ui/Button/Button';
import { Badge } from '@/components/ui/Badge/Badge';
import {
  Calendar,
  Star,
  CheckCircle2,
  ChevronDown,
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
      {/* Top Navbar with Acocks Green Medical Practice Theme */}
      <AcocksGreenHeader
        onOpenBooking={() => handleOpenBooking()}
        onOpenEmergency={() => handleOpenBooking(1)}
      />

      <main className={`${styles.mainContent} pt-28 bg-surface`}>
        {/* ========================================================
            PHASE 2: ACOCKS GREEN HERO & STATS SECTION
            ======================================================== */}
        <AcocksGreenHero
          onOpenBooking={() => handleOpenBooking()}
          onOpenEmergency={() => handleOpenBooking(1)}
        />

        {/* ========================================================
            PHASE 3: ACOCKS GREEN SERVICES GRID & ABOUT OUR SURGERY
            ======================================================== */}
        <AcocksGreenServices onOpenBooking={handleOpenBooking} />

        <AcocksGreenAbout onOpenBooking={handleOpenBooking} />

        {/* ========================================================
            BEFORE & AFTER SMILE MAKEOVER SLIDER (Interactive)
            ======================================================== */}
        <section id="makeover" className={styles.makeoverSection}>
          <div className={styles.container}>
            <div className={styles.makeoverGrid}>
              <div className={styles.makeoverText}>
                <span className={styles.sectionSubtitle}>Clinical Visual Proof</span>
                <h2>Interactive Smile Transformations</h2>
                <p>
                  Drag the slider to compare pre-operative tooth discoloration and misalignment against our custom porcelain veneer restorations.
                </p>

                <div className={styles.transformationDetails}>
                  <div className={styles.detailRow}>
                    <CheckCircle2 size={16} color="#0D9488" />
                    <div>
                      <strong>Case #ADC-4102: Upper Arch Aesthetic Restoration</strong>
                      <p>Corrected discoloration and enamel spacing with 8 handcrafted E-Max porcelain veneers.</p>
                    </div>
                  </div>
                  <div className={styles.detailRow}>
                    <CheckCircle2 size={16} color="#0D9488" />
                    <div>
                      <strong>Gentle Sedation Protocol</strong>
                      <p>Full aesthetic treatment completed comfortably across two relaxing clinical visits.</p>
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
                      <img
                        src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=800&q=80"
                        alt="Pre-treatment dental alignment"
                        className={styles.sliderImage}
                        loading="lazy"
                      />
                      <div className={styles.imageOverlayLabel}>
                        <strong>Before Treatment</strong>
                        <span>Enamel Staining & Irregular Spacing</span>
                      </div>
                    </div>
                  </div>

                  {/* After (Clipped over top) */}
                  <div
                    className={styles.afterFrame}
                    style={{ clipPath: `inset(0 0 0 ${sliderPosition}%)` }}
                  >
                    <div className={styles.simulatedSmileAfter}>
                      <img
                        src="https://images.unsplash.com/photo-1606811841689-23dfddce3e95?auto=format&fit=crop&w=800&q=80"
                        alt="Post-makeover radiant smile"
                        className={styles.sliderImage}
                        loading="lazy"
                      />
                      <div className={styles.imageOverlayLabel}>
                        <strong>After Makeover</strong>
                        <span>Handcrafted E-Max Porcelain Veneers</span>
                      </div>
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
              <span className={styles.sectionSubtitle}>Master Clinical Specialists</span>
              <h2>Meet Our Attending Dental Team</h2>
              <p>Multidisciplinary specialists collaborating to deliver exceptional oral healthcare under one roof.</p>
            </div>

            <div className={styles.doctorsGrid}>
              {[
                {
                  id: 1,
                  name: 'Dr. Ethan Caldwell, DDS, FACP',
                  role: 'Clinical Director & Prosthodontist',
                  school: 'Midwestern University College of Dental Medicine',
                  exp: '16+ Years Experience',
                  image: 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80',
                  skills: ['Implantology', 'Full-Mouth Rehabilitation', 'All-on-4'],
                },
                {
                  id: 2,
                  name: 'Dr. Maya Lin, DMD, MS',
                  role: 'Chief Orthodontist & Dentofacial Orthopedics',
                  school: 'Pacific University School of Dentistry',
                  exp: '12+ Years Experience',
                  image: 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80',
                  skills: ['Invisalign Clear Aligners', 'Interceptive Orthodontics', 'Bite Alignment'],
                },
                {
                  id: 3,
                  name: 'Dr. Marcus Vance, DDS',
                  role: 'Endodontist & Microsurgical Specialist',
                  school: 'American Dental Institute of Science',
                  exp: '10+ Years Experience',
                  image: 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=600&q=80',
                  skills: ['Microscopic Root Canal', 'Apicoectomy', 'Dental Trauma Management'],
                },
                {
                  id: 4,
                  name: 'Dr. Olivia Harper, DDS',
                  role: 'Pediatric Dental & Family Specialist',
                  school: 'National Health Dental College',
                  exp: '8+ Years Experience',
                  image: 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80',
                  skills: ['Gentle Pediatric Care', 'Preventive Sealants', 'Biofilm Elimination'],
                },
              ].map((doc) => (
                <div key={doc.id} className={styles.doctorCard}>
                  <div className={styles.docAvatarHeader}>
                    <div className={styles.avatarCircle}>
                      <img
                        src={doc.image}
                        alt={doc.name}
                        className={styles.avatarImage}
                        loading="lazy"
                      />
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
                    onClick={() => handleOpenBooking(doc.id)}
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
              <span className={styles.sectionSubtitle}>Transparent Patient Economics</span>
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
                <h3>Essential Dental Care</h3>
                <span className={styles.planBadge}>Individual Care</span>
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
                <h3>Complete VIP Care</h3>
                <span className={styles.planBadge}>Family & Cosmetic</span>
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
              <span className={styles.sectionSubtitle}>Verified Patient Testimonials</span>
              <h2>Real Experiences, Transformed Lives</h2>
              <p>Read authenticated reviews from patients treated across our 3 clinic locations.</p>
            </div>

            <div className={styles.reviewsGrid}>
              {[
                {
                  author: 'Jennifer Hayes',
                  location: 'Central Practice (Austin)',
                  review: 'Dr. Caldwell and the clinical team made my implant consultation so reassuring. The 3D imaging explained every step clearly, and the procedure was completely painless.',
                  procedure: 'Dental Implant Consultation',
                  stars: 5,
                },
                {
                  author: 'Robert Martinez',
                  location: 'Westside Cosmetic Studio',
                  review: 'I started clear aligners 6 months ago with Dr. Lin. The digital scans are so fast and the progress has been incredible. Exceptional modern clinic with transparent pricing.',
                  procedure: 'Invisalign Clear Aligners',
                  stars: 5,
                },
                {
                  author: 'Amanda Collins',
                  location: 'Northside Family Center',
                  review: 'Brought my two children for their routine dental cleanings. Dr. Harper has a gentle touch and made both kids feel completely at ease. Truly a warm, patient-first dental home.',
                  procedure: 'Family Preventative Care',
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
              <span className={styles.sectionSubtitle}>Patient Guidelines</span>
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
