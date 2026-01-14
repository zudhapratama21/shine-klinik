<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokters', function (Blueprint $table) {
            $table->id();            
            $table->string('kode_dokter');
            $table->string('nama_dokter');
            $table->string('foto')->nullable();            
            $table->string('nomor_hp');                        
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->text('alamat')->nullable();
            $table->integer('status');
            $table->date('tanggal_lahir');
            $table->timestamps();            
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('dokters');
    }
};
