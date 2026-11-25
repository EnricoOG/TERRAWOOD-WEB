<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    // Menampilkan daftar layanan
    public function index()
    {
        $services = Service::latest()->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    // Menampilkan form tambah layanan
    public function create()
    {
        return view('admin.services.create');
    }

    // Menyimpan layanan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'translations' => 'nullable|array',
            'translations.*' => 'nullable|array',
            'translations.*.*' => 'nullable|string',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['translations'] = $this->cleanTranslations($request->input('translations', []));

        $validated['slug'] = Str::slug($validated['name'])
            . '-' . Str::random(5);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('services', 'public');
        }

        Service::create($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    // Menampilkan form edit layanan
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    // Memperbarui layanan
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'translations' => 'nullable|array',
            'translations.*' => 'nullable|array',
            'translations.*.*' => 'nullable|string',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['translations'] = $this->cleanTranslations($request->input('translations', []));

        $validated['slug'] = Str::slug($validated['name'])
            . '-' . Str::random(5);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $validated['image'] = $request->file('image')
                ->store('services', 'public');
        }

        $service->update($validated);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    // Menghapus layanan
    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Layanan berhasil dihapus!');
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