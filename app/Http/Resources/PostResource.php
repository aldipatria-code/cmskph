<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    // public function toArray(Request $request): array
    // {
    //     return parent::toArray($request);
    // }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'cover_image' => $this->cover_image ? Storage::disk('public')->url($this->cover_image) : null,
            'category' => $this->category->name,
            'author' => [
                'name' => $this->author->name,
                'username' => $this->author->username,
            ],
            'seo' => [
                'meta_title' => $this->meta_title ?? $this->title,
                'meta_description' => $this->meta_description,
            ],
            'published_at' => $this->published_at,
            'updated_at' => $this->updated_at->isoFormat('D MMMM Y'),
        ];
    }
}
