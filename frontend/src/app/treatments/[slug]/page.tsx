import React from 'react';
import { Metadata } from 'next';
import { TREATMENTS_REGISTRY, getTreatmentBySlug } from '@/data/treatments';
import { TreatmentDetailClient } from './TreatmentDetailClient';

interface TreatmentPageProps {
  params: Promise<{ slug: string }>;
}

export async function generateStaticParams() {
  return Object.keys(TREATMENTS_REGISTRY).map((slug) => ({
    slug,
  }));
}

export async function generateMetadata({ params }: TreatmentPageProps): Promise<Metadata> {
  const { slug } = await params;
  const treatment = getTreatmentBySlug(slug);

  if (slug === 'general-dentistry') {
    return {
      title: 'General Dentistry & Routine Dental Check-ups in Birmingham | Acocks Green Dental Practice',
      description:
        'Comprehensive oral examinations, gentle precision care, low-dose digital radiographs, and bespoke preventative care in Acocks Green, Birmingham B27 6BH. NHS & Private patients welcome.',
      keywords: [
        'Acocks Green Dental Practice',
        'Dentist Birmingham B27',
        'Routine Dental Examination',
        'NHS Dental Band 1',
        'Dental Check-up Birmingham',
        'Private Dentist B27',
      ],
      openGraph: {
        title: 'General Dentistry & Routine Dental Check-ups in Birmingham | Acocks Green Dental Practice',
        description:
          'Comprehensive oral examinations, gentle precision care, low-dose digital radiographs, and bespoke preventative care to safeguard your smile for life.',
        images: [
          {
            url: 'https://images.unsplash.com/photo-1629909615184-74f495363b67?auto=format&fit=crop&q=80&w=1200',
            width: 1200,
            height: 630,
            alt: 'General Dentistry Birmingham',
          },
        ],
        type: 'article',
      },
      twitter: {
        card: 'summary_large_image',
        title: 'General Dentistry & Routine Dental Check-ups in Birmingham | Acocks Green Dental Practice',
        description:
          'Comprehensive oral examinations, gentle precision care, low-dose digital radiographs, and bespoke preventative care to safeguard your smile for life.',
        images: ['https://images.unsplash.com/photo-1629909615184-74f495363b67?auto=format&fit=crop&q=80&w=1200'],
      },
    };
  }

  return {
    title: `${treatment.title} | Acocks Green Dental Practice Birmingham`,
    description: treatment.seo?.metaDescription || treatment.overview,
    keywords: treatment.seo?.keywords,
    openGraph: {
      title: treatment.seo?.metaTitle || treatment.title,
      description: treatment.seo?.metaDescription || treatment.overview,
      images: [{ url: treatment.heroImage, width: 1200, height: 630, alt: treatment.title }],
      type: 'article',
    },
    twitter: {
      card: 'summary_large_image',
      title: treatment.seo?.metaTitle || treatment.title,
      description: treatment.seo?.metaDescription || treatment.overview,
      images: [treatment.heroImage],
    },
  };
}

export default async function TreatmentDetailPage({ params }: TreatmentPageProps) {
  const { slug } = await params;

  return <TreatmentDetailClient slug={slug} />;
}
