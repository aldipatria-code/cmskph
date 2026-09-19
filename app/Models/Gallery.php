<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    public static function categories(): array
    {
        $categories = GalleryCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name')
            ->all();

        return $categories ?: [
            'Pendidikan', 'Sosial', 'Dakwah', 'Ekonomi',
            'Kesehatan', 'Kurban', 'Ramadhan',
        ];
    }

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'image_path',
        'additional_images',
        'event_date',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_published' => 'boolean',
            'additional_images' => 'array',
        ];
    }

    public function imageUrl(): ?string
    {
        return filled($this->image_path)
            ? Storage::disk('public')->url($this->image_path)
            : null;
    }

    public function imageUrls(): array
    {
        return collect([$this->image_path, ...($this->additional_images ?? [])])
            ->filter()
            ->map(fn (string $path): string => Storage::disk('public')->url($path))
            ->values()
            ->all();
    }
}
