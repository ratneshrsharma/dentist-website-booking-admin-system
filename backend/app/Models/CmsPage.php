<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $page_key
 * @property string $active_template modern_minimalist, classic_heritage, clinical_luxury
 * @property string $meta_title
 * @property string $meta_description
 * @property string $hero_headline
 * @property string $hero_subheadline
 * @property string $cta_primary_label
 * @property string $cta_primary_url
 * @property array<string, mixed> $content_blocks
 * @property bool $is_published
 */
final class CmsPage extends Model
{
    use HasFactory;

    protected $table = 'cms_pages';

    protected $fillable = [
        'page_key',
        'active_template',
        'meta_title',
        'meta_description',
        'hero_headline',
        'hero_subheadline',
        'cta_primary_label',
        'cta_primary_url',
        'content_blocks',
        'is_published',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'content_blocks' => 'array',
            'is_published' => 'boolean',
        ];
    }
}
