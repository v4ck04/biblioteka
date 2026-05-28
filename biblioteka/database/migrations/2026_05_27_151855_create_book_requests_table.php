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
        Schema::create('book_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->restrictOnDelete();
            $table->string('reader_name');
            $table->string('contact');
            $table->text('notes')->nullable();
            $table->enum('status', ['na čekanju', 'odobreno', 'odbijeno'])->default('na čekanju');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_requests');
    }
};
