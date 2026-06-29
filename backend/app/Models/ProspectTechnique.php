<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspectTechnique extends Model  // FIX: no underscore in class name
{
    use HasFactory;

    protected $table = 'prospect_techniques';  // explicitly set table name

    protected $fillable = [
        'technique_name',
       
    ];

    public function performancePlans()
    {
        return $this->hasMany(PerformancePlan::class, 'technique_id');
    }
}