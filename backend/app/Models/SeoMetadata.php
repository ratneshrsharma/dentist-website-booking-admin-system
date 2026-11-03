<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class SeoMetadata extends Model
{
    use HasFactory;

    protected $table = 'seo_metadata';

    protected $fillable = [
        'entity_type',
        'entity_slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image_url',
        'og_type',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image_url',
        'robots_index',
        'robots_follow',
        'schema_type',
        'schema_json',
        'custom_css',
        'custom_js_head',
        'custom_js_footer',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
            'schema_json' => 'array',
        ];
    }
}
