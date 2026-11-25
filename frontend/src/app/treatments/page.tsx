'use client';

import React, { useEffect, useState } from 'react';
import Link from 'next/link';
import Image from 'next/image';
import { apiClient } from '@/api/client';
import { DEFAULT_HOME_PAGE } from '@/api/cms';
import { PageSection, ServiceItem } from '@/types/cms';
import { assetUrl } from '@/utils/asset';
import { HeaderTopBar } from '@/components/layout/HeaderTopBar/HeaderTopBar';
import { HeaderNavBar } from '@/components/layout/HeaderNavBar/HeaderNavBar';
import { Footer } from '@/components/layout/Footer/Footer';
import { MobileAppNavBar } from '@/components/layout/MobileAppNavBar/MobileAppNavBar';
import { BookingModal } from '@/components/common/BookingModal/BookingModal';
import { ContentBlockSection } from '@/components/sections/ContentBlockSection/ContentBlockSection';
import { TestimonialsSlider } from '@/components/sections/TestimonialsSlider/TestimonialsSlider';
import { ClinicAddressAndContact } from '@/components/sections/ClinicAddressAndContact/ClinicAddressAndContact';

interface FeeBand {
  icon: string;
  title: string;
  badge: string;
  price: string;
  desc: string;
  is_active?: boolean;
}

interface ClinicalPillar {
  icon: string;
  title: string;
  desc: string;
  is_active?: boolean;
}

interface TreatmentsPageCms {
  hero?: {
    eyebrow?: string;
    headline?: string;
    subtitle?: string;
    image?: string;
    cta_primary?: string;
    cta_primary_link?: string;
  };
  fee_bands?: FeeBand[];
  fee_bands_cols?: number;
  clinical_pillars?: ClinicalPillar[];
  pillars_cols?: number;
  sections?: PageSection[];
  seo?: { meta_title?: string };
}

export default function TreatmentsCatalogPage() {
  const [services, setServices] = useState<ServiceItem[]>(DEFAULT_HOME_PAGE.featured_services);
  const [cms, setCms] = useState<TreatmentsPageCms>({});
  const [activeCategory, setActiveCategory] = useState<string>('All');
  const [isBookingOpen, setIsBookingOpen] = useState(false);
  const [bookingTreatment, setBookingTreatment] = useState('Routine Dental Examination');

  useEffect(() => {
    document.title = 'Treatments & Services | Acocks Green Dental Practice';
    async function loadData() {
      try {
        const [svcRes, cmsRes] = await Promise.all([
          apiClient.get<ServiceItem[]>(`/services?_t=${Date.now()}`),
          apiClient.get<TreatmentsPageCms>(`/pages/treatments?_t=${Date.now()}`),
        ]);
        if (svcRes?.success && Array.isArray(svcRes.data)) {
          setServices(svcRes.data);
        }
        if (cmsRes?.success && cmsRes.data) {
          setCms(cmsRes.data);
          if (cmsRes.data.seo?.meta_title) {
            document.title = cmsRes.data.seo.meta_title;
          }
        }
      } catch {
        // Fallback to defaults
      }
    }
    loadData();
  }, []);

  const categories = ['All', ...Array.from(new Set(services.map((s) => s.category).filter(Boolean)))];
  const filteredServices = activeCategory === 'All' ? services : services.filter((s) => s.category === activeCategory);

  const handleBook = (title?: string) => {
    if (title) setBookingTreatment(title);
    setIsBookingOpen(true);
  };

  const hero = cms.hero || {};
  const sections: PageSection[] =
    cms.sections && cms.sections.length > 0
      ? [...cms.sections].sort((a, b) => (a.order ?? 0) - (b.order ?? 0))
      : [
          {
            id: 'sec_trt_grid',
            type: 'services_block',
            category: 'prebuilt',
            name: 'Treatments Grid',
            eyebrow: 'Clinical Catalog',
            title: 'Explore Our Dental Treatments',
            summary: '',
            is_active: true,
            order: 1,
          },
          {
            id: 'sec_trt_cta',
            type: 'custom_content',
            category: 'custom_content',
            name: 'Quick Book Banner',
            eyebrow: 'NEED CLINICAL ADVICE FIRST?',
            title: 'Not Sure Which Treatment is Right for You?',
            summary:
              'Speak directly with our clinical team or book a consultation at our Warwick Road surgery. We will guide you through all NHS and private options clearly, with zero obligation.',
            column_layout: 'action_bar',
            cta_text: 'Book Consultation',
            cta_link: '#quick-book',
            is_active: true,
            order: 2,
          },
        ];

  const activeFees = (cms.fee_bands || []).filter((f) => f.is_active !== false);
  const activePillars = (cms.clinical_pillars || []).filter((p) => p.is_active !== false);

  return (
    <div style={{ display: 'flex', flexDirection: 'column', minHeight: '100vh', background: '#f8fafc' }}>
      <HeaderTopBar />
      <HeaderNavBar onBookClick={(trt) => handleBook(trt)} />

      <main style={{ flex: 1 }}>
        {/* 1. Hero & Category Filter */}
        <section style={{ background: 'linear-gradient(135deg, #f2fcf5 0%, #e7f8ec 100%)', padding: '40px 0', borderBottom: '1px solid #dcfce7' }}>
          <div style={{ maxWidth: '1400px', margin: '0 auto', padding: '0 24px', display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))', gap: '32px', alignItems: 'center' }}>
            <div>
              <nav aria-label="Breadcrumb" style={{ display: 'flex', alignItems: 'center', gap: '8px', fontSize: '13px', color: '#64748b', marginBottom: '12px' }}>
                <Link href="/" style={{ color: '#0d631b', textDecoration: 'none', fontWeight: 600 }}>Home</Link>
                <span>/</span>
                <span>Treatments &amp; Services</span>
              </nav>
              <span
                style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.1em', color: '#0d631b', display: 'block', marginBottom: '8px' }}
                dangerouslySetInnerHTML={{ __html: hero.eyebrow || 'OUR CLINICAL SERVICES &amp; PROCEDURES' }}
              />
              <h1
                style={{ fontSize: 'clamp(28px, 3.6vw, 40px)', fontWeight: 800, color: '#0f172a', margin: '0 0 12px', lineHeight: 1.15 }}
                dangerouslySetInnerHTML={{ __html: hero.headline || 'Comprehensive Dental Care &amp; Specialized Treatments' }}
              />
              <p
                style={{ fontSize: '15px', color: '#475569', margin: '0 0 20px', lineHeight: 1.6 }}
                dangerouslySetInnerHTML={{
                  __html:
                    hero.subtitle ||
                    'From essential routine NHS care to advanced cosmetic smile makeovers and restorative procedures in Acocks Green, Birmingham. Delivered with gentle compassion and state-of-the-art diagnostics.',
                }}
              />

              <div style={{ display: 'flex', flexWrap: 'wrap', gap: '8px' }}>
                {categories.map((cat) => (
                  <button
                    key={cat}
                    type="button"
                    onClick={() => setActiveCategory(cat)}
                    style={{
                      padding: '8px 16px',
                      borderRadius: '8px',
                      border: activeCategory === cat ? '1px solid #0d631b' : '1px solid #cbd5e1',
                      backgroundColor: activeCategory === cat ? '#0d631b' : '#ffffff',
                      color: activeCategory === cat ? '#ffffff' : '#334155',
                      fontSize: '13px',
                      fontWeight: 600,
                      cursor: 'pointer',
                    }}
                  >
                    {cat === 'All' ? 'All Services' : cat}
                  </button>
                ))}
              </div>
            </div>

            <div style={{ position: 'relative', height: '280px', borderRadius: '20px', overflow: 'hidden', boxShadow: '0 12px 30px rgba(9, 71, 19, 0.12)' }}>
              <Image
                src={assetUrl(hero.image || '/uploads/home/hero-patient.jpg')}
                alt="Acocks Green Dental Treatments"
                fill
                style={{ objectFit: 'cover' }}
              />
            </div>
          </div>
        </section>

        {/* 2. Dynamic CMS Sections */}
        {sections.map((sec, idx) => {
          if (sec.is_active === false) return null;

          if (sec.type === 'services_block') {
            return (
              <section key={sec.id || idx} style={{ padding: '56px 0', background: '#f8fafc' }}>
                <div style={{ maxWidth: '1400px', margin: '0 auto', padding: '0 24px' }}>
                  {(sec.eyebrow || sec.title) && (
                    <div style={{ marginBottom: '28px' }}>
                      {sec.eyebrow && (
                        <span style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.1em', color: '#0d631b', display: 'block', marginBottom: '6px' }} dangerouslySetInnerHTML={{ __html: sec.eyebrow }} />
                      )}
                      {sec.title && (
                        <h2 style={{ fontSize: '28px', fontWeight: 800, color: '#0f172a', margin: '0 0 6px' }} dangerouslySetInnerHTML={{ __html: sec.title }} />
                      )}
                      {sec.summary && (
                        <p style={{ fontSize: '15px', color: '#475569', margin: 0 }} dangerouslySetInnerHTML={{ __html: sec.summary }} />
                      )}
                    </div>
                  )}

                  <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(310px, 1fr))', gap: '24px' }}>
                    {filteredServices.map((service) => (
                      <div
                        key={service.id}
                        style={{
                          background: '#ffffff',
                          borderRadius: '18px',
                          border: '1px solid #e2e8f0',
                          overflow: 'hidden',
                          display: 'flex',
                          flexDirection: 'column',
                          justifyContent: 'space-between',
                          boxShadow: '0 4px 16px rgba(15, 23, 42, 0.04)',
                        }}
                      >
                        <div>
                          <div style={{ position: 'relative', height: '190px', background: '#f1f5f9' }}>
                            <Image
                              src={assetUrl(service.feature_image || '/uploads/home/treatment-room.jpg')}
                              alt={service.title}
                              fill
                              style={{ objectFit: 'cover' }}
                            />
                            <span
                              style={{
                                position: 'absolute',
                                top: '12px',
                                right: '12px',
                                background: '#ffffff',
                                color: '#0d631b',
                                fontSize: '11px',
                                fontWeight: 700,
                                padding: '4px 10px',
                                borderRadius: '9999px',
                                boxShadow: '0 2px 8px rgba(0,0,0,0.1)',
                              }}
                            >
                              {service.badge || service.category}
                            </span>
                          </div>
                          <div style={{ padding: '20px' }}>
                            <div style={{ display: 'flex', alignItems: 'center', gap: '10px', marginBottom: '10px' }}>
                              <span className="material-symbols-outlined" style={{ fontSize: '22px', color: '#0d631b', background: '#f0fdf4', padding: '8px', borderRadius: '10px' }}>
                                {service.icon || 'dentistry'}
                              </span>
                              <span style={{ fontSize: '12px', fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>
                                {service.category}
                              </span>
                            </div>
                            <h3 style={{ fontSize: '19px', fontWeight: 700, color: '#0f172a', margin: '0 0 8px' }}>
                              <Link href={`/treatments/${service.slug}`} style={{ color: 'inherit', textDecoration: 'none' }}>
                                {service.title}
                              </Link>
                            </h3>
                            <p style={{ fontSize: '14px', color: '#475569', margin: 0, lineHeight: 1.55 }}>
                              {service.summary || service.description}
                            </p>
                          </div>
                        </div>

                        <div style={{ padding: '14px 20px 20px', borderTop: '1px solid #f1f5f9', display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: '10px' }}>
                          <div>
                            <div style={{ fontSize: '13px', fontWeight: 700, color: '#0d631b' }}>{service.starting_price}</div>
                            <div style={{ fontSize: '11px', color: '#64748b' }}>{service.duration}</div>
                          </div>
                          <div style={{ display: 'flex', gap: '8px' }}>
                            <Link
                              href={`/treatments/${service.slug}`}
                              style={{
                                padding: '7px 14px',
                                borderRadius: '9999px',
                                border: '1px solid #cbd5e1',
                                color: '#334155',
                                fontSize: '12.5px',
                                fontWeight: 600,
                                textDecoration: 'none',
                              }}
                            >
                              View Details
                            </Link>
                            <button
                              type="button"
                              onClick={() => handleBook(service.title)}
                              style={{
                                padding: '7px 14px',
                                borderRadius: '9999px',
                                border: 'none',
                                background: '#0d631b',
                                color: '#ffffff',
                                fontSize: '12.5px',
                                fontWeight: 600,
                                cursor: 'pointer',
                              }}
                            >
                              Book
                            </button>
                          </div>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
              </section>
            );
          }

          if ((sec.type as string) === 'fee_bands_block' && activeFees.length > 0) {
            return (
              <section key={sec.id || idx} style={{ padding: '56px 0', background: '#ffffff', borderTop: '1px solid #e2e8f0' }}>
                <div style={{ maxWidth: '1400px', margin: '0 auto', padding: '0 24px' }}>
                  <div style={{ textAlign: 'center', maxWidth: '720px', margin: '0 auto 36px' }}>
                    {sec.eyebrow && <span style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.1em', color: '#0d631b' }} dangerouslySetInnerHTML={{ __html: sec.eyebrow }} />}
                    {sec.title && <h2 style={{ fontSize: '28px', fontWeight: 800, color: '#0f172a', margin: '8px 0 10px' }} dangerouslySetInnerHTML={{ __html: sec.title }} />}
                    {sec.summary && <p style={{ fontSize: '15px', color: '#475569', margin: 0 }} dangerouslySetInnerHTML={{ __html: sec.summary }} />}
                  </div>
                  <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))', gap: '20px' }}>
                    {activeFees.map((fb, fIdx) => (
                      <div key={fIdx} style={{ background: '#f2fcf5', borderRadius: '18px', padding: '24px', border: '1px solid #bbf7d0' }}>
                        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '12px' }}>
                          <span className="material-symbols-outlined" style={{ fontSize: '26px', color: '#0d631b' }}>{fb.icon || 'local_hospital'}</span>
                          <span style={{ fontSize: '11px', fontWeight: 700, background: '#ffffff', color: '#0d631b', padding: '4px 10px', borderRadius: '9999px' }}>{fb.badge}</span>
                        </div>
                        <h3 style={{ fontSize: '18px', fontWeight: 700, color: '#0f172a', margin: '0 0 6px' }}>{fb.title}</h3>
                        <div style={{ fontSize: '24px', fontWeight: 800, color: '#0d631b', marginBottom: '10px' }}>{fb.price}</div>
                        <p style={{ fontSize: '14px', color: '#475569', margin: 0, lineHeight: 1.55 }}>{fb.desc}</p>
                      </div>
                    ))}
                  </div>
                </div>
              </section>
            );
          }

          if (sec.type === 'why_us_block' && activePillars.length > 0) {
            return (
              <section key={sec.id || idx} style={{ padding: '56px 0', background: '#f8fafc', borderTop: '1px solid #e2e8f0' }}>
                <div style={{ maxWidth: '1400px', margin: '0 auto', padding: '0 24px' }}>
                  <div style={{ textAlign: 'center', maxWidth: '720px', margin: '0 auto 36px' }}>
                    {sec.eyebrow && <span style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.1em', color: '#0d631b' }} dangerouslySetInnerHTML={{ __html: sec.eyebrow }} />}
                    {sec.title && <h2 style={{ fontSize: '28px', fontWeight: 800, color: '#0f172a', margin: '8px 0 10px' }} dangerouslySetInnerHTML={{ __html: sec.title }} />}
                    {sec.summary && <p style={{ fontSize: '15px', color: '#475569', margin: 0 }} dangerouslySetInnerHTML={{ __html: sec.summary }} />}
                  </div>
                  <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(260px, 1fr))', gap: '20px' }}>
                    {activePillars.map((pl, pIdx) => (
                      <div key={pIdx} style={{ background: '#ffffff', borderRadius: '18px', padding: '24px', border: '1px solid #e2e8f0' }}>
                        <span className="material-symbols-outlined" style={{ fontSize: '26px', color: '#0d631b', background: '#f0fdf4', padding: '10px', borderRadius: '12px', marginBottom: '14px', display: 'inline-block' }}>
                          {pl.icon || 'biotech'}
                        </span>
                        <h3 style={{ fontSize: '17px', fontWeight: 700, color: '#0f172a', margin: '0 0 8px' }}>{pl.title}</h3>
                        <p style={{ fontSize: '14px', color: '#475569', margin: 0, lineHeight: 1.55 }}>{pl.desc}</p>
                      </div>
                    ))}
                  </div>
                </div>
              </section>
            );
          }

          if (sec.type === 'testimonials_block') {
            return <TestimonialsSlider key={sec.id || idx} eyebrow={sec.eyebrow} title={sec.title} />;
          }

          if (sec.type === 'contact_block') {
            return <ClinicAddressAndContact key={sec.id || idx} eyebrow={sec.eyebrow} title={sec.title} subtitle={sec.summary} />;
          }

          return <ContentBlockSection key={sec.id || idx} section={sec} index={idx} />;
        })}
      </main>

      <Footer />
      <MobileAppNavBar onBookClick={() => handleBook()} />
      <BookingModal isOpen={isBookingOpen} onClose={() => setIsBookingOpen(false)} initialTreatment={bookingTreatment} />
    </div>
  );
}
