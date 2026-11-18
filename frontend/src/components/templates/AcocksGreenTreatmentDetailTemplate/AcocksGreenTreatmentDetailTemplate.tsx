'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import { AcocksGreenHeader } from '@/components/organisms/AcocksGreenHeader/AcocksGreenHeader';
import { AcocksGreenFooter } from '@/components/organisms/AcocksGreenFooter/AcocksGreenFooter';
import { BookingWizard } from '@/components/organisms/BookingWizard/BookingWizard';
import { WhatsAppHub } from '@/components/ui/WhatsAppHub/WhatsAppHub';

export interface TreatmentDetailData {
  slug?: string;
  title?: string;
  eyebrow?: string;
  subtitle?: string;
  badge?: string;
  phone?: string;
  breadcrumbs?: string[];
  feature_badges?: { icon: string; text: string }[];
  hero_image?: string;
  hero_badge?: { title: string; subtitle: string };
  what_includes?: {
    eyebrow?: string;
    title?: string;
    subtitle?: string;
    diagnostic_cards?: {
      number: string;
      icon: string;
      title: string;
      badge: string;
      description: string;
      checklist: string[];
    }[];
    nervous_patient_banner?: {
      icon?: string;
      title?: string;
      description?: string;
      cta_text?: string;
      cta_link?: string;
    };
  };
  procedures?: {
    eyebrow?: string;
    title?: string;
    subtitle?: string;
    items?: {
      number: string;
      icon: string;
      title: string;
      duration: string;
      description: string;
      link_text: string;
      link_href: string;
    }[];
  };
  pricing?: {
    eyebrow?: string;
    title?: string;
    subtitle?: string;
    cards?: {
      badge: string;
      title: string;
      price: string;
      price_note: string;
      popular?: boolean;
      features: string[];
      cta_text: string;
      cta_type: string;
    }[];
    comparison_table?: {
      title?: string;
      headers: string[];
      rows: { feature: string; nhs: string; private: string }[];
    };
  };
  faqs?: {
    eyebrow?: string;
    title?: string;
    subtitle?: string;
    items?: { question: string; answer: string }[];
  };
  consultation_cta?: {
    eyebrow?: string;
    title?: string;
    subtitle?: string;
    phone?: string;
    address?: string;
    hours?: string;
    cta_primary?: string;
    cta_secondary?: string;
    reassurance_badges?: string[];
  };
}

export interface AcocksGreenTreatmentDetailTemplateProps {
  data: TreatmentDetailData;
  onOpenBooking?: (service?: string) => void;
  onOpenEmergency?: () => void;
}

export const AcocksGreenTreatmentDetailTemplate: React.FC<AcocksGreenTreatmentDetailTemplateProps> = ({
  data,
  onOpenBooking,
  onOpenEmergency,
}) => {
  const [wizardOpen, setWizardOpen] = useState(false);
  const [openFaqIndex, setOpenFaqIndex] = useState<number | null>(0);

  // Quick Book Form State
  const [patientType, setPatientType] = useState<'new' | 'existing'>('new');
  const [carePathway, setCarePathway] = useState<'nhs' | 'private' | 'combined'>('private');
  const [fullName, setFullName] = useState('');
  const [phone, setPhone] = useState('');
  const [email, setEmail] = useState('');
  const [preferredSlot, setPreferredSlot] = useState<'morning' | 'afternoon' | 'urgent'>('morning');
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [submitSuccess, setSubmitSuccess] = useState(false);
  const [bookingRef, setBookingRef] = useState('');

  const handleBookingTrigger = (serviceName?: string) => {
    if (onOpenBooking) {
      onOpenBooking(serviceName);
    } else {
      setWizardOpen(true);
    }
  };

  const handleQuickBookSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setIsSubmitting(true);

    // Simulate reliable triage reservation
    setTimeout(() => {
      const generatedRef = `AGD-${Math.floor(100000 + Math.random() * 900000)}`;
      setBookingRef(generatedRef);
      setIsSubmitting(false);
      setSubmitSuccess(true);
    }, 600);
  };

  const toggleFaq = (index: number) => {
    setOpenFaqIndex((prev) => (prev === index ? null : index));
  };

  const breadcrumbs = data.breadcrumbs || [
    'Home',
    'Treatments & Services',
    data.title || 'General Dentistry & Routine Check-ups',
  ];

  const diagnosticCards = data.what_includes?.diagnostic_cards || [];
  const procedureCards = data.procedures?.items || [];
  const pricingCards = data.pricing?.cards || [];
  const comparisonRows = data.pricing?.comparison_table?.rows || [];
  const comparisonHeaders = data.pricing?.comparison_table?.headers || [
    'Feature / Pathway',
    'NHS Dental Care',
    'Private Dental Care',
  ];
  const faqItems = data.faqs?.items || [];

  return (
    <div className="min-h-screen bg-[#F8FAFC] text-slate-800 flex flex-col font-sans antialiased">
      {/* 1. Global Navigation Header */}
      <AcocksGreenHeader
        onOpenBooking={() => handleBookingTrigger('Routine Examination')}
        onOpenEmergency={onOpenEmergency}
      />

      {/* 2. Clinical Breadcrumbs & Quick Triage Strip */}
      <div className="bg-white border-b border-slate-200/80 py-3 px-4 sm:px-6 lg:px-8">
        <div className="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-4 text-xs sm:text-sm">
          <nav aria-label="Breadcrumb" className="flex items-center space-x-2 text-slate-500">
            {breadcrumbs.map((crumb, idx) => {
              const isLast = idx === breadcrumbs.length - 1;
              return (
                <React.Fragment key={crumb}>
                  {idx > 0 && (
                    <span className="material-symbols-outlined text-[16px] text-slate-400 select-none">
                      chevron_right
                    </span>
                  )}
                  {isLast ? (
                    <span className="font-semibold text-teal-800 line-clamp-1">{crumb}</span>
                  ) : (
                    <Link
                      href={idx === 0 ? '/' : '/treatments'}
                      className="hover:text-teal-700 transition-colors font-medium"
                    >
                      {crumb}
                    </Link>
                  )}
                </React.Fragment>
              );
            })}
          </nav>

          <div className="flex items-center space-x-3 text-slate-600 font-medium ml-auto">
            <span className="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200/60 px-2.5 py-0.5 rounded-full text-xs font-semibold">
              <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" />
              Accepting Patients
            </span>
            <a
              href="tel:+441217652870"
              className="inline-flex items-center gap-1 hover:text-teal-700 transition-colors text-xs sm:text-sm font-semibold"
            >
              <span className="material-symbols-outlined text-[18px] text-teal-700">call</span>
              0121 765 2870
            </a>
          </div>
        </div>
      </div>

      <main className="flex-1">
        {/* 3. Hero Section */}
        <section className="relative overflow-hidden bg-gradient-to-b from-white via-teal-50/20 to-slate-50 pt-10 pb-16 lg:py-20 border-b border-slate-200/80">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
              {/* Left Column: Core Value Proposition */}
              <div className="lg:col-span-7 space-y-6">
                <div className="inline-flex items-center gap-2 bg-teal-100/70 text-teal-800 text-xs sm:text-sm font-bold uppercase tracking-wider px-3.5 py-1.5 rounded-full border border-teal-200/80">
                  <span className="material-symbols-outlined text-[18px]">verified</span>
                  {data.eyebrow || 'CORE HEALTHCARE & PREVENTATIVE CARE'}
                </div>

                <h1 className="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                  {data.title || 'General Dentistry & Routine Dental Check-ups in Birmingham'}
                </h1>

                <p className="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl">
                  {data.subtitle ||
                    'Comprehensive oral examinations, gentle precision care, low-dose digital radiographs, and bespoke preventative care to safeguard your smile for life. Available under NHS dental bands and private pathways.'}
                </p>

                {/* 4 Feature Badges */}
                <div className="grid grid-cols-2 sm:grid-cols-2 gap-3 pt-2">
                  {(
                    data.feature_badges || [
                      { icon: 'verified', text: 'NHS & Private Available' },
                      { icon: 'schedule', text: 'Same-Day Emergency Relief' },
                      { icon: 'radiology', text: 'Digital Low-Dose Radiography' },
                      { icon: 'favorite', text: 'Gentle Phobic-Friendly Care' },
                    ]
                  ).map((badge, bIdx) => (
                    <div
                      key={bIdx}
                      className="flex items-center gap-2.5 bg-white/90 p-3 rounded-xl border border-slate-200/80 shadow-xs"
                    >
                      <span className="material-symbols-outlined text-teal-700 text-[20px] shrink-0">
                        {badge.icon}
                      </span>
                      <span className="text-xs sm:text-sm font-semibold text-slate-800">
                        {badge.text}
                      </span>
                    </div>
                  ))}
                </div>

                {/* Action Buttons */}
                <div className="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-4">
                  <button
                    type="button"
                    onClick={() => handleBookingTrigger(data.title)}
                    className="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-teal-700 hover:bg-teal-800 text-white font-bold text-sm sm:text-base shadow-md hover:shadow-lg transition-all cursor-pointer"
                  >
                    <span className="material-symbols-outlined text-[20px]">calendar_month</span>
                    Book Routine Examination
                  </button>
                  <a
                    href="tel:+441217652870"
                    className="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-sm sm:text-base border border-slate-300 shadow-xs transition-all"
                  >
                    <span className="material-symbols-outlined text-teal-700 text-[20px]">call</span>
                    Call Reception: 0121 765 2870
                  </a>
                </div>
              </div>

              {/* Right Column: Hero Visual Card */}
              <div className="lg:col-span-5 relative">
                <div className="relative mx-auto max-w-md lg:max-w-none">
                  {/* Outer Frame with Soft Backdrop */}
                  <div className="absolute -inset-4 bg-gradient-to-tr from-teal-200/30 to-emerald-100/30 rounded-3xl blur-xl -z-10" />

                  <div className="relative overflow-hidden rounded-2xl border-4 border-white shadow-2xl bg-white aspect-[4/3] sm:aspect-[4/3]">
                    <img
                      src={
                        data.hero_image ||
                        'https://images.unsplash.com/photo-1629909615184-74f495363b67?auto=format&fit=crop&q=80&w=1200'
                      }
                      alt={data.title || 'General Dentistry Clinical Examination Birmingham'}
                      className="w-full h-full object-cover"
                      loading="eager"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent" />

                    {/* Reassurance Floating Card */}
                    <div className="absolute bottom-4 left-4 right-4 bg-white/95 backdrop-blur-md p-4 rounded-xl border border-white/60 shadow-lg">
                      <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-full bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
                          <span className="material-symbols-outlined text-[24px]">verified</span>
                        </div>
                        <div>
                          <p className="text-xs sm:text-sm font-bold text-slate-900 leading-snug">
                            {data.hero_badge?.title || 'Gentle Dental Check • Digital Precision X-Rays'}
                          </p>
                          <p className="text-[11px] sm:text-xs text-slate-600">
                            {data.hero_badge?.subtitle || 'NHS Standard & Comprehensive Private'}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        {/* 4. Clinical Precision: 14-Point Check-Up Breakdown */}
        <section className="py-16 lg:py-24 bg-white border-b border-slate-200/80">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center max-w-3xl mx-auto mb-16 space-y-3">
              <span className="inline-block text-teal-700 text-xs sm:text-sm font-bold uppercase tracking-wider">
                {data.what_includes?.eyebrow || 'CLINICAL PRECISION'}
              </span>
              <h2 className="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                {data.what_includes?.title || 'What Happens During Your 14-Point Dental Check-Up?'}
              </h2>
              <p className="text-slate-600 text-sm sm:text-base leading-relaxed">
                {data.what_includes?.subtitle ||
                  'Our thorough 30-minute examinations evaluate teeth, gums, jaw joints, bite dynamics, and soft tissues for early detection and peace of mind. We believe proactive care prevents complex future procedures.'}
              </p>
            </div>

            {/* 3 Diagnostic Cards */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
              {diagnosticCards.map((card, idx) => (
                <div
                  key={idx}
                  className="bg-slate-50/70 hover:bg-white rounded-2xl p-7 border border-slate-200/90 hover:border-teal-300 transition-all duration-300 hover:shadow-lg flex flex-col justify-between group"
                >
                  <div className="space-y-4">
                    <div className="flex items-center justify-between">
                      <div className="w-12 h-12 rounded-xl bg-teal-100/70 text-teal-800 flex items-center justify-center group-hover:bg-teal-700 group-hover:text-white transition-colors duration-200">
                        <span className="material-symbols-outlined text-[26px]">{card.icon}</span>
                      </div>
                      <span className="text-xs font-bold text-slate-400 font-mono tracking-wider">
                        {card.number}
                      </span>
                    </div>

                    <div>
                      <span className="inline-block bg-teal-50 text-teal-800 border border-teal-200/60 text-[11px] font-bold px-2 py-0.5 rounded-md mb-2">
                        {card.badge}
                      </span>
                      <h3 className="text-lg font-bold text-slate-900">{card.title}</h3>
                    </div>

                    <p className="text-xs sm:text-sm text-slate-600 leading-relaxed">
                      {card.description}
                    </p>
                  </div>

                  {/* Checklist */}
                  <div className="mt-6 pt-5 border-t border-slate-200/80 space-y-2">
                    {card.checklist.map((item, cIdx) => (
                      <div key={cIdx} className="flex items-start gap-2 text-xs sm:text-sm text-slate-700">
                        <span className="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">
                          check_circle
                        </span>
                        <span>{item}</span>
                      </div>
                    ))}
                  </div>
                </div>
              ))}
            </div>

            {/* Nervous Patient Protocol Banner */}
            {data.what_includes?.nervous_patient_banner && (
              <div className="mt-12 bg-gradient-to-r from-teal-800 to-teal-900 text-white rounded-2xl p-6 sm:p-8 shadow-md">
                <div className="flex flex-col md:flex-row items-center justify-between gap-6">
                  <div className="flex items-center gap-4 text-center md:text-left">
                    <div className="w-14 h-14 rounded-full bg-white/10 text-teal-200 flex items-center justify-center shrink-0">
                      <span className="material-symbols-outlined text-[32px]">
                        {data.what_includes.nervous_patient_banner.icon || 'favorite'}
                      </span>
                    </div>
                    <div className="space-y-1">
                      <h3 className="text-lg sm:text-xl font-bold">
                        {data.what_includes.nervous_patient_banner.title ||
                          'New Patient or Nervous Visitor?'}
                      </h3>
                      <p className="text-teal-100 text-xs sm:text-sm max-w-2xl">
                        {data.what_includes.nervous_patient_banner.description ||
                          'Our gentle Birmingham clinicians take extra time to explain every step, ensuring painless, relaxed examinations.'}
                      </p>
                    </div>
                  </div>
                  <button
                    type="button"
                    onClick={() => handleBookingTrigger('Nervous Patient Consultation')}
                    className="shrink-0 px-6 py-3 bg-white text-teal-900 hover:bg-teal-50 font-bold rounded-xl text-xs sm:text-sm shadow-md transition-all cursor-pointer"
                  >
                    {data.what_includes.nervous_patient_banner.cta_text ||
                      'Register as a New Patient'}
                  </button>
                </div>
              </div>
            )}
          </div>
        </section>

        {/* 5. Complete Everyday Dental Solutions Pathway */}
        <section className="py-16 lg:py-24 bg-[#F8FAFC] border-b border-slate-200/80">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center max-w-3xl mx-auto mb-16 space-y-3">
              <span className="inline-block text-teal-700 text-xs sm:text-sm font-bold uppercase tracking-wider">
                {data.procedures?.eyebrow || 'RESTORATIVE & PREVENTATIVE SERVICES'}
              </span>
              <h2 className="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                {data.procedures?.title || 'Complete Everyday Dental Solutions Under One Roof'}
              </h2>
              <p className="text-slate-600 text-sm sm:text-base leading-relaxed">
                {data.procedures?.subtitle ||
                  'From preventative maintenance and discreet composite repairs to emergency toothache triage, we provide gentle, long-lasting clinical care tailored to your exact smile goals.'}
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
              {procedureCards.map((proc, pIdx) => (
                <div
                  key={pIdx}
                  className="bg-white rounded-2xl p-6 border border-slate-200/90 hover:border-teal-400 transition-all duration-300 hover:shadow-lg flex flex-col justify-between group"
                >
                  <div className="space-y-4">
                    <div className="flex items-center justify-between">
                      <div className="w-11 h-11 rounded-xl bg-teal-50 text-teal-700 group-hover:bg-teal-700 group-hover:text-white flex items-center justify-center transition-colors">
                        <span className="material-symbols-outlined text-[24px]">{proc.icon}</span>
                      </div>
                      <span className="text-[11px] font-semibold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full">
                        {proc.duration}
                      </span>
                    </div>

                    <h3 className="text-base font-bold text-slate-900 group-hover:text-teal-800 transition-colors">
                      {proc.title}
                    </h3>
                    <p className="text-xs sm:text-sm text-slate-600 leading-relaxed">
                      {proc.description}
                    </p>
                  </div>

                  <div className="mt-6 pt-4 border-t border-slate-100">
                    <Link
                      href={proc.link_href}
                      className="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-teal-700 hover:text-teal-800 group-hover:translate-x-1 transition-all"
                    >
                      <span>{proc.link_text}</span>
                      <span className="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </Link>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* 6. Transparent Pricing: NHS Bands & Private Options */}
        <section className="py-16 lg:py-24 bg-white border-b border-slate-200/80">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center max-w-3xl mx-auto mb-16 space-y-3">
              <span className="inline-block text-teal-700 text-xs sm:text-sm font-bold uppercase tracking-wider">
                {data.pricing?.eyebrow || 'TRANSPARENT COSTS'}
              </span>
              <h2 className="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                {data.pricing?.title || 'Clear Pricing: NHS Bands & Private Options'}
              </h2>
              <p className="text-slate-600 text-sm sm:text-base leading-relaxed">
                {data.pricing?.subtitle ||
                  'We believe in honest, predictable clinical care with zero hidden costs. Choose between standard NHS tiered bandings or our enhanced private restorative treatments.'}
              </p>
            </div>

            {/* 3 Pricing Cards */}
            <div className="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch mb-16">
              {pricingCards.map((pCard, cIdx) => (
                <div
                  key={cIdx}
                  className={`rounded-2xl p-7 border transition-all duration-300 flex flex-col justify-between relative ${
                    pCard.popular
                      ? 'bg-gradient-to-b from-white via-teal-50/20 to-white border-teal-500 shadow-xl ring-2 ring-teal-500/20'
                      : 'bg-white border-slate-200/90 shadow-xs hover:shadow-md'
                  }`}
                >
                  {pCard.popular && (
                    <div className="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-teal-700 text-white font-extrabold text-xs px-4 py-1 rounded-full uppercase tracking-wider shadow-sm">
                      Most Popular Choice
                    </div>
                  )}

                  <div className="space-y-4">
                    <span className="inline-block text-xs font-bold text-slate-500 uppercase tracking-wider">
                      {pCard.badge}
                    </span>
                    <h3 className="text-xl font-bold text-slate-900">{pCard.title}</h3>

                    <div className="flex items-baseline gap-2 pt-1 pb-3">
                      <span className="text-3xl sm:text-4xl font-extrabold text-slate-900">
                        {pCard.price}
                      </span>
                      <span className="text-xs text-slate-500 font-medium">/{pCard.price_note}</span>
                    </div>

                    <div className="space-y-2.5 pt-2 border-t border-slate-100">
                      {pCard.features.map((feat, fIdx) => (
                        <div key={fIdx} className="flex items-start gap-2.5 text-xs sm:text-sm text-slate-700">
                          <span className="material-symbols-outlined text-teal-700 text-[18px] shrink-0 mt-0.5">
                            check_circle
                          </span>
                          <span>{feat}</span>
                        </div>
                      ))}
                    </div>
                  </div>

                  <div className="mt-8 pt-4">
                    <button
                      type="button"
                      onClick={() => handleBookingTrigger(pCard.title)}
                      className={`w-full py-3 px-4 rounded-xl font-bold text-xs sm:text-sm transition-all cursor-pointer ${
                        pCard.popular
                          ? 'bg-teal-700 hover:bg-teal-800 text-white shadow-md'
                          : 'bg-slate-100 hover:bg-slate-200 text-slate-800'
                      }`}
                    >
                      {pCard.cta_text}
                    </button>
                  </div>
                </div>
              ))}
            </div>

            {/* NHS vs Private Comparison Table */}
            <div className="bg-slate-50 rounded-2xl p-6 sm:p-8 border border-slate-200/90 shadow-xs">
              <h3 className="text-lg sm:text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <span className="material-symbols-outlined text-teal-700">balance</span>
                {data.pricing?.comparison_table?.title || 'NHS vs Private: Key Differences at a Glance'}
              </h3>

              <div className="overflow-x-auto">
                <table className="w-full text-left border-collapse text-xs sm:text-sm">
                  <thead>
                    <tr className="border-b border-slate-200 bg-white">
                      {comparisonHeaders.map((header, hIdx) => (
                        <th key={hIdx} className="py-3 px-4 font-bold text-slate-800 first:rounded-l-lg last:rounded-r-lg">
                          {header}
                        </th>
                      ))}
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-slate-200/70">
                    {comparisonRows.map((row, rIdx) => (
                      <tr key={rIdx} className="hover:bg-white/80 transition-colors">
                        <td className="py-3.5 px-4 font-semibold text-slate-900">{row.feature}</td>
                        <td className="py-3.5 px-4 text-slate-600">{row.nhs}</td>
                        <td className="py-3.5 px-4 text-teal-900 font-medium bg-teal-50/40 rounded-r-lg">
                          {row.private}
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>

        {/* 7. Clinical FAQs Accordion */}
        <section className="py-16 lg:py-24 bg-[#F8FAFC] border-b border-slate-200/80">
          <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center max-w-3xl mx-auto mb-16 space-y-3">
              <span className="inline-block text-teal-700 text-xs sm:text-sm font-bold uppercase tracking-wider">
                {data.faqs?.eyebrow || 'CLINICAL REASSURANCE'}
              </span>
              <h2 className="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                {data.faqs?.title || 'Frequently Asked Questions About Routine Check-ups'}
              </h2>
              <p className="text-slate-600 text-sm sm:text-base leading-relaxed">
                {data.faqs?.subtitle ||
                  'Clear answers to common questions about dental examinations, NHS fees, and patient comfort.'}
              </p>
            </div>

            <div className="space-y-4">
              {faqItems.map((faq, fIdx) => {
                const isOpen = openFaqIndex === fIdx;
                return (
                  <div
                    key={fIdx}
                    className="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-xs transition-all duration-200"
                  >
                    <button
                      type="button"
                      onClick={() => toggleFaq(fIdx)}
                      className="w-full py-4.5 px-6 text-left flex items-center justify-between gap-4 font-bold text-slate-900 hover:text-teal-700 transition-colors cursor-pointer"
                      aria-expanded={isOpen}
                    >
                      <span className="text-sm sm:text-base leading-snug">{faq.question}</span>
                      <span
                        className={`material-symbols-outlined text-teal-700 text-[22px] shrink-0 transition-transform duration-200 ${
                          isOpen ? 'rotate-180' : ''
                        }`}
                      >
                        expand_more
                      </span>
                    </button>

                    {isOpen && (
                      <div className="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100">
                        {faq.answer}
                      </div>
                    )}
                  </div>
                );
              })}
            </div>
          </div>
        </section>

        {/* 8. Quick Reservation Form & Reception Direct Contact */}
        <section id="quick-book" className="py-16 lg:py-24 bg-white">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="bg-gradient-to-br from-slate-900 via-slate-800 to-teal-950 text-white rounded-3xl p-8 sm:p-12 lg:p-16 shadow-2xl overflow-hidden relative">
              {/* Background Glow */}
              <div className="absolute top-0 right-0 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none -z-0" />

              <div className="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                {/* Left: Contact Info & Reassurance */}
                <div className="lg:col-span-5 space-y-6">
                  <span className="inline-block text-teal-400 text-xs sm:text-sm font-bold uppercase tracking-wider">
                    {data.consultation_cta?.eyebrow || 'SEAMLESS SCHEDULING'}
                  </span>
                  <h2 className="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-tight">
                    {data.consultation_cta?.title || 'Reserve Your Routine Check-Up Today'}
                  </h2>
                  <p className="text-slate-300 text-xs sm:text-sm leading-relaxed">
                    {data.consultation_cta?.subtitle ||
                      'Join thousands of satisfied Birmingham families enjoying gentle, trusted dental care on Warwick Road. Book your appointment online or call our friendly team.'}
                  </p>

                  <div className="space-y-4 pt-2">
                    <div className="flex items-start gap-3">
                      <span className="material-symbols-outlined text-teal-400 text-[20px] shrink-0 mt-0.5">
                        pin_drop
                      </span>
                      <div className="text-xs sm:text-sm">
                        <p className="font-semibold text-white">Acocks Green Dental Practice</p>
                        <p className="text-slate-400">
                          {data.consultation_cta?.address ||
                            '1078 Warwick Road, Acocks Green, Birmingham B27 6BH'}
                        </p>
                      </div>
                    </div>

                    <div className="flex items-start gap-3">
                      <span className="material-symbols-outlined text-teal-400 text-[20px] shrink-0 mt-0.5">
                        schedule
                      </span>
                      <div className="text-xs sm:text-sm">
                        <p className="font-semibold text-white">Surgery Hours</p>
                        <p className="text-slate-400">
                          {data.consultation_cta?.hours || 'Mon–Fri: 8:30am – 5:30pm (Emergency Daily)'}
                        </p>
                      </div>
                    </div>
                  </div>

                  {/* Reassurance Badges */}
                  <div className="flex flex-wrap gap-2 pt-2">
                    {(
                      data.consultation_cta?.reassurance_badges || [
                        'Confidential & GDPR Compliant',
                        'No Obligation Assessment',
                        'GDC Registered Dentists',
                      ]
                    ).map((badge, bIdx) => (
                      <span
                        key={bIdx}
                        className="inline-flex items-center gap-1.5 bg-white/10 text-teal-200 text-[11px] font-semibold px-2.5 py-1 rounded-full border border-white/10"
                      >
                        <span className="material-symbols-outlined text-[14px]">check</span>
                        {badge}
                      </span>
                    ))}
                  </div>
                </div>

                {/* Right: Reservation Form */}
                <div className="lg:col-span-7">
                  <div className="bg-white text-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl">
                    {submitSuccess ? (
                      <div className="text-center py-8 space-y-4">
                        <div className="w-16 h-16 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center mx-auto">
                          <span className="material-symbols-outlined text-[36px]">verified</span>
                        </div>
                        <h3 className="text-xl sm:text-2xl font-extrabold text-slate-900">
                          Check-Up Request Received!
                        </h3>
                        <p className="text-xs sm:text-sm text-slate-600 max-w-md mx-auto">
                          Thank you, <strong>{fullName}</strong>. Your clinical request has been
                          logged with triage priority reference:
                        </p>
                        <div className="bg-slate-100 p-3 rounded-xl font-mono text-sm font-bold text-teal-800 inline-block">
                          {bookingRef}
                        </div>
                        <p className="text-[12px] text-slate-500">
                          Our reception team will call you within surgery hours to confirm your exact
                          time slot.
                        </p>
                        <button
                          type="button"
                          onClick={() => {
                            setSubmitSuccess(false);
                            setFullName('');
                            setPhone('');
                            setEmail('');
                          }}
                          className="mt-4 px-6 py-2.5 bg-teal-700 hover:bg-teal-800 text-white font-bold rounded-xl text-xs sm:text-sm transition-all cursor-pointer"
                        >
                          Book Another Appointment
                        </button>
                      </div>
                    ) : (
                      <form onSubmit={handleQuickBookSubmit} className="space-y-4">
                        <div className="space-y-2">
                          <label className="text-xs font-bold uppercase tracking-wider text-slate-500 block">
                            Patient Status
                          </label>
                          <div className="grid grid-cols-2 gap-3">
                            <button
                              type="button"
                              onClick={() => setPatientType('new')}
                              className={`py-2 px-3 rounded-xl text-xs font-bold border transition-all cursor-pointer ${
                                patientType === 'new'
                                  ? 'bg-teal-50 border-teal-600 text-teal-800'
                                  : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'
                              }`}
                            >
                              New Patient
                            </button>
                            <button
                              type="button"
                              onClick={() => setPatientType('existing')}
                              className={`py-2 px-3 rounded-xl text-xs font-bold border transition-all cursor-pointer ${
                                patientType === 'existing'
                                  ? 'bg-teal-50 border-teal-600 text-teal-800'
                                  : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'
                              }`}
                            >
                              Registered Patient
                            </button>
                          </div>
                        </div>

                        <div className="space-y-2">
                          <label className="text-xs font-bold uppercase tracking-wider text-slate-500 block">
                            Care Pathway
                          </label>
                          <div className="grid grid-cols-3 gap-2">
                            <button
                              type="button"
                              onClick={() => setCarePathway('nhs')}
                              className={`py-2 px-2 rounded-xl text-[11px] sm:text-xs font-bold border text-center transition-all cursor-pointer ${
                                carePathway === 'nhs'
                                  ? 'bg-teal-50 border-teal-600 text-teal-800'
                                  : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'
                              }`}
                            >
                              NHS Band 1 (£26.80)
                            </button>
                            <button
                              type="button"
                              onClick={() => setCarePathway('private')}
                              className={`py-2 px-2 rounded-xl text-[11px] sm:text-xs font-bold border text-center transition-all cursor-pointer ${
                                carePathway === 'private'
                                  ? 'bg-teal-50 border-teal-600 text-teal-800'
                                  : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'
                              }`}
                            >
                              Private (£55.00)
                            </button>
                            <button
                              type="button"
                              onClick={() => setCarePathway('combined')}
                              className={`py-2 px-2 rounded-xl text-[11px] sm:text-xs font-bold border text-center transition-all cursor-pointer ${
                                carePathway === 'combined'
                                  ? 'bg-teal-50 border-teal-600 text-teal-800'
                                  : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'
                              }`}
                            >
                              Combined (£110.00)
                            </button>
                          </div>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                          <div>
                            <label className="text-xs font-bold text-slate-700 block mb-1">
                              Full Name *
                            </label>
                            <input
                              type="text"
                              required
                              value={fullName}
                              onChange={(e) => setFullName(e.target.value)}
                              placeholder="e.g. Sarah Jenkins"
                              className="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-600/30 focus:border-teal-600 text-xs sm:text-sm"
                            />
                          </div>

                          <div>
                            <label className="text-xs font-bold text-slate-700 block mb-1">
                              Phone Number *
                            </label>
                            <input
                              type="tel"
                              required
                              value={phone}
                              onChange={(e) => setPhone(e.target.value)}
                              placeholder="e.g. 07123 456789"
                              className="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-600/30 focus:border-teal-600 text-xs sm:text-sm"
                            />
                          </div>
                        </div>

                        <div>
                          <label className="text-xs font-bold text-slate-700 block mb-1">
                            Email Address *
                          </label>
                          <input
                            type="email"
                            required
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            placeholder="e.g. sarah@example.co.uk"
                            className="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-600/30 focus:border-teal-600 text-xs sm:text-sm"
                          />
                        </div>

                        <div>
                          <label className="text-xs font-bold text-slate-700 block mb-1">
                            Preferred Slot
                          </label>
                          <div className="grid grid-cols-3 gap-2">
                            <button
                              type="button"
                              onClick={() => setPreferredSlot('morning')}
                              className={`py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all cursor-pointer ${
                                preferredSlot === 'morning'
                                  ? 'bg-teal-50 border-teal-600 text-teal-800'
                                  : 'bg-white border-slate-200 text-slate-600'
                              }`}
                            >
                              Morning (9am - 12pm)
                            </button>
                            <button
                              type="button"
                              onClick={() => setPreferredSlot('afternoon')}
                              className={`py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all cursor-pointer ${
                                preferredSlot === 'afternoon'
                                  ? 'bg-teal-50 border-teal-600 text-teal-800'
                                  : 'bg-white border-slate-200 text-slate-600'
                              }`}
                            >
                              Afternoon (1pm - 5pm)
                            </button>
                            <button
                              type="button"
                              onClick={() => setPreferredSlot('urgent')}
                              className={`py-1.5 px-2 rounded-lg text-xs font-semibold border transition-all cursor-pointer ${
                                preferredSlot === 'urgent'
                                  ? 'bg-amber-50 border-amber-500 text-amber-800'
                                  : 'bg-white border-slate-200 text-slate-600'
                              }`}
                            >
                              Urgent / Same-Day
                            </button>
                          </div>
                        </div>

                        <button
                          type="submit"
                          disabled={isSubmitting}
                          className="w-full mt-2 py-3.5 px-6 rounded-xl bg-teal-700 hover:bg-teal-800 text-white font-extrabold text-sm sm:text-base shadow-md transition-all cursor-pointer disabled:opacity-50 flex items-center justify-center gap-2"
                        >
                          {isSubmitting ? (
                            <>
                              <span className="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin" />
                              <span>Reserving Slot...</span>
                            </>
                          ) : (
                            <>
                              <span className="material-symbols-outlined text-[20px]">
                                calendar_month
                              </span>
                              <span>Confirm Routine Check-Up Request</span>
                            </>
                          )}
                        </button>
                      </form>
                    )}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>

      {/* 9. Global Practice Footer */}
      <AcocksGreenFooter
        onOpenBooking={() => handleBookingTrigger('Routine Examination')}
        onOpenEmergency={onOpenEmergency}
      />

      {/* 10. Integrated 5-Step Booking Drawer Wizard */}
      <BookingWizard isOpen={wizardOpen} onClose={() => setWizardOpen(false)} />

      {/* 11. WhatsApp Floating Triage Hub */}
      <WhatsAppHub />
    </div>
  );
};
