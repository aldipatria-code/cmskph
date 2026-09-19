@extends('layouts.app')

@push('seo')
    <title>{{ $post->meta_title ?? $post->title }} - Komunitas Peduli Hepatitis</title>
    <meta name="description" content="{{ $post->meta_description ?? Str::limit(strip_tags($post->content), 160) }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->meta_description ?? Str::limit(strip_tags($post->content), 160) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $post->cover_image ? Storage::disk('public')->url($post->cover_image) : 'https://placehold.co/1200x700?text=No+Image' }}">
    @if ($post->published_at)
        <meta property="article:published_time" content="{{ $post->published_at?->toIso8601String() }}">
    @endif
    <meta property="article:author" content="{{ $post->author->name }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:image" content="{{ $post->cover_image ? Storage::disk('public')->url($post->cover_image) : 'https://placehold.co/1200x700?text=No+Image' }}">

    {{-- <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "headline": "{{ $post->title }}",
      "image": ["{{ asset(Storage::url($post->cover_image)) }}"],
      "datePublished": "{{ $post->published_at }}",
      "dateModified": "{{ $post->updated_at }}",
      "author": {
        "@type": "Person",
        "name": "{{ $post->author->name }}"
      },
      "publisher": {
        "@type": "Organization",
        "name": "WartaKita",
        "logo": {
          "@type": "ImageObject",
          "url": "{{ asset('logo.png') }}"
        }
      }
    }
    </script> --}}
@endpush

@section('content')
<article class="mx-auto max-w-4xl px-0 py-4 sm:px-4 sm:py-10">
    
    <nav class="mb-6 flex flex-wrap items-center gap-2 text-sm">
        <a href="/" class="text-gray-500 transition hover:text-blue-600">Beranda KPH</a>
        <span class="text-gray-300">/</span>
        <span class="font-bold text-blue-600 uppercase tracking-widest text-xs">{{ $post->category->name }}</span>
    </nav>

    <header class="mb-10 text-center md:text-left">
        <h1 class="text-3xl font-black leading-tight tracking-tight text-gray-900 sm:text-4xl md:text-5xl lg:text-6xl">
            {{ $post->title }}
        </h1>
        
        <div class="mt-8 flex flex-wrap items-center justify-center md:justify-start gap-4 border-b border-gray-100 pb-8">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 flex-shrink-0 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white uppercase shadow-md">
                    {{ substr($post->author->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">{{ $post->author->name }}</p>
                    <p class="text-xs text-gray-500">
                        {{ ($post->published_at ?? $post->updated_at)?->isoFormat('D MMMM Y') ?? 'Tanggal belum tersedia' }}
                        • {{ $post->views_count ?? 0 }} Views
                    </p>
                </div>
            </div>
        </div>
    </header>

    <figure class="mb-8 overflow-hidden rounded-2xl shadow-2xl sm:mb-12 sm:rounded-3xl">
        <img src="{{ $post->cover_image ? Storage::disk('public')->url($post->cover_image) : 'https://placehold.co/1200x700?text=No+Image' }}"
             alt="{{ $post->title }}" 
             class="max-h-[500px] w-full object-cover">
        @if(filled($post->image_caption ?? null))
            <figcaption class="mt-4 text-center text-sm italic text-gray-500">
                Foto: {{ $post->image_caption }}
            </figcaption>
        @endif
    </figure>

    <div class="prose prose-base prose-blue max-w-none text-gray-800 leading-relaxed sm:prose-lg lg:prose-xl prose-img:rounded-2xl">
        {!! $post->content !!}
    </div>

    <div class="mt-12 flex flex-wrap gap-2 border-t border-gray-100 pt-8">
        @foreach($post->tags as $tag)
            <a href="/tags/{{ $tag->slug }}" class="rounded-full bg-gray-100 px-4 py-1.5 text-xs font-semibold text-gray-600 hover:bg-blue-600 hover:text-white transition">
                #{{ $tag->name }}
            </a>
        @endforeach
    </div>

</article>

<section class="bg-gray-50 py-10 sm:py-16">
    <div class="mx-auto max-w-4xl px-4">
        <h2 class="mb-6 text-2xl font-bold sm:mb-8">Berita Terkait</h2>
        <div id="related-posts" class="grid grid-cols-1 gap-6 md:grid-cols-2">
            {{-- Kita bisa mengisi ini via API nanti untuk interaktivitas --}}
            <p class="text-gray-400">Memuat berita terkait...</p>
        </div>
    </div>
</section>

@endsection