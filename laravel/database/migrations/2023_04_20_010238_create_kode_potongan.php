<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKodePotongan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kode_potongan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode');
            $table->mediumText('gambar');
            $table->integer('fk_user')->nullable();
            $table->integer('jenis')->comment = '1 = Promo ; 2 = Referral';
            $table->integer('tipe')->comment = '1 = Harga ; 2 = Persen';
            $table->bigInteger('jumlah')->default('0');
            $table->mediumText('ket')->nullable();
            $table->integer('status')->default('1')->comment = '0 = Tidak Aktif ; 1 = Aktif';
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
        Schema::dropIfExists('kode_potongan');
    }
}
