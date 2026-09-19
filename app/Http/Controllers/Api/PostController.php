<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\YoutubeVideo;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $featuredPostId = SiteSetting::current()->featuredPostId();

        $postSearch = trim((string) request()->query('post_search', ''));
        $postCategory = request()->query('post_category');
        $postTag = request()->query('post_tag');

        $publishedPosts = Post::with(['author', 'category', 'tags'])
            ->where('status', Post::STATUS_PUBLISHED)
            ->when($postSearch !== '', function ($query) use ($postSearch): void {
                $query->where(function ($query) use ($postSearch): void {
                    $query->where('title', 'like', '%'.$postSearch.'%')
                        ->orWhere('content', 'like', '%'.$postSearch.'%');
                });
            })
            ->when(filled($postCategory), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $postCategory)))
            ->when(filled($postTag), fn ($query) => $query->whereHas('tags', fn ($tag) => $tag->where('slug', $postTag)))
            ->latest('published_at');

        $featuredPost = $featuredPostId
            ? (clone $publishedPosts)->find($featuredPostId)
            : null;

        $featuredPost ??= (clone $publishedPosts)->first();

        $archivePosts = (clone $publishedPosts)
            ->when($featuredPost, fn ($query) => $query->whereKeyNot($featuredPost->getKey()))
            ->paginate(6, ['*'], 'arsip_page');

        $homeGalleries = Gallery::query()
            ->where('is_published', true)
            ->latest('event_date')
            ->latest()
            ->take(5)
            ->get();

        $videoSearch = trim((string) request()->query('video_search', ''));
        $videoCategory = request()->query('video_category');
        $videoQuery = YoutubeVideo::query()
            ->published()
            ->whereNotNull('youtube_url');

        if ($videoSearch !== '') {
            $videoQuery->where(function ($query) use ($videoSearch): void {
                $query->where('title', 'like', '%'.$videoSearch.'%')
                    ->orWhere('description', 'like', '%'.$videoSearch.'%')
                    ->orWhere('youtube_url', 'like', '%'.$videoSearch.'%');
            });
        }

        if (filled($videoCategory) && in_array($videoCategory, Gallery::categories(), true)) {
            $videoQuery->where('category', $videoCategory);
        }

        $youtubeVideos = $videoQuery
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(2, ['*'], 'video_page')
            ->withQueryString();

        return view('posts.index', [
            'featuredPost' => $featuredPost,
            'archivePosts' => $archivePosts,
            'homeGalleries' => $homeGalleries,
            'youtubeVideos' => $youtubeVideos,
            'postSearch' => $postSearch,
            'postCategory' => $postCategory,
            'postTag' => $postTag,
            'postCategories' => Category::query()->orderBy('name')->get(['name', 'slug']),
            'postTags' => Tag::query()->orderBy('name')->get(['name', 'slug']),
            'videoSearch' => $videoSearch,
            'videoCategory' => $videoCategory,
            'videoCategories' => Gallery::categories(),
        ]);
    }

    public function show($slug) {
        $post = Post::where('slug', $slug)->where('status', 3)->firstOrFail();
        $post->increment('views_count'); // Tambah viewer setiap klik
        // return new PostResource($post);
        return view('posts.show', compact('post'));

    }
}
