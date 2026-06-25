<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Archive;
use App\Models\User;

class Lead extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'contact_person',
        'job_position',
        'contact_number',
        'email',
        'service_name',
        'status_name',
        'remarks',
        'location',
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
}