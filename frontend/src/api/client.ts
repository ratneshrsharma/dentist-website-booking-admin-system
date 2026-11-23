import axios, { AxiosInstance, AxiosRequestConfig, AxiosResponse } from 'axios';
import { ApiResponse } from '@/types/api';
import { CryptoHelper } from '@/utils/crypto';

const BASE_URL =
  process.env.NEXT_PUBLIC_API_BASE_URL || '/dental-saas/api/v1';

/**
 * Core Axios HTTP Instance with standard headers & interceptors
 */
export const axiosInstance: AxiosInstance = axios.create({
  baseURL: BASE_URL,
  timeout: 15000,
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  },
});

// Request Interceptor: Attach Auth Token or Encrypted Headers if required
axiosInstance.interceptors.request.use(
  (config) => {
    if (typeof window !== 'undefined') {
      const token = localStorage.getItem('auth_token');
      if (token) {
        config.headers.Authorization = `Bearer ${CryptoHelper.decodeToken(token)}`;
      }
    }
    return config;
  },
  (error) => Promise.reject(error)
);

// Response Interceptor: Standardize API responses & manage status codes
axiosInstance.interceptors.response.use(
  (response: AxiosResponse) => {
    return response;
  },
  (error) => {
    // If backend returns 401 Unauthorized in protected routes
    if (error.response?.status === 401 && typeof window !== 'undefined') {
      localStorage.removeItem('auth_token');
    }
    return Promise.reject(error);
  }
);

/**
 * Standardized Global Axios Toolkit with CRUD helper functions:
 * `get`, `add`, `edit`, `view`, `update`, `delete`, `action`
 */
export const apiClient = {
  /**
   * Generic GET request
   */
  get: async <T = unknown>(
    endpoint: string,
    params?: Record<string, unknown>,
    config?: AxiosRequestConfig
  ): Promise<ApiResponse<T>> => {
    const response = await axiosInstance.get<ApiResponse<T>>(endpoint, {
      ...config,
      params,
    });
    return response.data;
  },

  /**
   * Generic POST / Add request
   */
  add: async <T = unknown, B = unknown>(
    endpoint: string,
    body: B,
    config?: AxiosRequestConfig
  ): Promise<ApiResponse<T>> => {
    const response = await axiosInstance.post<ApiResponse<T>>(endpoint, body, config);
    return response.data;
  },

  /**
   * Generic Edit request (fetches resource by ID for edit form)
   */
  edit: async <T = unknown>(
    endpoint: string,
    id: string | number,
    config?: AxiosRequestConfig
  ): Promise<ApiResponse<T>> => {
    const cleanEndpoint = endpoint.replace(/\/$/, '');
    const response = await axiosInstance.get<ApiResponse<T>>(
      `${cleanEndpoint}/${id}/edit`,
      config
    );
    return response.data;
  },

  /**
   * Generic View request (fetches single resource by ID)
   */
  view: async <T = unknown>(
    endpoint: string,
    id: string | number,
    config?: AxiosRequestConfig
  ): Promise<ApiResponse<T>> => {
    const cleanEndpoint = endpoint.replace(/\/$/, '');
    const response = await axiosInstance.get<ApiResponse<T>>(
      `${cleanEndpoint}/${id}`,
      config
    );
    return response.data;
  },

  /**
   * Generic PUT/PATCH Update request
   */
  update: async <T = unknown, B = unknown>(
    endpoint: string,
    id: string | number,
    body: B,
    config?: AxiosRequestConfig
  ): Promise<ApiResponse<T>> => {
    const cleanEndpoint = endpoint.replace(/\/$/, '');
    const response = await axiosInstance.put<ApiResponse<T>>(
      `${cleanEndpoint}/${id}`,
      body,
      config
    );
    return response.data;
  },

  /**
   * Generic DELETE request
   */
  delete: async <T = unknown>(
    endpoint: string,
    id: string | number,
    config?: AxiosRequestConfig
  ): Promise<ApiResponse<T>> => {
    const cleanEndpoint = endpoint.replace(/\/$/, '');
    const response = await axiosInstance.delete<ApiResponse<T>>(
      `${cleanEndpoint}/${id}`,
      config
    );
    return response.data;
  },

  /**
   * Generic Custom Action request (e.g. /appointments/1/cancel, /theme/reset)
   */
  action: async <T = unknown, B = unknown>(
    endpoint: string,
    actionName: string,
    body?: B,
    config?: AxiosRequestConfig
  ): Promise<ApiResponse<T>> => {
    const cleanEndpoint = endpoint.replace(/\/$/, '');
    const response = await axiosInstance.post<ApiResponse<T>>(
      `${cleanEndpoint}/${actionName}`,
      body,
      config
    );
    return response.data;
  },
};
