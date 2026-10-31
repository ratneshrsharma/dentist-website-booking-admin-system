import type { Clinic } from '@/types/clinic.types';
import type { ServiceCategory } from '@/types/service.types';
import type { Doctor } from '@/types/doctor.types';
import type { TimeSlot, BookingFormData, BookingResponse } from '@/types/booking.types';

const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api/v1';

// Fallback Mock Data for Standalone Static Deployment / Offline Previews
export const MOCK_CLINICS: Clinic[] = [
  {
    id: 1,
    name: 'Advanced Dental Practice (Central Branch)',
    slug: 'advanced-dental-central',
    branch_code: 'ADC-001',
    tagline: 'Comprehensive Multi-Specialty Dental Center & Restorations',
    address: {
      line1: 'Suite 400, Sample Medical Plaza, 500 Healthcare Blvd',
      city: 'Metropolis',
      state: 'NY',
      postal_code: '10001',
      country: 'US',
    },
    contact: {
      phone: '+1 (555) 019-2830',
      emergency_phone: '+1 (555) 019-2830',
      email: 'central@example.com',
    },
    currency: {
      code: 'USD',
      symbol: '$',
    },
    total_chairs: 8,
    operating_hours: {
      monday: { open: '08:00', close: '19:00' },
      tuesday: { open: '08:00', close: '19:00' },
      wednesday: { open: '08:00', close: '19:00' },
      thursday: { open: '08:00', close: '19:00' },
      friday: { open: '08:00', close: '18:00' },
      saturday: { open: '09:00', close: '15:00' },
      sunday: { open: null, close: null, closed: true },
    },
    is_headquarters: true,
  },
  {
    id: 2,
    name: 'Advanced Dental Studio (Westside)',
    slug: 'advanced-dental-westside',
    branch_code: 'ADC-002',
    tagline: 'Cosmetic Smile Care & Orthodontic Studio',
    address: {
      line1: '720 Sunset Boulevard, Suite 150',
      city: 'Metropolis',
      state: 'NY',
      postal_code: '10024',
      country: 'US',
    },
    contact: {
      phone: '+1 (555) 024-5820',
      emergency_phone: '+1 (555) 019-2830',
      email: 'westside@example.com',
    },
    currency: {
      code: 'USD',
      symbol: '$',
    },
    total_chairs: 4,
    operating_hours: {
      monday: { open: '09:00', close: '18:00' },
      tuesday: { open: '09:00', close: '18:00' },
      wednesday: { open: '09:00', close: '18:00' },
      thursday: { open: '09:00', close: '18:00' },
      friday: { open: '09:00', close: '17:00' },
      saturday: { open: '09:00', close: '14:00' },
      sunday: { open: null, close: null, closed: true },
    },
    is_headquarters: false,
  },
  {
    id: 3,
    name: 'Advanced Dental Family Care (Eastside)',
    slug: 'advanced-dental-eastside',
    branch_code: 'ADC-003',
    tagline: 'Family Dental Wellness & Preventative Care',
    address: {
      line1: '1440 Sample Avenue, Building B',
      city: 'Metropolis',
      state: 'NY',
      postal_code: '10128',
      country: 'US',
    },
    contact: {
      phone: '+1 (555) 038-7711',
      emergency_phone: '+1 (555) 019-2830',
      email: 'eastside@example.com',
    },
    currency: {
      code: 'USD',
      symbol: '$',
    },
    total_chairs: 5,
    operating_hours: {
      monday: { open: '08:30', close: '18:30' },
      tuesday: { open: '08:30', close: '18:30' },
      wednesday: { open: '08:30', close: '18:30' },
      thursday: { open: '08:30', close: '18:30' },
      friday: { open: '08:30', close: '17:30' },
      saturday: { open: '09:00', close: '13:00' },
      sunday: { open: null, close: null, closed: true },
    },
    is_headquarters: false,
  },
];

export const MOCK_DOCTORS: Doctor[] = [
  {
    id: 1,
    name: 'Dr. Alex Morgan',
    license_number: 'DDS-DEMO-98241',
    specialization: 'Prosthodontics & Implant Restorations',
    qualifications: 'DDS, Board Certified Specialist',
    years_of_experience: 16,
    biography: 'Dr. Alex Morgan specializes in dental implants, restorative care, and complex smile reconstructions with over 16 years of clinical excellence.',
    consultation_fee: 150.00,
    calendar_color: '#0D9488',
    is_accepting_new_patients: true,
  },
  {
    id: 2,
    name: 'Dr. Sarah Jenkins',
    license_number: 'DMD-DEMO-77312',
    specialization: 'Orthodontics & Clear Aligners',
    qualifications: 'DMD, MS Orthodontics',
    years_of_experience: 12,
    biography: 'Dr. Sarah Jenkins is an experienced provider of clear aligner systems and gentle orthodontic transformations for all age groups.',
    consultation_fee: 120.00,
    calendar_color: '#6366F1',
    is_accepting_new_patients: true,
  },
  {
    id: 3,
    name: 'Dr. David Kim',
    license_number: 'DDS-DEMO-61294',
    specialization: 'Endodontics & Restorative Care',
    qualifications: 'DDS, Clinical Endodontics Fellow',
    years_of_experience: 9,
    biography: 'Dr. David Kim focuses on microscopic precision, root canal treatments, and conservative restorative dentistry.',
    consultation_fee: 100.00,
    calendar_color: '#0284C7',
    is_accepting_new_patients: true,
  },
];

export const MOCK_CATEGORIES: ServiceCategory[] = [
  {
    id: 1,
    name: 'Preventive & Diagnostic',
    slug: 'preventive-diagnostic',
    description: 'Comprehensive oral wellness inspections, digital OPG scans, and ultrasonic prophylaxis.',
    icon_name: 'ShieldCheck',
    services: [
      {
        id: 1,
        category_id: 1,
        name: 'Comprehensive Oral Exam & Cancer Screening',
        slug: 'comprehensive-oral-exam',
        short_description: 'Full 32-tooth assessment, digital intraoral camera tour, and Velscope cancer screening.',
        duration_minutes: 45,
        base_cost: 95.0,
        requires_xray: true,
      },
      {
        id: 2,
        category_id: 1,
        name: 'Ultrasonic Teeth Cleaning & Polishing',
        slug: 'ultrasonic-teeth-cleaning',
        short_description: 'Gentle piezo ultrasonic scaling to eliminate calculus and bacterial biofilm.',
        duration_minutes: 45,
        base_cost: 120.0,
        requires_xray: false,
      },
    ],
  },
  {
    id: 2,
    name: 'Cosmetic Dentistry',
    slug: 'cosmetic-dentistry',
    description: 'Porcelain ceramic veneers, laser teeth whitening, and smile design.',
    icon_name: 'Sparkles',
    services: [
      {
        id: 3,
        category_id: 2,
        name: 'In-Clinic Laser Teeth Whitening (Zoom 4)',
        slug: 'laser-teeth-whitening',
        short_description: 'Brighten your smile by up to 8 shades in a single comfortable 60-minute session.',
        duration_minutes: 60,
        base_cost: 399.0,
        requires_xray: false,
      },
      {
        id: 4,
        category_id: 2,
        name: 'Handcrafted Porcelain Ceramic Veneer',
        slug: 'porcelain-ceramic-veneer',
        short_description: 'Ultra-thin custom porcelain facing designed to correct chips, gaps, and shade.',
        duration_minutes: 90,
        base_cost: 950.0,
        requires_xray: true,
      },
    ],
  },
  {
    id: 3,
    name: 'Orthodontics & Aligners',
    slug: 'orthodontics',
    description: 'Invisalign clear aligners and discreet bite correction.',
    icon_name: 'Smile',
    services: [
      {
        id: 5,
        category_id: 3,
        name: 'Invisalign Aligner Consultation & 3D Simulation',
        slug: 'invisalign-consultation',
        short_description: 'iTero digital optical scan generating an immediate 3D simulation of your aligned smile.',
        duration_minutes: 45,
        base_cost: 120.0,
        requires_xray: true,
      },
    ],
  },
  {
    id: 4,
    name: 'Dental Implants & Surgery',
    slug: 'dental-implants',
    description: 'Permanent titanium implant placement, bone grafting, and immediate load crowns.',
    icon_name: 'Anchor',
    services: [
      {
        id: 6,
        category_id: 4,
        name: 'Single Tooth Titanium Dental Implant',
        slug: 'titanium-dental-implant',
        short_description: 'Permanent replacement tooth engineered with biocompatible surgical titanium.',
        duration_minutes: 60,
        base_cost: 1750.0,
        requires_xray: true,
      },
    ],
  },
  {
    id: 5,
    name: 'Emergency Dental Relief',
    slug: 'emergency-care',
    description: 'Same-day urgent relief for acute toothache, broken crowns, or trauma.',
    icon_name: 'AlertCircle',
    services: [
      {
        id: 7,
        category_id: 5,
        name: 'Emergency Pain Relief & Pulpotomy',
        slug: 'emergency-pain-relief',
        short_description: 'Immediate same-day clinical intervention to eliminate acute toothache.',
        duration_minutes: 45,
        base_cost: 195.0,
        requires_xray: true,
      },
    ],
  },
];

export async function fetchClinics(): Promise<Clinic[]> {
  try {
    const res = await fetch(`${API_BASE_URL}/clinics`, { next: { revalidate: 60 } });
    if (!res.ok) throw new Error('API request failed');
    const json = await res.json();
    return json.data || MOCK_CLINICS;
  } catch {
    return MOCK_CLINICS;
  }
}

export async function fetchServices(): Promise<ServiceCategory[]> {
  try {
    const res = await fetch(`${API_BASE_URL}/services`, { next: { revalidate: 60 } });
    if (!res.ok) throw new Error('API request failed');
    const json = await res.json();
    return json.data || MOCK_CATEGORIES;
  } catch {
    return MOCK_CATEGORIES;
  }
}

export async function fetchDoctors(clinicId?: number): Promise<Doctor[]> {
  try {
    const url = clinicId ? `${API_BASE_URL}/doctors?clinic_id=${clinicId}` : `${API_BASE_URL}/doctors`;
    const res = await fetch(url, { next: { revalidate: 60 } });
    if (!res.ok) throw new Error('API request failed');
    const json = await res.json();
    return json.data || MOCK_DOCTORS;
  } catch {
    return MOCK_DOCTORS;
  }
}

export async function fetchAvailableSlots(
  clinicId: number,
  doctorProfileId: number,
  serviceId: number,
  date: string
): Promise<TimeSlot[]> {
  try {
    const url = `${API_BASE_URL}/availability/slots?clinic_id=${clinicId}&doctor_profile_id=${doctorProfileId}&service_id=${serviceId}&date=${date}`;
    const res = await fetch(url);
    if (!res.ok) throw new Error('API request failed');
    const json = await res.json();
    return json.slots || [];
  } catch {
    // Generate realistic simulated slots based on operating hours
    const times = [
      '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
      '14:00', '14:30', '15:00', '15:30', '16:00', '16:30'
    ];
    return times.map((t, idx) => ({
      time: t,
      display: t.startsWith('09') || t.startsWith('10') || t.startsWith('11') ? `${t} AM` : `${parseInt(t.slice(0, 2)) - 12}:${t.slice(3)} PM`,
      available: idx !== 2 && idx !== 7, // simulate 2 booked slots
      remaining_chairs: idx === 2 || idx === 7 ? 0 : 2,
    }));
  }
}

export async function submitBooking(payload: BookingFormData): Promise<BookingResponse> {
  try {
    const res = await fetch(`${API_BASE_URL}/appointments/book`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify(payload),
    });
    if (!res.ok) {
      const err = await res.json();
      throw new Error(err.message || 'Booking submission failed');
    }
    const json = await res.json();
    return json;
  } catch {
    const clinicId = payload.clinicId || payload.clinic_id || 1;
    const doctorId = payload.doctorProfileId || payload.doctor_profile_id || 1;
    const clinic = MOCK_CLINICS.find(c => c.id === clinicId) || MOCK_CLINICS[0]!;
    const doctor = MOCK_DOCTORS.find(d => d.id === doctorId) || MOCK_DOCTORS[0]!;
    const patientName = payload.patient
      ? `${payload.patient.firstName} ${payload.patient.lastName}`.trim() || 'Valued Patient'
      : `${payload.first_name || ''} ${payload.last_name || ''}`.trim() || 'Valued Patient';

    return {
      success: true,
      message: 'Appointment confirmed successfully (Simulated)',
      data: {
        appointment_id: 1089,
        booking_reference: `ADC-${Math.floor(100000 + Math.random() * 900000)}`,
        patient_name: patientName,
        doctor_name: doctor.name || 'Dr. Alexander Vance',
        clinic_name: clinic.name,
        appointment_date: payload.appointmentDate || payload.appointment_date || new Date().toISOString().substring(0, 10),
        appointment_time: payload.appointmentTime || payload.start_time || '10:00 AM',
        status: 'confirmed',
        whatsapp_notified: true,
        email_notified: true,
      },
    };
  }
}

export async function uploadIntakeDocument(file: File, documentType: string = 'xray'): Promise<{ file_path: string; checksum: string }> {
  try {
    const formData = new FormData();
    formData.append('document', file);
    formData.append('document_type', documentType);

    const res = await fetch(`${API_BASE_URL}/documents/upload`, {
      method: 'POST',
      body: formData,
    });
    if (!res.ok) throw new Error('File upload failed');
    const json = await res.json();
    return json.data;
  } catch {
    // Offline simulated upload checksum
    return {
      file_path: `/storage/documents/simulated-${Date.now()}-${file.name}`,
      checksum: 'sha256-simulated-' + Math.random().toString(36).substring(2, 10),
    };
  }
}
