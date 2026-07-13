<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Page;
class RolePagePermission extends Model
{
    protected $fillable = [
        'role_id',
        'page_id',
        'permission_name',
        'can_edit',
        'can_create',
        'can_archive',
        'can_view',
    ];
    protected $casts = [
        'can_view'   => 'boolean',
        'can_create' => 'boolean',
        'can_edit'   => 'boolean',
        'can_archive' => 'boolean',
    ];

    public function Role(){
        return $this->belongsTo(Role::class);
    }

    public function page(){
        return $this->belongsTo(Page::class);
    }

}
