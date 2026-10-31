export interface TimeSlot {
  time: string;
  display: string;
  available: boolean;
  remaining_chairs: number;
}

export type BookingStep = 1 | 2 | 3 | 4 | 5;

export interface BookingFormData {
  clinic_id: number;
  service_id: number;
  doctor_profile_id: number;
  appointment_date: string;
  start_time: string;
  first_name: string;
  last_name: string;
  phone: string;
  email: string;
  patient_notes?: string;
  chief_complaint: string;
  pain_level: number;
  last_visit: 'within_6_months' | '6_to_12_months' | 'more_than_one_year' | 'never';
  has_allergies: boolean;
  allergy_details?: string;
  digital_signature: string;
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
