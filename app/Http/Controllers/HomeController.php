<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Partner;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::with('category')
            ->where('is_featured', true)
            ->latest()
            ->take(4)
            ->get();

        // Kategori untuk section "Belanja Berdasarkan Kategori" (maks. 6).
        // Aman jika model Category belum ada: section akan otomatis tidak tampil.
        $categories = class_exists(Category::class)
            ? Category::orderBy('name')->take(6)->get()
            : collect();

        $services = Service::where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        $portfolios = Portfolio::where('is_featured', true)
            ->latest()
            ->take(4)
            ->get();

        $articles = Article::where('is_published', true)
            ->latest()
            ->take(3)
            ->get();

        $partners = Partner::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        $testimonials = Testimonial::where('is_published', true)
            ->latest()
            ->take(5)
            ->get();

        return view('home', compact(
            'featuredProducts',
            'categories',
            'services',
            'portfolios',
            'articles',
            'partners',
            'testimonials'
        ));
    }
}