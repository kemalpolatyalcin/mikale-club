<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waiter_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_table_id')->nullable()->constrained('club_tables')->nullOnDelete();
            $table->foreignId('club_guest_id')->nullable()->constrained('club_guests')->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('orders')->cascadeOnDelete();
            $table->string('table_number', 50);
            $table->string('guest_name', 255)->nullable();
            $table->string('guest_code', 50)->nullable();
            $table->string('type', 50)->default('waiter');
            $table->string('title', 255);
            $table->text('message')->nullable();
            $table->json('order_items')->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->string('status', 50)->default('pending');
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waiter_calls');
    }
};
