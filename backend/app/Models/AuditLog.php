<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Archive;
use App\Models\User;
class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'time_log',
        'action',
        
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Archive(){
        return $this->hasMany(Archive::class);
    }
}
