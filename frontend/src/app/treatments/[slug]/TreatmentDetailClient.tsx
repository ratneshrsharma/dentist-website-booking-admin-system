'use client';

import React, { useState, useEffect } from 'react';
import {
  AcocksGreenTreatmentDetailTemplate,
  TreatmentDetailData,
} from '@/components/templates/AcocksGreenTreatmentDetailTemplate';
import { BrandPreloader } from '@/components/common/BrandPreloader';
import { ThemeHydrator } from '@/components/common/ThemeHydrator';
import { CodeInjector } from '@/components/common/CodeInjector';
import { getTreatmentDetailBySlug } from '@/data/treatmentDetails';
import {
  cmsService,
  CmsPageSeo,
  GlobalThemeConfig,
  CodeInjectionData,
} from '@/services/cms.service';

interface TreatmentDetailClientProps {
  slug: string;
  initialData?: TreatmentDetailData;
}

export const TreatmentDetailClient: React.FC<TreatmentDetailClientProps> = ({
  slug,
  initialData,
}) => {
  // 0ms Zero-Loading Strategy: Instant pre-rendered SSG with zero artificial delays
  const loading = false;
  const bespokeData = getTreatmentDetailBySlug(slug);
  const [pageData, setPageData] = useState<TreatmentDetailData>(
    initialData || bespokeData
  );
  const [, setSeoData] = useState<CmsPageSeo | null>(null);
  const [, setThemeData] = useState<GlobalThemeConfig | null>(null);
  const [, setCodeData] = useState<CodeInjectionData | null>(null);

  useEffect(() => {
    let isMounted = true;

    async function hydrateTreatmentDetail() {
      try {
        const [content, seo, theme, code] = await Promise.all([
          cmsService.getPageContent(slug),
          cmsService.getPageSeo(slug),
          cmsService.getGlobalTheme(),
          cmsService.getCodeInjection(slug),
        ]);

        if (isMounted) {
          if (content && typeof content === 'object') {
            setPageData((prev) => ({
              ...prev,
              ...(content as unknown as TreatmentDetailData),
            }));
          }
          setSeoData(seo);
          setThemeData(theme);
          setCodeData(code);

          // Update Document Title dynamically
          if (seo?.meta_title && typeof document !== 'undefined') {
            document.title = seo.meta_title;
          }
        }
      } catch (err) {
        console.warn(`[TreatmentDetailClient] CMS API hydration for '${slug}' fell back to local dataset:`, err);
      }
    }

    hydrateTreatmentDetail();

    return () => {
      isMounted = false;
    };
  }, [slug]);

  const activeData: TreatmentDetailData = {
    ...bespokeData,
    ...(pageData || {}),
  };

  return (
    <>
      {/* 1. Clinic Brand Preloader for smooth seamless load */}
      <BrandPreloader isLoading={loading} message="Loading Clinical Systems..." />

      {/* 2. Global CSS Custom Variables Token Hydrator */}
      <ThemeHydrator />

      {/* 3. Dual-Scope Custom Code Injector (GTM, Scripts, Per-Page CSS) */}
      <CodeInjector slug={slug} />

      {/* 4. Full Acocks Green Treatment Detail Template */}
      <div
        className={`transition-opacity duration-500 ${
          loading ? 'opacity-0 pointer-events-none' : 'opacity-100 pointer-events-auto'
        }`}
      >
        <AcocksGreenTreatmentDetailTemplate data={activeData} />
      </div>
    </>
  );
};
