<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Audit_Log;
use App\Models\Lead;
class Archive extends Model
{
    protected $fillable = [
        'lead_id',
        'log_id',
        'service_name',
        'status_name',
    ];
    public function lead(){
        return $this->belongsTo(Lead::class);
    }
    public function Audit_log(){
        return $this->belongsTo(Audit_Log::class);

}}
