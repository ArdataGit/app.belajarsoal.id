<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketZoom extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "paket_zoom";
    protected $guarded = ["id"];
}
