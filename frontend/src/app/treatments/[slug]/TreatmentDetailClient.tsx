'use client';

import React, { useEffect, useState } from 'react';
import Link from 'next/link';
import Image from 'next/image';
import { apiClient } from '@/api/client';
import { assetUrl } from '@/utils/asset';
import { HeaderTopBar } from '@/components/layout/HeaderTopBar/HeaderTopBar';
import { HeaderNavBar } from '@/components/layout/HeaderNavBar/HeaderNavBar';
import { Footer } from '@/components/layout/Footer/Footer';
import { MobileAppNavBar } from '@/components/layout/MobileAppNavBar/MobileAppNavBar';
import { BookingModal } from '@/components/common/BookingModal/BookingModal';

interface IncludedItem {
  icon: string;
  title: string;
  desc: string;
  is_active?: boolean;
}

interface JourneyStep {
  step: string;
  title: string;
  desc: string;
  is_active?: boolean;
}

interface PricingOption {
  title: string;
  badge: string;
  price: string;
  features: string[];
  is_featured?: boolean;
  is_active?: boolean;
}

interface FaqItem {
  question: string;
  answer: string;
  is_active?: boolean;
}

export interface TreatmentDetailData {
  id: number;
  slug: string;
  title: string;
  category: string;
  badge?: string;
  eyebrow?: string;
  summary?: string;
  description?: string;
  content?: string;
  icon?: string;
  feature_image?: string;
  starting_price?: string;
  duration?: string;
  included_items?: IncludedItem[];
  journey_steps?: JourneyStep[];
  pricing_options?: PricingOption[];
  faqs?: FaqItem[];
  section_flags?: {
    show_included?: boolean;
    show_journey?: boolean;
    show_pricing?: boolean;
    show_faqs?: boolean;
  };
}

export function TreatmentDetailClient({ initialService }: { initialService: TreatmentDetailData }) {
  const [service, setService] = useState<TreatmentDetailData>(initialService);
  const [openFaq, setOpenFaq] = useState<number | null>(0);
  const [isBookingOpen, setIsBookingOpen] = useState(false);

  useEffect(() => {
    document.title = `${service.title} | Acocks Green Dental Practice`;
    async function loadLive() {
      try {
        const res = await apiClient.get<TreatmentDetailData>(`/services/${initialService.slug}?_t=${Date.now()}`);
        if (res?.success && res.data) {
          setService(res.data);
          document.title = `${res.data.title} | Acocks Green Dental Practice`;
        }
      } catch {
        // Keep initialService
      }
    }
    loadLive();
  }, [initialService.slug]);

  const flags = service.section_flags || { show_included: true, show_journey: true, show_pricing: true, show_faqs: true };
  const included = flags.show_included !== false ? (service.included_items || []).filter((i) => i.is_active !== false) : [];
  const journey = flags.show_journey !== false ? (service.journey_steps || []).filter((i) => i.is_active !== false) : [];
  const pricing = flags.show_pricing !== false ? (service.pricing_options || []).filter((i) => i.is_active !== false) : [];
  const faqs = flags.show_faqs !== false ? (service.faqs || []).filter((i) => i.is_active !== false) : [];

  return (
    <div style={{ display: 'flex', flexDirection: 'column', minHeight: '100vh', background: '#ffffff' }}>
      <HeaderTopBar />
      <HeaderNavBar onBookClick={() => setIsBookingOpen(true)} />

      <main style={{ flex: 1 }}>
        {/* 1. HERO BANNER */}
        <section style={{ background: '#f8fafc', padding: '36px 0 48px', borderBottom: '1px solid #e2e8f0' }}>
          <div style={{ maxWidth: '1400px', margin: '0 auto', padding: '0 24px', display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: '40px', alignItems: 'center' }}>
            <div>
              <nav aria-label="Breadcrumb" style={{ display: 'flex', alignItems: 'center', gap: '8px', fontSize: '13px', color: '#64748b', marginBottom: '14px', flexWrap: 'wrap' }}>
                <Link href="/" style={{ color: '#0d631b', textDecoration: 'none', fontWeight: 600 }}>Home</Link>
                <span>/</span>
                <Link href="/treatments" style={{ color: '#0d631b', textDecoration: 'none', fontWeight: 600 }}>Treatments &amp; Services</Link>
                <span>/</span>
                <span>{service.title}</span>
              </nav>

              <span style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.1em', color: '#0d631b', display: 'block', marginBottom: '8px' }}>
                {service.eyebrow || `${service.category} • Acocks Green Surgery`}
              </span>

              <h1 style={{ fontSize: 'clamp(28px, 3.8vw, 42px)', fontWeight: 800, color: '#0f172a', margin: '0 0 14px', lineHeight: 1.15 }}>
                {service.title}
              </h1>

              <p style={{ fontSize: '16px', color: '#475569', lineHeight: 1.6, margin: '0 0 22px' }}>
                {service.summary || service.description}
              </p>

              {/* Key Info Pills */}
              <div style={{ display: 'flex', flexWrap: 'wrap', gap: '10px', marginBottom: '24px' }}>
                <span style={{ background: '#f0fdf4', border: '1px solid #bbf7d0', color: '#0d631b', padding: '6px 14px', borderRadius: '9999px', fontSize: '13px', fontWeight: 700, display: 'inline-flex', alignItems: 'center', gap: '6px' }}>
                  <span className="material-symbols-outlined" style={{ fontSize: '16px' }}>payments</span>
                  {service.starting_price || 'From £45.00'}
                </span>
                <span style={{ background: '#ffffff', border: '1px solid #cbd5e1', color: '#334155', padding: '6px 14px', borderRadius: '9999px', fontSize: '13px', fontWeight: 600, display: 'inline-flex', alignItems: 'center', gap: '6px' }}>
                  <span className="material-symbols-outlined" style={{ fontSize: '16px' }}>schedule</span>
                  {service.duration || '30–45 mins'}
                </span>
                <span style={{ background: '#ffffff', border: '1px solid #cbd5e1', color: '#334155', padding: '6px 14px', borderRadius: '9999px', fontSize: '13px', fontWeight: 600, display: 'inline-flex', alignItems: 'center', gap: '6px' }}>
                  <span className="material-symbols-outlined" style={{ fontSize: '16px' }}>{service.icon || 'dentistry'}</span>
                  {service.category}
                </span>
              </div>

              <div style={{ display: 'flex', gap: '12px', flexWrap: 'wrap' }}>
                <button
                  type="button"
                  onClick={() => setIsBookingOpen(true)}
                  style={{
                    background: '#0d631b',
                    color: '#ffffff',
                    border: 'none',
                    borderRadius: '9999px',
                    padding: '12px 26px',
                    fontSize: '14px',
                    fontWeight: 700,
                    cursor: 'pointer',
                    display: 'inline-flex',
                    alignItems: 'center',
                    gap: '8px',
                    boxShadow: '0 4px 14px rgba(13, 99, 27, 0.25)',
                  }}
                >
                  <span className="material-symbols-outlined" style={{ fontSize: '18px' }}>calendar_month</span>
                  <span>Book {service.title}</span>
                </button>
                <a
                  href="tel:+441217652870"
                  style={{
                    background: '#ffffff',
                    color: '#0f172a',
                    border: '1px solid #cbd5e1',
                    borderRadius: '9999px',
                    padding: '12px 22px',
                    fontSize: '14px',
                    fontWeight: 600,
                    textDecoration: 'none',
                    display: 'inline-flex',
                    alignItems: 'center',
                    gap: '8px',
                  }}
                >
                  <span className="material-symbols-outlined" style={{ fontSize: '18px', color: '#0d631b' }}>call</span>
                  <span>+44 121 765 2870</span>
                </a>
              </div>
            </div>

            <div style={{ position: 'relative', height: '340px', borderRadius: '24px', overflow: 'hidden', boxShadow: '0 16px 40px rgba(9, 71, 19, 0.14)' }}>
              <Image
                src={assetUrl(service.feature_image || '/uploads/home/hero-patient.jpg')}
                alt={service.title}
                fill
                priority
                style={{ objectFit: 'cover' }}
              />
            </div>
          </div>
        </section>

        {/* 2. WHAT'S INCLUDED / CLINICAL OVERVIEW */}
        {included.length > 0 && (
          <section style={{ background: '#f2fcf5', padding: '64px 0', borderBottom: '1px solid #dcfce7' }}>
            <div style={{ maxWidth: '1400px', margin: '0 auto', padding: '0 24px' }}>
              <div style={{ textAlign: 'center', maxWidth: '720px', margin: '0 auto 40px' }}>
                <span style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.1em', color: '#0d631b' }}>
                  CLINICAL EXCELLENCE
                </span>
                <h2 style={{ fontSize: '30px', fontWeight: 800, color: '#0f172a', margin: '8px 0 10px' }}>
                  What&apos;s Included in Your Appointment
                </h2>
                {service.content && (
                  <p style={{ fontSize: '15px', color: '#475569', margin: 0, lineHeight: 1.6 }} dangerouslySetInnerHTML={{ __html: service.content }} />
                )}
              </div>

              <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))', gap: '24px' }}>
                {included.map((item, idx) => (
                  <div key={idx} style={{ background: '#ffffff', borderRadius: '18px', padding: '26px', border: '1px solid #dcfce7', boxShadow: '0 4px 14px rgba(15, 23, 42, 0.04)' }}>
                    <div style={{ width: '48px', height: '48px', borderRadius: '12px', background: '#f0fdf4', color: '#0d631b', display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '16px' }}>
                      <span className="material-symbols-outlined" style={{ fontSize: '26px' }}>{item.icon || 'clinical_notes'}</span>
                    </div>
                    <h3 style={{ fontSize: '18px', fontWeight: 700, color: '#0f172a', margin: '0 0 8px' }}>{item.title}</h3>
                    <p style={{ fontSize: '14px', color: '#475569', margin: 0, lineHeight: 1.6 }}>{item.desc}</p>
                  </div>
                ))}
              </div>
            </div>
          </section>
        )}

        {/* 3. PATIENT STEP-BY-STEP JOURNEY */}
        {journey.length > 0 && (
          <section style={{ background: '#ffffff', padding: '64px 0', borderBottom: '1px solid #e2e8f0' }}>
            <div style={{ maxWidth: '1400px', margin: '0 auto', padding: '0 24px' }}>
              <div style={{ textAlign: 'center', maxWidth: '720px', margin: '0 auto 40px' }}>
                <span style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.1em', color: '#0d631b' }}>
                  STEP-BY-STEP CARE
                </span>
                <h2 style={{ fontSize: '30px', fontWeight: 800, color: '#0f172a', margin: '8px 0 0' }}>
                  Your Clinical Journey at Acocks Green
                </h2>
              </div>

              <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(240px, 1fr))', gap: '20px' }}>
                {journey.map((step, idx) => (
                  <div key={idx} style={{ background: '#f8fafc', borderRadius: '18px', padding: '24px', border: '1px solid #e2e8f0' }}>
                    <div style={{ fontSize: '26px', fontWeight: 800, color: '#0d631b', marginBottom: '10px', fontFamily: 'monospace' }}>
                      {step.step || `0${idx + 1}`}
                    </div>
                    <h3 style={{ fontSize: '17px', fontWeight: 700, color: '#0f172a', margin: '0 0 8px' }}>{step.title}</h3>
                    <p style={{ fontSize: '14px', color: '#475569', margin: 0, lineHeight: 1.55 }}>{step.desc}</p>
                  </div>
                ))}
              </div>
            </div>
          </section>
        )}

        {/* 4. TRANSPARENT PRICING TIERS */}
        {pricing.length > 0 && (
          <section style={{ background: '#f2fcf5', padding: '64px 0', borderBottom: '1px solid #dcfce7' }}>
            <div style={{ maxWidth: '1400px', margin: '0 auto', padding: '0 24px' }}>
              <div style={{ textAlign: 'center', maxWidth: '720px', margin: '0 auto 40px' }}>
                <span style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.1em', color: '#0d631b' }}>
                  TRANSPARENT FEES
                </span>
                <h2 style={{ fontSize: '30px', fontWeight: 800, color: '#0f172a', margin: '8px 0 0' }}>
                  NHS &amp; Private Care Options
                </h2>
              </div>

              <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(290px, 1fr))', gap: '24px' }}>
                {pricing.map((tier, idx) => (
                  <div
                    key={idx}
                    style={{
                      background: '#ffffff',
                      borderRadius: '20px',
                      padding: '28px',
                      border: tier.is_featured ? '2px solid #0d631b' : '1px solid #e2e8f0',
                      boxShadow: tier.is_featured ? '0 12px 30px rgba(13, 99, 27, 0.12)' : '0 4px 12px rgba(0,0,0,0.03)',
                      display: 'flex',
                      flexDirection: 'column',
                      justifyContent: 'space-between',
                      gap: '20px',
                    }}
                  >
                    <div>
                      <span style={{ fontSize: '11px', fontWeight: 700, textTransform: 'uppercase', color: '#0d631b', background: '#f0fdf4', padding: '4px 10px', borderRadius: '9999px' }}>
                        {tier.badge}
                      </span>
                      <h3 style={{ fontSize: '20px', fontWeight: 700, color: '#0f172a', margin: '12px 0 6px' }}>{tier.title}</h3>
                      <div style={{ fontSize: '26px', fontWeight: 800, color: '#0d631b', marginBottom: '16px' }}>{tier.price}</div>
                      <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: '10px' }}>
                        {(tier.features || []).map((feat, fIdx) => (
                          <li key={fIdx} style={{ display: 'flex', alignItems: 'center', gap: '8px', fontSize: '14px', color: '#334155' }}>
                            <span className="material-symbols-outlined" style={{ fontSize: '18px', color: '#0d631b' }}>check_circle</span>
                            <span>{feat}</span>
                          </li>
                        ))}
                      </ul>
                    </div>
                    <button
                      type="button"
                      onClick={() => setIsBookingOpen(true)}
                      style={{
                        width: '100%',
                        padding: '11px 20px',
                        borderRadius: '9999px',
                        border: tier.is_featured ? 'none' : '1px solid #0d631b',
                        background: tier.is_featured ? '#0d631b' : '#ffffff',
                        color: tier.is_featured ? '#ffffff' : '#0d631b',
                        fontWeight: 700,
                        fontSize: '14px',
                        cursor: 'pointer',
                      }}
                    >
                      Book This Option
                    </button>
                  </div>
                ))}
              </div>
            </div>
          </section>
        )}

        {/* 5. FAQS + QUICK BOOK CTA */}
        {faqs.length > 0 && (
          <section style={{ background: '#ffffff', padding: '64px 0' }}>
            <div style={{ maxWidth: '900px', margin: '0 auto', padding: '0 24px' }}>
              <div style={{ textAlign: 'center', marginBottom: '36px' }}>
                <span style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.1em', color: '#0d631b' }}>
                  PATIENT QUESTIONS
                </span>
                <h2 style={{ fontSize: '28px', fontWeight: 800, color: '#0f172a', margin: '8px 0 0' }}>
                  Frequently Asked Questions
                </h2>
              </div>

              <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
                {faqs.map((faq, idx) => {
                  const isOpen = openFaq === idx;
                  return (
                    <div key={idx} style={{ border: '1px solid #e2e8f0', borderRadius: '14px', overflow: 'hidden' }}>
                      <button
                        type="button"
                        onClick={() => setOpenFaq(isOpen ? null : idx)}
                        style={{
                          width: '100%',
                          padding: '16px 20px',
                          background: isOpen ? '#0d631b' : '#f8fafc',
                          color: isOpen ? '#ffffff' : '#0f172a',
                          border: 'none',
                          display: 'flex',
                          alignItems: 'center',
                          justifyContent: 'space-between',
                          fontWeight: 700,
                          fontSize: '15px',
                          cursor: 'pointer',
                          textAlign: 'left',
                        }}
                      >
                        <span>{faq.question}</span>
                        <span className="material-symbols-outlined">{isOpen ? 'remove' : 'add'}</span>
                      </button>
                      {isOpen && (
                        <div style={{ padding: '16px 20px', fontSize: '14px', color: '#475569', lineHeight: 1.6, background: '#ffffff' }}>
                          {faq.answer}
                        </div>
                      )}
                    </div>
                  );
                })}
              </div>
            </div>
          </section>
        )}
      </main>

      <Footer />
      <MobileAppNavBar onBookClick={() => setIsBookingOpen(true)} />
      <BookingModal isOpen={isBookingOpen} onClose={() => setIsBookingOpen(false)} initialTreatment={service.title} />
    </div>
  );
}
