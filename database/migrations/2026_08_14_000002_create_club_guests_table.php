<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('club_guests', function (Blueprint $table) {
            $table->id();
            $table->string('guest_code')->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->foreignId('club_table_id')->nullable()->constrained('club_tables')->nullOnDelete();
            $table->enum('status', ['active', 'checked_out'])->default('active');
            $table->timestamp('check_in_at')->useCurrent();
            $table->timestamp('check_out_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('club_guests');
    }
};
