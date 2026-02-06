<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketDtl extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "paket_dtl";
    protected $guarded = ["id"];

    public function paket_mst_r()
    {
        return $this->belongsTo(PaketSoalMst::class, 'fk_mapel_mst', 'id');
    }

    public function paket_soal_mst_kecermatan_r()
    {
        return $this->belongsTo(PaketSoalKecermatanMst::class, 'fk_mapel_mst', 'id');
    }
}
