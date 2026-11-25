<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    // Menampilkan daftar klien dan mitra
    public function index()
    {
        $partners = Partner::latest()->paginate(10);

        return view('admin.partners.index', compact('partners'));
    }

    // Form tambah klien atau mitra
    public function create()
    {
        return view('admin.partners.create');
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'translations' => 'nullable|array',
            'translations.*' => 'nullable|array',
            'translations.*.*' => 'nullable|string',
            'name' => 'required|string|max:255',
            'type' => 'required|in:client,partner',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['translations'] = $this->cleanTranslations($request->input('translations', []));

        $validated['slug'] = Str::slug($validated['name'])
            . '-' . Str::random(5);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')
                ->store('partners', 'public');
        }

        Partner::create($validated);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Data klien/mitra berhasil ditambahkan!');
    }

    // Form edit
    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    // Memperbarui data
    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'translations' => 'nullable|array',
            'translations.*' => 'nullable|array',
            'translations.*.*' => 'nullable|string',
            'name' => 'required|string|max:255',
            'type' => 'required|in:client,partner',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['translations'] = $this->cleanTranslations($request->input('translations', []));

        $validated['slug'] = Str::slug($validated['name'])
            . '-' . Str::random(5);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }

            $validated['logo'] = $request->file('logo')
                ->store('partners', 'public');
        }

        $partner->update($validated);

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Data klien/mitra berhasil diperbarui!');
    }

    // Menghapus data
    public function destroy(Partner $partner)
    {
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()
            ->route('admin.partners.index')
            ->with('success', 'Data klien/mitra berhasil dihapus!');
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
