<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UEventSyarat extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "u_event_syarat";
    protected $guarded = ["id"];
}
