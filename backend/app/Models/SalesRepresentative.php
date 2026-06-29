<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesRepresentative extends Model
{
    protected $table = 'sales__representatives';

    protected $fillable = [
        'representative_name',
    ];

    public function performancePlans()
    {
        return $this->hasMany(PerformancePlan::class, 'representative__id');
    }
}
