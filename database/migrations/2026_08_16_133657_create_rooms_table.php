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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pg_id')->constrained('pgs')->onDelete('cascade');
            $table->string('room_number');
            $table->enum('room_type', ['single', 'double', 'triple', 'four_sharing']);
            $table->integer('total_beds');
            $table->integer('available_beds');
            $table->decimal('monthly_rent', 10, 2);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
