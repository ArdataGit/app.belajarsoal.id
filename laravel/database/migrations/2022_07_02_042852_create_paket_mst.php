<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketMst extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_mst', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_paket_kategori');
            $table->integer('fk_paket_subkategori');
            $table->string('judul');
            $table->date('mulai')->nullable();
            $table->date('selesai')->nullable();
            $table->datetime('mulai_daftar')->nullable();
            $table->datetime('selesai_daftar')->nullable();
            $table->mediumText('ket')->nullable();
            $table->integer('status')->default('1');
            $table->integer('syarat')->default('1')->nullable();
            $table->bigInteger('harga')->default('0');
            $table->mediumText('banner')->nullable();
            $table->mediumText('juknis')->nullable();
            $table->integer('created_by');
            $table->datetime('created_at');
            $table->integer('updated_by')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->datetime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_mst');
    }
}
