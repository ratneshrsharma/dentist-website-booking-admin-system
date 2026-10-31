import React from 'react';
import styles from './Badge.module.scss';

export interface BadgeProps {
  variant?: 'primary' | 'accent' | 'success' | 'warning' | 'outline' | 'emergency';
  size?: 'sm' | 'md';
  children: React.ReactNode;
  icon?: React.ReactNode;
}

export const Badge: React.FC<BadgeProps> = ({
  variant = 'primary',
  size = 'md',
  children,
  icon,
}) => {
  return (
    <span className={`${styles.badge} ${styles[`variant_${variant}`]} ${styles[`size_${size}`]}`}>
      {icon && <span className={styles.icon}>{icon}</span>}
      <span>{children}</span>
    </span>
  );
};
