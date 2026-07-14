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
        'archived_at',
    ];

    // Relationship methods use camelCase to match controller's with() calls
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technique()  // was ProspectTechnique()
    {
        return $this->belongsTo(ProspectTechnique::class, 'technique_id');
    }

    public function service()  // already correct
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function salesRepresentative()  // was Sales_Representative()
    {
        return $this->belongsTo(SalesRepresentative::class, 'representative__id');
    }

    public function waysOfCommunication()  // was Way_of_Communication()
    {
        return $this->belongsTo(Way_of_Communication::class, 'communication_id');
    }

    /**
     * Archive this record by stamping archived_at with the current time.
     * Called from PerformancePlanController's archive route.
     */
    public function archive()
    {
        $this->update(['archived_at' => now()]);
    }

    /**
     * Restore this record by clearing archived_at.
     * Called from PerformancePlanController's unarchive route.
     */
    public function unarchive()
    {
        $this->update(['archived_at' => null]);
    }

    /**
     * True if this record is currently archived.
     */
    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }

    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }

    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }
}
