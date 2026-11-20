<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_package', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('templates')->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['template_id', 'package_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_package');
    }
};
