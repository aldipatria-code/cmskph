<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'category_id', 'editor_id', 'title', 'slug', 'content', 
        'cover_image', 'status', 'editor_notes', 'meta_title', 
        'meta_description', 'meta_keywords', 'views_count', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    const STATUS_DRAFT = 1;
    const STATUS_PENDING = 2;
    const STATUS_PUBLISHED = 3;
    const STATUS_REJECTED = 4;

    protected static function booted(): void
    {
        static::saving(function (Post $post): void {
            if ($post->isDirty('content') && is_string($post->content)) {
                $post->content = (new HtmlSanitizer(
                    (new HtmlSanitizerConfig())
                        ->allowSafeElements()
                        ->allowLinkSchemes(['https', 'mailto'])
                        ->allowRelativeLinks()
                ))->sanitize($post->content);
            }
        });
    }

    public function author(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function editor(): BelongsTo {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class);
    }
}
