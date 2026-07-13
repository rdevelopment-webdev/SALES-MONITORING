<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Page;

class UserPagePermission extends Model
{
    protected $fillable = [
        'user_id',
        'page_id',
        'permission_name',
        'can_edit',
        'can_create',
        'can_archive',
        'can_view',
    ];

    protected $casts = [
        'can_view'    => 'boolean',
        'can_create'  => 'boolean',
        'can_edit'    => 'boolean',
        'can_archive' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
