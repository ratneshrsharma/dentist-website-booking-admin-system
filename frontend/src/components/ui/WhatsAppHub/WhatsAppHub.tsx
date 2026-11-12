'use client';

import React, { useState, useEffect } from 'react';
import styles from './WhatsAppHub.module.scss';
import { MessageCircle, Phone, X, Calendar } from 'lucide-react';
import { fetchThemeSettings } from '@/lib/api-client';

interface WhatsAppHubProps {
  onOpenBooking?: () => void;
  phone?: string;
}

export const WhatsAppHub: React.FC<WhatsAppHubProps> = ({
  onOpenBooking,
  phone = '+919904379260',
}) => {
  const [isOpen, setIsOpen] = useState(false);
  const [activePhone, setActivePhone] = useState(phone);

  useEffect(() => {
    fetchThemeSettings()
      .then((settings) => {
        if (settings.whatsapp_number) {
          setActivePhone(settings.whatsapp_number);
        }
      })
      .catch(() => {});
  }, []);

  const whatsappMessage = encodeURIComponent(
    'Hello Advanced Dental Clinic! I would like to schedule an oral consultation or inquire about a dental treatment.'
  );
  const whatsappUrl = `https://wa.me/${activePhone.replace(/[^0-9]/g, '')}?text=${whatsappMessage}`;

  return (
    <div className={styles.hubContainer}>
      {isOpen && (
        <div className={styles.popupCard}>
          <div className={styles.popupHeader}>
            <div className={styles.headerInfo}>
              <span className={styles.statusDot} />
              <div>
                <h4 className={styles.headerTitle}>Advanced Dental Support Hub</h4>
                <p className={styles.headerSubtitle}>Instant Clinical Triage & WhatsApp: {activePhone}</p>
              </div>
            </div>
            <button
              type="button"
              className={styles.closeBtn}
              onClick={() => setIsOpen(false)}
              aria-label="Close support hub"
            >
              <X size={16} />
            </button>
          </div>

          <div className={styles.popupBody}>
            <p className={styles.messageSnippet}>
              Welcome to Advanced Dental Clinic. How can our patient care team assist your smile today?
            </p>

            <div className={styles.actionList}>
              <a
                href={whatsappUrl}
                target="_blank"
                rel="noopener noreferrer"
                className={`${styles.actionBtn} ${styles.whatsappBtn}`}
              >
                <MessageCircle size={18} />
                <div>
                  <strong>Chat on WhatsApp</strong>
                  <span>Direct triage line ({activePhone})</span>
                </div>
              </a>

              {onOpenBooking && (
                <button
                  type="button"
                  className={`${styles.actionBtn} ${styles.bookingBtn}`}
                  onClick={() => {
                    setIsOpen(false);
                    onOpenBooking();
                  }}
                >
                  <Calendar size={18} />
                  <div>
                    <strong>Book Online Drawer</strong>
                    <span>Select doctor & Calendly slot</span>
                  </div>
                </button>
              )}

              <a href={`tel:${activePhone.replace(/[^0-9+]/g, '')}`} className={`${styles.actionBtn} ${styles.callBtn}`}>
                <Phone size={18} />
                <div>
                  <strong>Emergency Hotline</strong>
                  <span>24/7 Dental Trauma Care</span>
                </div>
              </a>
            </div>
          </div>
        </div>
      )}

      <button
        type="button"
        className={styles.triggerButton}
        onClick={() => setIsOpen(!isOpen)}
        aria-label="Toggle instant patient support hub"
      >
        <span className={styles.pulseRing} />
        {isOpen ? <X size={24} /> : <MessageCircle size={26} />}
      </button>
    </div>
  );
};
