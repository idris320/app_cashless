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
        Schema::create('walisantri', function (Blueprint $table) {
            $table->id();
	        $table->unsignedBigInteger('iduser')->nullable();
            $table->string('nama_wali', 100);
            $table->string('alamat');
            $table->string('no_telp', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->foreign('iduser')->references('id')->on('all_users');   
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
