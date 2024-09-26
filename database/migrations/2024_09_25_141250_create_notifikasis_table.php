<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifikasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifikasis', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('UserID')->constrained()->onDelete('cascade'); // Mengaitkan dengan tabel users
                $table->string('tipe'); // Jenis notifikasi (ajukan cuti, ubah status, dll.)
                $table->text('pesan'); // Pesan notifikasi
                $table->boolean('dibaca')->default(false); // Status dibaca
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifikasis');
    }
}
