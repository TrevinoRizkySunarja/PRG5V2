<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description');
            $table->string('brand', 50)->index();
            $table->string('category', 50)->index();
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->unique(['brand', 'title']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
