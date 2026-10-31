export interface Doctor {
  id: number;
  name: string;
  full_name?: string;
  license_number: string;
  specialization: string;
  qualifications: string;
  years_of_experience: number;
  years_experience?: number;
  biography: string;
  consultation_fee: number;
  calendar_color: string;
  is_accepting_new_patients: boolean;
  avatar_url?: string | null;
}

export type DoctorProfile = Doctor;
