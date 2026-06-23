<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Archive;
use App\Models\User;
class Lead extends Model
{
    protected $fillable = [
        'user_id',
        'service_name',
        'status_name',
        'business_name',
        'contact_person',
        'job_position',
        'contact_number',
        'email',
    ];
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Archive(){
        return $this->hasMany(Archive::class);
    }

}
