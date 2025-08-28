<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('venue_id')->constrained()->onDelete('cascade');
        $table->string('event_name');
        $table->text('event_description')->nullable();
        $table->date('start_date');
        $table->date('end_date');
        $table->decimal('total_price', 10, 2);
        $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'completed'])->default('draft');
        $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
        $table->json('documents')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
