<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    // Menampilkan daftar portofolio
    public function index()
    {
        $portfolios = Portfolio::latest()->paginate(10);

        return view('admin.portfolios.index', compact('portfolios'));
    }

    // Menampilkan form tambah portofolio
    public function create()
    {
        return view('admin.portfolios.create');
    }

    // Menyimpan portofolio baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'translations' => 'nullable|array',
            'translations.*' => 'nullable|array',
            'translations.*.*' => 'nullable|string',
            'title' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'project_date' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['translations'] = $this->cleanTranslations($request->input('translations', []));

        $validated['slug'] = Str::slug($validated['title'])
            . '-' . Str::random(5);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('portfolios', 'public');
        }

        Portfolio::create($validated);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portofolio berhasil ditambahkan!');
    }

    // Menampilkan form edit
    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    // Memperbarui portofolio
    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'translations' => 'nullable|array',
            'translations.*' => 'nullable|array',
            'translations.*.*' => 'nullable|string',
            'title' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'project_date' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['translations'] = $this->cleanTranslations($request->input('translations', []));

        $validated['slug'] = Str::slug($validated['title'])
            . '-' . Str::random(5);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }

            $validated['image'] = $request->file('image')
                ->store('portfolios', 'public');
        }

        $portfolio->update($validated);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portofolio berhasil diperbarui!');
    }

    // Menghapus portofolio
    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portofolio berhasil dihapus!');
    }

    private function cleanTranslations(array $input): array
    {
        $allowed = ['title', 'client_name', 'category', 'description'];
        $clean = [];
        foreach (['en', 'id', 'zh'] as $locale) {
            foreach ($allowed as $field) {
                $value = $input[$locale][$field] ?? null;
                if (is_string($value) && trim($value) !== '') {
                    $clean[$locale][$field] = trim($value);
                }
            }
        }
        return $clean;
    }
}