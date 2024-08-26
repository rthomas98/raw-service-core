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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->nullable();  // Optional PO Number
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');  // Foreign key to Customer
            $table->foreignId('site_id')->constrained()->onDelete('cascade');  // Foreign key to Site
            $table->date('date');  // Date of the rental
            $table->time('start_time')->nullable();  // Optional start time
            $table->time('end_time')->nullable();  // Optional end time
            $table->integer('duration_hours')->nullable();  // Optional duration in hours
            $table->integer('duration_minutes')->nullable();  // Optional duration in minutes
            $table->text('driver_notes')->nullable();  // Optional driver notes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
