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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('company_organization')->nullable();
            $table->string('tax_code_id')->nullable();
            $table->string('payment_term_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('emails')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('preferred_billing_communication', ['Email', 'Print']);
            $table->string('phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('country');
            $table->string('address');
            $table->string('address_2')->nullable();
            $table->string('city');
            $table->string('state_province');
            $table->string('zip_postal_code');
            $table->string('county')->nullable();
            $table->enum('customer_type', ['Commercial', 'Government', 'Residential'])->nullable();
            $table->date('customer_since')->nullable();
            $table->string('heard_about_us')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
