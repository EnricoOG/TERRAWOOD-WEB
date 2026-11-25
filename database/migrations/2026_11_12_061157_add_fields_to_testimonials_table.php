<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Semua kolom testimonials sudah dibuat
        // pada migration create_testimonials_table.
    }

    public function down(): void
    {
        // Tidak perlu menghapus kolom dari migration awal.
    }
};
