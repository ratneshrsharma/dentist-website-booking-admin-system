/**
 * Standard API Response Structure
 */
export interface ApiResponse<T = unknown> {
  success: boolean;
  data: T;
  message?: string;
  meta?: {
    page?: number;
    per_page?: number;
    total?: number;
    timestamp?: string;
  };
  errors?: Record<string, string[]>;
}

/**
 * Standard CRUD API Actions Interface
 */
export interface ApiCrudHelper {
  get: <T = unknown>(endpoint: string, params?: Record<string, unknown>) => Promise<ApiResponse<T>>;
  add: <T = unknown, B = unknown>(endpoint: string, body: B) => Promise<ApiResponse<T>>;
  edit: <T = unknown>(endpoint: string, id: string | number) => Promise<ApiResponse<T>>;
  view: <T = unknown>(endpoint: string, id: string | number) => Promise<ApiResponse<T>>;
  update: <T = unknown, B = unknown>(endpoint: string, id: string | number, body: B) => Promise<ApiResponse<T>>;
  delete: <T = unknown>(endpoint: string, id: string | number) => Promise<ApiResponse<T>>;
  action: <T = unknown, B = unknown>(endpoint: string, actionName: string, body?: B) => Promise<ApiResponse<T>>;
}
