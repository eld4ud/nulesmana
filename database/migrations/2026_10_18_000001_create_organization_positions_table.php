<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_positions', function (Blueprint $table) {
            $table->id();
            $table->string('banom', 30)->index();
            $table->string('role', 100);
            $table->string('person_name', 120)->nullable();
            $table->unsignedBigInteger('member_id')->nullable()->index();
            $table->string('description', 180)->nullable();
            $table->unsignedTinyInteger('level')->default(2);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_positions');
    }
};
