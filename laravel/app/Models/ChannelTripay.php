<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ChannelTripay extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "channel_tripay";
    protected $guarded = ["id"];
}
