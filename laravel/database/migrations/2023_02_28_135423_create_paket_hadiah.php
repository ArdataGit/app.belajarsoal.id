<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketHadiah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_hadiah', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_mapel_mst');
            $table->string('judul');
            $table->mediumText('ket')->nullable();
            $table->bigInteger('harga')->default('0');
            $table->mediumText('foto')->nullable();
            $table->integer('berat')->comment = 'Gram';
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
        Schema::dropIfExists('paket_hadiah');
    }
}
