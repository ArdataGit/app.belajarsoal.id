<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('email')->nullable();
            $table->date('ttl')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('jenis_kelamin')->nullable()->comment = 'l = Laki-laki ; p = Perempuan';
            $table->mediumText('alamat')->nullable();
            $table->integer('provinsi')->nullable()->default('0');
            $table->integer('kabupaten')->nullable()->default('0');
            $table->integer('kecamatan')->nullable()->default('0');
            $table->integer('referrer')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->mediumText('ket')->nullable();
            // $table->integer('jenjang')->default('1')->comment = '1=SD ; 2=SMP ; 3=SMA ; 4=Mahasiswa ; 5=Guru';
            $table->string('photo')->nullable();
            // $table->string('scan')->nullable();
            $table->integer('user_level')->comment = '1=Admin ; 2=User';
            $table->integer('is_active')->comment = '0 = Tidak Aktif ; 1 = Aktif';
            // $table->integer('fk_affiliate')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
        Schema::dropIfExists('users');
    }
}
