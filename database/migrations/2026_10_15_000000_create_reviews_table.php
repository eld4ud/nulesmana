<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name', 80);
            $table->unsignedTinyInteger('rating');
            $table->text('message');
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_verified_member')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('reviews'); }
};
