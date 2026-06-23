<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Archive;
use App\Models\User;
class AuditLog extends Model
{
    protected $fillable = [
        'time_log',
        'action',
        'user_id',
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Archive(){
        return $this->hasMany(Archive::class);
    }
}
