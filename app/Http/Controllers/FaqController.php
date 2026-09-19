<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\SiteSetting;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        return view('faq.index', [
            'siteSettings' => SiteSetting::current(),
            'faqs' => Faq::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->paginate(3, ['*'], 'faq_page')
                ->withQueryString(),
        ]);
    }
}
