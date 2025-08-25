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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('id_santri');
            $table->unsignedBigInteger('id_pegawai');
            $table->enum('jenis', ['topup','pembelian']);
            $table->integer('total');
            $table->integer('saldo_awal');            
            $table->integer('saldo_akhir');
            $table->date('tanggal_transaksi');                        
            $table->foreign('id_santri')->references('id')->on('santris');       
            $table->foreign('id_pegawai')->references('id')->on('pegawai');       
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
