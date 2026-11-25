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

interface BlogPost {
  id: string;
  title: string;
  category: string;
  date: string;
  author: string;
  read_time?: string;
  image: string;
  excerpt: string;
  content: string;
}

interface BlogPageData {
  hero?: {
    eyebrow?: string;
    headline?: string;
    subtitle?: string;
  };
  sections?: Array<{
    eyebrow?: string;
    title?: string;
    summary?: string;
    grid_cols?: number;
  }>;
  blog_posts?: BlogPost[];
  seo?: {
    meta_title?: string;
  };
}

const DEFAULT_POSTS: BlogPost[] = [
  {
    id: 'post_1',
    title: 'How Often Should You Book a Dental Hygiene & Airflow Polish?',
    category: 'Preventive Care',
    date: '2026-11-18',
    author: 'Claire, Dental Hygienist',
    read_time: '4 min read',
    image: '/uploads/home/treatment-room.jpg',
    excerpt:
      'Learn how Airflow warm-water polishing removes stubborn tea, coffee, and plaque biofilm gently without scraping sensitive enamel.',
    content:
      'Regular dental hygiene appointments every 3 to 6 months are essential for preventing gum disease and preserving natural enamel. Our Airflow system uses a gentle stream of warm water, air, and fine erythritol powder to lift surface stains painlessly.',
  },
  {
    id: 'post_2',
    title: 'NHS vs Private Dental Care in Birmingham: What Is Included?',
    category: 'Patient Guides',
    date: '2026-11-10',
    author: 'Dr. Atandrilla Das',
    read_time: '5 min read',
    image: '/uploads/home/hero-patient.jpg',
    excerpt:
      'A transparent breakdown of NHS Band 1, Band 2, and Band 3 treatments alongside private cosmetic options like white fillings and Invisalign.',
    content:
      'Understanding your dental treatment options should always be clear and stress-free. At Acocks Green Dental Practice, we explain both NHS and private pathways upfront so you can choose what suits your clinical needs and budget.',
  },
  {
    id: 'post_3',
    title: 'Same-Day Emergency Dental Triage: What Counts as Urgent?',
    category: 'Emergency Care',
    date: '2026-11-02',
    author: 'Dr. Nadeem Sohail',
    read_time: '3 min read',
    image: '/uploads/home/surgery-clinic.jpg',
    excerpt:
      'Severe toothache, facial swelling, or a knocked-out tooth? Here is how our Birmingham B27 triage line gets you seen the very same day.',
    content:
      'Dental emergencies can happen without warning. If you experience severe throbbing pain, swelling, or dental trauma, call our reception on +44 121 765 2870 before 10:00 AM for priority same-day clinical triage.',
  },
];

export default function BlogPage() {
  const [blogData, setBlogData] = useState<BlogPageData>({
    hero: {
      eyebrow: 'Clinical Insights & Oral Wellness',
      headline: 'Dental Health Blog & Patient Guides',
      subtitle:
        'Evidence-based dental advice, NHS & private care tips, and practice updates from our Birmingham B27 clinical team.',
    },
    blog_posts: DEFAULT_POSTS,
  });
  const [selectedCategory, setSelectedCategory] = useState<string>('All');
  const [activePost, setActivePost] = useState<BlogPost | null>(null);
  const [isBookingOpen, setIsBookingOpen] = useState(false);

  useEffect(() => {
    async function loadBlog() {
      try {
        const res = await apiClient.get<BlogPageData>(`/pages/blog?_t=${Date.now()}`);
        if (res?.success && res.data) {
          setBlogData(res.data);
          if (res.data.seo?.meta_title) {
            document.title = res.data.seo.meta_title;
          }
        }
      } catch {
        // Fallback to default posts
      }
    }
    loadBlog();
  }, []);

  const posts = blogData.blog_posts && blogData.blog_posts.length > 0 ? blogData.blog_posts : DEFAULT_POSTS;
  const categories = ['All', ...Array.from(new Set(posts.map((p) => p.category).filter(Boolean)))];
  const filteredPosts = selectedCategory === 'All' ? posts : posts.filter((p) => p.category === selectedCategory);
  const gridCols = blogData.sections?.[0]?.grid_cols || 3;

  return (
    <div style={{ display: 'flex', flexDirection: 'column', minHeight: '100vh', background: '#f8fafc' }}>
      <HeaderTopBar />
      <HeaderNavBar onBookClick={() => setIsBookingOpen(true)} />

      <main style={{ flex: 1 }}>
        {/* Hero Banner */}
        <section style={{ background: 'linear-gradient(135deg, #f2fcf5 0%, #e7f8ec 100%)', padding: '48px 0 40px', borderBottom: '1px solid #dcfce7' }}>
          <div style={{ maxWidth: '1400px', margin: '0 auto', padding: '0 24px' }}>
            <nav aria-label="Breadcrumb" style={{ display: 'flex', alignItems: 'center', gap: '8px', fontSize: '13px', color: '#64748b', marginBottom: '16px' }}>
              <Link href="/" style={{ color: '#0d631b', textDecoration: 'none', fontWeight: 600 }}>Home</Link>
              <span>/</span>
              <span>Blog</span>
            </nav>
            <span
              style={{ fontSize: '12px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.1em', color: '#0d631b', display: 'block', marginBottom: '8px' }}
              dangerouslySetInnerHTML={{ __html: blogData.hero?.eyebrow || 'Clinical Insights & Oral Wellness' }}
            />
            <h1
              style={{ fontSize: 'clamp(28px, 4vw, 42px)', fontWeight: 800, color: '#0f172a', margin: '0 0 12px', lineHeight: 1.15 }}
              dangerouslySetInnerHTML={{ __html: blogData.hero?.headline || 'Dental Health Blog & Patient Guides' }}
            />
            <p
              style={{ fontSize: '16px', color: '#475569', maxWidth: '720px', margin: 0, lineHeight: 1.6 }}
              dangerouslySetInnerHTML={{ __html: blogData.hero?.subtitle || '' }}
            />
          </div>
        </section>

        {/* Blog Posts Grid */}
        <section style={{ padding: '48px 0 72px' }}>
          <div style={{ maxWidth: '1400px', margin: '0 auto', padding: '0 24px' }}>
            {/* Category Filter Pills */}
            <div style={{ display: 'flex', flexWrap: 'wrap', gap: '10px', marginBottom: '28px' }}>
              {categories.map((cat) => (
                <button
                  key={cat}
                  type="button"
                  onClick={() => setSelectedCategory(cat)}
                  style={{
                    padding: '8px 18px',
                    borderRadius: '9999px',
                    border: selectedCategory === cat ? '1px solid #0d631b' : '1px solid #cbd5e1',
                    backgroundColor: selectedCategory === cat ? '#0d631b' : '#ffffff',
                    color: selectedCategory === cat ? '#ffffff' : '#334155',
                    fontSize: '13px',
                    fontWeight: 600,
                    cursor: 'pointer',
                    transition: 'all 0.15s ease',
                  }}
                >
                  {cat}
                </button>
              ))}
            </div>

            {/* Posts Grid */}
            <div
              style={{
                display: 'grid',
                gridTemplateColumns: `repeat(auto-fill, minmax(${gridCols >= 4 ? '260px' : '320px'}, 1fr))`,
                gap: '24px',
              }}
            >
              {filteredPosts.map((post) => (
                <article
                  key={post.id}
                  style={{
                    background: '#ffffff',
                    borderRadius: '18px',
                    border: '1px solid #e2e8f0',
                    overflow: 'hidden',
                    display: 'flex',
                    flexDirection: 'column',
                    boxShadow: '0 4px 16px rgba(15, 23, 42, 0.04)',
                  }}
                >
                  <div style={{ position: 'relative', height: '210px', background: '#e2e8f0' }}>
                    <Image
                      src={assetUrl(post.image || '/uploads/home/treatment-room.jpg')}
                      alt={post.title}
                      fill
                      style={{ objectFit: 'cover' }}
                    />
                    <span
                      style={{
                        position: 'absolute',
                        top: '14px',
                        left: '14px',
                        background: '#0d631b',
                        color: '#ffffff',
                        fontSize: '11px',
                        fontWeight: 700,
                        padding: '4px 12px',
                        borderRadius: '9999px',
                      }}
                    >
                      {post.category}
                    </span>
                  </div>
                  <div style={{ padding: '20px', display: 'flex', flexDirection: 'column', flex: 1, justifyContent: 'space-between', gap: '14px' }}>
                    <div>
                      <div style={{ fontSize: '12px', color: '#64748b', marginBottom: '8px' }}>
                        {post.date} • {post.read_time || '4 min read'}
                      </div>
                      <h2 style={{ fontSize: '18px', fontWeight: 700, color: '#0f172a', margin: '0 0 10px', lineHeight: 1.35 }}>
                        {post.title}
                      </h2>
                      <p style={{ fontSize: '14px', color: '#475569', margin: 0, lineHeight: 1.55 }}>
                        {post.excerpt}
                      </p>
                    </div>
                    <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', paddingTop: '12px', borderTop: '1px solid #f1f5f9' }}>
                      <span style={{ fontSize: '12px', fontWeight: 600, color: '#334155' }}>{post.author}</span>
                      <button
                        type="button"
                        onClick={() => setActivePost(post)}
                        style={{
                          background: '#f0fdf4',
                          color: '#0d631b',
                          border: '1px solid #bbf7d0',
                          borderRadius: '9999px',
                          padding: '6px 14px',
                          fontSize: '12.5px',
                          fontWeight: 700,
                          cursor: 'pointer',
                        }}
                      >
                        Read Article →
                      </button>
                    </div>
                  </div>
                </article>
              ))}
            </div>
          </div>
        </section>
      </main>

      {/* Article Reader Modal */}
      {activePost && (
        <div
          style={{
            position: 'fixed',
            inset: 0,
            background: 'rgba(15, 23, 42, 0.7)',
            zIndex: 999999,
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            padding: '20px',
          }}
          onClick={() => setActivePost(null)}
        >
          <div
            style={{
              background: '#ffffff',
              borderRadius: '20px',
              maxWidth: '720px',
              width: '100%',
              maxHeight: '85vh',
              overflowY: 'auto',
              padding: '28px',
              position: 'relative',
            }}
            onClick={(e) => e.stopPropagation()}
          >
            <button
              type="button"
              onClick={() => setActivePost(null)}
              style={{
                position: 'absolute',
                top: '16px',
                right: '16px',
                width: '36px',
                height: '36px',
                borderRadius: '50%',
                border: '1px solid #cbd5e1',
                background: '#ffffff',
                cursor: 'pointer',
                fontWeight: 700,
              }}
            >
              ✕
            </button>
            <span style={{ fontSize: '12px', fontWeight: 700, color: '#0d631b', textTransform: 'uppercase' }}>
              {activePost.category} • {activePost.date}
            </span>
            <h2 style={{ fontSize: '24px', fontWeight: 800, color: '#0f172a', margin: '8px 0 12px' }}>
              {activePost.title}
            </h2>
            <p style={{ fontSize: '13px', color: '#64748b', marginBottom: '20px' }}>
              By {activePost.author}
            </p>
            <div
              style={{ fontSize: '15px', color: '#334155', lineHeight: 1.7 }}
              dangerouslySetInnerHTML={{ __html: activePost.content || activePost.excerpt }}
            />
          </div>
        </div>
      )}

      <Footer />
      <MobileAppNavBar onBookClick={() => setIsBookingOpen(true)} />
      <BookingModal isOpen={isBookingOpen} onClose={() => setIsBookingOpen(false)} />
    </div>
  );
}
