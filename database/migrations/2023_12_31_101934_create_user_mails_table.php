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
        Schema::create('user_mails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('mail_id');
            $table->foreign('mail_id')->references('id')->on('mails')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nomor')->nullable();
            $table->string('isi')->nullable();
            $table->string('tanda_tangan')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'ditolak', 'diterima'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_mails');
    }
};
