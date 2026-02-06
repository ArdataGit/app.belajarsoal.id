<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RunningText extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "running_texts";
    protected $guarded = ["id"];
}
