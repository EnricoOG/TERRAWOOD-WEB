<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Service;
use App\Models\Article;
use App\Models\Portfolio;
use App\Models\Partner;
use App\Models\Testimonial;
use App\Models\Order;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            // Ringkasan website
            'products' => Product::count(),
            'categories' => Category::count(),
            'services' => Service::count(),
            'articles' => Article::count(),
            'portfolios' => Portfolio::count(),
            'partners' => Partner::count(),
            'testimonials' => Testimonial::count(),

            // Ringkasan pesanan
            'orders' => Order::count(),
            'pending_orders' => Order::where('status', 'menunggu')->count(),
            'processing_orders' => Order::where('status', 'diproses')->count(),
            'completed_orders' => Order::where('status', 'selesai')->count(),
        ];

        // Data aktivitas terbaru
        $recentProducts = Product::latest()
            ->take(5)
            ->get();

        $recentArticles = Article::latest()
            ->take(5)
            ->get();

        $recentTestimonials = Testimonial::latest()
            ->take(5)
            ->get();

        // Pesanan terbaru beserta informasi produk
        $recentOrders = Order::with('product')
            ->latest()
            ->take(5)
            ->get();

        $recentCustomers = \App\Models\User::where('role', 'user')->latest()->take(10)->get();
        $customerCount = \App\Models\User::where('role', 'user')->count();

        return view('admin.dashboard', compact(
            'stats',
            'recentProducts',
            'recentArticles',
            'recentTestimonials',
            'recentOrders',
            'recentCustomers',
            'customerCount'
        ));
    }
}
