'use client';

import React from 'react';

export const TreatmentCardSkeleton: React.FC = () => {
  return (
    <div className="bg-surface-card rounded-2xl border border-border-subtle/80 overflow-hidden shadow-xs flex flex-col h-full animate-pulse">
      {/* Thumbnail Placeholder */}
      <div className="h-52 sm:h-56 w-full bg-slate-200" />

      {/* Body Content Placeholder */}
      <div className="p-5 sm:p-6 flex-1 flex flex-col justify-between">
        <div>
          <div className="h-5 bg-slate-200 rounded-md w-3/4 mb-3" />
          <div className="space-y-2 mb-4">
            <div className="h-3.5 bg-slate-200 rounded-md w-full" />
            <div className="h-3.5 bg-slate-200 rounded-md w-5/6" />
          </div>

          <div className="space-y-2 mb-5">
            <div className="h-3 bg-slate-200 rounded-md w-4/5" />
            <div className="h-3 bg-slate-200 rounded-md w-3/4" />
            <div className="h-3 bg-slate-200 rounded-md w-2/3" />
          </div>
        </div>

        <div className="pt-4 border-t border-border-subtle/60">
          <div className="flex justify-between mb-3">
            <div className="h-4 bg-slate-200 rounded-md w-1/3" />
            <div className="h-4 bg-slate-200 rounded-md w-1/3" />
          </div>
          <div className="grid grid-cols-2 gap-2">
            <div className="h-9 bg-slate-200 rounded-lg" />
            <div className="h-9 bg-slate-200 rounded-lg" />
          </div>
        </div>
      </div>
    </div>
  );
};
