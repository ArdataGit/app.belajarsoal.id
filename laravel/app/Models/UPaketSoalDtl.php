<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UPaketSoalDtl extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "u_paket_soal_dtl";
    protected $guarded = ["id"];

    public function u_mapel_mst_r()
    {
        return $this->belongsTo(UMapelMst::class, 'fk_u_paket_soal_ktg', 'id');
    }

    public function u_paket_soal_ktg_r()
    {
        return $this->belongsTo(UPaketSoalKtg::class, 'fk_u_paket_soal_ktg', 'id');
    }

    public function getNamaTingkatAttribute() {
        if ($this->tingkat==1) {
            return "Easy";
        }else if($this->tingkat==2){
            return "Medium";
        }else if($this->tingkat==3){
            return "Hard";
        }else if($this->tingkat==4){
            return "Very Hard";
        }else{
            return "Tidak Ada Data";
        }
    }
}
