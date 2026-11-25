'use client';

import React, { useEffect, useState } from 'react';
import Link from 'next/link';
import Image from 'next/image';
import { apiClient } from '@/api/client';
import { assetUrl } from '@/utils/asset';

interface BlogPostItem {
  id: string;
  title: string;
  slug: string;
  category?: string;
  categories?: Array<{ id: string; name: string; slug: string }>;
  date?: string;
  date_formatted?: string;
  author?: string;
  read_time?: string;
  featured_image?: string;
  featured_image_alt?: string;
  excerpt?: string;
}

export interface BlogPostsSectionProps {
  eyebrow?: string;
  title?: string;
  subtitle?: string;
  actionText?: string;
  actionUrl?: string;
  gridCols?: number;
  limit?: number;
}

export const BlogPostsSection: React.FC<BlogPostsSectionProps> = ({
  eyebrow = 'Get the latest news, offers and updates',
  title = 'Latest Dental & Oral Health Articles',
  subtitle = 'Clinical insights, preventive brushing advice, and community health updates.',
  actionText = 'View All Articles',
  actionUrl = '/blog/',
  gridCols = 3,
  limit = 3,
}) => {
  const [posts, setPosts] = useState<BlogPostItem[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    let mounted = true;
    async function loadPosts() {
      try {
        const res = await apiClient.get<BlogPostItem[]>(`/blog/posts?_t=${Date.now()}`);
        const raw = res as unknown as { success?: boolean; data?: BlogPostItem[] };
        if (mounted && raw?.success && Array.isArray(raw.data)) {
          setPosts(raw.data.slice(0, limit));
        }
      } catch {
        // Ignore gracefully
      } finally {
        if (mounted) setLoading(false);
      }
    }
    loadPosts();
    return () => {
      mounted = false;
    };
  }, [limit]);

  const colMinWidth = gridCols >= 4 ? '260px' : gridCols === 2 ? '420px' : '320px';

  return (
    <section style={{ padding: '16px 0' }}>
      <div style={{ maxWidth: 1400, margin: '0 auto', padding: '0 24px' }}>
        <div
          style={{
            display: 'flex',
            justifyContent: 'space-between',
            alignItems: 'flex-end',
            flexWrap: 'wrap',
            gap: 20,
            marginBottom: 36,
          }}
        >
          <div style={{ maxWidth: 720 }}>
            {eyebrow && (
              <span
                style={{
                  display: 'inline-block',
                  fontSize: 12,
                  fontWeight: 700,
                  textTransform: 'uppercase',
                  letterSpacing: '0.08em',
                  color: '#0d631b',
                  marginBottom: 8,
                }}
              >
                {eyebrow}
              </span>
            )}
            <h2
              style={{
                fontSize: 'clamp(1.75rem, 3vw, 2.35rem)',
                fontWeight: 800,
                color: '#0f172a',
                margin: '0 0 10px',
                lineHeight: 1.2,
              }}
            >
              {title}
            </h2>
            {subtitle && (
              <p style={{ fontSize: 16, color: '#475569', margin: 0, lineHeight: 1.6 }}>
                {subtitle}
              </p>
            )}
          </div>
          {actionText && actionUrl && (
            <Link
              href={actionUrl.startsWith('/') ? actionUrl : '/blog/'}
              style={{
                display: 'inline-flex',
                alignItems: 'center',
                gap: 6,
                padding: '11px 22px',
                borderRadius: 10,
                background: '#0d631b',
                color: '#ffffff',
                fontWeight: 700,
                fontSize: 14,
                textDecoration: 'none',
                whiteSpace: 'nowrap',
              }}
            >
              {actionText} →
            </Link>
          )}
        </div>

        {loading ? (
          <div style={{ textAlign: 'center', padding: '40px 0', color: '#64748b' }}>
            Loading latest dental articles...
          </div>
        ) : posts.length === 0 ? (
          <div
            style={{
              textAlign: 'center',
              padding: '36px 24px',
              background: '#ffffff',
              borderRadius: 16,
              border: '1px solid #e2e8f0',
              color: '#64748b',
            }}
          >
            No published articles yet.
          </div>
        ) : (
          <div
            style={{
              display: 'grid',
              gridTemplateColumns: `repeat(auto-fill, minmax(${colMinWidth}, 1fr))`,
              gap: 26,
            }}
          >
            {posts.map((post) => {
              const imgPath = post.featured_image || '/uploads/home/treatment-room.jpg';
              const catName = post.categories?.[0]?.name || post.category || 'Clinical Guide';
              return (
                <article
                  key={post.id}
                  style={{
                    background: '#ffffff',
                    borderRadius: 18,
                    overflow: 'hidden',
                    border: '1px solid #e2e8f0',
                    boxShadow: '0 8px 24px rgba(15, 23, 42, 0.04)',
                    display: 'flex',
                    flexDirection: 'column',
                  }}
                >
                  <Link
                    href={`/blog/${post.slug}`}
                    style={{ display: 'block', position: 'relative', height: 210, background: '#e2e8f0' }}
                  >
                    <Image
                      src={assetUrl(imgPath)}
                      alt={post.featured_image_alt || post.title}
                      fill
                      style={{ objectFit: 'cover' }}
                    />
                  </Link>
                  <div style={{ padding: 22, display: 'flex', flexDirection: 'column', flex: 1 }}>
                    <div
                      style={{
                        display: 'flex',
                        justifyContent: 'space-between',
                        alignItems: 'center',
                        gap: 8,
                        marginBottom: 10,
                        fontSize: 12,
                        color: '#64748b',
                      }}
                    >
                      <span
                        style={{
                          fontWeight: 700,
                          color: '#0d631b',
                          background: '#dcfce7',
                          padding: '3px 10px',
                          borderRadius: 999,
                        }}
                      >
                        {catName}
                      </span>
                      <span>{post.date_formatted || post.date}</span>
                    </div>
                    <Link href={`/blog/${post.slug}`} style={{ textDecoration: 'none' }}>
                      <h3
                        style={{
                          fontSize: 18,
                          fontWeight: 700,
                          color: '#0f172a',
                          marginBottom: 10,
                          lineHeight: 1.35,
                        }}
                      >
                        {post.title}
                      </h3>
                    </Link>
                    {post.excerpt && (
                      <p
                        style={{
                          fontSize: 14,
                          color: '#475569',
                          lineHeight: 1.6,
                          flex: 1,
                          marginBottom: 16,
                        }}
                      >
                        {post.excerpt}
                      </p>
                    )}
                    <div
                      style={{
                        display: 'flex',
                        justifyContent: 'space-between',
                        alignItems: 'center',
                        borderTop: '1px solid #f1f5f9',
                        paddingTop: 12,
                      }}
                    >
                      <span style={{ fontSize: 12.5, fontWeight: 600, color: '#334155' }}>
                        {post.author || 'Acocks Green Team'}
                      </span>
                      <Link
                        href={`/blog/${post.slug}`}
                        style={{
                          color: '#0d631b',
                          fontWeight: 700,
                          fontSize: 13.5,
                          textDecoration: 'none',
                        }}
                      >
                        Read Article →
                      </Link>
                    </div>
                  </div>
                </article>
              );
            })}
          </div>
        )}
      </div>
    </section>
  );
};
