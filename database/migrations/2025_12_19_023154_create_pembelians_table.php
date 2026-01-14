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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('kode_supplier')->nullable();
            $table->date('tanggal');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->double('subtotal');
            $table->double('diskon')->default(0);
            $table->double('ppn')->default(0);
            $table->double('grandtotal')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
