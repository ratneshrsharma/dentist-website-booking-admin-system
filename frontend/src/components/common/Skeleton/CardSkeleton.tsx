import React from 'react';
import styles from './CardSkeleton.module.css';

export interface CardSkeletonProps {
  type?: 'service' | 'doctor' | 'review';
}

export const CardSkeleton: React.FC<CardSkeletonProps> = ({ type = 'service' }) => {
  if (type === 'doctor') {
    return (
      <div className={styles.skeletonCard} aria-hidden="true">
        <div className={`${styles.skeletonBlock} ${styles.skeletonImage}`} />
        <div className={`${styles.skeletonBlock} ${styles.skeletonTitle}`} />
        <div className={`${styles.skeletonBlock} ${styles.skeletonTextLine} ${styles.short}`} />
        <div className={`${styles.skeletonBlock} ${styles.skeletonTextLine}`} />
      </div>
    );
  }

  return (
    <div className={styles.skeletonCard} aria-hidden="true">
      <div className={`${styles.skeletonBlock} ${styles.skeletonIcon}`} />
      <div className={`${styles.skeletonBlock} ${styles.skeletonTitle}`} />
      <div className={`${styles.skeletonBlock} ${styles.skeletonTextLine}`} />
      <div className={`${styles.skeletonBlock} ${styles.skeletonTextLine} ${styles.short}`} />
    </div>
  );
};
