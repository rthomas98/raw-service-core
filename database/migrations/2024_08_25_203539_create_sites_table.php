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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Commercial', 'Government', 'Residential']);
            $table->string('site_name')->nullable();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // This links to the Customer model
            $table->string('country');
            $table->string('site_address');
            $table->string('site_address_2')->nullable();
            $table->string('city');
            $table->string('state_province');
            $table->string('zip_postal_code');
            $table->string('county')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
