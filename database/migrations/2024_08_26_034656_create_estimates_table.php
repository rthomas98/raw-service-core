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
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('emails')->nullable(); // Optional emails field
            $table->date('invoice_date');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Clerk is the user creating the invoice
            $table->string('po_number')->nullable();
            $table->date('start_date');
            $table->string('address_name');
            $table->string('address');
            $table->string('address_2')->nullable();
            $table->string('city');
            $table->string('state_province');
            $table->string('zip_postal_code');
            $table->text('message_displayed_on_invoice')->nullable();
            $table->text('internal_memo')->nullable();
            $table->json('attachments')->nullable();
            $table->enum('preferred_communication', ['Email', 'Print'])->default('Email');
            $table->boolean('online_payment')->default(true); // Allow online payment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
