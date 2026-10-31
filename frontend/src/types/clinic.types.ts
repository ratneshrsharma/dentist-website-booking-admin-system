export interface DaySchedule {
  open: string | null;
  close: string | null;
  closed?: boolean;
}

export interface OperatingHours {
  monday: DaySchedule;
  tuesday: DaySchedule;
  wednesday: DaySchedule;
  thursday: DaySchedule;
  friday: DaySchedule;
  saturday: DaySchedule;
  sunday: DaySchedule;
}

export interface Clinic {
  id: number;
  name: string;
  slug: string;
  branch_code: string;
  tagline: string;
  address: string | {
    line1: string;
    city: string;
    state: string;
    postal_code: string;
    country: string;
  };
  phone?: string;
  contact: {
    phone: string;
    emergency_phone: string;
    email: string;
  };
  currency: {
    code: string;
    symbol: string;
  };
  total_chairs: number;
  operating_hours: OperatingHours;
  is_headquarters: boolean;
}
