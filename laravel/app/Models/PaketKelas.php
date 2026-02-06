<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketKelas extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "paket_kelas";
    protected $guarded = ["id"];
}
