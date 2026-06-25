<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\AuditLog;
use App\Models\Lead;
use App\Models\SalesTask;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'full_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'password' => 'hashed', // Laravel 10+ auto-hashes
    ];
    public function Role(){
        return $this->belongsTo(Role::class);
    }
    public function audit_log(){

        return $this->hasMany(AuditLog::class);
    }

    public function Lead(){
        return $this->hasMany(Lead::class);
    }
    public function Sales_Task(){
        return $this->hasMany(SalesTask::class);
    }
    public function performance_plan(){
        return $this->hasMany(performancePlan::class);
    }
}
