<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('heroes');
    }

    public function down(): void
    {
        // Jika ingin bisa di-rollback:
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('subtitle');
            $table->timestamps();
        });
    }
};
