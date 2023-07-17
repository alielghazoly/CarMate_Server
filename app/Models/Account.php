<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable 
{

    protected $guarded = [];
    protected $primaryKey = 'account_id'; 
    protected $casts = [
        'account_fcm_token' => 'array'
    ];

    public function cars()
    {
        return $this->belongsToMany(Car::class,'account_car','account_id','car_id');
    }

    
}

