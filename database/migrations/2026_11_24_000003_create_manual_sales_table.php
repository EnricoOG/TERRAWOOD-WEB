<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('manual_sales')) {
            Schema::create('manual_sales', function (Blueprint $table) {
                $table->id();
                $table->string('sale_reference')->nullable();
                $table->string('product_name');
                $table->unsignedInteger('quantity')->default(1);
                $table->decimal('unit_price', 14, 2);
                $table->decimal('total', 14, 2);
                $table->date('sold_at');
                $table->string('channel')->default('Offline');
                $table->text('notes')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('manual_sales');
    }
};
