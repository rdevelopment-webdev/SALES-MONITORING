<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RolePagePermission;
class Page extends Model
{
    protected $fillable = [
        'page_name',
    ];
    public function Role_Page_Permission(){
        return $this->hasMany(RolePagePermission::class);
    }
}
