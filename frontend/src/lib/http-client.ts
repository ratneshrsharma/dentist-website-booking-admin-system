/**
 * Advanced Dental Clinic - Centralized Enterprise HTTP & API Client
 * Powered by Axios, Crypto-JS, Day.js, JS-Cookie, JWT-Decode, and Lodash
 */

import axios, { AxiosInstance, AxiosResponse, AxiosError } from 'axios';
import CryptoJS from 'crypto-js';
import Cookies from 'js-cookie';
import { jwtDecode } from 'jwt-decode';
import dayjs from 'dayjs';
import _ from 'lodash';

// Primary API Base URL
export const API_BASE_URL: string =
  process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api/v1';

// Cookie keys
export const TOKEN_COOKIE_KEY = 'adc_auth_token';
export const THEME_COOKIE_KEY = 'adc_theme_preference';

export interface DecodedAuthToken {
  sub: string;
  role: string;
  email: string;
  exp: number;
  iat: number;
}

export interface ApiResponse<T = unknown> {
  success: boolean;
  message?: string;
  data: T;
  meta?: Record<string, unknown>;
}

// Create dedicated Axios instance
export const httpClient: AxiosInstance = axios.create({
  baseURL: API_BASE_URL,
  timeout: 15000,
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
    'X-Client-Platform': 'NextJS-AppRouter',
  },
});

// Request Interceptor: Attach Token & Integrity Nonce
httpClient.interceptors.request.use(
  (config) => {
    // Attach authorization bearer token if available
    const token = Cookies.get(TOKEN_COOKIE_KEY);
    if (token && config.headers) {
      config.headers.Authorization = `Bearer ${token}`;
    }

    // Add unique request signature & timestamp
    const timestamp = dayjs().toISOString();
    const nonce = CryptoJS.lib.WordArray.random(16).toString();
    if (config.headers) {
      config.headers['X-Request-Timestamp'] = timestamp;
      config.headers['X-Request-Nonce'] = nonce;
    }

    return config;
  },
  (error: AxiosError) => {
    return Promise.reject(error);
  }
);

// Response Interceptor: Standardize payload and handle errors
httpClient.interceptors.response.use(
  (response: AxiosResponse) => {
    return response;
  },
  (error: AxiosError<ApiResponse<unknown>>) => {
    const status = error.response?.status;
    const errorMsg =
      error.response?.data?.message || error.message || 'An unexpected clinical API error occurred.';

    if (status === 401) {
      // Clear expired authentication session
      Cookies.remove(TOKEN_COOKIE_KEY);
    }

    return Promise.reject({
      status,
      message: errorMsg,
      data: error.response?.data,
    });
  }
);

/**
 * Validates whether the active JWT token is unexpired
 */
export function isTokenValid(token?: string): boolean {
  const activeToken = token || Cookies.get(TOKEN_COOKIE_KEY);
  if (!activeToken) return false;

  try {
    const decoded = jwtDecode<DecodedAuthToken>(activeToken);
    const nowInSeconds = dayjs().unix();
    return decoded.exp > nowInSeconds;
  } catch {
    return false;
  }
}

/**
 * Format clinical appointment dates using dayjs
 */
export function formatClinicalDate(dateStr: string, format = 'MMMM D, YYYY'): string {
  if (!dateStr) return '';
  return dayjs(dateStr).format(format);
}

/**
 * Utility to group clinical treatments by category using lodash
 */
export function groupByCategory<T extends { category: string }>(items: T[]): Record<string, T[]> {
  return _.groupBy(items, 'category');
}
