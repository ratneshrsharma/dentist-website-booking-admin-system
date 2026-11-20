'use client';

import React from 'react';

export interface ContactCmsData {
  phone?: string;
  address?: string;
  hours?: string;
  headline?: string;
  description?: string;
}

interface AcocksGreenContactProps {
  data?: ContactCmsData;
  onOpenBooking?: () => void;
}

export const AcocksGreenContact: React.FC<AcocksGreenContactProps> = ({ data, onOpenBooking }) => {
  const phone = data?.phone || '0121 765 2870';
  const rawPhone = phone.replace(/\s+/g, '');
  const openingHours = [
    { day: 'Monday', hours: '09:00 – 17:30', status: 'Open' },
    { day: 'Tuesday', hours: '09:00 – 17:30', status: 'Open' },
    { day: 'Wednesday', hours: '09:00 – 17:30', status: 'Open' },
    { day: 'Thursday', hours: '09:00 – 17:30', status: 'Open' },
    { day: 'Friday', hours: '09:00 – 17:00', status: 'Open' },
    { day: 'Saturday', hours: 'Closed', status: 'Emergency On-call' },
    { day: 'Sunday', hours: 'Closed', status: 'Emergency On-call' },
  ];

  return (
    <section id="contact" className="py-20 md:py-24 bg-surface relative overflow-hidden">
      <div className="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
        {/* Section Header */}
        <div className="text-center max-w-2xl mx-auto mb-14 md:mb-16">
          <span className="font-subheading-eyebrow text-subheading-eyebrow uppercase text-primary tracking-wider font-bold block mb-2">
            Practice Location &amp; Hours
          </span>
          <h2 className="font-headline-lg text-[28px] sm:text-[34px] lg:text-headline-lg text-on-surface font-bold tracking-tight">
            Visiting Acocks Green Dental Practice
          </h2>
          <p className="font-body-md text-body-md text-on-surface-variant mt-3 leading-relaxed">
            Conveniently located in the heart of Acocks Green, Birmingham. Our surgery offers accessible ground-floor treatment suites, gentle patient parking, and direct transport links.
          </p>
        </div>

        {/* 3-Column Practice Overview */}
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-12">
          {/* Col 1: Surgery Contact & Emergency Details (4 cols) */}
          <div className="lg:col-span-4 space-y-6">
            {/* Surgery Address Card */}
            <div className="bg-surface-card p-6 rounded-2xl shadow-xs border border-border-subtle/80 hover:shadow-md transition-shadow">
              <div className="flex items-start gap-4">
                <div className="w-12 h-12 rounded-xl bg-brand-accent-glow text-primary flex items-center justify-center shrink-0">
                  <span className="material-symbols-outlined text-[26px]">location_on</span>
                </div>
                <div>
                  <h3 className="font-headline-sm text-headline-sm text-on-surface font-bold mb-1">
                    Surgery Address
                  </h3>
                  <address className="not-italic font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                    <strong>Acocks Green Dental Practice</strong><br />
                    Warwick Road, Acocks Green<br />
                    Birmingham, West Midlands<br />
                    <span className="text-primary font-bold">B27 6BH, United Kingdom</span>
                  </address>
                  <div className="mt-4">
                    <a
                      href="https://www.google.com/maps/search/?api=1&query=Acocks+Green+Dental+Practice+Birmingham+B27+6BH"
                      target="_blank"
                      rel="noopener noreferrer"
                      className="inline-flex items-center gap-1.5 text-primary font-label-sm text-label-sm font-semibold hover:underline"
                    >
                      <span>Get Directions on Google Maps</span>
                      <span className="material-symbols-outlined text-[16px]">open_in_new</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            {/* Direct Telephone Card */}
            <div className="bg-surface-card p-6 rounded-2xl shadow-xs border border-border-subtle/80 hover:shadow-md transition-shadow">
              <div className="flex items-start gap-4">
                <div className="w-12 h-12 rounded-xl bg-brand-accent-glow text-primary flex items-center justify-center shrink-0">
                  <span className="material-symbols-outlined text-[26px]">call</span>
                </div>
                <div>
                  <h3 className="font-headline-sm text-headline-sm text-on-surface font-bold mb-1">
                    Direct Appointments
                  </h3>
                  <p className="font-body-sm text-body-sm text-on-surface-variant mb-2">
                    Speak directly with our friendly reception team to book or reschedule:
                  </p>
                  <a
                    href={`tel:${rawPhone}`}
                    className="font-headline-sm text-primary font-bold hover:underline block text-[20px]"
                  >
                    {phone}
                  </a>
                  <span className="font-body-sm text-[12px] text-on-surface-variant block mt-1">
                    Direct Clinical Line
                  </span>
                </div>
              </div>
            </div>

            {/* NHS 111 Emergency Box */}
            <div className="bg-primary-container/10 p-6 rounded-2xl border border-primary/20">
              <div className="flex items-start gap-3.5">
                <span className="material-symbols-outlined text-primary text-[24px] shrink-0 mt-0.5">
                  emergency
                </span>
                <div>
                  <h4 className="font-label-md text-label-md text-on-surface font-bold">
                    Urgent &amp; Out-of-Hours Dental Care
                  </h4>
                  <p className="font-body-sm text-[13px] text-on-surface-variant mt-1 leading-snug">
                    If you experience acute dental pain, swelling, or trauma outside of our regular opening hours, please dial <strong className="text-primary font-bold">NHS 111</strong> (free from any phone) for immediate clinical triage and advice.
                  </p>
                </div>
              </div>
            </div>
          </div>

          {/* Col 2: Surgery Opening Hours Table (4 cols) */}
          <div className="lg:col-span-4 bg-surface-card p-6 md:p-8 rounded-2xl shadow-xs border border-border-subtle/80">
            <div className="flex items-center gap-3 mb-6">
              <div className="w-10 h-10 rounded-xl bg-brand-accent-glow text-primary flex items-center justify-center shrink-0">
                <span className="material-symbols-outlined text-[24px]">schedule</span>
              </div>
              <div>
                <h3 className="font-headline-sm text-headline-sm text-on-surface font-bold">
                  Clinical Surgery Hours
                </h3>
                <p className="font-body-sm text-[12px] text-on-surface-variant">
                  Appointments &amp; Emergency Seating
                </p>
              </div>
            </div>

            <div className="divide-y divide-border-subtle/50">
              {openingHours.map((item, index) => {
                const isClosed = item.hours === 'Closed';
                return (
                  <div key={index} className="py-3 flex items-center justify-between font-body-sm text-body-sm">
                    <span className="font-medium text-on-surface">{item.day}</span>
                    <div className="text-right">
                      <span className={`font-semibold ${isClosed ? 'text-on-surface-variant' : 'text-primary'}`}>
                        {item.hours}
                      </span>
                      {isClosed && (
                        <span className="block text-[11px] text-amber-600 font-medium">
                          {item.status}
                        </span>
                      )}
                    </div>
                  </div>
                );
              })}
            </div>

            <div className="mt-8 pt-6 border-t border-border-subtle/60">
              <button
                type="button"
                onClick={onOpenBooking}
                className="w-full bg-primary text-on-primary py-3.5 px-6 rounded-xl font-label-md text-label-md font-semibold hover:bg-primary-container transition-all shadow-sm hover:shadow-md cursor-pointer flex items-center justify-center gap-2"
              >
                <span className="material-symbols-outlined text-[20px]">calendar_month</span>
                <span>Book Surgery Appointment</span>
              </button>
              <p className="text-center font-body-sm text-[12px] text-on-surface-variant mt-2.5">
                Instant confirmation &bull; NHS and Private slots available
              </p>
            </div>
          </div>

          {/* Col 3: Interactive Location Map & Transport (4 cols) */}
          <div className="lg:col-span-4 space-y-6">
            {/* Visual Surgery Map Embed */}
            <div className="bg-surface-card rounded-2xl overflow-hidden shadow-xs border border-border-subtle/80 flex flex-col">
              <div className="h-64 sm:h-72 w-full bg-surface-variant relative">
                <iframe
                  title="Acocks Green Dental Practice Map Location"
                  className="w-full h-full border-0"
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m13!1d2432.20302839212!2d-1.8283597!3d52.4482029!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4870bb8cf8ef5571%3A0x7d6f51cb7e44a49c!2sAcocks%20Green%20Dental%20Practice!5e0!3m2!1sen!2suk!4v1715000000000!5m2!1sen!2suk"
                  loading="lazy"
                  referrerPolicy="no-referrer-when-downgrade"
                  aria-label="Map showing Acocks Green Dental Practice location in Birmingham"
                />
              </div>

              {/* Transit & Parking Details */}
              <div className="p-5 bg-surface-card space-y-3">
                <div className="flex items-start gap-2.5">
                  <span className="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">
                    train
                  </span>
                  <p className="font-body-sm text-[13px] text-on-surface-variant leading-snug">
                    <strong>By Rail:</strong> Acocks Green Railway Station is a gentle 4&ndash;6 minute walk (direct lines from Birmingham Moor Street &amp; Snow Hill).
                  </p>
                </div>

                <div className="flex items-start gap-2.5">
                  <span className="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">
                    directions_bus
                  </span>
                  <p className="font-body-sm text-[13px] text-on-surface-variant leading-snug">
                    <strong>By Bus:</strong> Routes 4, 4A, 11A, 11C (Outer Circle) and 37 stop within 100 yards on Warwick Road.
                  </p>
                </div>

                <div className="flex items-start gap-2.5">
                  <span className="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">
                    local_parking
                  </span>
                  <p className="font-body-sm text-[13px] text-on-surface-variant leading-snug">
                    <strong>Parking:</strong> Short-stay street bays and public car parks located on Warwick Road and Station Road.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};
