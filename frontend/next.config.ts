import type { NextConfig } from 'next';
import path from 'path';

const nextConfig: NextConfig = {
  // Static HTML export for shared hosting (cPanel / Apache / LiteSpeed)
  output: 'export',
  trailingSlash: true,
  images: {
    unoptimized: true,
  },
  sassOptions: {
    includePaths: [path.join(__dirname, 'src', 'styles')],
  },
};

export default nextConfig;
