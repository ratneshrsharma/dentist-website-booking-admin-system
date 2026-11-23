'use client';

import React from 'react';
import styles from './TestimonialsSlider.module.css';
import { HomePageData } from '@/types/cms';

export interface TestimonialsSliderProps {
  reviewsData?: HomePageData['reviews'];
}

export const TestimonialsSlider: React.FC<TestimonialsSliderProps> = ({
  reviewsData,
}) => {
  if (!reviewsData) return null;

  const { average_rating, total_rating_text, items } = reviewsData;

  return (
    <section className={styles.section} id="reviews">
      <div className={styles.container}>
        {/* Header */}
        <div className={styles.headerRow}>
          <div>
            <span className={styles.eyebrow}>Patient Feedback</span>
            <h2 className={styles.title}>Hear From Our Acocks Green Community</h2>
          </div>

          <div className={styles.ratingSummary}>
            <div className={styles.starsRow}>
              {[...Array(5)].map((_, i) => (
                <span key={i} className="material-symbols-outlined">
                  star
                </span>
              ))}
            </div>
            <span className={styles.ratingNumber}>
              {total_rating_text || `${average_rating} / 5.0 Rating`}
            </span>
          </div>
        </div>

        {/* Reviews Cards */}
        <div className={styles.reviewsGrid}>
          {items?.map((item) => (
            <div key={item.id} className={styles.reviewCard}>
              <div>
                <div className={styles.starsMini}>
                  {[...Array(item.rating || 5)].map((_, s) => (
                    <span key={s} className="material-symbols-outlined">
                      star
                    </span>
                  ))}
                </div>
                <p className={styles.quoteText}>{item.review_text}</p>
              </div>

              <div className={styles.authorRow}>
                <div className={styles.authorAvatar}>
                  {item.initials || item.patient_name.slice(0, 2).toUpperCase()}
                </div>
                <div>
                  <p className={styles.authorName}>{item.patient_name}</p>
                  <p className={styles.authorType}>{item.patient_type}</p>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};
