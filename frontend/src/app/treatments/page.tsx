'use client';

import React, { useState, useEffect } from 'react';
import Link from 'next/link';
import { AcocksGreenHeader } from '@/components/organisms/AcocksGreenHeader/AcocksGreenHeader';
import { AcocksGreenFooter } from '@/components/organisms/AcocksGreenFooter/AcocksGreenFooter';
import { BookingWizard } from '@/components/organisms/BookingWizard/BookingWizard';
import { WhatsAppHub } from '@/components/ui/WhatsAppHub/WhatsAppHub';

// Initial resilient fallback data matching CMS Website Management & Acocks Green Clinical System
const INITIAL_CMS_TREATMENTS = {
  eyebrow: 'OUR CLINICAL SERVICES & PROCEDURES',
  title: 'Comprehensive Dental Care & Specialized Treatments',
  subtitle:
    'From essential routine NHS care to advanced cosmetic smile makeovers and restorative procedures in Acocks Green, Birmingham. Delivered with gentle compassion and state-of-the-art diagnostics.',
  categories: [
    { id: 'all', label: 'All Services' },
    { id: 'general', label: 'General Dentistry' },
    { id: 'hygiene', label: 'Hygiene & Prevention' },
    { id: 'restorative', label: 'Restorative Dentistry' },
    { id: 'aesthetic', label: 'Aesthetic & Cosmetic' },
    { id: 'emergency', label: 'Emergency & Surgery' },
  ],
  services: [
    {
      id: 1,
      category: 'general',
      categoryEyebrow: 'Core Healthcare',
      icon: 'dentistry',
      badge: 'NHS & Private Available',
      badgeClass: 'bg-primary text-on-primary',
      title: 'General Dentistry & Routine Check-ups',
      description:
        'Thorough digital oral examinations, low-dose digital radiographs, routine cleaning, gentle composite fillings, and preventative treatments designed to maintain lifelong dental health.',
      features: [
        'Comprehensive Oral Health Exam',
        'Preventative Sealants & Fluoride',
        'High-durability Tooth-Coloured Fillings',
        'Digital Diagnostics',
      ],
      image:
        'https://lh3.googleusercontent.com/aida/ALJJyrBulpLAFKRcjrRGV6hulvVqTB_rylHNa1m79uzT1KOptIUdEQlbsIdBtjKKhY-4imQeQRBCad4E3wgyJN4aNGDfiL73ORavlpjtXWneM74i_j5cT7DpDhAsvlMinjPXDf3ufvMWE_xMI-fZ4_4H6fVZc-seyiL4IPS4LdyN0hIL1ArRgFqHO29uWKhEL5GIPlmT0mCjCONg3zJEXosyzBOWIBthmahxmy2c-j-xLg9_',
      ctaText: 'View General Dentistry Details',
    },
    {
      id: 2,
      category: 'hygiene',
      categoryEyebrow: 'Periodontal Health',
      icon: 'clean_hands',
      badge: 'Led by Claire (Hygienist)',
      badgeClass: 'bg-tertiary-container text-on-primary',
      title: 'Dental Hygiene & Airflow Periodontics',
      description:
        'Specialist ultrasonic periodontal deep cleaning, gentle stubborn stain removal (tea, coffee, tobacco), airflow polish therapy, and personalized plaque defense coaching.',
      features: [
        'Ultrasonic Scaling & Polishing',
        'Airflow Stain Removal Treatment',
        'Gingival & Periodontal Assessment',
        'Personalized Home Care Plans',
      ],
      image:
        'https://lh3.googleusercontent.com/aida/ALJJyrC3kB9wbfNCQ8zjPfAniHa05giYtxRDiO5WHljU7BjQWp2DBSndqgwSHtqUcaGJorilRTthHpDfq5vmlvCmmw9-eWc5Lsl-oHEbmE9NtqyC8mHOU7uCyXU2Vec9QNHgNZSkRDoqu0tt2yMStVb_Ta60bO9vEYEPDrzBH4ludY8iIaXytrlDkOtv8XhD4tzMDjqU5Fr_MPUY_V4dvQ_89APb60Tfsl1BBeT1N0DQJ6e-6Q',
      ctaText: 'Explore Hygiene Services',
    },
    {
      id: 3,
      category: 'restorative',
      categoryEyebrow: 'Structural Repair',
      icon: 'architecture',
      badge: 'Function & Biomechanics',
      badgeClass: 'bg-secondary text-on-secondary',
      title: 'Restorative Dentistry & Dental Crowns',
      description:
        'Rebuild chewing function, comfort, and structural integrity with precision custom ceramic crowns, bridge work, root canal therapy, and long-lasting prosthetics.',
      features: [
        'Custom Porcelain & Zirconia Crowns',
        'Root Canal Endodontic Therapy',
        'Fixed Bridgework & Inlays/Onlays',
        'Tooth Wear & Bite Rehabilitation',
      ],
      image:
        'https://lh3.googleusercontent.com/aida/ALJJyrDPUq5ohOJ-ZEgA0z8fZ0Ny8xwYb0gAFbKmCTeAdlTzuvtHVtjzbx_4vXZWqzzHoxTtuqCmjl2wHTlqdj0mEk0UeBQMl5f_RwGv3Vn-kcBjbyF4rpaE9WGzD-0lti9csVOvtFlaeJpmSYmTk47jZZHzKXtluORH5Yix-U-saz8J8fAdRj3uct8isBDFPZVhqBplvNqrlhaK9D1ZuyzBnBDA9hF705iJInkP-qW-D6-O-Q',
      ctaText: 'Learn About Restorative Care',
    },
    {
      id: 4,
      category: 'aesthetic',
      categoryEyebrow: 'Cosmetic Artistry',
      icon: 'auto_fix_high',
      badge: 'Boutique Smile Design',
      badgeClass: 'bg-primary-container text-on-primary',
      title: 'Aesthetic Dentistry & Invisalign® Aligners',
      description:
        'Transform and illuminate your smile with professional boutique whitening treatments, bespoke handcrafted veneers, composite bonding, and discreet clear aligners.',
      features: [
        'Invisalign® Clear Aligner Therapy',
        'Boutique Teeth Whitening Systems',
        'Handcrafted Porcelain Veneers',
        'Minimally Invasive Composite Bonding',
      ],
      image:
        'https://lh3.googleusercontent.com/aida/ALJJyrAQ-F1QuRaRrEd6FO4rB8ZvgBInl_6NGw3m5qTdAD6ft5AVqjSJt2pnhFLMkhcy30r82pynr0xWmUXphGOIEYXSTnqYkLI7Ybf30wNQHeLKwPA1-H257X2ZjKnovt45mYM7ivHcn2D9p_hpZS50gzDZSvs-5afZjOejZFbdiK5MiRR1pt1rZDL0AQt2lCFfMGHXM7Ta32BgCRJiqbuKTqBVJu-kjQBCyMGLcLmSyW06',
      ctaText: 'Discover Aesthetic Options',
    },
    {
      id: 5,
      category: 'emergency',
      categoryEyebrow: 'Urgent Intervention',
      icon: 'medical_services',
      iconColor: 'text-status-error',
      badge: 'Same-Day Emergency Slots',
      badgeClass: 'bg-status-error text-on-error',
      badgeIcon: 'alarm_on',
      title: 'Emergency Dental Care & Urgent Pain Relief',
      description:
        'Rapid triage and immediate pain relief for severe toothache, broken teeth, lost fillings, dental abscesses, or facial trauma. Priority same-day bookings available.',
      features: [
        'Immediate Triage on +44 121 765 2870',
        'Acute Pulpitis & Abscess Treatment',
        'Temporary & Urgent Restorations',
        'Gentle Extraction when Required',
      ],
      image:
        'https://lh3.googleusercontent.com/aida/ALJJyrBcbHFf72C77aVCUJUqKG_wMcQ96MHwndkHljTZQTge2WyNvRxft4HbcWsF7eJxg347VvGHmdMpoOc3LvQho_dEU--KG2jkpNZ-IKwPY8tbFG_SMF6dMj8VPBBlHbpX5_0Qfyfe1rqJ3nsHMSUfWmAvLHEWo2omHCaxFxegt5k23pyUfzMYz0jjEa8rbzNHDK267WYwfMnlmeiEpIWRVh1VGoPox9ZskfxqGCYkm1ppyA',
      ctaText: 'Emergency Care Guidance',
      ctaPhone: true,
    },
    {
      id: 6,
      category: 'general',
      categoryEyebrow: 'Family Dentistry',
      icon: 'family_restroom',
      badge: 'Child-Friendly Environment',
      badgeClass: 'bg-secondary-container text-on-secondary-container',
      title: 'Pediatric & Family Dentistry',
      description:
        'A welcoming, reassuring environment for young patients. Fostering positive attitudes toward oral care through gentle examinations and preventive advice.',
      features: [
        'Gentle First Dental Visits',
        'Fissure Sealants & Fluoride Varnishes',
        'Diet & Sugar Acid Advice',
        'Early Orthodontic Monitoring',
      ],
      image:
        'https://lh3.googleusercontent.com/aida/ALJJyrAjr3mnx__gb3icEsidfNmN0Yo6SfWItzxqvKPt0BHI-BgWjtfZ7dxRK_mFr319KIaMV1fLsMfTgBACJbQQZCc_2lGVgavBj6hsNKJkpmGqzjuJIkAnzz4pxSruMh4CSYpJUOab7wCqkYZsiKr6aJuJ5RWzw1OeCKE11bMraDRgDLvzYr6_SDI1JxDvLl0gMm8zyxovQi1MVn9a3EplE8ZnkGJYeJLr0jRbkJ5yU90Whw',
      ctaText: 'Family Dentistry Services',
    },
  ],
  pricingNhs: [
    {
      band: 'Band 1 Treatment',
      desc: 'Check-up, digital x-rays, basic polish & diagnosis',
      price: '£26.80',
    },
    {
      band: 'Band 2 Treatment',
      desc: 'Fillings, root canal therapy & tooth extractions',
      price: '£73.50',
    },
    {
      band: 'Band 3 Treatment',
      desc: 'Complex crowns, precision bridges & full/partial dentures',
      price: '£319.10',
    },
    {
      band: 'Urgent Care Band',
      desc: 'Immediate emergency relief, triage & temporary dressing',
      price: '£26.80',
      isUrgent: true,
    },
  ],
  pricingPrivate: [
    {
      service: 'Hygiene Airflow Polish',
      desc: '30-min intensive ultrasonic scale & air polish stain removal',
      price: '£65.00',
      prefix: 'From',
    },
    {
      service: 'Boutique Teeth Whitening',
      desc: 'Customized take-home whitening trays with high-strength gel',
      price: '£299.00',
      prefix: 'From',
    },
    {
      service: 'Composite Bonding',
      desc: 'Micro-layer aesthetic sculpting per tooth with zero drilling',
      price: '£150.00',
      prefix: 'Per Tooth',
    },
    {
      service: 'Invisalign® Clear Consultation',
      desc: 'Full 3D digital scan & computerized treatment smile simulator',
      price: 'Complimentary',
      prefix: '',
    },
  ],
  pillars: [
    {
      icon: 'radiology',
      title: 'Modern Digital Technology',
      description:
        'Ultra-low radiation digital radiography and high-definition intraoral cameras for precise, comfortable diagnoses.',
      tag: 'Digital Precision',
    },
    {
      icon: 'favorite',
      title: 'Welcoming Phobic Patients',
      description:
        'A gentle, unhurried bedside manner designed specifically to dissolve dental anxiety, panic, and sensory discomfort.',
      tag: 'Gentle Pacing',
    },
    {
      icon: 'calendar_clock',
      title: 'Flexible Appointments',
      description:
        'Early morning slots from 8:30 AM and guaranteed priority emergency triage windows throughout each working day.',
      tag: 'Prompt Access',
    },
    {
      icon: 'verified',
      title: 'Strict NHS & CQC Safety',
      description:
        'Strict compliance with Care Quality Commission infection controls, NHS safety charters, and gold-standard autoclaving.',
      tag: '100% CQC Compliant',
    },
  ],
};

export default function TreatmentsPage() {
  const [bookingOpen, setBookingOpen] = useState(false);
  const [selectedServiceId, setSelectedServiceId] = useState<number | undefined>(undefined);
  const [activeCategory, setActiveCategory] = useState<string>('all');
  const [cmsContent, setCmsContent] = useState(INITIAL_CMS_TREATMENTS);

  // Maintain Acocks Green clinical theme
  useEffect(() => {
    if (typeof window !== 'undefined') {
      document.documentElement.setAttribute('data-theme', 'acocks-green');
    }
  }, []);

  // Fetch dynamic CMS data from backend API
  useEffect(() => {
    const fetchCmsData = async () => {
      try {
        const res = await fetch('/api/v1/cms/pages/treatments');
        if (res.ok) {
          const data = await res.json();
          if (data?.success && data?.data) {
            const d = data.data;
            setCmsContent((prev) => ({
              ...prev,
              title: d.title || prev.title,
              eyebrow: d.eyebrow || prev.eyebrow,
              subtitle: d.subtitle || prev.subtitle,
            }));
          }
        }
      } catch {
        // Gracefully use complete local fallback for offline static export
      }
    };
    fetchCmsData();
  }, []);

  const handleOpenBooking = (serviceId?: number) => {
    setSelectedServiceId(serviceId);
    setBookingOpen(true);
  };

  const filteredServices =
    activeCategory === 'all'
      ? cmsContent.services
      : cmsContent.services.filter((s) => s.category === activeCategory);

  return (
    <>
      <AcocksGreenHeader
        onOpenBooking={() => handleOpenBooking()}
        onOpenEmergency={() => handleOpenBooking(1)}
      />

      <main className="min-h-screen pt-28 bg-surface text-on-surface">
        {/* ========================================================
            1. COMPACT INNER HERO BANNER & CATEGORY FILTERS
            ======================================================== */}
        <section className="w-full bg-surface py-6 lg:py-7 border-b border-border-subtle/50">
          <div className="max-w-7xl mx-auto px-6 lg:px-12">
            <div className="grid lg:grid-cols-12 gap-8 items-center">
              <div className="lg:col-span-7">
                {/* Breadcrumb Navigation */}
                <nav
                  aria-label="Breadcrumb"
                  className="flex items-center gap-1.5 font-label-sm text-label-sm text-on-surface-variant mb-2.5"
                >
                  <Link
                    href="/"
                    className="hover:text-primary transition-colors flex items-center gap-1"
                  >
                    <span className="material-symbols-outlined text-[15px]">home</span>
                    <span>Home</span>
                  </Link>
                  <span className="material-symbols-outlined text-[13px] text-outline">
                    chevron_right
                  </span>
                  <span className="text-primary font-semibold">Treatments &amp; Services</span>
                </nav>

                <span className="font-subheading-eyebrow text-subheading-eyebrow text-primary uppercase tracking-widest block mb-1.5 font-bold">
                  {cmsContent.eyebrow}
                </span>

                <h1 className="font-display-hero text-[32px] sm:text-[38px] lg:text-display-hero text-on-surface mb-2 tracking-tight leading-tight">
                  {cmsContent.title}
                </h1>

                <p className="font-body-md text-body-md text-on-surface-variant leading-relaxed mb-4 max-w-2xl">
                  {cmsContent.subtitle}
                </p>

                {/* Filter Pills Group */}
                <div
                  className="flex flex-wrap items-center gap-2"
                  id="service-filter-group"
                  role="tablist"
                >
                  {cmsContent.categories.map((cat) => {
                    const isActive = activeCategory === cat.id;
                    return (
                      <button
                        key={cat.id}
                        type="button"
                        role="tab"
                        aria-selected={isActive}
                        onClick={() => setActiveCategory(cat.id)}
                        className={`filter-btn font-label-md text-label-md px-3.5 py-1.5 rounded-lg transition-all duration-150 cursor-pointer ${
                          isActive
                            ? 'active bg-primary text-on-primary shadow-sm font-semibold'
                            : 'bg-surface-card border border-border-subtle text-on-surface-variant hover:text-on-surface hover:bg-surface-container'
                        }`}
                      >
                        {cat.label}
                      </button>
                    );
                  })}
                </div>
              </div>

              {/* Clinical Lead & Surgery Trust Banner */}
              <div className="lg:col-span-5 relative">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img
                  alt="Warm professional photo of friendly UK dentist doctor smiling warmly in modern clean dental clinic surgery"
                  className="rounded-2xl shadow-md border border-border-subtle/80 object-cover h-64 lg:h-72 w-full"
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuCCzsykyKI2PU6E0wW2t2do2Qt2jbZzaqv_u_IJJfWkGvhSuGk34VpR3MY2x4tckcQ7PvE8fx9330s7IMyCF22GzBT7fwxSeNcAOOD7tpfAxTZzm7QZCMGl6HzbuEloTxaCtsTeKlfT5IMQkb87H0BQKnEXK2e9CMWx1fSlXVcpfVg5S-JRnPWoyF_vquS3r9UtLCekgTGZVu6dH9nXrVl1I2ZJ-m95ISoH2D2GD9IF"
                />
                <div className="absolute bottom-3 left-3 right-3 bg-surface-card/95 backdrop-blur-md px-4 py-2.5 rounded-xl border border-border-subtle shadow-sm flex items-center justify-between">
                  <div>
                    <span className="font-label-sm text-label-sm text-primary font-bold block">
                      Dr. Richard C. Williams
                    </span>
                    <span className="text-[11px] text-on-surface-variant font-medium">
                      Clinical Director &amp; Lead Surgeon | GDC No: 178924
                    </span>
                  </div>
                  <span className="bg-primary/10 text-primary font-label-sm text-[11px] px-2.5 py-1 rounded-md font-semibold">
                    NHS &amp; Private
                  </span>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* ========================================================
            2. FEATURED CLINICAL SERVICE CARDS (DYNAMIC FILTER)
            ======================================================== */}
        <section className="w-full py-14 lg:py-16 border-b border-border-subtle/40 bg-surface-container-low">
          <div className="max-w-7xl mx-auto px-6 lg:px-12">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="services-grid">
              {filteredServices.map((card) => (
                <article
                  key={card.id}
                  data-category={card.category}
                  className="service-card group bg-surface-card rounded-2xl border border-border-subtle shadow-sm overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1.5 hover:shadow-lg"
                >
                  <div className="relative h-56 w-full overflow-hidden bg-surface-container-high">
                    {/* eslint-disable-next-line @next/next/no-img-element */}
                    <img
                      alt={card.title}
                      className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                      src={card.image}
                    />
                    <div
                      className={`absolute top-4 left-4 font-label-sm text-label-sm px-3 py-1 rounded-md shadow-sm flex items-center gap-1 ${card.badgeClass}`}
                    >
                      {card.badgeIcon && (
                        <span className="material-symbols-outlined text-[14px]">
                          {card.badgeIcon}
                        </span>
                      )}
                      <span>{card.badge}</span>
                    </div>
                  </div>

                  <div className="p-6 lg:p-7 flex flex-col flex-1 justify-between">
                    <div>
                      <div className="flex items-center gap-2 mb-2">
                        <span
                          className={`material-symbols-outlined text-[20px] ${
                            card.iconColor || 'text-primary'
                          }`}
                        >
                          {card.icon}
                        </span>
                        <span
                          className={`font-subheading-eyebrow text-subheading-eyebrow uppercase ${
                            card.iconColor || 'text-primary'
                          }`}
                        >
                          {card.categoryEyebrow}
                        </span>
                      </div>

                      <h2 className="font-headline-sm text-headline-sm text-on-surface mb-3 group-hover:text-primary transition-colors">
                        {card.title}
                      </h2>

                      <p className="font-body-md text-body-md text-on-surface-variant mb-6 leading-relaxed">
                        {card.description}
                      </p>

                      <ul className="flex flex-col gap-2.5 mb-6 text-on-surface-variant font-body-sm text-body-sm">
                        {card.features.map((feat, i) => (
                          <li key={i} className="flex items-center gap-2">
                            <span className="material-symbols-outlined text-primary text-[18px]">
                              check_circle
                            </span>
                            <span>{feat}</span>
                          </li>
                        ))}
                      </ul>
                    </div>

                    <div className="pt-4 border-t border-border-subtle flex items-center justify-between gap-3">
                      <button
                        type="button"
                        onClick={() => handleOpenBooking(card.id)}
                        className="inline-flex items-center gap-1.5 font-label-md text-label-md bg-primary-container text-on-primary px-3.5 py-2 rounded-lg shadow-xs hover:bg-primary transition-colors cursor-pointer"
                      >
                        <span className="material-symbols-outlined text-[16px]">calendar_month</span>
                        <span>Book Treatment</span>
                      </button>

                      {card.ctaPhone ? (
                        <a
                          href="tel:+441217652870"
                          className="inline-flex items-center gap-1 font-label-sm text-label-sm text-status-error font-semibold hover:underline"
                        >
                          <span>Call Triage</span>
                          <span className="material-symbols-outlined text-[16px]">call</span>
                        </a>
                      ) : (
                        <a
                          href="#quick-book"
                          className="inline-flex items-center gap-1 font-label-sm text-label-sm text-primary font-semibold group-hover:text-tertiary-container transition-colors"
                        >
                          <span>Guidance</span>
                          <span className="material-symbols-outlined text-[16px] transition-transform duration-200 group-hover:translate-x-0.5">
                            arrow_forward
                          </span>
                        </a>
                      )}
                    </div>
                  </div>
                </article>
              ))}
            </div>
          </div>
        </section>

        {/* ========================================================
            3. TREATMENT PRICING & NHS VS PRIVATE COMPARISON GUIDE
            ======================================================== */}
        <section className="w-full bg-surface py-14 lg:py-16 border-b border-border-subtle/40">
          <div className="max-w-7xl mx-auto px-6 lg:px-12">
            <div className="flex flex-col md:flex-row md:items-end justify-between mb-12">
              <div className="max-w-2xl">
                <span className="font-subheading-eyebrow text-subheading-eyebrow text-primary uppercase tracking-widest block mb-2 font-bold">
                  TRANSPARENT FINANCIAL CLARITY
                </span>
                <h2 className="font-headline-lg text-headline-lg text-on-surface tracking-tight">
                  Treatment Pricing &amp; Comparison Guide
                </h2>
                <p className="font-body-md text-body-md text-on-surface-variant mt-2.5">
                  We believe in honest, predictable clinical costs with no hidden fees. Choose between standard NHS tiered bandings or our tailored private aesthetic and restorative pathways.
                </p>
              </div>
              <div className="mt-6 md:mt-0 flex items-center gap-2 bg-brand-accent-glow px-4 py-2.5 rounded-xl border border-secondary-container">
                <span className="material-symbols-outlined text-primary text-[20px]">percent</span>
                <span className="font-label-sm text-label-sm text-primary font-bold">
                  0% APR Patient Financing Available
                </span>
              </div>
            </div>

            {/* Pricing Matrix Split */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
              {/* NHS Band Matrix Card */}
              <div className="bg-surface-card rounded-2xl p-8 border border-border-subtle shadow-sm flex flex-col justify-between">
                <div>
                  <div className="flex items-center justify-between pb-6 mb-6 border-b border-border-subtle">
                    <div>
                      <span className="font-subheading-eyebrow text-[11px] text-primary uppercase font-bold tracking-wider">
                        Public Health Service
                      </span>
                      <h3 className="font-headline-md text-headline-md text-on-surface">
                        NHS Fee Bands
                      </h3>
                    </div>
                    <span className="bg-surface-container-low text-on-surface font-label-md text-label-md px-3.5 py-1.5 rounded-lg border border-border-subtle font-semibold">
                      Standard UK Rates
                    </span>
                  </div>

                  <div className="space-y-3.5">
                    {cmsContent.pricingNhs.map((band, idx) => (
                      <div
                        key={idx}
                        className="p-4 rounded-xl bg-surface-clinical border border-border-subtle/80 grid [grid-template-columns:3fr_2fr] gap-5 items-center"
                      >
                        <div>
                          <h4 className="font-headline-sm text-headline-sm text-on-surface">
                            {band.band}
                          </h4>
                          <p className="font-body-sm text-body-sm text-on-surface-variant">
                            {band.desc}
                          </p>
                        </div>
                        <div className="text-right">
                          <span
                            className={`font-headline-md text-headline-md font-bold ${
                              band.isUrgent ? 'text-status-error' : 'text-primary'
                            }`}
                          >
                            {band.price}
                          </span>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>

                <div className="mt-8 pt-4 border-t border-border-subtle flex items-center gap-2 text-on-surface-variant font-body-sm text-body-sm">
                  <span className="material-symbols-outlined text-[18px] text-primary">
                    verified_user
                  </span>
                  <span>Regulated under standard NHS England primary dental care contracts.</span>
                </div>
              </div>

              {/* Private Treatment & Aesthetic Matrix Card */}
              <div className="bg-surface-card rounded-2xl p-8 border border-border-subtle shadow-sm flex flex-col justify-between">
                <div>
                  <div className="flex items-center justify-between pb-6 mb-6 border-b border-border-subtle">
                    <div>
                      <span className="font-subheading-eyebrow text-[11px] text-primary uppercase font-bold tracking-wider">
                        Premium &amp; Cosmetic
                      </span>
                      <h3 className="font-headline-md text-headline-md text-on-surface">
                        Private Dentistry Options
                      </h3>
                    </div>
                    <span className="bg-primary-container text-on-primary font-label-md text-label-md px-3.5 py-1.5 rounded-lg shadow-sm font-semibold">
                      Custom Materials
                    </span>
                  </div>

                  <div className="space-y-3.5">
                    {cmsContent.pricingPrivate.map((item, idx) => (
                      <div
                        key={idx}
                        className="p-4 rounded-xl bg-surface-clinical border border-border-subtle/80 grid [grid-template-columns:3fr_2fr] gap-5 items-center"
                      >
                        <div>
                          <h4 className="font-headline-sm text-headline-sm text-on-surface">
                            {item.service}
                          </h4>
                          <p className="font-body-sm text-body-sm text-on-surface-variant">
                            {item.desc}
                          </p>
                        </div>
                        <div className="text-right">
                          {item.prefix && (
                            <span className="font-subheading-eyebrow text-on-surface-variant block uppercase text-[10px]">
                              {item.prefix}
                            </span>
                          )}
                          <span className="font-headline-md text-headline-md text-primary font-bold">
                            {item.price}
                          </span>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>

                <div className="mt-8 pt-4 border-t border-border-subtle flex items-center gap-2 text-on-surface-variant font-body-sm text-body-sm">
                  <span className="material-symbols-outlined text-[18px] text-primary">
                    credit_card
                  </span>
                  <span>
                    Split payments across 6 to 12 months with 0% interest via our dental finance partner.
                  </span>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* ========================================================
            4. CLINICAL EXCELLENCE PILLARS (WHY CHOOSE ACOCKS GREEN)
            ======================================================== */}
        <section className="w-full py-14 lg:py-16 border-b border-border-subtle/40 bg-surface-container-low">
          <div className="max-w-7xl mx-auto px-6 lg:px-12">
            <div className="text-center max-w-2xl mx-auto mb-14">
              <span className="font-subheading-eyebrow text-subheading-eyebrow text-primary uppercase tracking-widest block mb-2 font-bold">
                CLINICAL EXCELLENCE &amp; REASSURANCE
              </span>
              <h2 className="font-headline-lg text-headline-lg text-on-surface tracking-tight">
                Why Choose Acocks Green Dental Practice?
              </h2>
              <p className="font-body-md text-body-md text-on-surface-variant mt-3">
                We combine hospital-grade clinical precision with a gentle, patient-first demeanor that puts you entirely at ease.
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
              {cmsContent.pillars.map((pillar, idx) => (
                <div
                  key={idx}
                  className="bg-surface-card p-6 rounded-2xl border border-border-subtle shadow-sm transition-all duration-300 hover:shadow-md flex flex-col justify-between"
                >
                  <div>
                    <div className="w-12 h-12 rounded-xl bg-brand-accent-glow text-primary flex items-center justify-center mb-5">
                      <span className="material-symbols-outlined text-[26px]">
                        {pillar.icon}
                      </span>
                    </div>
                    <h3 className="font-headline-sm text-headline-sm text-on-surface mb-2">
                      {pillar.title}
                    </h3>
                    <p className="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                      {pillar.description}
                    </p>
                  </div>
                  <div className="mt-6 pt-4 border-t border-border-subtle/80 flex items-center gap-1.5 text-primary font-label-sm text-label-sm font-semibold">
                    <span className="material-symbols-outlined text-[16px]">check</span>
                    <span>{pillar.tag}</span>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* ========================================================
            5. PRE-APPOINTMENT CONSULTATION CTA CARD (#quick-book)
            ======================================================== */}
        <section className="w-full bg-surface py-14 lg:py-16" id="quick-book">
          <div className="max-w-7xl mx-auto px-6 lg:px-12">
            <div className="relative bg-appointment-card-bg text-on-primary rounded-3xl overflow-hidden shadow-2xl p-8 lg:p-14">
              <div className="absolute -top-24 -right-24 w-96 h-96 bg-primary-container/20 rounded-full blur-3xl pointer-events-none" />

              <div className="relative z-10 grid lg:grid-cols-12 gap-8 items-center">
                <div className="lg:col-span-7">
                  <span className="font-subheading-eyebrow text-subheading-eyebrow text-primary-fixed uppercase tracking-widest block mb-3 font-bold">
                    NEED CLINICAL ADVICE FIRST?
                  </span>
                  <h2 className="font-headline-lg text-[32px] sm:text-headline-lg text-on-primary mb-4 tracking-tight leading-tight">
                    Not Sure Which Treatment is Right for You?
                  </h2>
                  <p className="font-body-lg text-body-lg text-surface-container-low mb-8 leading-relaxed">
                    Speak directly with our clinical team or book a consultation at our Warwick Road surgery. We will guide you through all NHS and private options clearly, with zero obligation.
                  </p>

                  <div className="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                    <button
                      type="button"
                      onClick={() => handleOpenBooking()}
                      className="inline-flex items-center justify-center gap-2 bg-primary-container text-on-primary font-label-md text-label-md px-6 py-3.5 rounded-lg shadow-sm hover:bg-primary transition-all duration-200 cursor-pointer"
                    >
                      <span className="material-symbols-outlined text-[18px]">calendar_month</span>
                      <span>Book Consultation</span>
                    </button>
                    <a
                      className="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/15 text-primary-fixed font-label-md text-label-md px-6 py-3.5 rounded-lg border border-primary-fixed/20 transition-all duration-200"
                      href="tel:+441217652870"
                    >
                      <span className="material-symbols-outlined text-[18px]">call</span>
                      <span>Call Triage: +44 121 765 2870</span>
                    </a>
                  </div>

                  <div className="mt-8 pt-8 border-t border-white/10 flex flex-wrap items-center gap-6 font-body-sm text-body-sm text-surface-container-highest">
                    <div className="flex items-center gap-2">
                      <span className="material-symbols-outlined text-[18px] text-primary-fixed">
                        pin_drop
                      </span>
                      <span>1078 Warwick Road, Acocks Green, Birmingham B27 6BH</span>
                    </div>
                    <div className="flex items-center gap-2">
                      <span className="material-symbols-outlined text-[18px] text-primary-fixed">
                        schedule
                      </span>
                      <span>Mon-Fri 8:30 AM – 5:30 PM</span>
                    </div>
                  </div>
                </div>

                <div className="lg:col-span-5">
                  {/* eslint-disable-next-line @next/next/no-img-element */}
                  <img
                    alt="Friendly receptionist or female dental nurse wearing medical scrubs on phone and tablet at modern dental clinic reception desk"
                    className="rounded-2xl overflow-hidden shadow-lg border border-white/10 w-full h-64 lg:h-72 object-cover"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuAOTQNJkx83b7VwmVKlFNM8zuZvRtH__mUxQwiHZ8SgGxQMU7ZWrmUlZ1oZSfEqrkA-N_lfiC6Cu09nZaTnwr1MNtjdN_LCrVrjn4Kb5snLRDBXgKvRFtgIC5xiUwbP_WRGtvmE33RNYTYkBbbl-1Plcxh33tK4vvXM45TX65ALHdsxlTq0aUWyVySHfal3hjqoYiiqQkuoUeIhGPId83l_Zfsuyxr1Y1kZ3gcU7NbW"
                  />
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>

      <WhatsAppHub onOpenBooking={() => handleOpenBooking()} />
      <BookingWizard
        isOpen={bookingOpen}
        onClose={() => setBookingOpen(false)}
        preselectedServiceId={selectedServiceId}
      />
      <AcocksGreenFooter
        onOpenBooking={() => handleOpenBooking()}
        onOpenEmergency={() => handleOpenBooking(1)}
      />
    </>
  );
}
