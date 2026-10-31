export interface Service {
  id: number;
  category_id: number;
  category_name?: string;
  name: string;
  slug: string;
  short_description: string;
  detailed_description?: string;
  duration_minutes: number;
  base_cost: number;
  requires_xray: boolean;
}

export interface ServiceCategory {
  id: number;
  name: string;
  slug: string;
  description: string;
  icon_name: string;
  services: Service[];
}
