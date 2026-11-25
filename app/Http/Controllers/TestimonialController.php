<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    // Menampilkan seluruh testimoni
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    // Menampilkan formulir tambah
    public function create()
    {
        return view('admin.testimonials.create');
    }

    // Menyimpan testimoni baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'testimonial' => 'required|string',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('customer_photo')) {
            $data['customer_photo'] = $request->file('customer_photo')
                ->store('testimonials', 'public');
        }

        $data['is_published'] = $request->boolean('is_published');

        Testimonial::create($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimoni customer berhasil ditambahkan!');
    }

    // Menampilkan formulir edit
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    // Memperbarui testimoni
    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'testimonial' => 'required|string',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('customer_photo')) {
            $oldPhoto = $testimonial->customer_photo;

            $data['customer_photo'] = $request->file('customer_photo')
                ->store('testimonials', 'public');

            if ($oldPhoto) {
                Storage::disk('public')->delete($oldPhoto);
            }
        }

        $data['is_published'] = $request->boolean('is_published');

        $testimonial->update($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimoni customer berhasil diperbarui!');
    }

    // Menghapus testimoni
    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->customer_photo) {
            Storage::disk('public')->delete($testimonial->customer_photo);
        }

        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimoni customer berhasil dihapus!');
    }
}
