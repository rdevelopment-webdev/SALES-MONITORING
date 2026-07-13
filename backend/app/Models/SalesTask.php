<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Archivable;
use App\Models\User;

class SalesTask extends Model
{
    use Archivable;

    protected $table = 'sales_task';

    protected $fillable = [
        'user_id',
        'task_date',
        'task_notes',
        'archived_at',
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function archiveEntries(){
        return $this->hasMany(Archive::class, 'task_id');
    }
}
