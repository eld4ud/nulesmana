<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('infaq_transactions', function (Blueprint $table) {
        $table->id();
        $table->integer('amount');
        $table->string('description')->nullable();
        $table->enum('type', ['masuk', 'keluar'])->default('masuk');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infaq_transactions');
    }
};
