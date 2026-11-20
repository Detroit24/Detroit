<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('template_categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('preview_image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('price_override', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
