<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Archivable;

class Industry extends Model
{
    use HasFactory, Archivable;

    protected $table = 'industries';

    protected $fillable = [
        'industry_name',
        'archived_at',
    ];

    protected $casts = [
        'archived_at' => 'datetime',
    ];

    public function leads() 
    {
        return $this->hasMany(Lead::class, 'industry_id');
    }
}
