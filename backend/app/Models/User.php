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
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
    public function Role(){
        return $this->belongsToss(Role::class);
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
