'use client';

import React, { useEffect } from 'react';
import { CodeInjectionData, cmsService } from '@/services/cms.service';

export interface CodeInjectorProps {
  initialCode?: CodeInjectionData | null;
  slug?: string;
}

/**
 * Safely parses and injects HTML / script snippets into DOM.
 * Standard innerHTML does not execute <script> tags per W3C specification;
 * this utility extracts <script> nodes, creates native script elements, and appends them.
 */
function injectHtmlScripts(htmlContent: string, targetContainer: HTMLElement, scopeKey: string) {
  if (!htmlContent || !htmlContent.trim()) return;

  const parser = new DOMParser();
  const doc = parser.parseFromString(htmlContent, 'text/html');

  // 1. Extract and inject non-script HTML nodes (e.g. noscript, link, div)
  const childNodes = Array.from(doc.body.childNodes);
  childNodes.forEach((node) => {
    if (node.nodeName.toLowerCase() !== 'script') {
      const cloned = node.cloneNode(true) as HTMLElement;
      if (cloned.setAttribute) {
        cloned.setAttribute('data-cms-injected', scopeKey);
      }
      targetContainer.appendChild(cloned);
    }
  });

  // 2. Extract and create executable script elements
  const scriptTags = Array.from(doc.querySelectorAll('script'));
  scriptTags.forEach((oldScript) => {
    const newScript = document.createElement('script');
    newScript.setAttribute('data-cms-injected', scopeKey);

    // Copy attributes (src, async, defer, type, id, etc.)
    Array.from(oldScript.attributes).forEach((attr) => {
      newScript.setAttribute(attr.name, attr.value);
    });

    // Copy inline code
    if (oldScript.textContent) {
      newScript.textContent = oldScript.textContent;
    }

    targetContainer.appendChild(newScript);
  });
}

/**
 * Removes previously injected elements for a specific scope
 */
function removeInjectedScope(scopeKey: string) {
  const elements = document.querySelectorAll(`[data-cms-injected="${scopeKey}"]`);
  elements.forEach((el) => el.remove());
}

/**
 * Dual-Scope Code Injector Component
 * Injects Common (Global) + Page-Specific Custom CSS and JavaScript
 */
export const CodeInjector: React.FC<CodeInjectorProps> = ({ initialCode, slug = 'home' }) => {
  useEffect(() => {
    let isMounted = true;
    const cleanSlug = slug.replace(/^\/+/, '') || 'home';
    const scopeId = `cms-${cleanSlug}`;

    const applyInjection = (codeData: CodeInjectionData) => {
      if (!codeData) return;

      // Clean up any previously injected nodes for this scope
      removeInjectedScope(scopeId);

      // A. Custom CSS Injection (Common + Page)
      const commonCss = codeData.common?.custom_css || '';
      const pageCss = codeData.page?.custom_css || '';
      const mergedCss = [commonCss, pageCss].filter(Boolean).join('\n\n/* --- Page Specific Styles --- */\n\n');

      let styleTag = document.getElementById('cms-custom-styles') as HTMLStyleElement | null;
      if (!styleTag) {
        styleTag = document.createElement('style');
        styleTag.id = 'cms-custom-styles';
        styleTag.setAttribute('type', 'text/css');
        document.head.appendChild(styleTag);
      }
      styleTag.textContent = mergedCss;

      // B. Head Scripts Injection (Common + Page)
      const commonHead = codeData.common?.head_scripts || '';
      const pageHead = codeData.page?.head_scripts || '';
      const combinedHead = `${commonHead}\n${pageHead}`.trim();
      if (combinedHead) {
        injectHtmlScripts(combinedHead, document.head, scopeId);
      }

      // C. Body Scripts Injection (Common + Page)
      const commonBody = codeData.common?.body_scripts || '';
      const pageBody = codeData.page?.body_scripts || '';
      const combinedBody = `${commonBody}\n${pageBody}`.trim();
      if (combinedBody) {
        injectHtmlScripts(combinedBody, document.body, scopeId);
      }
    };

    if (initialCode) {
      applyInjection(initialCode);
    } else {
      cmsService
        .getCodeInjection(cleanSlug)
        .then((codeData) => {
          if (isMounted && codeData) {
            applyInjection(codeData);
          }
        })
        .catch((err) => {
          console.warn('[CodeInjector] Failed to fetch code injection data:', err);
        });
    }

    return () => {
      isMounted = false;
      removeInjectedScope(scopeId);
    };
  }, [initialCode, slug]);

  return null;
};

export default CodeInjector;
