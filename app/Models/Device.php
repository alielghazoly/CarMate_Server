<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Device extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'device_id'; 

    public function getNextId() {
        $statement = DB::select("show table status like 'devices'");
        return $statement[0]->Auto_increment;
    }

}
