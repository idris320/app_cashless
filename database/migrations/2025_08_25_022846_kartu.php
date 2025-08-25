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
        Schema::create('kartu', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('id_santri');
            $table->string('no_kartu');
            $table->string('pin', 250);
            $table->string('saldo', 20);
            $table->date('tanggal_aktivasi');            
            $table->string('tanggal_perubahan');            
            $table->enum('status', ['aktif','tidak aktif']);
            $table->string('keterangan', 100);
            $table->foreign('id_santri')->references('id')->on('santris');       
            $table->timestamps();
            $table->softDeletes();
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
