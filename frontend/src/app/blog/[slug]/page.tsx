import React from 'react';
import { BlogPostClient } from './BlogPostClient';

const DEFAULT_BLOG_SLUGS = [
  'post-template',
  'how-often-dental-hygiene-airflow',
  'nhs-vs-private-dental-care-birmingham',
  'same-day-emergency-dental-triage',
];

export function generateStaticParams() {
  return DEFAULT_BLOG_SLUGS.map((slug) => ({ slug }));
}

export default async function BlogPostPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;
  return <BlogPostClient initialSlug={slug} />;
}
