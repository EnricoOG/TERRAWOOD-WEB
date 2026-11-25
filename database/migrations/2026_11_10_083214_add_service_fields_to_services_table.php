<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Semua kolom services sudah dibuat
        // pada migration create_services_table.
    }

    public function down(): void
    {
        // Tidak perlu menghapus kolom dari migration awal.
    }
};
