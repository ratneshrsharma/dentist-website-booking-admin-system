/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  images: {
    unoptimized: true,
    remotePatterns: [
      {
        protocol: 'https',
        hostname: '**',
      },
    ],
  },
  async rewrites() {
    return [
      {
        source: '/api/:path*',
        destination: process.env.NEXT_PUBLIC_BACKEND_API_URL 
          ? `${process.env.NEXT_PUBLIC_BACKEND_API_URL}/api/:path*`
          : 'http://localhost/dental-saas/backend/public/api/:path*',
      },
    ];
  },
};

export default nextConfig;
