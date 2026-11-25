<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // Menampilkan daftar artikel
    public function index()
    {
        $articles = Article::latest()->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    // Menampilkan form tambah artikel
    public function create()
    {
        return view('admin.articles.create');
    }

    // Menyimpan artikel baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'translations' => 'nullable|array',
            'translations.*' => 'nullable|array',
            'translations.*.*' => 'nullable|string',
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['translations'] = $this->cleanTranslations($request->input('translations', []));

        $validated['slug'] = Str::slug($validated['title'])
            . '-' . Str::random(5);

        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('articles', 'public');
        }

        Article::create($validated);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan!');
    }

    // Menampilkan form edit artikel
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    // Memperbarui artikel
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'translations' => 'nullable|array',
            'translations.*' => 'nullable|array',
            'translations.*.*' => 'nullable|string',
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['translations'] = $this->cleanTranslations($request->input('translations', []));

        $validated['slug'] = Str::slug($validated['title'])
            . '-' . Str::random(5);

        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published']) {
            $validated['published_at'] = $article->published_at ?? now();
        } else {
            $validated['published_at'] = null;
        }

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }

            $validated['image'] = $request->file('image')
                ->store('articles', 'public');
        }

        $article->update($validated);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    // Menghapus artikel
    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }

    private function cleanTranslations(array $input): array
    {
        $allowed = ['title', 'category', 'excerpt', 'content'];
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