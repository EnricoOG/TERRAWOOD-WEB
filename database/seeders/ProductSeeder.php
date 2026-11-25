<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'category_id' => 1,
                'name' => 'Sofa Modern Elegance',
                'slug' => 'sofa-modern-elegance',
                'description' => 'Sofa modern dengan desain elegan untuk ruang keluarga.',
                'price' => 8500000,
                'image' => null,
                'is_featured' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Meja Minimalis Oak',
                'slug' => 'meja-minimalis-oak',
                'description' => 'Meja minimalis dengan sentuhan material kayu oak.',
                'price' => 4200000,
                'image' => null,
                'is_featured' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Kursi Scandinavian',
                'slug' => 'kursi-scandinavian',
                'description' => 'Kursi bergaya Scandinavian yang nyaman dan modern.',
                'price' => 1750000,
                'image' => null,
                'is_featured' => false,
            ],
        ]);
    }
}