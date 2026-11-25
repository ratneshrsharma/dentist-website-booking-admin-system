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

interface BlogFaq {
  question: string;
  answer: string;
  is_active?: boolean;
}

interface BlogPost {
  id: string;
  title: string;
  slug: string;
  author: string;
  read_time?: string;
  date?: string;
  date_formatted?: string;
  featured_image?: string;
  featured_image_alt?: string;
  excerpt?: string;
  content: string;
  categories?: BlogCategory[];
  tags?: BlogTag[];
  show_faqs?: boolean;
  faqs?: BlogFaq[];
  seo?: {
    meta_title?: string;
    meta_description?: string;
    meta_keywords?: string;
  };
}

export function BlogPostClient({ initialSlug }: { initialSlug: string }) {
  const [post, setPost] = useState<BlogPost | null>(null);
  const [related, setRelated] = useState<BlogPost[]>([]);
  const [loading, setLoading] = useState(true);
  const [notFound, setNotFound] = useState(false);
  const [openFaqIdx, setOpenFaqIdx] = useState<number | null>(0);
  const [isBookingOpen, setIsBookingOpen] = useState(false);

  useEffect(() => {
    let resolvedSlug = initialSlug;
    if (typeof window !== 'undefined') {
      const match = window.location.pathname.match(/\/blog\/([^/]+)\/?$/);
      if (match && match[1] && match[1] !== 'post-template') {
        resolvedSlug = decodeURIComponent(match[1]);
      }
    }

    async function loadPost() {
      setLoading(true);
      setNotFound(false);
      try {
        const res = await apiClient.get<BlogPost>(`/blog/posts/${encodeURIComponent(resolvedSlug)}?_t=${Date.now()}`);
        const raw = res as unknown as { success?: boolean; data?: BlogPost; related?: BlogPost[] };
        if (raw?.success && raw.data) {
          setPost(raw.data);
          setRelated(Array.isArray(raw.related) ? raw.related : []);
          const metaTitle = raw.data.seo?.meta_title || `${raw.data.title} | Acocks Green Dental Practice`;
          document.title = metaTitle;
          if (raw.data.seo?.meta_description) {
            let metaDesc = document.querySelector('meta[name="description"]');
            if (!metaDesc) {
              metaDesc = document.createElement('meta');
              metaDesc.setAttribute('name', 'description');
              document.head.appendChild(metaDesc);
            }
            metaDesc.setAttribute('content', raw.data.seo.meta_description);
          }
        } else {
          setNotFound(true);
        }
      } catch {
        setNotFound(true);
      } finally {
        setLoading(false);
      }
    }

    if (resolvedSlug && resolvedSlug !== 'post-template') {
      loadPost();
    } else {
      setNotFound(true);
      setLoading(false);
    }
  }, [initialSlug]);

  const activeFaqs = (post?.faqs || []).filter((f) => f.is_active !== false);

  return (
    <div style={{ minHeight: '100vh', display: 'flex', flexDirection: 'column', background: '#f8fafc' }}>
      <HeaderTopBar />
      <HeaderNavBar onBookClick={() => setIsBookingOpen(true)} />

      <main style={{ flex: 1 }}>
        {loading ? (
          <div style={{ maxWidth: 960, margin: '80px auto', padding: '0 24px', textAlign: 'center', color: '#64748b' }}>
            Loading article...
          </div>
        ) : notFound || !post ? (
          <div style={{ maxWidth: 720, margin: '80px auto', padding: '48px 24px', background: '#fff', borderRadius: 18, border: '1px solid #e2e8f0', textAlign: 'center' }}>
            <h1 style={{ fontSize: 28, fontWeight: 800, color: '#0f172a', marginBottom: 12 }}>Article Not Found</h1>
            <p style={{ color: '#64748b', marginBottom: 24 }}>This blog post may be a draft, scheduled for a future date, or removed.</p>
            <Link href="/blog" style={{ display: 'inline-block', padding: '12px 24px', borderRadius: 10, background: '#0d631b', color: '#fff', fontWeight: 700, textDecoration: 'none' }}>
              ← Back to All Articles
            </Link>
          </div>
        ) : (
          <>
            {/* Article Header */}
            <section style={{ background: 'linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%)', borderBottom: '1px solid #e2e8f0', padding: '44px 0 36px' }}>
              <div style={{ maxWidth: 1000, margin: '0 auto', padding: '0 24px' }}>
                <nav style={{ fontSize: 13, color: '#64748b', marginBottom: 18, display: 'flex', gap: 8, flexWrap: 'wrap' }}>
                  <Link href="/" style={{ color: '#0d631b', textDecoration: 'none', fontWeight: 600 }}>Home</Link>
                  <span>/</span>
                  <Link href="/blog" style={{ color: '#0d631b', textDecoration: 'none', fontWeight: 600 }}>Blog</Link>
                  {post.categories?.[0] && (
                    <>
                      <span>/</span>
                      <Link href={`/blog?category=${post.categories[0].slug}`} style={{ color: '#0d631b', textDecoration: 'none', fontWeight: 600 }}>
                        {post.categories[0].name}
                      </Link>
                    </>
                  )}
                </nav>

                <div style={{ display: 'flex', gap: 8, flexWrap: 'wrap', marginBottom: 14 }}>
                  {(post.categories || []).map((cat) => (
                    <Link
                      key={cat.id}
                      href={`/blog?category=${cat.slug}`}
                      style={{
                        fontSize: 12,
                        fontWeight: 700,
                        color: '#0d631b',
                        background: '#dcfce7',
                        padding: '5px 12px',
                        borderRadius: 999,
                        textDecoration: 'none',
                      }}
                    >
                      {cat.name}
                    </Link>
                  ))}
                </div>

                <h1 style={{ fontSize: 'clamp(1.9rem, 3.8vw, 2.85rem)', fontWeight: 800, color: '#0f172a', lineHeight: 1.2, marginBottom: 16 }}>
                  {post.title}
                </h1>

                {post.excerpt && (
                  <p style={{ fontSize: 18, color: '#475569', lineHeight: 1.6, marginBottom: 20 }}>
                    {post.excerpt}
                  </p>
                )}

                <div style={{ display: 'flex', gap: 18, flexWrap: 'wrap', fontSize: 14, color: '#475569', fontWeight: 500 }}>
                  <span><strong>Author:</strong> {post.author}</span>
                  <span>•</span>
                  <span><strong>Published:</strong> {post.date_formatted || post.date}</span>
                  {post.read_time && (
                    <>
                      <span>•</span>
                      <span>{post.read_time}</span>
                    </>
                  )}
                </div>
              </div>
            </section>

            {/* Article Body */}
            <section style={{ padding: '44px 0 72px' }}>
              <div style={{ maxWidth: 1000, margin: '0 auto', padding: '0 24px' }}>
                {post.featured_image && (
                  <div style={{ position: 'relative', width: '100%', height: 'clamp(260px, 42vw, 440px)', borderRadius: 20, overflow: 'hidden', marginBottom: 36, border: '1px solid #e2e8f0' }}>
                    <Image
                      src={assetUrl(post.featured_image)}
                      alt={post.featured_image_alt || post.title}
                      fill
                      style={{ objectFit: 'cover' }}
                    />
                  </div>
                )}

                <article
                  style={{
                    background: '#ffffff',
                    borderRadius: 20,
                    padding: 'clamp(24px, 4vw, 44px)',
                    border: '1px solid #e2e8f0',
                    boxShadow: '0 8px 28px rgba(15, 23, 42, 0.04)',
                    fontSize: 16.5,
                    lineHeight: 1.8,
                    color: '#1e293b',
                  }}
                >
                  <div
                    className="blog-rich-content"
                    dangerouslySetInnerHTML={{ __html: post.content }}
                  />

                  {/* Tags */}
                  {post.tags && post.tags.length > 0 && (
                    <div style={{ marginTop: 36, paddingTop: 24, borderTop: '1px solid #e2e8f0', display: 'flex', gap: 8, flexWrap: 'wrap', alignItems: 'center' }}>
                      <span style={{ fontSize: 13, fontWeight: 700, color: '#64748b', marginRight: 4 }}>Tags:</span>
                      {post.tags.map((tag) => (
                        <Link
                          key={tag.id}
                          href={`/blog?tag=${tag.slug}`}
                          style={{
                            fontSize: 13,
                            fontWeight: 600,
                            color: '#334155',
                            background: '#f1f5f9',
                            padding: '5px 12px',
                            borderRadius: 999,
                            textDecoration: 'none',
                          }}
                        >
                          #{tag.name}
                        </Link>
                      ))}
                    </div>
                  )}
                </article>

                {/* Post FAQs Section */}
                {post.show_faqs !== false && activeFaqs.length > 0 && (
                  <div style={{ marginTop: 36, background: '#ffffff', borderRadius: 20, padding: 'clamp(24px, 4vw, 36px)', border: '1px solid #e2e8f0' }}>
                    <h2 style={{ fontSize: 24, fontWeight: 800, color: '#0f172a', marginBottom: 20 }}>
                      Frequently Asked Questions
                    </h2>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: 12 }}>
                      {activeFaqs.map((faq, idx) => {
                        const isOpen = openFaqIdx === idx;
                        return (
                          <div key={idx} style={{ border: '1px solid #e2e8f0', borderRadius: 12, overflow: 'hidden' }}>
                            <button
                              type="button"
                              onClick={() => setOpenFaqIdx(isOpen ? null : idx)}
                              style={{
                                width: '100%',
                                textAlign: 'left',
                                padding: '16px 20px',
                                background: isOpen ? '#f0fdf4' : '#ffffff',
                                border: 'none',
                                fontWeight: 700,
                                fontSize: 16,
                                color: '#0f172a',
                                display: 'flex',
                                justifyContent: 'space-between',
                                alignItems: 'center',
                                cursor: 'pointer',
                              }}
                            >
                              <span>{faq.question}</span>
                              <span style={{ color: '#0d631b', fontSize: 20 }}>{isOpen ? '−' : '+'}</span>
                            </button>
                            {isOpen && (
                              <div
                                style={{ padding: '0 20px 18px', fontSize: 15, lineHeight: 1.7, color: '#475569', background: '#f0fdf4' }}
                                dangerouslySetInnerHTML={{ __html: faq.answer }}
                              />
                            )}
                          </div>
                        );
                      })}
                    </div>
                  </div>
                )}

                {/* Booking CTA */}
                <div
                  style={{
                    marginTop: 36,
                    background: 'linear-gradient(135deg, #0d631b 0%, #15803d 100%)',
                    color: '#ffffff',
                    borderRadius: 20,
                    padding: '32px',
                    display: 'flex',
                    justifyContent: 'space-between',
                    alignItems: 'center',
                    flexWrap: 'wrap',
                    gap: 20,
                  }}
                >
                  <div>
                    <h3 style={{ fontSize: 22, fontWeight: 800, marginBottom: 6 }}>Need Clinical Advice or an Appointment?</h3>
                    <p style={{ margin: 0, opacity: 0.92, fontSize: 15 }}>Book online in 60 seconds with our Birmingham B27 dental team.</p>
                  </div>
                  <button
                    type="button"
                    onClick={() => setIsBookingOpen(true)}
                    style={{
                      padding: '12px 24px',
                      borderRadius: 12,
                      border: 'none',
                      background: '#ffffff',
                      color: '#0d631b',
                      fontWeight: 800,
                      fontSize: 15,
                      cursor: 'pointer',
                    }}
                  >
                    Book An Appointment
                  </button>
                </div>

                {/* Related Articles */}
                {related.length > 0 && (
                  <div style={{ marginTop: 48 }}>
                    <h3 style={{ fontSize: 22, fontWeight: 800, color: '#0f172a', marginBottom: 20 }}>More Dental Guides</h3>
                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(280px, 1fr))', gap: 20 }}>
                      {related.map((rel) => (
                        <Link
                          key={rel.id}
                          href={`/blog/${rel.slug}`}
                          style={{
                            background: '#ffffff',
                            borderRadius: 16,
                            padding: 20,
                            border: '1px solid #e2e8f0',
                            textDecoration: 'none',
                            display: 'block',
                          }}
                        >
                          <div style={{ fontSize: 12, fontWeight: 700, color: '#0d631b', marginBottom: 6 }}>
                            {rel.categories?.[0]?.name || 'Clinical Guide'}
                          </div>
                          <h4 style={{ fontSize: 16, fontWeight: 700, color: '#0f172a', marginBottom: 8, lineHeight: 1.4 }}>{rel.title}</h4>
                          <span style={{ fontSize: 13, fontWeight: 600, color: '#0d631b' }}>Read Article →</span>
                        </Link>
                      ))}
                    </div>
                  </div>
                )}
              </div>
            </section>
          </>
        )}
      </main>

      <Footer />
      <MobileAppNavBar onBookClick={() => setIsBookingOpen(true)} />
      <BookingModal isOpen={isBookingOpen} onClose={() => setIsBookingOpen(false)} />
    </div>
  );
}
