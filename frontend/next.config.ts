import type { NextConfig } from 'next';
import path from 'path';

const isProduction = process.env.NODE_ENV === 'production';

const nextConfig: NextConfig = {
  // Static HTML export for shared hosting (Hostinger / cPanel / Apache / LiteSpeed) in production
  ...(isProduction ? { output: 'export' } : {}),
  trailingSlash: true,
  basePath: '/advanced-dental-clinic',
  assetPrefix: '/advanced-dental-clinic',
  images: {
    unoptimized: true,
  },
  sassOptions: {
    includePaths: [path.join(__dirname, 'src', 'styles')],
  },
  // In local development, seamlessly proxy /admin and /api to local PHP/Laravel backend
  ...(isProduction
    ? {}
    : {
        async rewrites() {
          return [
            {
              source: '/admin/:path*',
              destination: 'http://127.0.0.1:8000/admin/:path*',
            },
            {
              source: '/admin',
              destination: 'http://127.0.0.1:8000/admin/',
            },
            {
              source: '/api/:path*',
              destination: 'http://127.0.0.1:8000/api/:path*',
            },
          ];
        },
      }),
};

export default nextConfig;
