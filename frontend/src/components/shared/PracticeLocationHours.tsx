'use client';

import React from 'react';

interface PracticeLocationHoursProps {
  address?: string;
  phone?: string;
  email?: string;
  onOpenBooking?: () => void;
}

export const PracticeLocationHours: React.FC<PracticeLocationHoursProps> = ({
  address = '1078 Warwick Road, Acocks Green, Birmingham B27 6BH',
  phone = '+44 121 765 2870',
  email = 'reception@advanceddentalpractice.co.uk',
  onOpenBooking,
}) => {
  const schedule = [
    { day: 'Monday', hours: '8:30 AM – 5:30 PM', emergency: 'Triage slots available' },
    { day: 'Tuesday', hours: '8:30 AM – 5:30 PM', emergency: 'Triage slots available' },
    { day: 'Wednesday', hours: '8:30 AM – 5:30 PM', emergency: 'Triage slots available' },
    { day: 'Thursday', hours: '8:30 AM – 7:00 PM', emergency: 'Late evening clinic' },
    { day: 'Friday', hours: '8:30 AM – 5:00 PM', emergency: 'Triage slots available' },
    { day: 'Saturday', hours: '9:00 AM – 1:00 PM', emergency: 'Private & emergency only' },
    { day: 'Sunday', hours: 'Closed', emergency: 'Call NHS 111 out-of-hours' },
  ];

  return (
    <section className="w-full py-12 lg:py-16 bg-surface-container/30 border-t border-border-subtle/60" id="practice-location-hours">
      <div className="max-w-7xl mx-auto px-6 lg:px-12">
        <div className="grid lg:grid-cols-12 gap-8 items-center">
          {/* Surgery Location Card */}
          <div className="lg:col-span-6 bg-surface-card rounded-2xl border border-border-subtle p-6 sm:p-8 shadow-sm">
            <span className="font-subheading-eyebrow text-subheading-eyebrow text-primary uppercase tracking-widest block mb-2 font-bold">
              BIRMINGHAM SURGERY
            </span>
            <h2 className="font-display-section text-[26px] sm:text-[32px] text-on-surface tracking-tight mb-4">
              Practice Location &amp; Directions
            </h2>
            <p className="font-body-md text-body-md text-on-surface-variant mb-6">
              Conveniently located on Warwick Road in Acocks Green with dedicated patient parking and step-free wheelchair accessibility.
            </p>

            <div className="space-y-4 mb-6">
              <div className="flex items-start gap-3">
                <span className="material-symbols-outlined text-[20px] text-primary shrink-0 mt-0.5">
                  location_on
                </span>
                <div>
                  <span className="font-bold text-on-surface block text-sm">Practice Address</span>
                  <span className="text-sm text-on-surface-variant">{address}</span>
                </div>
              </div>

              <div className="flex items-start gap-3">
                <span className="material-symbols-outlined text-[20px] text-primary shrink-0 mt-0.5">
                  call
                </span>
                <div>
                  <span className="font-bold text-on-surface block text-sm">Telephone Reception</span>
                  <a href={`tel:${phone}`} className="text-sm text-primary hover:underline font-semibold">
                    {phone}
                  </a>
                </div>
              </div>

              <div className="flex items-start gap-3">
                <span className="material-symbols-outlined text-[20px] text-primary shrink-0 mt-0.5">
                  mail
                </span>
                <div>
                  <span className="font-bold text-on-surface block text-sm">Email Enquiries</span>
                  <a href={`mailto:${email}`} className="text-sm text-on-surface-variant hover:text-primary">
                    {email}
                  </a>
                </div>
              </div>
            </div>

            <button
              type="button"
              onClick={onOpenBooking}
              className="w-full py-3 px-4 rounded-xl font-semibold bg-primary hover:bg-primary-dark text-on-primary transition-colors flex items-center justify-center gap-2 cursor-pointer shadow-xs"
            >
              <span className="material-symbols-outlined text-[18px]">calendar_month</span>
              <span>Book Appointment Slot</span>
            </button>
          </div>

          {/* Opening Hours Schedule */}
          <div className="lg:col-span-6 bg-surface-card rounded-2xl border border-border-subtle p-6 sm:p-8 shadow-sm">
            <span className="font-subheading-eyebrow text-subheading-eyebrow text-primary uppercase tracking-widest block mb-2 font-bold">
              SURGERY TIMINGS
            </span>
            <h2 className="font-display-section text-[26px] sm:text-[32px] text-on-surface tracking-tight mb-4">
              Opening Hours &amp; Triage Roster
            </h2>

            <div className="divide-y divide-border-subtle/60">
              {schedule.map((item, idx) => (
                <div key={idx} className="py-2.5 flex items-center justify-between text-sm">
                  <span className="font-semibold text-on-surface">{item.day}</span>
                  <div className="text-right">
                    <span className="text-on-surface font-medium block">{item.hours}</span>
                    <span className="text-[11px] text-on-surface-variant">{item.emergency}</span>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};
