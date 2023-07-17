<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as OrmModel;

class CarModel extends OrmModel
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'model_id'; 

    public function car()
    {
        return $this->hasOne(Car::class,'model_id','model_id');
    }
}
