<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class SalesTask extends Model
{
    protected $fillable = [
        'task_date',
        'user_id',
        'task_notes',
        'pdf_export',
    ];
    public function User(){
        return $this->belongsTo(User::class);
    }
}
