'use client';

import React, { useState } from 'react';
import styles from './WhatsAppHub.module.scss';
import { MessageCircle, Phone, X, Calendar } from 'lucide-react';

interface WhatsAppHubProps {
  onOpenBooking?: () => void;
  phone?: string;
}

export const WhatsAppHub: React.FC<WhatsAppHubProps> = ({
  onOpenBooking,
  phone = '+15550192830',
}) => {
  const [isOpen, setIsOpen] = useState(false);

  const whatsappMessage = encodeURIComponent(
    'Hello Smile Care Dental! I would like to schedule an oral consultation or inquire about a dental treatment.'
  );
  const whatsappUrl = `https://wa.me/${phone.replace(/[^0-9]/g, '')}?text=${whatsappMessage}`;

  return (
    <div className={styles.hubContainer}>
      {isOpen && (
        <div className={styles.popupCard}>
          <div className={styles.popupHeader}>
            <div className={styles.headerInfo}>
              <span className={styles.statusDot} />
              <div>
                <h4 className={styles.headerTitle}>Smile Care Support Hub</h4>
                <p className={styles.headerSubtitle}>Instant Clinical Triage & Assistance</p>
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
              Welcome to Smile Care. How can our patient coordination team assist your smile today?
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
                  <span>Instant reply within ~5 minutes</span>
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
                    <strong>Book Online Wizard</strong>
                    <span>Select doctor & real-time slot</span>
                  </div>
                </button>
              )}

              <a href={`tel:${phone}`} className={`${styles.actionBtn} ${styles.callBtn}`}>
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
