<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSoal extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "master_soal";
    protected $guarded = ["id"];

    public function getNamaTingkatAttribute() {
        if ($this->tingkat==1) {
            return "Easy";
        }else if($this->tingkat==2){
            return "Medium";
        }else if($this->tingkat==3){
            return "Hard";
        }else if($this->tingkat==4){
            return "Very Hard";
        }else{
            return "Tidak Ada Data";
        }
    }
}
