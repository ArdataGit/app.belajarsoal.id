<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketSubkategori extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "paket_sub_kategori";
    protected $guarded = ["id"];

    public function kategori_r()
    {
        return $this->belongsTo(PaketKategori::class, 'fk_paket_kategori', 'id');
    }
}
