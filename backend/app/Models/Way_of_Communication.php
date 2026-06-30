<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Way_of_Communication extends Model
{
    protected $table = 'ways_of_communication';

    protected $fillable = [
        'communication_name',
    ];

    public function performancePlans()
    {
        return $this->hasMany(PerformancePlan::class, 'communication_id');
    }
} 
