<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('brand');
            $table->decimal('price_per_day', 8, 2);
            $table->text('description');
            $table->json('images')->nullable();
            $table->json('features')->nullable();
            $table->unsignedTinyInteger('capacity');
            $table->string('transmission');
            $table->string('fuel');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};