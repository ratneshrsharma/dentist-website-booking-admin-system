/**
 * Universal Asset Path Resolver for Acocks Green Dental Practice
 * Automatically prepends the Next.js basePath (/advanced-dental-clinic)
 * to internal static assets, while leaving external URLs intact.
 */
export const BASE_PATH = '/advanced-dental-clinic';

export function getAssetPath(path: string): string {
  if (!path) return '';
  // Remote URLs or data URIs remain untouched
  if (
    path.startsWith('http://') ||
    path.startsWith('https://') ||
    path.startsWith('//') ||
    path.startsWith('data:')
  ) {
    return path;
  }

  const normalized = path.startsWith('/') ? path : `/${path}`;
  if (normalized.startsWith(BASE_PATH)) {
    return normalized;
  }
  return `${BASE_PATH}${normalized}`;
}
