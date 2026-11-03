import type { NextConfig } from 'next';
import path from 'path';

const nextConfig: NextConfig = {
  // Static HTML export for shared hosting (Hostinger / cPanel / Apache / LiteSpeed)
  output: 'export',
  trailingSlash: true,
  basePath: '/advanced-dental-clinic',
  assetPrefix: '/advanced-dental-clinic',
  images: {
    unoptimized: true,
  },
  sassOptions: {
    includePaths: [path.join(__dirname, 'src', 'styles')],
  },
};

export default nextConfig;
