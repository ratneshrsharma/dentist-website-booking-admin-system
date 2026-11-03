'use client';

import React, { useState } from 'react';
import { PageLayout } from '@/components/templates/PageLayout/PageLayout';
import styles from './page.module.scss';
import { MapPin, Phone, Clock, Send, CheckCircle2 } from 'lucide-react';

export default function ContactPage() {
  const [formData, setFormData] = useState({
    fullName: '',
    phone: '',
    email: '',
    branch: 'Downtown Flagship',
    serviceInterest: 'Dental Implants',
    notes: '',
  });
  const [submitted, setSubmitted] = useState(false);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setSubmitted(true);
  };

  const schemaJson = {
    '@context': 'https://schema.org',
    '@type': 'Dentist',
    name: 'Advanced Dental Clinic',
    telephone: '+1 (800) 555-DENT',
    email: 'appointments@advanceddentalclinic.com',
    address: {
      '@type': 'PostalAddress',
      streetAddress: '742 Evergreen Medical Pavilion, Suite 400',
      addressLocality: 'Metropolis',
      postalCode: '10001',
      addressCountry: 'US',
    },
    openingHoursSpecification: [
      {
        '@type': 'OpeningHoursSpecification',
        dayOfWeek: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
        opens: '08:00',
        closes: '19:00',
      },
      {
        '@type': 'OpeningHoursSpecification',
        dayOfWeek: ['Saturday'],
        opens: '09:00',
        closes: '16:00',
      },
    ],
  };

  return (
    <PageLayout
      title="Contact & Practice Locations"
      subtitle="Reach our patient coordination desk, locate our 3 state-of-the-art clinical branches, or book an emergency consultation."
      badge="Get In Touch"
      breadcrumbs={[{ label: 'Contact & Clinics' }]}
      schemaJson={schemaJson}
    >
      <div className={styles.contactContainer}>
        <div className={styles.contentWrap}>
          {/* Emergency Strip */}
          <div className={styles.emergencyBanner}>
            <div className={styles.emergencyText}>
              <h4>Immediate Dental Emergency? Severe Toothache or Trauma?</h4>
              <p>Our on-call dental trauma team is available 24 hours a day, 7 days a week.</p>
            </div>
            <a href="tel:+18005553368" className={styles.emergencyCallBtn}>
              <Phone size={16} /> 24/7 Hotline: +1 (800) 555-DENT
            </a>
          </div>

          <div className={styles.twoColLayout}>
            {/* Left: Contact Form */}
            <div className={styles.formCard}>
              <h3>Send an Inquiry or Request a Call Back</h3>
              <p>Our patient concierge team will contact you within 15 minutes during clinical hours.</p>

              {submitted ? (
                <div style={{ padding: '2rem 1rem', textAlign: 'center' }}>
                  <CheckCircle2 size={48} color="#0D9488" style={{ margin: '0 auto 1rem' }} />
                  <h4>Inquiry Successfully Received!</h4>
                  <p style={{ color: 'var(--color-text-muted)', fontSize: '1rem' }}>
                    Thank you, {formData.fullName}. Our patient coordinator has been notified and will call you at {formData.phone} shortly.
                  </p>
                </div>
              ) : (
                <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                  <div className={styles.formGroup}>
                    <label htmlFor="fullName">Full Patient Name *</label>
                    <input
                      id="fullName"
                      type="text"
                      required
                      placeholder="e.g. Johnathan Miller"
                      value={formData.fullName}
                      onChange={(e) => setFormData({ ...formData, fullName: e.target.value })}
                    />
                  </div>

                  <div className={styles.formGroup}>
                    <label htmlFor="phone">Mobile Phone (with WhatsApp) *</label>
                    <input
                      id="phone"
                      type="tel"
                      required
                      placeholder="+1 (555) 000-0000"
                      value={formData.phone}
                      onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                    />
                  </div>

                  <div className={styles.formGroup}>
                    <label htmlFor="email">Email Address</label>
                    <input
                      id="email"
                      type="email"
                      placeholder="name@example.com"
                      value={formData.email}
                      onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                    />
                  </div>

                  <div className={styles.formGroup}>
                    <label htmlFor="branch">Preferred Clinical Location</label>
                    <select
                      id="branch"
                      value={formData.branch}
                      onChange={(e) => setFormData({ ...formData, branch: e.target.value })}
                    >
                      <option value="Downtown Flagship">Downtown Flagship Medical Center</option>
                      <option value="Westside Smile Pavilion">Westside Cosmetic & Aligner Studio</option>
                      <option value="Northpark Surgical Center">Northpark Implant & Surgical Facility</option>
                    </select>
                  </div>

                  <div className={styles.formGroup}>
                    <label htmlFor="notes">How Can We Help You?</label>
                    <textarea
                      id="notes"
                      placeholder="Describe your symptoms, questions, or requested procedure..."
                      value={formData.notes}
                      onChange={(e) => setFormData({ ...formData, notes: e.target.value })}
                    />
                  </div>

                  <button type="submit" className={styles.submitBtn}>
                    <Send size={16} /> Submit Patient Inquiry
                  </button>
                </form>
              )}
            </div>

            {/* Right: Branch Locations */}
            <div className={styles.branchList}>
              <div className={styles.branchCard}>
                <h4>
                  <span>Downtown Flagship Medical Suite</span>
                  <span className={styles.branchBadge}>Main Center</span>
                </h4>
                <div className={styles.branchInfoRow}>
                  <MapPin size={18} />
                  <span>742 Evergreen Medical Pavilion, Suite 400, Financial District</span>
                </div>
                <div className={styles.branchInfoRow}>
                  <Phone size={18} />
                  <a href="tel:+18005553368">+1 (800) 555-DENT (Ext 1)</a>
                </div>
                <div className={styles.branchInfoRow}>
                  <Clock size={18} />
                  <span>Mon–Fri: 8:00 AM – 7:00 PM | Sat: 9:00 AM – 4:00 PM</span>
                </div>
              </div>

              <div className={styles.branchCard}>
                <h4>
                  <span>Westside Cosmetic & Aligner Studio</span>
                  <span className={styles.branchBadge}>Aesthetic Suite</span>
                </h4>
                <div className={styles.branchInfoRow}>
                  <MapPin size={18} />
                  <span>1088 Ocean Boulevard, Floor 2, Westside Plaza</span>
                </div>
                <div className={styles.branchInfoRow}>
                  <Phone size={18} />
                  <a href="tel:+18005553368">+1 (800) 555-DENT (Ext 2)</a>
                </div>
                <div className={styles.branchInfoRow}>
                  <Clock size={18} />
                  <span>Mon–Sat: 9:00 AM – 6:00 PM</span>
                </div>
              </div>

              <div className={styles.branchCard}>
                <h4>
                  <span>Northpark Surgical & Implant Facility</span>
                  <span className={styles.branchBadge}>3D Imaging & Day Surgery</span>
                </h4>
                <div className={styles.branchInfoRow}>
                  <MapPin size={18} />
                  <span>320 Highland Medical Park, Surgical Wing B</span>
                </div>
                <div className={styles.branchInfoRow}>
                  <Phone size={18} />
                  <a href="tel:+18005553368">+1 (800) 555-DENT (Ext 3)</a>
                </div>
                <div className={styles.branchInfoRow}>
                  <Clock size={18} />
                  <span>Mon–Fri: 7:30 AM – 5:30 PM (Surgical Sessions)</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </PageLayout>
  );
}
