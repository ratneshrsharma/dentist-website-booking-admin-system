'use client';

import React, { useEffect, useState } from 'react';
import Link from 'next/link';
import Image from 'next/image';
import { apiClient } from '@/api/client';
import { assetUrl } from '@/utils/asset';
import { useTheme } from '@/context/ThemeContext';
import { HeaderTopBar } from '@/components/layout/HeaderTopBar/HeaderTopBar';
import { HeaderNavBar } from '@/components/layout/HeaderNavBar/HeaderNavBar';
import { Footer } from '@/components/layout/Footer/Footer';
import { MobileAppNavBar } from '@/components/layout/MobileAppNavBar/MobileAppNavBar';
import { BookingModal } from '@/components/common/BookingModal/BookingModal';

interface ContactSectionItem {
  id: string;
  type: string;
  eyebrow?: string;
  title?: string;
  summary?: string;
  description?: string;
  is_active?: boolean;
  order?: number;
}

interface ContactPageData {
  hero?: {
    eyebrow?: string;
    headline?: string;
    subtitle?: string;
    image?: string;
    triage_label?: string;
    triage_phone?: string;
    badges?: Array<{ icon: string; label: string }>;
  };
  journey_steps?: Array<{ step: string; title: string; desc: string; is_active?: boolean }>;
  reassurance_card?: { title?: string; desc?: string };
  sections?: ContactSectionItem[];
  seo?: { meta_title?: string; meta_description?: string };
}

export default function ContactPage() {
  const { theme } = useTheme();
  const [pageData, setPageData] = useState<ContactPageData>({
    hero: {
      eyebrow: 'GET IN TOUCH WITH OUR TEAM',
      headline: 'Contact Acocks Green Dental Practice in Birmingham',
      subtitle:
        'Whether you are booking a routine NHS check-up, inquiring about cosmetic Invisalign® aligners, or requiring emergency dental triage, our gentle team at 1078 Warwick Road is here to assist you.',
      image: '/uploads/home/surgery-clinic.jpg',
      triage_label: 'Direct Clinical Triage',
      triage_phone: '0121 765 2870',
      badges: [
        { icon: 'local_parking', label: 'Free On-Site Patient Parking' },
        { icon: 'directions_subway', label: '5 Mins from Acocks Green Station' },
        { icon: 'accessible', label: 'Step-Free Ground Floor Access' },
        { icon: 'emergency', label: 'Same-Day Emergency Slots' },
      ],
    },
    journey_steps: [
      {
        step: '1',
        title: 'Immediate Clinical Triage',
        desc: 'A dedicated receptionist reviews your clinical needs within 2 working hours. If symptoms suggest pulpitis, swelling, or infection, we prioritise same-day treatment.',
      },
      {
        step: '2',
        title: 'Tailored Clinician Matching',
        desc: 'We match your requirement with the right GDC-registered dentist or therapist (NHS Band 1-3 or private cosmetic clinician) at your preferred time.',
      },
      {
        step: '3',
        title: 'Digital Paperwork & SMS Check-In',
        desc: 'You receive an encrypted SMS/email to complete medical history from home on your phone — avoiding waiting room clipboard queues entirely.',
      },
    ],
    reassurance_card: {
      title: 'Nervous or Dental Phobic?',
      desc: "Haven't visited a dental surgery in years? Don't worry — we never judge. Mention your dental anxiety in the message notes, and our team will book an extra unhurried consultation with our gentlest clinicians.",
    },
    sections: [
      { id: 'sec_contact_channels', type: 'channels_block', eyebrow: 'COMMUNICATION CHANNELS', title: 'Immediate Ways to Connect & Clinical Hours', summary: 'Connect directly with our dedicated Birmingham reception team, dental nurses, and clinical care coordinators.', is_active: true, order: 1 },
      { id: 'sec_contact_form', type: 'contact_form_block', eyebrow: 'APPOINTMENT & CLINICAL INQUIRY', title: 'Send a Message or Request a Slot', summary: 'Complete the form below. For acute pain or same-day emergency triage, please call us directly on 0121 765 2870.', is_active: true, order: 2 },
      { id: 'sec_contact_directions', type: 'directions_block', eyebrow: 'LOCATION & ACCESSIBILITY', title: 'Finding Us: Transport & Dedicated Parking', summary: 'Situated on the bustling Warwick Road (A41), our dental practice is conveniently positioned for patients across Acocks Green, Hall Green, Solihull, and Greater Birmingham.', is_active: true, order: 3 },
    ],
  });

  const [isBookingOpen, setIsBookingOpen] = useState(false);

  // Contact Form State
  const [patientStatus, setPatientStatus] = useState<'new' | 'existing' | 'emergency'>('new');
  const [fullName, setFullName] = useState('');
  const [phone, setPhone] = useState('');
  const [email, setEmail] = useState('');
  const [serviceRequired, setServiceRequired] = useState('');
  const [preferredTime, setPreferredTime] = useState('morning');
  const [commMethod, setCommMethod] = useState('phone');
  const [message, setMessage] = useState('');
  const [gdprConsent, setGdprConsent] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [submitSuccess, setSubmitSuccess] = useState<string | null>(null);
  const [submitError, setSubmitError] = useState<string | null>(null);

  useEffect(() => {
    async function loadContact() {
      try {
        const res = await apiClient.get<ContactPageData>(`/pages/contact?_t=${Date.now()}`);
        if (res?.success && res.data) {
          setPageData(res.data);
          if (res.data.seo?.meta_title) {
            document.title = res.data.seo.meta_title;
          }
        }
      } catch {
        // Keep defaults
      }
    }
    loadContact();
  }, []);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setSubmitting(true);
    setSubmitError(null);
    setSubmitSuccess(null);

    try {
      const res = await apiClient.add<{ reference?: string; message?: string }>('/contact/submit', {
        patient_status: patientStatus,
        full_name: fullName,
        phone,
        email,
        service_required: serviceRequired || 'General Practice Enquiry',
        preferred_time: preferredTime,
        comm_method: commMethod,
        message,
        gdpr_consent: gdprConsent,
      });

      const raw = res as unknown as { success?: boolean; reference?: string; message?: string };
      if (raw?.success) {
        setSubmitSuccess(`Thank you! Reference ${raw.reference || ''} — your enquiry has been saved and routed to our reception team.`);
        setFullName('');
        setPhone('');
        setEmail('');
        setServiceRequired('');
        setMessage('');
        setGdprConsent(false);
      } else {
        setSubmitError(raw?.message || 'Unable to submit enquiry. Please call us on 0121 765 2870.');
      }
    } catch {
      setSubmitError('Network error submitting enquiry. Please try again or call 0121 765 2870.');
    } finally {
      setSubmitting(false);
    }
  };

  const phoneDisplay = theme?.branding?.phone || pageData.hero?.triage_phone || '+44 121 765 2870';
  const emailDisplay = (theme?.branding as unknown as { email?: string })?.email || 'reception@acocksgreendental.co.uk';
  const addressDisplay = theme?.branding?.address || '1078 Warwick Road, Acocks Green, Birmingham B27 6BH';

  const sections = [...(pageData.sections || [])]
    .filter((s) => s.is_active !== false)
    .sort((a, b) => (Number(a.order) || 0) - (Number(b.order) || 0));

  return (
    <div style={{ minHeight: '100vh', display: 'flex', flexDirection: 'column', background: '#f2fcf5' }}>
      <HeaderTopBar />
      <HeaderNavBar onBookClick={() => setIsBookingOpen(true)} />

      <main style={{ flex: 1 }}>
        {/* HERO BANNER */}
        <section style={{ padding: '44px 0 40px', background: '#f2fcf5' }}>
          <div style={{ maxWidth: 1400, margin: '0 auto', padding: '0 24px' }}>
            <nav style={{ fontSize: 13, color: '#40493d', marginBottom: 18, display: 'flex', alignItems: 'center', gap: 8 }}>
              <Link href="/" style={{ color: '#0d631b', fontWeight: 600, textDecoration: 'none' }}>Home</Link>
              <span>›</span>
              <span style={{ color: '#0d631b', fontWeight: 700 }}>Contact Us</span>
            </nav>

            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: 40, alignItems: 'center' }}>
              <div>
                <span style={{ display: 'block', fontSize: 12.5, fontWeight: 700, color: '#0d631b', letterSpacing: '0.08em', textTransform: 'uppercase', marginBottom: 10 }}>
                  {pageData.hero?.eyebrow}
                </span>
                <h1 style={{ fontSize: 'clamp(2rem, 3.8vw, 3rem)', fontWeight: 800, color: '#151d1a', lineHeight: 1.15, marginBottom: 16 }}>
                  {pageData.hero?.headline}
                </h1>
                <p style={{ fontSize: 17, color: '#40493d', lineHeight: 1.65, marginBottom: 24 }}>
                  {pageData.hero?.subtitle}
                </p>
                <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(150px, 1fr))', gap: 12 }}>
                  {(pageData.hero?.badges || []).map((b, i) => (
                    <div key={i} style={{ padding: 14, background: '#ffffff', borderRadius: 14, border: '1px solid #e5efe7', display: 'flex', flexDirection: 'column', gap: 6 }}>
                      <span className="material-symbols-outlined" style={{ color: b.icon === 'emergency' ? '#D32F2F' : '#0d631b', fontSize: 22 }}>{b.icon}</span>
                      <span style={{ fontSize: 12.5, fontWeight: 700, color: '#151d1a', lineHeight: 1.3 }}>{b.label}</span>
                    </div>
                  ))}
                </div>
              </div>

              <div style={{ position: 'relative', borderRadius: 20, overflow: 'hidden', height: 340, border: '1px solid #e5efe7', boxShadow: '0 18px 40px rgba(13,46,26,0.12)' }}>
                <Image
                  src={assetUrl(pageData.hero?.image || '/uploads/home/surgery-clinic.jpg')}
                  alt="Acocks Green Dental Practice Reception"
                  fill
                  style={{ objectFit: 'cover' }}
                />
                <div
                  style={{
                    position: 'absolute',
                    bottom: 14,
                    left: 14,
                    right: 14,
                    background: 'rgba(255,255,255,0.95)',
                    backdropFilter: 'blur(8px)',
                    padding: '12px 16px',
                    borderRadius: 14,
                    display: 'flex',
                    justifyContent: 'space-between',
                    alignItems: 'center',
                    gap: 12,
                  }}
                >
                  <div>
                    <div style={{ fontSize: 11, fontWeight: 700, textTransform: 'uppercase', color: '#40493d' }}>
                      {pageData.hero?.triage_label || 'Direct Clinical Triage'}
                    </div>
                    <a href={`tel:${phoneDisplay.replace(/\s+/g, '')}`} style={{ fontSize: 19, fontWeight: 800, color: '#0d631b', textDecoration: 'none' }}>
                      {phoneDisplay}
                    </a>
                  </div>
                  <span style={{ fontSize: 12, fontWeight: 700, background: '#2e7d32', color: '#fff', padding: '5px 12px', borderRadius: 999 }}>
                    Lines Open
                  </span>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* DYNAMIC CMS SECTIONS */}
        {sections.map((sec) => {
          if (sec.type === 'channels_block') {
            return (
              <section key={sec.id} style={{ background: '#ecf6ef', padding: '64px 0' }}>
                <div style={{ maxWidth: 1400, margin: '0 auto', padding: '0 24px' }}>
                  <div style={{ textAlign: 'center', maxWidth: 680, margin: '0 auto 40px' }}>
                    <span style={{ fontSize: 12.5, fontWeight: 700, color: '#0d631b', textTransform: 'uppercase', letterSpacing: '0.08em' }}>{sec.eyebrow}</span>
                    <h2 style={{ fontSize: 'clamp(1.75rem, 3vw, 2.3rem)', fontWeight: 800, color: '#151d1a', margin: '8px 0 12px' }}>{sec.title}</h2>
                    <p style={{ color: '#40493d', margin: 0 }}>{sec.summary}</p>
                  </div>

                  <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(260px, 1fr))', gap: 22 }}>
                    <div style={{ background: '#fff', padding: 24, borderRadius: 18, border: '1px solid #e5efe7', display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
                      <div>
                        <span className="material-symbols-outlined" style={{ color: '#0d631b', fontSize: 28, marginBottom: 12 }}>call</span>
                        <h3 style={{ fontSize: 19, fontWeight: 700, marginBottom: 6 }}>Direct Telephone</h3>
                        <p style={{ fontSize: 13.5, color: '#40493d', marginBottom: 14 }}>Appointments, triage &amp; urgent slots</p>
                        <a href={`tel:${phoneDisplay.replace(/\s+/g, '')}`} style={{ fontSize: 20, fontWeight: 800, color: '#0d631b', textDecoration: 'none' }}>{phoneDisplay}</a>
                      </div>
                      <a href={`tel:${phoneDisplay.replace(/\s+/g, '')}`} style={{ marginTop: 20, display: 'block', textAlign: 'center', padding: '10px 16px', borderRadius: 10, background: '#2e7d32', color: '#fff', fontWeight: 700, textDecoration: 'none' }}>
                        Call Practice Now
                      </a>
                    </div>

                    <div style={{ background: '#fff', padding: 24, borderRadius: 18, border: '1px solid #e5efe7', display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
                      <div>
                        <span className="material-symbols-outlined" style={{ color: '#0d631b', fontSize: 28, marginBottom: 12 }}>location_on</span>
                        <h3 style={{ fontSize: 19, fontWeight: 700, marginBottom: 6 }}>Practice Address</h3>
                        <p style={{ fontSize: 14, color: '#151d1a', lineHeight: 1.6 }}>{addressDisplay}</p>
                      </div>
                      <a href="#travel-directions" style={{ marginTop: 20, display: 'block', textAlign: 'center', padding: '10px 16px', borderRadius: 10, background: '#e1ebe4', color: '#151d1a', fontWeight: 700, textDecoration: 'none' }}>
                        View Transport Guide
                      </a>
                    </div>

                    <div style={{ background: '#fff', padding: 24, borderRadius: 18, border: '1px solid #e5efe7', display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
                      <div>
                        <span className="material-symbols-outlined" style={{ color: '#0d631b', fontSize: 28, marginBottom: 12 }}>schedule</span>
                        <h3 style={{ fontSize: 19, fontWeight: 700, marginBottom: 10 }}>Opening Hours</h3>
                        <div style={{ fontSize: 13.5, display: 'flex', justifyContent: 'space-between', padding: '5px 0', borderBottom: '1px solid #f1f5f9' }}><span>Mon – Thu</span><strong>8:30am – 5:30pm</strong></div>
                        <div style={{ fontSize: 13.5, display: 'flex', justifyContent: 'space-between', padding: '5px 0', borderBottom: '1px solid #f1f5f9' }}><span>Friday</span><strong>8:30am – 5:00pm</strong></div>
                        <div style={{ fontSize: 13.5, display: 'flex', justifyContent: 'space-between', padding: '5px 0' }}><span>Saturday</span><strong style={{ color: '#0d631b' }}>Emergency On-Call</strong></div>
                      </div>
                      <div style={{ marginTop: 18, padding: 10, borderRadius: 10, background: '#E8F5E9', textAlign: 'center', fontSize: 12, fontWeight: 700, color: '#0d631b' }}>
                        Early morning &amp; lunchtime slots
                      </div>
                    </div>

                    <div style={{ background: '#fff', padding: 24, borderRadius: 18, border: '1px solid #e5efe7', display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
                      <div>
                        <span className="material-symbols-outlined" style={{ color: '#0d631b', fontSize: 28, marginBottom: 12 }}>mail</span>
                        <h3 style={{ fontSize: 19, fontWeight: 700, marginBottom: 6 }}>Email Enquiries</h3>
                        <p style={{ fontSize: 13.5, color: '#40493d', marginBottom: 10 }}>Referrals, dental records &amp; queries</p>
                        <a href={`mailto:${emailDisplay}`} style={{ fontSize: 14, fontWeight: 700, color: '#0d631b', wordBreak: 'break-all' }}>{emailDisplay}</a>
                      </div>
                      <a href="#contact-form" style={{ marginTop: 20, display: 'block', textAlign: 'center', padding: '10px 16px', borderRadius: 10, background: '#e1ebe4', color: '#151d1a', fontWeight: 700, textDecoration: 'none' }}>
                        Send Direct Message
                      </a>
                    </div>
                  </div>
                </div>
              </section>
            );
          }

          if (sec.type === 'contact_form_block') {
            return (
              <section key={sec.id} id="contact-form" style={{ background: '#f2fcf5', padding: '68px 0' }}>
                <div style={{ maxWidth: 1400, margin: '0 auto', padding: '0 24px' }}>
                  <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(340px, 1fr))', gap: 40, alignItems: 'start' }}>
                    {/* LEFT: INTERACTIVE FORM */}
                    <div style={{ background: '#ffffff', padding: 'clamp(24px, 4vw, 40px)', borderRadius: 24, border: '1px solid #e5efe7', boxShadow: '0 10px 30px rgba(15,23,42,0.05)' }}>
                      <span style={{ fontSize: 12, fontWeight: 700, color: '#0d631b', textTransform: 'uppercase', letterSpacing: '0.08em' }}>{sec.eyebrow}</span>
                      <h2 style={{ fontSize: 'clamp(1.6rem, 3vw, 2.1rem)', fontWeight: 800, color: '#151d1a', margin: '8px 0 10px' }}>{sec.title}</h2>
                      <p style={{ fontSize: 14.5, color: '#40493d', marginBottom: 24 }}>{sec.summary}</p>

                      <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: 18 }}>
                        <div>
                          <label style={{ display: 'block', fontSize: 14, fontWeight: 700, marginBottom: 8 }}>Patient Status *</label>
                          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 10 }}>
                            {[
                              { val: 'new', label: 'New Patient' },
                              { val: 'existing', label: 'Existing Patient' },
                              { val: 'emergency', label: 'Emergency / Pain' },
                            ].map((opt) => (
                              <button
                                key={opt.val}
                                type="button"
                                onClick={() => setPatientStatus(opt.val as 'new' | 'existing' | 'emergency')}
                                style={{
                                  padding: '11px 10px',
                                  borderRadius: 12,
                                  border: '1px solid',
                                  borderColor: patientStatus === opt.val ? (opt.val === 'emergency' ? '#D32F2F' : '#0d631b') : '#dbe5de',
                                  background: patientStatus === opt.val ? (opt.val === 'emergency' ? '#D32F2F' : '#2e7d32') : '#ecf6ef',
                                  color: patientStatus === opt.val ? '#ffffff' : '#151d1a',
                                  fontWeight: 700,
                                  fontSize: 13,
                                  cursor: 'pointer',
                                }}
                              >
                                {opt.label}
                              </button>
                            ))}
                          </div>
                        </div>

                        <div>
                          <label htmlFor="fullName" style={{ display: 'block', fontSize: 14, fontWeight: 700, marginBottom: 6 }}>Full Name *</label>
                          <input
                            id="fullName"
                            required
                            value={fullName}
                            onChange={(e) => setFullName(e.target.value)}
                            placeholder="e.g. Sarah Jenkins"
                            style={{ width: '100%', padding: '12px 14px', borderRadius: 12, border: '1px solid #dbe5de', background: '#ecf6ef', fontSize: 15 }}
                          />
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(180px, 1fr))', gap: 14 }}>
                          <div>
                            <label htmlFor="phoneNum" style={{ display: 'block', fontSize: 14, fontWeight: 700, marginBottom: 6 }}>Telephone Number *</label>
                            <input
                              id="phoneNum"
                              type="tel"
                              required
                              value={phone}
                              onChange={(e) => setPhone(e.target.value)}
                              placeholder="e.g. 07700 900123"
                              style={{ width: '100%', padding: '12px 14px', borderRadius: 12, border: '1px solid #dbe5de', background: '#ecf6ef', fontSize: 15 }}
                            />
                          </div>
                          <div>
                            <label htmlFor="emailAddr" style={{ display: 'block', fontSize: 14, fontWeight: 700, marginBottom: 6 }}>Email Address *</label>
                            <input
                              id="emailAddr"
                              type="email"
                              required
                              value={email}
                              onChange={(e) => setEmail(e.target.value)}
                              placeholder="sarah.jenkins@example.co.uk"
                              style={{ width: '100%', padding: '12px 14px', borderRadius: 12, border: '1px solid #dbe5de', background: '#ecf6ef', fontSize: 15 }}
                            />
                          </div>
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(180px, 1fr))', gap: 14 }}>
                          <div>
                            <label htmlFor="dentalService" style={{ display: 'block', fontSize: 14, fontWeight: 700, marginBottom: 6 }}>Service Required *</label>
                            <select
                              id="dentalService"
                              required
                              value={serviceRequired}
                              onChange={(e) => setServiceRequired(e.target.value)}
                              style={{ width: '100%', padding: '12px 14px', borderRadius: 12, border: '1px solid #dbe5de', background: '#ecf6ef', fontSize: 14.5 }}
                            >
                              <option value="">Select dental treatment...</option>
                              <option value="Routine Dental Examination & Clean">Routine Dental Examination &amp; Clean</option>
                              <option value="Emergency Pain Relief & Infection Triage">Emergency Pain Relief &amp; Infection Triage</option>
                              <option value="Invisalign & Clear Aligners">Invisalign® &amp; Clear Aligners Consultation</option>
                              <option value="Hygiene & Airflow Stain Removal">Hygiene &amp; Airflow Stain Removal</option>
                              <option value="Dental Crowns & Bridges">Dental Implants, Crowns &amp; Bridges</option>
                              <option value="NHS Dental Treatment Inquiry">NHS Dental Treatment Inquiry</option>
                              <option value="General Practice Enquiry">General Practice Enquiry</option>
                            </select>
                          </div>
                          <div>
                            <label htmlFor="prefTime" style={{ display: 'block', fontSize: 14, fontWeight: 700, marginBottom: 6 }}>Preferred Time</label>
                            <select
                              id="prefTime"
                              value={preferredTime}
                              onChange={(e) => setPreferredTime(e.target.value)}
                              style={{ width: '100%', padding: '12px 14px', borderRadius: 12, border: '1px solid #dbe5de', background: '#ecf6ef', fontSize: 14.5 }}
                            >
                              <option value="morning">Morning (8:30am - 12:00pm)</option>
                              <option value="afternoon">Afternoon (12:00pm - 5:00pm)</option>
                              <option value="first-available">First Available Slot (Urgent)</option>
                            </select>
                          </div>
                        </div>

                        <div>
                          <label style={{ display: 'block', fontSize: 14, fontWeight: 700, marginBottom: 6 }}>How should we confirm?</label>
                          <div style={{ display: 'flex', gap: 18, flexWrap: 'wrap' }}>
                            {[
                              { val: 'phone', label: 'Telephone Call' },
                              { val: 'email', label: 'Email Confirmation' },
                              { val: 'sms', label: 'SMS Text Message' },
                            ].map((m) => (
                              <label key={m.val} style={{ display: 'flex', alignItems: 'center', gap: 6, fontSize: 14, cursor: 'pointer' }}>
                                <input type="radio" name="comm_method" checked={commMethod === m.val} onChange={() => setCommMethod(m.val)} />
                                {m.label}
                              </label>
                            ))}
                          </div>
                        </div>

                        <div>
                          <label htmlFor="messageNotes" style={{ display: 'block', fontSize: 14, fontWeight: 700, marginBottom: 6 }}>Dental Concern Notes or Specific Requests</label>
                          <textarea
                            id="messageNotes"
                            rows={4}
                            value={message}
                            onChange={(e) => setMessage(e.target.value)}
                            placeholder="Please describe any toothache symptoms, previous dental history, or questions..."
                            style={{ width: '100%', padding: 14, borderRadius: 12, border: '1px solid #dbe5de', background: '#ecf6ef', fontSize: 15 }}
                          />
                        </div>

                        <label style={{ display: 'flex', alignItems: 'flex-start', gap: 10, fontSize: 13, color: '#40493d', cursor: 'pointer' }}>
                          <input type="checkbox" required checked={gdprConsent} onChange={(e) => setGdprConsent(e.target.checked)} style={{ marginTop: 3 }} />
                          <span>I consent to Acocks Green Dental Practice storing my contact details to process this appointment enquiry in accordance with UK GDPR and NHS clinical confidentiality standards.</span>
                        </label>

                        <button
                          type="submit"
                          disabled={submitting}
                          style={{
                            width: '100%',
                            padding: '15px 24px',
                            borderRadius: 12,
                            border: 'none',
                            background: '#2e7d32',
                            color: '#ffffff',
                            fontWeight: 800,
                            fontSize: 16,
                            cursor: submitting ? 'not-allowed' : 'pointer',
                          }}
                        >
                          {submitting ? 'Sending Enquiry...' : 'Send Enquiry & Request Callback'}
                        </button>

                        {submitSuccess && (
                          <div style={{ padding: 14, borderRadius: 12, background: '#E8F5E9', color: '#0d631b', fontWeight: 700, fontSize: 14 }}>
                            {submitSuccess}
                          </div>
                        )}
                        {submitError && (
                          <div style={{ padding: 14, borderRadius: 12, background: '#ffdad6', color: '#93000a', fontWeight: 700, fontSize: 14 }}>
                            {submitError}
                          </div>
                        )}
                      </form>
                    </div>

                    {/* RIGHT: JOURNEY TIMELINE + REASSURANCE */}
                    <div style={{ display: 'flex', flexDirection: 'column', gap: 22 }}>
                      <div style={{ background: '#ffffff', padding: 32, borderRadius: 24, border: '1px solid #e5efe7' }}>
                        <span style={{ fontSize: 12, fontWeight: 700, color: '#0d631b', textTransform: 'uppercase', letterSpacing: '0.08em' }}>SEAMLESS PATIENT JOURNEY</span>
                        <h3 style={{ fontSize: 22, fontWeight: 800, margin: '6px 0 22px' }}>What Happens After You Contact Us?</h3>
                        <div style={{ display: 'flex', flexDirection: 'column', gap: 20 }}>
                          {(pageData.journey_steps || []).map((st, idx) => (
                            <div key={idx} style={{ display: 'flex', gap: 14, alignItems: 'flex-start' }}>
                              <div style={{ width: 38, height: 38, borderRadius: '50%', background: idx === 2 ? '#2e7d32' : '#E8F5E9', color: idx === 2 ? '#fff' : '#0d631b', fontWeight: 800, display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 }}>
                                {st.step}
                              </div>
                              <div>
                                <h4 style={{ fontSize: 16.5, fontWeight: 700, marginBottom: 4 }}>{st.title}</h4>
                                <p style={{ fontSize: 14, color: '#40493d', margin: 0, lineHeight: 1.6 }}>{st.desc}</p>
                              </div>
                            </div>
                          ))}
                        </div>
                      </div>

                      {pageData.reassurance_card?.title && (
                        <div style={{ background: '#ffffff', padding: 24, borderRadius: 20, border: '1px solid #e5efe7', display: 'flex', gap: 14, alignItems: 'flex-start' }}>
                          <span className="material-symbols-outlined" style={{ color: '#0d631b', fontSize: 28 }}>favorite</span>
                          <div>
                            <h4 style={{ fontSize: 17, fontWeight: 700, marginBottom: 6 }}>{pageData.reassurance_card.title}</h4>
                            <p style={{ fontSize: 14, color: '#40493d', margin: 0, lineHeight: 1.6 }}>{pageData.reassurance_card.desc}</p>
                          </div>
                        </div>
                      )}

                      <div style={{ background: '#0D2E1A', color: '#ffffff', padding: 24, borderRadius: 20, display: 'flex', justifyContent: 'space-between', alignItems: 'center', flexWrap: 'wrap', gap: 14 }}>
                        <div>
                          <div style={{ fontSize: 11, fontWeight: 700, color: '#cbffc2', textTransform: 'uppercase' }}>Fast-Track Assistance</div>
                          <div style={{ fontSize: 15, fontWeight: 600 }}>Speak to Head Receptionist</div>
                        </div>
                        <a href={`tel:${phoneDisplay.replace(/\s+/g, '')}`} style={{ padding: '10px 18px', borderRadius: 10, background: '#ffffff', color: '#0d631b', fontWeight: 800, textDecoration: 'none' }}>
                          {phoneDisplay}
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            );
          }

          if (sec.type === 'directions_block') {
            return (
              <section key={sec.id} id="travel-directions" style={{ background: '#ecf6ef', padding: '64px 0' }}>
                <div style={{ maxWidth: 1400, margin: '0 auto', padding: '0 24px' }}>
                  <div style={{ maxWidth: 740, marginBottom: 32 }}>
                    <span style={{ fontSize: 12.5, fontWeight: 700, color: '#0d631b', textTransform: 'uppercase', letterSpacing: '0.08em' }}>{sec.eyebrow}</span>
                    <h2 style={{ fontSize: 'clamp(1.75rem, 3vw, 2.3rem)', fontWeight: 800, color: '#151d1a', margin: '8px 0 12px' }}>{sec.title}</h2>
                    <p style={{ color: '#40493d', margin: 0 }}>{sec.summary}</p>
                  </div>
                  <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))', gap: 28, alignItems: 'stretch' }}>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: 18 }}>
                      <div style={{ background: '#fff', padding: 24, borderRadius: 18, border: '1px solid #e5efe7' }}>
                        <h3 style={{ fontSize: 18, fontWeight: 700, marginBottom: 8 }}>By Car &amp; Free Patient Parking</h3>
                        <p style={{ fontSize: 14, color: '#40493d', margin: 0, lineHeight: 1.6 }}>
                          Located on Warwick Road (A41) in Acocks Green, Birmingham B27 6BH with complimentary rear patient parking bays and nearby street parking.
                        </p>
                      </div>
                      <div style={{ background: '#fff', padding: 24, borderRadius: 18, border: '1px solid #e5efe7' }}>
                        <h3 style={{ fontSize: 18, fontWeight: 700, marginBottom: 8 }}>By Train &amp; Bus</h3>
                        <p style={{ fontSize: 14, color: '#40493d', margin: 0, lineHeight: 1.6 }}>
                          5 minutes walk from Acocks Green Railway Station and directly served by National Express West Midlands bus routes 1, 11A, 11C, and 37.
                        </p>
                      </div>
                    </div>
                    <div style={{ borderRadius: 18, overflow: 'hidden', border: '1px solid #e5efe7', minHeight: 280, background: '#fff' }}>
                      <iframe
                        title="Acocks Green Dental Practice Map"
                        src="https://www.google.com/maps?q=1078+Warwick+Road+Acocks+Green+Birmingham+B27+6BH&output=embed"
                        width="100%"
                        height="100%"
                        style={{ border: 0, minHeight: 280 }}
                        loading="lazy"
                      />
                    </div>
                  </div>
                </div>
              </section>
            );
          }

          return (
            <section key={sec.id} style={{ padding: '48px 0', background: '#ffffff' }}>
              <div style={{ maxWidth: 1400, margin: '0 auto', padding: '0 24px' }}>
                {sec.eyebrow && <span style={{ fontSize: 12, fontWeight: 700, color: '#0d631b', textTransform: 'uppercase' }}>{sec.eyebrow}</span>}
                {sec.title && <h2 style={{ fontSize: 28, fontWeight: 800, margin: '8px 0 12px' }}>{sec.title}</h2>}
                {sec.summary && <div dangerouslySetInnerHTML={{ __html: sec.summary }} style={{ color: '#40493d', lineHeight: 1.7 }} />}
              </div>
            </section>
          );
        })}
      </main>

      <Footer />
      <MobileAppNavBar onBookClick={() => setIsBookingOpen(true)} />
      <BookingModal isOpen={isBookingOpen} onClose={() => setIsBookingOpen(false)} />
    </div>
  );
}
