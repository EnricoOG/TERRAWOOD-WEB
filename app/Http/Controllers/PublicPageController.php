<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Article;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    public function services(): View
    {
        $services = Service::where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('services.index', compact('services'));
    }

    public function portfolios(): View
    {
        $portfolios = Portfolio::latest()
            ->paginate(12);

        return view('portfolios.index', compact('portfolios'));
    }

    public function articles(): View
    {
        $articles = Article::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(9);

        return view('articles.index', compact('articles'));
    }

    public function showArticle(string $slug): View
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        $relatedArticles = Article::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('articles.show', compact(
            'article',
            'relatedArticles'
        ));
    }
}
