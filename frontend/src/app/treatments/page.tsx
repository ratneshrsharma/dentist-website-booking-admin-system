'use client';

import React, { useEffect, useState } from 'react';
import Link from 'next/link';
import Image from 'next/image';
import { apiClient } from '@/api/client';
import { DEFAULT_HOME_PAGE } from '@/api/cms';
import { ServiceItem } from '@/types/cms';
import { assetUrl } from '@/utils/asset';
import { HeaderTopBar } from '@/components/layout/HeaderTopBar/HeaderTopBar';
import { HeaderNavBar } from '@/components/layout/HeaderNavBar/HeaderNavBar';
import { Footer } from '@/components/layout/Footer/Footer';
import { MobileAppNavBar } from '@/components/layout/MobileAppNavBar/MobileAppNavBar';
import { BookingModal } from '@/components/common/BookingModal/BookingModal';

export default function TreatmentsCatalogPage() {
  const [services, setServices] = useState<ServiceItem[]>(DEFAULT_HOME_PAGE.featured_services);
  const [activeCategory, setActiveCategory] = useState<string>('All');
  const [isBookingOpen, setIsBookingOpen] = useState(false);
  const [bookingTreatment, setBookingTreatment] = useState('Routine Dental Examination');

  useEffect(() => {
    document.title = 'Treatments & Services | Acocks Green Dental Practice';
    async function loadServices() {
      try {
        const res = await apiClient.get<ServiceItem[]>(`/services?_t=${Date.now()}`);
        if (res?.success && Array.isArray(res.data) && res.data.length > 0) {
          setServices(res.data);
        }
      } catch {
        // Use defaults
      }
    }
    loadServices();
  }, []);

  const categories = ['All', ...Array.from(new Set(services.map((s) => s.category).filter(Boolean)))];
  const filteredServices = activeCategory === 'All' ? services : services.filter((s) => s.category === activeCategory);

  const handleBook = (title?: string) => {
    if (title) setBookingTreatment(title);
    setIsBookingOpen(true);
  };

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
              <span style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.1em', color: '#0d631b', display: 'block', marginBottom: '8px' }}>
                OUR CLINICAL SERVICES &amp; PROCEDURES
              </span>
              <h1 style={{ fontSize: 'clamp(28px, 3.6vw, 40px)', fontWeight: 800, color: '#0f172a', margin: '0 0 12px', lineHeight: 1.15 }}>
                Comprehensive Dental Care &amp; Specialized Treatments
              </h1>
              <p style={{ fontSize: '15px', color: '#475569', margin: '0 0 20px', lineHeight: 1.6 }}>
                From essential routine NHS care to advanced cosmetic smile makeovers and restorative procedures in Acocks Green, Birmingham. Delivered with gentle compassion and state-of-the-art diagnostics.
              </p>

              {/* Category Filter Pills */}
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
                src={assetUrl('/uploads/home/hero-patient.jpg')}
                alt="Acocks Green Dental Treatments"
                fill
                style={{ objectFit: 'cover' }}
              />
            </div>
          </div>
        </section>

        {/* 2. Services Catalog Grid */}
        <section style={{ padding: '56px 0' }}>
          <div style={{ maxWidth: '1400px', margin: '0 auto', padding: '0 24px' }}>
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
                      <h2 style={{ fontSize: '19px', fontWeight: 700, color: '#0f172a', margin: '0 0 8px' }}>
                        <Link href={`/treatments/${service.slug}`} style={{ color: 'inherit', textDecoration: 'none' }}>
                          {service.title}
                        </Link>
                      </h2>
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

        {/* 3. Quick Book Banner */}
        <section style={{ padding: '0 24px 64px' }}>
          <div style={{ maxWidth: '1400px', margin: '0 auto', background: 'linear-gradient(135deg, #094713 0%, #0d631b 100%)', borderRadius: '24px', padding: '40px', color: '#ffffff', display: 'flex', flexWrap: 'wrap', alignItems: 'center', justifyContent: 'space-between', gap: '24px' }}>
            <div style={{ maxWidth: '640px' }}>
              <span style={{ fontSize: '12px', fontWeight: 700, letterSpacing: '0.1em', color: '#bbf7d0', textTransform: 'uppercase' }}>
                NEED CLINICAL ADVICE FIRST?
              </span>
              <h2 style={{ fontSize: '28px', fontWeight: 800, margin: '8px 0 10px' }}>
                Not Sure Which Treatment is Right for You?
              </h2>
              <p style={{ fontSize: '15px', color: 'rgba(255,255,255,0.88)', margin: 0 }}>
                Book a consultation at our Warwick Road surgery. We will guide you through all NHS and private options clearly, with zero obligation.
              </p>
            </div>
            <div style={{ display: 'flex', gap: '12px', flexWrap: 'wrap' }}>
              <button
                type="button"
                onClick={() => handleBook('Clinical Consultation')}
                style={{ background: '#ffffff', color: '#094713', border: 'none', borderRadius: '9999px', padding: '12px 24px', fontWeight: 700, cursor: 'pointer' }}
              >
                Book Consultation
              </button>
              <a
                href="tel:+441217652870"
                style={{ background: 'rgba(255,255,255,0.12)', color: '#ffffff', border: '1px solid rgba(255,255,255,0.3)', borderRadius: '9999px', padding: '12px 24px', fontWeight: 700, textDecoration: 'none' }}
              >
                Call +44 121 765 2870
              </a>
            </div>
          </div>
        </section>
      </main>

      <Footer />
      <MobileAppNavBar onBookClick={() => handleBook()} />
      <BookingModal isOpen={isBookingOpen} onClose={() => setIsBookingOpen(false)} initialTreatment={bookingTreatment} />
    </div>
  );
}
