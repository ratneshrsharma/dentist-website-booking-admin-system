/**
 * Asset URL helper for Next.js static exports deployed in subdirectories (e.g. /dental-saas)
 */
export function assetUrl(path?: string | null): string {
  if (!path) return '';
  if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('data:')) {
    return path;
  }
  const basePath = process.env.NEXT_PUBLIC_BASE_PATH ?? '/dental-saas';
  const cleanPath = path.startsWith('/') ? path : `/${path}`;
  if (basePath && cleanPath.startsWith(basePath)) {
    return cleanPath;
  }
  return `${basePath}${cleanPath}`;
}
