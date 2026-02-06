<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UPaketSoalKecermatanMst extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "u_paket_soal_kecermatan_mst";
    protected $guarded = ["id"];

    public function u_paket_soal_kecermatan_ktg_r()
    {
        return $this->hasMany(UPaketSoalKecermatanKtg::class, 'fk_u_paket_soal_kecermatan_mst', 'id');
    }

    public function u_paket_soal_kecermatan_soal_mst_r()
    {
        return $this->hasMany(UPaketSoalKecermatanSoalMst::class, 'fk_u_paket_soal_kecermatan_mst', 'id');
    }

    public function current_kolom()
    {
        return count(UPaketSoalKecermatanSoalMst::where('is_mengerjakan', '<>', 0)->where('fk_u_paket_soal_kecermatan_mst', $this->id)->get());
    }

    public function user_r()
    {
        return $this->belongsTo(User::class, 'fk_user_id', 'id');
    }
}
