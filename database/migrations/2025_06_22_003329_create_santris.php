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
        Schema::create('santris', function (Blueprint $table) {
            $table->id();
	        $table->unsignedBigInteger('id_wali')->nullable(); 
            $table->string('nama_santri', 100);
            $table->string('alamat')->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin',['L', 'P']);
            $table->enum('status', ['aktif','tidak aktif'])->default('aktif');          
            $table->foreign('id_wali')->references('id')->on('wali_santri');                        
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};
