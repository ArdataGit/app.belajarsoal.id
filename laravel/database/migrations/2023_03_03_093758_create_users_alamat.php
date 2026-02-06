<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAlamat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_alamat', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_user_id');
            $table->string('nama_penerima');
            $table->string('no_hp_penerima');
            $table->string('kode_pos');
            $table->integer('fk_provinsi')->default('1');
            $table->integer('fk_kabupaten')->default('1');
            $table->mediumText('alamat_lengkap')->nullable();
            $table->integer('status')->default('1');
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
        Schema::dropIfExists('users_alamat');
    }
}
