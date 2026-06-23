<?php

namespace App\Models;

 use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\RolePagePermission;

class Role extends Model
{

    protected $fillable = [
        'role_name',
    ];


    public function users(){
        return $this->hasMany(User::class);
    }

    public function rolePagePermissions(){
        return $this->hasMany(RolePagePermission::class,'role_id');
    }
}
