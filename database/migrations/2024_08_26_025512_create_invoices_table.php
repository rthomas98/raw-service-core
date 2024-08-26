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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->date('invoice_date');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Updated to user_id
            $table->foreignId('service_location_id')->nullable()->constrained('sites')->onDelete('set null');
            $table->foreignId('payment_term_id')->constrained()->onDelete('cascade');
            $table->date('due_date');
            $table->string('po_number')->nullable();
            $table->string('address_name');
            $table->string('address');
            $table->string('address_2')->nullable();
            $table->string('city');
            $table->string('state_province');
            $table->string('zip_postal_code');
            $table->decimal('invoice_subtotal', 10, 2)->default(0);
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->foreignId('tax_code_id')->constrained()->onDelete('cascade');
            $table->text('message_displayed_on_invoice')->nullable();
            $table->text('internal_memo')->nullable();
            $table->json('attachments')->nullable();
            $table->enum('preferred_communication', ['Email', 'Print'])->default('Email');
            $table->boolean('online_payment')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
