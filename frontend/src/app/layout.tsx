import type { Metadata } from 'next';
import '@/styles/globals.scss';

export const metadata: Metadata = {
  title: 'Acocks Green Dental Practice | NHS & Private Family Dental Care Birmingham B27',
  description:
    'Welcoming NHS & private dental patients across Birmingham B27. Board-certified dentists, emergency triage, hygiene, restorative dentistry, cosmetic veneers, and Invisalign clear aligners.',
  keywords: [
    'Acocks Green Dental Practice',
    'Dentist Birmingham B27',
    'NHS Dentist Birmingham',
    'Emergency Dentist Birmingham',
    'Dental Implants',
    'Invisalign Clear Aligners',
    'Teeth Whitening',
    'Tarlok Marok',
    'Dr Atandrilla Das',
  ],
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en" data-theme="acocks-green">
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link
          rel="preconnect"
          href="https://fonts.gstatic.com"
          crossOrigin="anonymous"
        />
        <link
          href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Work+Sans:wght@400;500;600&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap"
          rel="stylesheet"
        />
        <link
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
          rel="stylesheet"
        />
      </head>
      <body>{children}</body>
    </html>
  );
}
