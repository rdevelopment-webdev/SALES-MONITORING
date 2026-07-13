<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Archive;
use App\Models\User;


class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'module',
        'action',
        'record_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'time_log'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];


    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Archive(){
        return $this->hasMany(Archive::class);
    }
}
