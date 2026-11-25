<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // BARU
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Menampilkan seluruh kategori
    public function index()
    {
        $categories = Category::withCount('products')
            ->latest()
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('admin.categories.create');
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'translations' => 'nullable|array',
            'translations.*' => 'nullable|array',
            'translations.*.*' => 'nullable|string',
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // BARU (maks 2MB)
        ]);

        $validated['translations'] = $this->cleanTranslations($request->input('translations', []));

        // BARU: simpan file foto
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan form edit kategori
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Memperbarui kategori
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'translations' => 'nullable|array',
            'translations.*' => 'nullable|array',
            'translations.*.*' => 'nullable|string',
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // BARU
        ]);

        $validated['translations'] = $this->cleanTranslations($request->input('translations', []));

        // PENTING: kalau tidak ada file baru, kolom image dari form bernilai null dan akan
        // menimpa foto lama. Buang dulu; nilainya diatur lagi oleh blok di bawah.
        unset($validated['image']);

        // BARU: hapus foto kalau dicentang "hapus foto"
        if ($request->boolean('remove_image') && $category->image) {
            Storage::disk('public')->delete($category->image);
            $validated['image'] = null;
        }

        // BARU: ganti dengan foto baru (foto lama dihapus)
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    // Menghapus kategori
    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk!');
        }

        // BARU: hapus file foto dari storage
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }

    private function cleanTranslations(array $input): array
    {
        $allowed = ['name', 'description'];
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