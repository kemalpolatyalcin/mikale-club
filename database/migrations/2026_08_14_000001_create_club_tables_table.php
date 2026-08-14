<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_number')->unique();
            $table->string('name');
            $table->string('section')->default('Main Floor');
            $table->string('qr_token')->unique();
            $table->integer('capacity')->default(4);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_tables');
    }
};
