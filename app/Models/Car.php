<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Car extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'car_id'; 

    public function getNextId() {
        $statement = DB::select("show table status like 'cars'");
        return $statement[0]->Auto_increment;
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'car_user','car_id','user_id');
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class,'model_id');
    }
}
