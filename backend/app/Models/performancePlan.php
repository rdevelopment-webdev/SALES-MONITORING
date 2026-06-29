<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformancePlan extends Model
{
    use HasFactory;
    protected $table = 'performanceplans';

    protected $fillable = [
        'user_id',
        'date_recorded',
        'client_name',
        'technique_id',
        'email',
        'service_id',
        'status',
        'percentage',
        'area_input',
        'representative__id',
        'onboarding_date',
        'remarks',
        'contact_name',
        'contact_number',
        'communication_id',
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Archive(){
        return $this->hasMany(Archive::class);
    }

    public function Sales_Representative(){
    return $this->belongsTo(SalesRepresentative::class, 'representative__id');
    }

    public function ProspectTechnique(){
        return $this->belongsTo(ProspectTechnique::class, 'technique_id');
    }

    public function Service(){
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function Way_of_Communication(){
        return $this->belongsTo(Way_of_Communication::class, 'communication_id');
    }
}