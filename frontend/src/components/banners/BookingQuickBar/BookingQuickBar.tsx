'use client';

import React, { useState } from 'react';
import styles from './BookingQuickBar.module.css';

export interface BookingQuickBarProps {
  onSearchSlots?: (params: { treatment: string; date: string; timeOfDay: string }) => void;
}

export const BookingQuickBar: React.FC<BookingQuickBarProps> = ({ onSearchSlots }) => {
  const [treatment, setTreatment] = useState('general-checkup');
  const [date, setDate] = useState(() => {
    const today = new Date();
    today.setDate(today.getDate() + 1);
    return today.toISOString().split('T')[0];
  });
  const [timeOfDay, setTimeOfDay] = useState('morning');

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (onSearchSlots) {
      onSearchSlots({ treatment, date, timeOfDay });
    }
  };

  return (
    <div className={styles.quickBarContainer}>
      <div className={styles.card}>
        <form onSubmit={handleSubmit} className={styles.formGrid}>
          {/* Treatment Select */}
          <div className={styles.inputGroup}>
            <label htmlFor="qb-treatment">
              <span className={`material-symbols-outlined ${styles.labelIcon}`}>
                dentistry
              </span>
              <span>Treatment Procedure</span>
            </label>
            <select
              id="qb-treatment"
              value={treatment}
              onChange={(e) => setTreatment(e.target.value)}
            >
              <option value="general-checkup">Routine Dental Examination & Checkup</option>
              <option value="hygiene-clean">Dental Hygiene & Ultrasonic Airflow</option>
              <option value="emergency-pain">Same-Day Emergency Pain Relief</option>
              <option value="invisalign-consult">Invisalign Clear Aligners Assessment</option>
              <option value="teeth-whitening">Boutique Cosmetic Teeth Whitening</option>
              <option value="dental-implants">Dental Implants & Restorative Consult</option>
            </select>
          </div>

          {/* Date Picker */}
          <div className={styles.inputGroup}>
            <label htmlFor="qb-date">
              <span className={`material-symbols-outlined ${styles.labelIcon}`}>
                calendar_today
              </span>
              <span>Preferred Date</span>
            </label>
            <input
              id="qb-date"
              type="date"
              value={date}
              onChange={(e) => setDate(e.target.value)}
              min={new Date().toISOString().split('T')[0]}
            />
          </div>

          {/* Time Slot Window */}
          <div className={styles.inputGroup}>
            <label htmlFor="qb-time">
              <span className={`material-symbols-outlined ${styles.labelIcon}`}>
                schedule
              </span>
              <span>Preferred Window</span>
            </label>
            <select
              id="qb-time"
              value={timeOfDay}
              onChange={(e) => setTimeOfDay(e.target.value)}
            >
              <option value="morning">Morning (8:30 AM – 12:00 PM)</option>
              <option value="afternoon">Afternoon (12:00 PM – 5:30 PM)</option>
              <option value="any">Any Available Time Slot</option>
            </select>
          </div>

          {/* Submit CTA */}
          <div>
            <button type="submit" className={styles.submitBtn}>
              <span>Check Slots & Book</span>
              <span className="material-symbols-outlined text-[16px]">
                arrow_forward
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};
