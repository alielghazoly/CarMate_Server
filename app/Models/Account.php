<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable implements JWTSubject
{

    protected $guarded = [];
    protected $primaryKey = 'account_id'; 
    protected $casts = [
        'account_fcm_token' => 'array'
    ];

    public function getJWTIdentifier () {
        return $this->getKey();
    }

    public function getJWTCustomClaims () {
        return [];
    }

    public function getAuthIdentifierName () {
        // TODO: Implement getAuthIdentifierName() method.
    }

    public function getAuthIdentifier () {
        // TODO: Implement getAuthIdentifier() method.
    }

    public function getAuthPassword () {
        // TODO: Implement getAuthPassword() method.
    }

    public function getRememberToken () {
        // TODO: Implement getRememberToken() method.
    }

    public function setRememberToken ($value) {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName () {
        // TODO: Implement getRememberTokenName() method.
    }
}

