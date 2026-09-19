<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $category = $request->query('category');
        $query = Gallery::query()->where('is_published', true);

        if ($search !== '') {
            $query->where(function ($query) use ($search): void {
                $query->where('title', 'like', '%'.$search.'%')
                    ->orWhere('category', 'like', '%'.$search.'%')
                    ->orWhere('image_path', 'like', '%'.$search.'%');
            });
        }

        if (filled($category) && in_array($category, Gallery::categories(), true)) {
            $query->where('category', $category);
        }

        return view('galleries.index', [
            'galleries' => $query
                ->latest('event_date')
                ->latest()
                ->paginate(6)
                ->withQueryString(),
            'featuredGalleries' => Gallery::query()
                ->where('is_published', true)
                ->latest('event_date')
                ->latest()
                ->take(2)
                ->get(),
            'search' => $search,
            'selectedCategory' => $category,
            'categories' => Gallery::categories(),
            'activeAlbumCount' => Gallery::query()->where('is_published', true)->count(),
            'categoryCount' => count(Gallery::categories()),
        ]);
    }

    public function show(Gallery $gallery): View
    {
        abort_unless($gallery->is_published, 404);

        return view('galleries.show', compact('gallery'));
    }
}
