'use client';

import React from 'react';

interface Review {
  id: number;
  name: string;
  category: string;
  initials: string;
  quote: string;
  rating: number;
}

const reviewsData: Review[] = [
  {
    id: 1,
    name: 'Vikram Kline',
    category: 'Verified Patient',
    initials: 'VK',
    quote:
      '“The best dental care I have ever experienced! Professional, courteous, and friendly staff made me feel like family... would highly recommend to anyone!”',
    rating: 5,
  },
  {
    id: 2,
    name: 'Emelia Hewitt',
    category: 'Family Dental Patient',
    initials: 'EH',
    quote:
      '“Always have a great, smooth experience here. The staff and dental nurses are friendly, respectful, caring and courteous of your time. The office is run efficiently.”',
    rating: 5,
  },
  {
    id: 3,
    name: 'Joe Bloggs',
    category: 'Restorative Care Patient',
    initials: 'JB',
    quote:
      '“The professionalism and friendliness of the whole team is outstanding. Every visit is like visiting friends. I couldn’t be happier with the results.”',
    rating: 5,
  },
];

export interface ReviewsCmsData {
  badge?: string;
  headline?: string;
  title?: string;
  subtitle?: string;
  overall_rating?: string;
  total_reviews_count?: string;
}

interface AcocksGreenReviewsProps {
  data?: ReviewsCmsData;
}

export const AcocksGreenReviews: React.FC<AcocksGreenReviewsProps> = ({ data }) => {
  const badgeText = data?.badge || 'Patient Feedback';
  const headlineText = data?.headline || data?.title || 'Hear From Our Acocks Green Community';
  const ratingText = data?.overall_rating || '4.9';
  const countText = data?.total_reviews_count || '284';

  return (
    <section id="reviews" className="py-20 md:py-24 bg-surface-container-low relative overflow-hidden">
      <div className="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
        {/* Section Header */}
        <div className="flex flex-col md:flex-row md:items-end justify-between mb-12 md:mb-16 gap-6">
          <div>
            <span className="font-subheading-eyebrow text-subheading-eyebrow uppercase text-primary tracking-wider font-bold block mb-2">
              {badgeText}
            </span>
            <h2 className="font-headline-lg text-[28px] sm:text-[34px] lg:text-headline-lg text-on-surface font-bold tracking-tight">
              {headlineText}
            </h2>
          </div>

          {/* Rating Summary */}
          <div className="flex items-center gap-2.5 bg-surface-card px-4 py-2.5 rounded-xl border border-border-subtle/80 shadow-xs shrink-0">
            <div className="flex text-amber-500 gap-0.5">
              {[...Array(5)].map((_, i) => (
                <span
                  key={i}
                  className="material-symbols-outlined text-[20px]"
                  style={{ fontVariationSettings: '"FILL" 1' }}
                >
                  star
                </span>
              ))}
            </div>
            <span className="font-label-md text-label-md text-on-surface font-bold">
              {ratingText} / 5.0 Rating ({countText}+ Reviews)
            </span>
          </div>
        </div>

        {/* 3-Column Testimonial Cards */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {reviewsData.map((review) => (
            <div
              key={review.id}
              className="bg-surface-card p-6 md:p-8 rounded-2xl shadow-xs hover:shadow-md border border-border-subtle/70 transition-all duration-300 flex flex-col justify-between"
            >
              <div>
                {/* 5 Amber Stars */}
                <div className="flex text-amber-500 mb-4 gap-0.5">
                  {[...Array(review.rating)].map((_, i) => (
                    <span
                      key={i}
                      className="material-symbols-outlined text-[18px]"
                      style={{ fontVariationSettings: '"FILL" 1' }}
                    >
                      star
                    </span>
                  ))}
                </div>

                {/* Patient Quote */}
                <p className="font-body-md text-body-md text-on-surface-variant italic mb-6 leading-relaxed">
                  {review.quote}
                </p>
              </div>

              {/* Patient Identity */}
              <div className="flex items-center gap-3 pt-4 border-t border-border-subtle/40">
                <div className="w-10 h-10 rounded-full bg-brand-accent-glow text-primary font-bold flex items-center justify-center font-label-md text-label-md shrink-0">
                  {review.initials}
                </div>
                <div>
                  <p className="font-label-md text-label-md text-on-surface font-bold">
                    {review.name}
                  </p>
                  <p className="font-body-sm text-[12px] text-on-surface-variant">
                    {review.category}
                  </p>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};
