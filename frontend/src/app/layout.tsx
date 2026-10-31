import type { Metadata } from 'next';
import '@/styles/globals.scss';

export const metadata: Metadata = {
  title: 'DentaFlow - Modern Digital Dental Practice & Multi-Clinic Ecosystem',
  description:
    'Board-certified prosthodontists, dental implants, Invisalign clear aligners, and 24/7 emergency dental care across 3 metropolitan clinics.',
  keywords: [
    'Dentist',
    'Dental Implants',
    'Invisalign',
    'Teeth Whitening',
    'Emergency Dentist',
    'Cosmetic Dentistry',
    'DentaFlow',
  ],
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en" data-theme="modern">
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link
          rel="preconnect"
          href="https://fonts.gstatic.com"
          crossOrigin="anonymous"
        />
        <link
          href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Cinzel:wght@500;700&display=swap"
          rel="stylesheet"
        />
      </head>
      <body>{children}</body>
    </html>
  );
}
