<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Archive;
use App\Models\User;
use App\Models\Traits\Archivable;

class Lead extends Model
{
    use Archivable;

    protected $fillable = [
        'user_id',
        'industry_id',
        'business_name',
        'contact_person',
        'job_position',
        'contact_number',
        'email',
        'service_name',
        'status_name',
        'status_percent',
        'remarks',
        'location',
        'archived_at',
    ];

    protected $casts = [
        'archived_at' => 'datetime',
    ];

    // ✅ camelCase, not PascalCase
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ camelCase + plural for hasMany
    public function archives()
    {
        return $this->hasMany(Archive::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    // Shapes the record into exactly what your Vue table/add-record page expect
    public function toApiArray(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->created_at->format('m/d/Y'),
            'businessName' => $this->business_name,
            'contactPerson' => $this->contact_person,
            'jobPosition' => $this->job_position,
            'contactNo' => $this->contact_number,
            'email' => $this->email,
            'service' => $this->service_name,
            'status' => $this->status_name,
            'statusPercent' => $this->status_percent,
            'remarks' => $this->remarks,
            'location' => $this->location,
            'industry' => $this->industry?->industry_name,
        ];
    }
}