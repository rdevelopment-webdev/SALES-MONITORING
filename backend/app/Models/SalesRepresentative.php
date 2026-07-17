<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SalesRepresentative extends Model
{
    protected $table = 'sales__representatives';

    protected $fillable = [
        'representative_name',
    ];

    // Renamed relation type from hasMany to belongsToMany, but kept the
    // method name performancePlans() so SalesRepresentativeController's
    // existing ->with('performancePlans') / ->load('performancePlans')
    // calls keep working unchanged.
    public function performancePlans(): BelongsToMany
    {
        return $this->belongsToMany(
            PerformancePlan::class,
            'performance_plan_sales_representative',
            'representative__id',
            'performance_plan_id'
        )->withTimestamps();
    }
}