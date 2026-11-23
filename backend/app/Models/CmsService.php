<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $service_id
 * @property string|null $featured_badge
 * @property string $hero_image_url
 * @property array<array{before: string, after: string, label: string}>|null $before_after_gallery
 * @property array<array{question: string, answer: string}>|null $faq_items
 * @property int $display_order
 * @property bool $is_featured_on_home
 */
final class CmsService extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'cms_services';

    protected $fillable = [
        'service_id',
        'featured_badge',
        'hero_image_url',
        'before_after_gallery',
        'faq_items',
        'display_order',
        'is_featured_on_home',
        'updated_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'before_after_gallery' => 'array',
            'faq_items' => 'array',
            'display_order' => 'integer',
            'is_featured_on_home' => 'boolean',
            'updated_at' => 'datetime',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
