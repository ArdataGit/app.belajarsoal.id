<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    use HasFactory;

    protected $table = 'role_menus';
    protected $guarded = ['id'];

    public function fk_role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
