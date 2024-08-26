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
        Schema::create('credit_memos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('emails')->nullable(); // Optional emails field
            $table->date('invoice_date');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Clerk is the user creating the credit memo
            $table->string('po_number')->nullable();
            $table->text('message_displayed_on_credit_memo')->nullable();
            $table->text('internal_memo')->nullable();
            $table->json('attachments')->nullable();
            $table->enum('preferred_communication', ['Email', 'Print'])->default('Email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_memos');
    }
};
