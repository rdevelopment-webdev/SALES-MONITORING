<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class SalesTask extends Model
{
    protected $table = 'sales_task'; 
    
    protected $fillable = [
        'user_id',
        'task_date',
        'task_notes',
        'pdf_export',
    ];
    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Archive(){
        return $this->hasMany(Archive::class);
    }
}
