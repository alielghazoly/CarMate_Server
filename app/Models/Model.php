<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as OrmModel;

class Model extends OrmModel
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'model_id'; 

}
