<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class YoutubeVideo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'youtube_url',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    public function youtubeId(): ?string
    {
        $url = trim($this->youtube_url);

        if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function embedUrl(): ?string
    {
        return $this->youtubeId() ? 'https://www.youtube-nocookie.com/embed/'.$this->youtubeId() : null;
    }

    public function thumbnailUrl(): ?string
    {
        return $this->youtubeId() ? 'https://i.ytimg.com/vi/'.$this->youtubeId().'/hqdefault.jpg' : null;
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
