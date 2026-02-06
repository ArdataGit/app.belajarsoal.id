<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;



class PaketMst extends Model

{

    use HasFactory;

    use SoftDeletes;

    protected $table = "paket_mst";

    protected $guarded = ["id"];



    public function paket_dtl_r()

    {

        return $this->hasMany(PaketDtl::class, 'fk_paket_mst', 'id');

    }



    public function fitur_r()

    {

        return $this->hasMany(PaketFitur::class, 'fk_paket_mst', 'id');

    }



    public function video_r()

    {

        return $this->hasMany(PaketVideo::class, 'fk_paket_mst', 'id');

    }



    public function kategori_r()

    {

        return $this->belongsTo(PaketKategori::class, 'fk_paket_kategori', 'id');

    }



    public function subkategori_r()

    {

        return $this->belongsTo(PaketSubkategori::class, 'fk_paket_subkategori', 'id');

    }

}

