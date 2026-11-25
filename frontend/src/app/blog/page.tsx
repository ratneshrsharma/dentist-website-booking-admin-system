'use client';

import React, { useEffect, useState } from 'react';
import Link from 'next/link';
import Image from 'next/image';
import { apiClient } from '@/api/client';
import { assetUrl } from '@/utils/asset';
import { HeaderTopBar } from '@/components/layout/HeaderTopBar/HeaderTopBar';
import { HeaderNavBar } from '@/components/layout/HeaderNavBar/HeaderNavBar';
import { Footer } from '@/components/layout/Footer/Footer';
import { MobileAppNavBar } from '@/components/layout/MobileAppNavBar/MobileAppNavBar';
import { BookingModal } from '@/components/common/BookingModal/BookingModal';

interface BlogCategory {
  id: string;
  name: string;
  slug: string;
}

interface BlogTag {
  id: string;
  name: string;
  slug: string;
}

interface BlogPost {
  id: string;
  title: string;
  slug: string;
  category: string;
  categories?: BlogCategory[];
  tags?: BlogTag[];
  date: string;
  date_formatted?: string;
  author: string;
  read_time?: string;
  featured_image?: string;
  featured_image_alt?: string;
  image?: string;
  excerpt: string;
  content: string;
}

interface BlogPostsResponse {
  data: BlogPost[];
  categories?: BlogCategory[];
  tags?: BlogTag[];
}

interface BlogPageData {
  hero?: {
    eyebrow?: string;
    headline?: string;
    subtitle?: string;
  };
  sections?: Array<{
    grid_cols?: number;
  }>;
  seo?: {
    meta_title?: string;
  };
}

export default function BlogPage() {
  const [pageData, setPageData] = useState<BlogPageData>({
    hero: {
      eyebrow: 'Clinical Insights & Oral Wellness',
      headline: 'Dental Health Blog & Patient Guides',
      subtitle:
        'Evidence-based dental advice, NHS & private care tips, and practice updates from our Birmingham B27 clinical team.',
    },
  });
  const [posts, setPosts] = useState<BlogPost[]>([]);
  const [categories, setCategories] = useState<BlogCategory[]>([]);
  const [tags, setTags] = useState<BlogTag[]>([]);
  const [selectedCategory, setSelectedCategory] = useState<string>('all');
  const [selectedTag, setSelectedTag] = useState<string>('all');
  const [searchQuery, setSearchQuery] = useState<string>('');
  const [loading, setLoading] = useState<boolean>(true);
  const [isBookingOpen, setIsBookingOpen] = useState(false);

  useEffect(() => {
    if (typeof window !== 'undefined') {
      const params = new URLSearchParams(window.location.search);
      const catParam = params.get('category');
      const tagParam = params.get('tag');
      if (catParam) setSelectedCategory(catParam);
      if (tagParam) setSelectedTag(tagParam);
    }

    async function loadData() {
      try {
        const [pageRes, postsRes] = await Promise.all([
          apiClient.get<BlogPageData>(`/pages/blog?_t=${Date.now()}`),
          apiClient.get<BlogPost[]>(`/blog/posts?_t=${Date.now()}`),
        ]);

        if (pageRes?.success && pageRes.data) {
          setPageData(pageRes.data);
          if (pageRes.data.seo?.meta_title) {
            document.title = pageRes.data.seo.meta_title;
          }
        }

        const rawPosts = postsRes as unknown as BlogPostsResponse & { success?: boolean };
        if (rawPosts?.success && Array.isArray(rawPosts.data)) {
          setPosts(rawPosts.data);
          if (Array.isArray(rawPosts.categories)) setCategories(rawPosts.categories);
          if (Array.isArray(rawPosts.tags)) setTags(rawPosts.tags);
        }
      } catch {
        // Keep empty state gracefully
      } finally {
        setLoading(false);
      }
    }
    loadData();
  }, []);

  const filteredPosts = posts.filter((post) => {
    if (selectedCategory !== 'all') {
      const catSlugs = (post.categories || []).map((c) => c.slug);
      if (!catSlugs.includes(selectedCategory)) return false;
    }
    if (selectedTag !== 'all') {
      const tagSlugs = (post.tags || []).map((t) => t.slug);
      if (!tagSlugs.includes(selectedTag)) return false;
    }
    if (searchQuery.trim() !== '') {
      const q = searchQuery.toLowerCase();
      const hay = `${post.title} ${post.excerpt} ${post.author}`.toLowerCase();
      if (!hay.includes(q)) return false;
    }
    return true;
  });

  const gridCols = Math.max(1, Math.min(6, Number(pageData.sections?.[0]?.grid_cols) || 3));

  return (
    <div style={{ minHeight: '100vh', display: 'flex', flexDirection: 'column', background: '#f8fafc' }}>
      <HeaderTopBar />
      <HeaderNavBar onBookClick={() => setIsBookingOpen(true)} />

      <main style={{ flex: 1 }}>
        {/* Hero */}
        <section
          style={{
            background: 'linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%)',
            borderBottom: '1px solid #e2e8f0',
            padding: '56px 0 44px',
          }}
        >
          <div className="container" style={{ maxWidth: 1400, margin: '0 auto', padding: '0 24px' }}>
            <div style={{ maxWidth: 780 }}>
              <span
                style={{
                  display: 'inline-block',
                  fontSize: 12,
                  fontWeight: 700,
                  textTransform: 'uppercase',
                  letterSpacing: '0.08em',
                  color: '#0d631b',
                  background: '#dcfce7',
                  padding: '6px 14px',
                  borderRadius: 999,
                  marginBottom: 14,
                }}
              >
                {pageData.hero?.eyebrow || 'Clinical Insights & Oral Wellness'}
              </span>
              <h1 style={{ fontSize: 'clamp(2rem, 4vw, 3rem)', fontWeight: 800, color: '#0f172a', marginBottom: 14 }}>
                {pageData.hero?.headline || 'Dental Health Blog & Patient Guides'}
              </h1>
              <p style={{ fontSize: 17, lineHeight: 1.65, color: '#475569', margin: 0 }}>
                {pageData.hero?.subtitle ||
                  'Evidence-based dental advice, NHS & private care tips, and practice updates from our Birmingham B27 clinical team.'}
              </p>
            </div>
          </div>
        </section>

        {/* Filter & Search Bar */}
        <section style={{ padding: '40px 0 72px' }}>
          <div className="container" style={{ maxWidth: 1400, margin: '0 auto', padding: '0 24px' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', flexWrap: 'wrap', gap: 16, marginBottom: 20 }}>
              {/* Category Pills */}
              <div style={{ display: 'flex', gap: 10, flexWrap: 'wrap' }}>
                <button
                  type="button"
                  onClick={() => setSelectedCategory('all')}
                  style={{
                    padding: '9px 18px',
                    borderRadius: 999,
                    border: '1px solid',
                    borderColor: selectedCategory === 'all' ? '#0d631b' : '#cbd5e1',
                    background: selectedCategory === 'all' ? '#0d631b' : '#ffffff',
                    color: selectedCategory === 'all' ? '#ffffff' : '#334155',
                    fontWeight: 600,
                    fontSize: 14,
                    cursor: 'pointer',
                  }}
                >
                  All Articles
                </button>
                {categories.map((cat) => (
                  <button
                    key={cat.id}
                    type="button"
                    onClick={() => setSelectedCategory(cat.slug)}
                    style={{
                      padding: '9px 18px',
                      borderRadius: 999,
                      border: '1px solid',
                      borderColor: selectedCategory === cat.slug ? '#0d631b' : '#cbd5e1',
                      background: selectedCategory === cat.slug ? '#0d631b' : '#ffffff',
                      color: selectedCategory === cat.slug ? '#ffffff' : '#334155',
                      fontWeight: 600,
                      fontSize: 14,
                      cursor: 'pointer',
                    }}
                  >
                    {cat.name}
                  </button>
                ))}
              </div>

              {/* Search */}
              <input
                type="search"
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                placeholder="Search articles..."
                style={{
                  padding: '9px 16px',
                  borderRadius: 999,
                  border: '1px solid #cbd5e1',
                  fontSize: 14,
                  minWidth: 240,
                  background: '#ffffff',
                }}
              />
            </div>

            {/* Tag Chips */}
            {tags.length > 0 && (
              <div style={{ display: 'flex', gap: 8, flexWrap: 'wrap', alignItems: 'center', marginBottom: 30 }}>
                <span style={{ fontSize: 12, fontWeight: 700, color: '#64748b', textTransform: 'uppercase' }}>Topics:</span>
                <button
                  type="button"
                  onClick={() => setSelectedTag('all')}
                  style={{
                    padding: '4px 12px',
                    borderRadius: 999,
                    border: '1px solid',
                    borderColor: selectedTag === 'all' ? '#0f172a' : '#e2e8f0',
                    background: selectedTag === 'all' ? '#0f172a' : '#ffffff',
                    color: selectedTag === 'all' ? '#ffffff' : '#475569',
                    fontSize: 12,
                    fontWeight: 600,
                    cursor: 'pointer',
                  }}
                >
                  All Tags
                </button>
                {tags.map((tag) => (
                  <button
                    key={tag.id}
                    type="button"
                    onClick={() => setSelectedTag(selectedTag === tag.slug ? 'all' : tag.slug)}
                    style={{
                      padding: '4px 12px',
                      borderRadius: 999,
                      border: '1px solid',
                      borderColor: selectedTag === tag.slug ? '#0d631b' : '#e2e8f0',
                      background: selectedTag === tag.slug ? '#dcfce7' : '#ffffff',
                      color: selectedTag === tag.slug ? '#0d631b' : '#475569',
                      fontSize: 12,
                      fontWeight: 600,
                      cursor: 'pointer',
                    }}
                  >
                    #{tag.name}
                  </button>
                ))}
              </div>
            )}

            {/* Posts Grid */}
            {loading ? (
              <div style={{ textAlign: 'center', padding: '60px 0', color: '#64748b' }}>Loading dental articles...</div>
            ) : filteredPosts.length === 0 ? (
              <div style={{ textAlign: 'center', padding: '60px 24px', background: '#ffffff', borderRadius: 16, border: '1px solid #e2e8f0' }}>
                <h3 style={{ fontSize: 20, fontWeight: 700, color: '#0f172a', marginBottom: 8 }}>No articles match your filter</h3>
                <p style={{ color: '#64748b', marginBottom: 16 }}>Try clearing your category, tag, or search filter.</p>
                <button
                  type="button"
                  onClick={() => { setSelectedCategory('all'); setSelectedTag('all'); setSearchQuery(''); }}
                  style={{ padding: '10px 20px', borderRadius: 10, border: 'none', background: '#0d631b', color: '#fff', fontWeight: 600, cursor: 'pointer' }}
                >
                  Reset Filters
                </button>
              </div>
            ) : (
              <div className="blog-list-dynamic-grid">
                <style>{`
                  .blog-list-dynamic-grid {
                    display: grid;
                    grid-template-columns: repeat(${gridCols}, minmax(0, 1fr));
                    gap: 24px;
                  }
                  @media (max-width: 1100px) {
                    .blog-list-dynamic-grid {
                      grid-template-columns: repeat(${Math.min(2, gridCols)}, minmax(0, 1fr));
                    }
                  }
                  @media (max-width: 640px) {
                    .blog-list-dynamic-grid {
                      grid-template-columns: 1fr;
                    }
                  }
                `}</style>
                {filteredPosts.map((post) => {
                  const postImg = post.featured_image || post.image || '/uploads/home/treatment-room.jpg';
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
                      <Link href={`/blog/${post.slug}`} style={{ display: 'block', position: 'relative', height: 220, background: '#e2e8f0' }}>
                        <Image
                          src={assetUrl(postImg)}
                          alt={post.featured_image_alt || post.title}
                          fill
                          style={{ objectFit: 'cover' }}
                        />
                      </Link>
                      <div style={{ padding: 24, display: 'flex', flexDirection: 'column', flex: 1 }}>
                        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: 12, fontSize: 12, color: '#64748b', gap: 8, flexWrap: 'wrap' }}>
                          <span
                            style={{
                              fontWeight: 700,
                              color: '#0d631b',
                              background: '#dcfce7',
                              padding: '4px 10px',
                              borderRadius: 999,
                            }}
                          >
                            {post.categories?.[0]?.name || post.category || 'Clinical Guide'}
                          </span>
                          <span>{post.date_formatted || post.date} • {post.read_time || '4 min read'}</span>
                        </div>
                        <Link href={`/blog/${post.slug}`} style={{ textDecoration: 'none' }}>
                          <h2 style={{ fontSize: 20, fontWeight: 700, color: '#0f172a', marginBottom: 10, lineHeight: 1.35 }}>
                            {post.title}
                          </h2>
                        </Link>
                        <p style={{ fontSize: 14, color: '#475569', lineHeight: 1.65, flex: 1, marginBottom: 16 }}>
                          {post.excerpt}
                        </p>
                        {post.tags && post.tags.length > 0 && (
                          <div style={{ display: 'flex', gap: 6, flexWrap: 'wrap', marginBottom: 16 }}>
                            {post.tags.slice(0, 3).map((t) => (
                              <span key={t.id} style={{ fontSize: 11, color: '#475569', background: '#f1f5f9', padding: '3px 8px', borderRadius: 6 }}>
                                #{t.name}
                              </span>
                            ))}
                          </div>
                        )}
                        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', borderTop: '1px solid #f1f5f9', paddingTop: 14 }}>
                          <span style={{ fontSize: 13, fontWeight: 600, color: '#334155' }}>{post.author}</span>
                          <Link
                            href={`/blog/${post.slug}`}
                            style={{
                              color: '#0d631b',
                              fontWeight: 700,
                              fontSize: 14,
                              display: 'inline-flex',
                              alignItems: 'center',
                              gap: 4,
                              textDecoration: 'none',
                            }}
                          >
                            Read Full Guide →
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
      </main>

      <Footer />
      <MobileAppNavBar onBookClick={() => setIsBookingOpen(true)} />
      <BookingModal isOpen={isBookingOpen} onClose={() => setIsBookingOpen(false)} />
    </div>
  );
}
