<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['name' => 'Sofa', 'description' => 'Koleksi sofa premium untuk ruang keluarga.'],
            ['name' => 'Meja', 'description' => 'Meja modern untuk berbagai kebutuhan interior.'],
            ['name' => 'Kursi', 'description' => 'Kursi dengan desain elegan dan nyaman.'],
            ['name' => 'Lemari', 'description' => 'Lemari fungsional dengan desain minimalis.'],
            ['name' => 'Dekorasi', 'description' => 'Produk dekorasi untuk mempercantik ruangan.'],
        ]);
    }
}