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
        Schema::create('komentarfotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('foto_id')->constrained()->cascadeOnDelete('cascade');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete('cascade');
            $table->text('komentar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentarfotos');
    }
};
