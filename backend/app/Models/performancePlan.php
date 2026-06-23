<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class performancePlan extends Model
{
    protected $fillable = [
        'user_id',
        'date_recorded',
        'client_name',
        'technique_name',
        'email',
        'service_name',
        'status(percentage)',
        'area_input ',
        'sales_representative',
        'onboarding_date',
        'remarks',
        'contact_name',
        'contact_number',
        'way_of_communication',
    ];
    public function User(){
        return $this->belongsTo(User::class);
    }
}
