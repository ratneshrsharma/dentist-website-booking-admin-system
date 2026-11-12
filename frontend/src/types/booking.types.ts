export interface TimeSlot {
  time: string;
  display: string;
  available: boolean;
  remaining_chairs: number;
  period?: 'morning' | 'afternoon';
}

export type BookingStep = 1 | 2 | 3 | 4 | 5;

export interface BookingFormData {
  // Flat API format
  clinic_id?: number;
  service_id?: number;
  doctor_profile_id?: number;
  appointment_date?: string;
  start_time?: string;
  first_name?: string;
  last_name?: string;
  phone?: string;
  email?: string;
  patient_notes?: string;
  chief_complaint?: string;
  pain_level?: number;
  last_visit?: 'within_6_months' | '6_to_12_months' | 'more_than_one_year' | 'never';
  has_allergies?: boolean;
  allergy_details?: string;
  digital_signature?: string;

  // Wizard nested form format
  clinicId?: number;
  serviceId?: number;
  doctorProfileId?: number;
  appointmentDate?: string;
  appointmentTime?: string;
  patient?: {
    firstName: string;
    lastName: string;
    phone: string;
    email: string;
    dateOfBirth: string;
    gender: string;
  };
  intake?: {
    chiefComplaint: string;
    painScale: number;
    lastDentalVisit: string;
    hasBleedingGums: boolean;
    hasSensitivity: boolean;
    hasToothache: boolean;
    systemicConditions: string[];
    allergies: string[];
    isPregnant: boolean;
  };
  uploadedDocumentIds?: number[];
  bookingChannel?: string;
}

export interface BookingResponse {
  success: boolean;
  message?: string;
  data: {
    appointment_id?: number;
    booking_reference: string;
    patient_name: string;
    doctor_name: string;
    clinic_name: string;
    appointment_date: string;
    appointment_time: string;
    status: string;
    whatsapp_notified?: boolean;
    email_notified?: boolean;
    whatsapp_url?: string;
  };
}

export interface BookingConfirmation {
  booking_reference: string;
  clinic: {
    id: number;
    name: string;
    phone: string;
  };
  doctor: {
    id: number;
    name: string;
    specialization: string;
  };
  service: {
    id: number;
    name: string;
    duration_minutes: number;
    cost: number;
  };
  schedule: {
    date: string;
    start_time: string;
    end_time: string;
  };
  status: string;
  patient: {
    first_name: string;
    last_name: string;
    phone: string;
    email?: string;
  };
  created_at: string;
}
