<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keranjang extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "keranjang";
    protected $guarded = ["id"];

    public function paket_hadiah_r()
    {
        return $this->belongsTo(PaketHadiah::class, 'fk_paket_hadiah_id', 'id');
    }
}
