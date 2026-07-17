<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Traits\Archivable;

class PerformancePlan extends Model
{
    use Archivable;

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
        'onboarding_date',
        'remarks',
        'contact_name',
        'contact_number',
        'communication_id',
        'archived_at',
    ];

    protected $casts = [
        'date_recorded' => 'date',
        'onboarding_date' => 'date',
        'archived_at' => 'datetime',
        'percentage' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function technique(): BelongsTo
    {
        return $this->belongsTo(ProspectTechnique::class, 'technique_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    // Fixed: class is Way_of_Communication (matching the actual filename/
    // class name in app/Models), not WayOfCommunication.
    public function waysOfCommunication(): BelongsTo
    {
        return $this->belongsTo(Way_of_Communication::class, 'communication_id');
    }

    // Replaces the old single belongsTo('salesRepresentative') relation.
    // A plan can now have many reps, and a rep can be on many plans.
    public function salesRepresentatives(): BelongsToMany
    {
        return $this->belongsToMany(
            SalesRepresentative::class,
            'performance_plan_sales_representative',
            'performance_plan_id',
            'representative__id'
        )->withTimestamps();
    }
}