import React from 'react';
import { DEFAULT_HOME_PAGE } from '@/api/cms';
import { TreatmentDetailClient, TreatmentDetailData } from './TreatmentDetailClient';

const TREATMENT_SLUGS = [
  'routine-examinations',
  'dental-hygiene-airflow',
  'composite-white-fillings',
  'root-canal-therapy',
  'crowns-and-bridges',
  'invisalign-clear-aligners',
  'tooth-extractions',
  'same-day-emergency-relief',
];

export function generateStaticParams() {
  return TREATMENT_SLUGS.map((slug) => ({ slug }));
}

export default async function TreatmentDetailPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;
  const matched =
    DEFAULT_HOME_PAGE.featured_services.find((s) => s.slug === slug) ||
    DEFAULT_HOME_PAGE.featured_services[0];

  const initialService: TreatmentDetailData = {
    id: matched.id,
    slug: slug || matched.slug,
    title: matched.title,
    category: matched.category,
    badge: matched.badge,
    summary: matched.description,
    description: matched.description,
    icon: matched.icon,
    feature_image: matched.feature_image,
    starting_price: matched.starting_price,
    duration: matched.duration,
  };

  return <TreatmentDetailClient initialService={initialService} />;
}
