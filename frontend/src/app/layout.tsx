import type { Metadata } from 'next';
import '@/styles/globals.css';
import { ThemeProvider } from '@/context/ThemeContext';
import { BrandPreloader } from '@/components/common/BrandPreloader/BrandPreloader';
import { PageTransition } from '@/components/common/PageTransition/PageTransition';
import { FloatingWhatsAppMenu } from '@/components/common/FloatingWhatsAppMenu/FloatingWhatsAppMenu';

export const metadata: Metadata = {
  title: 'Acocks Green Dental Practice | Birmingham B27 NHS & Private Care',
  description:
    'Welcoming new NHS and private patients across Birmingham B27. Routine check-ups, dental hygiene, implants, Invisalign, and same-day emergency slots.',
  keywords: [
    'Dentist Birmingham',
    'Acocks Green Dental',
    'NHS Dentist B27',
    'Emergency Dentist Birmingham',
    'Invisalign Birmingham',
  ],
  icons: {
    icon: '/dental-saas/images/acocks-green-logo.png',
  },
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en">
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link
          rel="preconnect"
          href="https://fonts.gstatic.com"
          crossOrigin="anonymous"
        />
        <link
          href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Work+Sans:wght@400;500;600&display=swap"
          rel="stylesheet"
        />
        <link
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
          rel="stylesheet"
        />
      </head>
      <body>
        <ThemeProvider>
          <BrandPreloader isReady={true} />
          <PageTransition>{children}</PageTransition>
          <FloatingWhatsAppMenu />
        </ThemeProvider>
      </body>
    </html>
  );
}
