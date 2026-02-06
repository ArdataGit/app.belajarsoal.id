<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeranjang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_user_id');
            $table->integer('fk_paket_hadiah_id');
            $table->mediumText('fk_mapel_mst');
            $table->bigInteger('harga');
            $table->integer('jumlah')->default('1');
            $table->bigInteger('total_harga');
            $table->string('status')->default('0')->comment = '0 = Belum Beli ; 1 = Sudah Transaksi ; 2= Sudah Beli';
            $table->datetime('expired');
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
        Schema::dropIfExists('keranjang');
    }
}
