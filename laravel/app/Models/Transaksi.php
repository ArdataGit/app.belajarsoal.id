<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "transaksi";
    protected $guarded = ["id"];

    public function paket_mst_r()
    {
        return $this->belongsTo(PaketMst::class, 'fk_paket_mst', 'id');
    }

    public function user_r()
    {
        return $this->belongsTo(User::class, 'fk_user_id', 'id');
    }

    public function created_r()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function channel_r()
    {
        return $this->belongsTo(ChannelTripay::class, 'channel', 'kode');
    }

    // public function getNameAtribute($value)
    // {
    //     $this->attributes['expired'] =Carbon::parse($this->attributes['value'])->translatedFormat('l, d F Y');
    // }
}
