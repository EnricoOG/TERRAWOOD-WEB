<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->search;
        $categoryId = $request->category;

        $products = Product::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('catalog.index', compact(
            'products',
            'categories',
            'search',
            'categoryId'
        ));
    }

    public function show(string $slug): View
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('catalog.show', compact('product'));
    }
}
