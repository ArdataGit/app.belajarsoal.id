<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;



class UPaketSoalKtg extends Model

{

    use HasFactory;

    use SoftDeletes;

    protected $table = "u_paket_soal_ktg";

    protected $guarded = ["id"];

    public function u_paket_soal_dtl_r()
    {
        return $this->hasMany(UPaketSoalDtl::class, 'fk_u_paket_soal_ktg', 'id');
    }

    public function u_paket_soal_dtl_benar_r()
    {
        return $this->hasMany(UPaketSoalDtl::class, 'fk_u_paket_soal_ktg', 'id')->where('benar_salah','>','0');
    }

    public function u_paket_soal_dtl_salah_r()
    {
        return $this->hasMany(UPaketSoalDtl::class, 'fk_u_paket_soal_ktg', 'id')->where('benar_salah','<=','0');
    }

    public function u_paket_soal_dtl_kosong_r()
    {
        return $this->hasMany(UPaketSoalDtl::class, 'fk_u_paket_soal_ktg', 'id')->whereNull('jawaban_user');
    }
    
    public function user_r()
    {
        return $this->belongsTo(User::class, 'fk_user_id', 'id');
    }
}

