<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class CmsTreatment extends Model
{
    use HasFactory;

    protected $table = 'cms_treatments';

    protected $fillable = [
        'slug',
        'title',
        'category_name',
        'subtitle',
        'hero_image_url',
        'overview_html',
        'benefits_list',
        'procedure_steps',
        'faq_items',
        'duration',
        'recovery_time',
        'cost_estimate',
        'featured_badge',
        'display_order',
        'is_published',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'benefits_list' => 'array',
            'procedure_steps' => 'array',
            'faq_items' => 'array',
            'display_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function seo(): HasOne
    {
        return $this->hasOne(SeoMetadata::class, 'entity_slug', 'slug');
    }
}
