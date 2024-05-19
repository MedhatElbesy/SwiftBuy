<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->string('stock');
            $table->decimal('price',10,2);
            $table->string('slug')->unique();
            $table->enum('rating',[1,2,3,4,5]);
            $table->enum('status',[0,1]);
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Foreign key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
