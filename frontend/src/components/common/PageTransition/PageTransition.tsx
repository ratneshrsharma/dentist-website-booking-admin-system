'use client';

import React, { useEffect, useState } from 'react';
import { usePathname } from 'next/navigation';
import styles from './PageTransition.module.css';

interface PageTransitionProps {
  children: React.ReactNode;
}

export const PageTransition: React.FC<PageTransitionProps> = ({ children }) => {
  const pathname = usePathname();
  const [transitioning, setTransitioning] = useState(false);

  useEffect(() => {
    setTransitioning(true);
    const timer = setTimeout(() => {
      setTransitioning(false);
    }, 150);
    return () => clearTimeout(timer);
  }, [pathname]);

  return (
    <div
      className={`${styles.transitionContainer} ${
        transitioning ? styles.entering : ''
      }`}
    >
      {children}
    </div>
  );
};
