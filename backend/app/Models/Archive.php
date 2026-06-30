<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AuditLog;
use App\Models\Lead;
use App\Models\PerformancePlan;
use App\Models\SalesTask;

class Archive extends Model
{
    // Match the migration table name
    protected $table = 'archive'; 

    protected $fillable = [
        'lead_id',
        'log_id',
        'performance_id',
        'task_id',
        'service_name',
        'status_name',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class); // 'lead_id' matches convention
    }

    public function auditLog()
    {
        return $this->belongsTo(AuditLog::class, 'log_id'); // column is 'log_id', not 'audit_log_id'
    }

    public function performancePlan()
    {
        return $this->belongsTo(PerformancePlan::class, 'performance_id'); // column is 'performance_id', not 'performance_plan_id'
    }

    public function salesTask()
    {
        return $this->belongsTo(SalesTask::class, 'task_id'); // column is 'task_id', not 'sales_task_id'
    }
}