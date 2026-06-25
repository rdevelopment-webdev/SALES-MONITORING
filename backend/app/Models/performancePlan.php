<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformancePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_recorded',
        'client_name',
        'technique_name',
        'email',
        'service_name',
        'status',
        'percentage',
        'area_input',
        'sales_representative',
        'onboarding_date',
        'remarks',
        'contact_name',
        'contact_number',
        'ways_of_communication',
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Archive(){
        return $this->hasMany(Archive::class);
    }
}