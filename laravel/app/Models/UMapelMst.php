<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;



class UMapelMst extends Model

{

    use HasFactory;

    use SoftDeletes;

    protected $table = "u_mapel_mst";

    protected $guarded = ["id"];



    public function u_paket_soal_ktg_r()

    {

        return $this->hasMany(UPaketSoalKtg::class, 'fk_u_paket_soal_mst', 'id');

    }

    public function u_paket_soal_dtl_r()

    {

        return $this->hasMany(UPaketSoalDtl::class, 'fk_u_paket_soal_mst', 'id')->orderBy('no_soal','asc');

    }

    public function u_paket_soal_ktg_aktif_r()
    {
        return $this->hasMany(UPaketSoalKtg::class, 'fk_u_paket_soal_mst', 'id')->where('is_mengerjakan',1)->limit(1);
    }
    
    public function u_paket_soal_ktg_nonaktif_r()
    {
        return $this->hasMany(UPaketSoalKtg::class, 'fk_u_paket_soal_mst', 'id')->where('is_mengerjakan',0);
    }

    public function paket_soal_mst_r()
    {

        return $this->belongsTo(PaketSoalMst::class, 'fk_mapel_mst', 'id');

    }



    public function user_r()

    {

        return $this->belongsTo(User::class, 'fk_user_id', 'id');

    }



    public function getNamaJenisPenilaianAttribute() {

        if ($this->jenis_penilaian==1) {

            return "Rata-rata";

        }else if($this->jenis_penilaian==2){

            return "Point";

        }

    }

}

